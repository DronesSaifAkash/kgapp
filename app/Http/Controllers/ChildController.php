<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PickedUpPerson;
use App\Models\Child;
use App\Models\State;
use App\Models\Country;

class ChildController extends Controller
{

    public function listChildren(){
        $children = Child::all();
        return view('children.list', compact('children'));
    }

    public function showChildDetails($id)
    {
        // $child = Child::findOrFail($id);
        // dd(PickedUpPerson::get());
        $child = Child::with('pickedUpPersons')->findOrFail($id);
        return view('children.details', compact('child'));
    }


    public function updatePickupPersons(Request $request, $id)
    {
        $child = Child::findOrFail($id);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'pickup_persons.*.name' => 'required|string|max:255',
            'pickup_persons.*.relation' => 'required|string|in:Father,Mother,Brother,Sister,Grand Father,Grand Mother',
            'pickup_persons.*.contact_no' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Clear existing pickup persons
        $child->pickupPersons()->delete();

        // Save new pickup persons
        foreach ($request->pickup_persons as $pickup_person) {
            $child->pickupPersons()->create($pickup_person);
        }

        // Redirect with success message
        return redirect()->route('child.details', $child->id)->with('success', 'Pickup persons updated successfully!');
    }   






    public function updateChildDetails(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'class' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|digits:7',
        ]);

        $child = Child::findOrFail($id);
        $child->update($request->all());

        return redirect()->route('child.details', $child->id)->with('success', 'Child details updated successfully.');
    }

    // app/Http/Controllers/RegistrationController.php
    public function addPickupPerson(Request $request, $id)
    {
        $request->validate([
            'pickup_name' => 'required|string|max:255',
            'pickup_relation' => 'required|string',
            'pickup_contact' => 'required|digits:10',
        ]);

        PickedUpPerson::create([
            'child_id' => $id,
            'name' => $request->pickup_name,
            'relation' => $request->pickup_relation,
            'contact_no' => $request->pickup_contact,
        ]);

        return redirect()->route('child.details', $id)->with('success', 'Pick-up person added successfully.');
    }

    public function removePickupPerson($id, $personId)
    {
        $person = PickedUpPerson::where('child_id', $id)->where('id', $personId)->firstOrFail();
        $person->delete();

        return redirect()->route('child.details', $id)->with('success', 'Pick-up person removed successfully.');
    }
}
