<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PickedUpPerson;
use App\Models\Child;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ChildController extends Controller
{

    public function listChildren()
    {
        $children = Child::all();
        return view('children.list', compact('children'));
    }

    public function showChildDetails($id)
    {
        $child = Child::with('pickedUpPersons')->findOrFail($id);
        
        return view('children.details', compact('child'));
    }


    public function updatePickupPersons(Request $request, $id)
    {
        $request->validate([
            'pickup_persons.*.name' => 'required|string|max:255',
            'pickup_persons.*.relation' => 'required|string|in:Father,Mother,Brother,Sister,Grand Father,Grand Mother',
            'pickup_persons.*.contact_number' => 'required|string|regex:/^[0-9]{10}$/',
        ]);

        try {
            $child = Child::findOrFail($id);

            foreach ($request->pickup_persons as $pickupPersonData) {

                if (isset($pickupPersonData['id'])) {

                    $pickupPerson = PickedUpPerson::findOrFail($pickupPersonData['id']);
                    $pickupPerson->update([
                        'name' => $pickupPersonData['name'],
                        'relation' => $pickupPersonData['relation'],
                        'contact_number' => $pickupPersonData['contact_number'],
                    ]);
                } else {

                    $child->pickedUpPersons()->create([
                        'name' => $pickupPersonData['name'],
                        'relation' => $pickupPersonData['relation'],
                        'contact_number' => $pickupPersonData['contact_number'],
                    ]);
                }
            }

            return redirect()->route('child.details', $child->id)->with('success', 'Child pickup persons updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function deletePickupPerson(Request $request, $id)
    {
        $pickupPerson = PickedUpPerson::findOrFail($id);
        $childId = $pickupPerson->child_id;
        
        $pickupPersonsCount = PickedUpPerson::where('child_id', $childId)->count();
    
        if ($pickupPersonsCount > 1) {
            try {
                $pickupPerson->delete();
                return response()->json(['success' => true, 'message' => 'Pickup person deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'There was an error deleting the pickup person.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'There must be at least one pickup person.']);
        }
       
    }


    public function children_edit($id)
    {
        $child = Child::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id', $child->country)->get();
        return view('children.edit', compact('child', 'countries', 'states'));
    }


    public function updateChildDetails(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'class' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|digits:7',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ],[
            'photo.max' => 'The photo must not exceed 1 MB.', 
            'photo.dimensions' => 'The photo must be at least 100x100 pixels.',
        ]);

        
        $child = Child::findOrFail($id);
        $child->update($request->all());
        try {
            if ($request->hasFile('photo')) {
                $this->validateImageDimensions($request->file('photo'));
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                
                $imagePath = $request->file('photo')->store('photos', 'public');
    
                if ($child->photo_path && file_exists(storage_path('app/public/' . $child->photo_path))) {
                    unlink(storage_path('app/public/' . $child->photo_path));
                }
    
                $child->photo_path = $imagePath;
                $child->update($request->except('photo'));
            }
    
    
            return redirect()->route('child.details', $child->id)->with('success', 'Child details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error updating the child details: ' . $e->getMessage());
        }

        return redirect()->route('child.details', $child->id)->with('success', 'Child details updated successfully.');
    }

    protected function validateImageDimensions($image)
    {
        $imageDimensions = getimagesize($image);
        // dd($imageDimensions, $imageDimensions[0] < 100 || $imageDimensions[1] < 100);
        if ($imageDimensions[0] < 100 || $imageDimensions[1] < 100) {
            throw ValidationException::withMessages([
                'photo' => 'The photo must be at least 100x100 pixels.',
            ]);
        }
    }
}
