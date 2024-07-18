<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\Child; 
use App\Models\Country;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{

    public function registerChildForm(){
        $countries = Country::all();
        return view('registration.form', compact('countries'));
    }

    protected function validateImageDimensions($image)
    {
        $imageDimensions = getimagesize($image);
        
        if ($imageDimensions[0] < 100 || $imageDimensions[1] < 100) {
            throw ValidationException::withMessages([
                'photo' => 'The photo must be at least 100x100 pixels.',
            ]);
        }
    }

    public function registerForm_submit(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'class' => 'required|string',
            'address' => 'required|string|max:500',
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:states,id',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|digits:7',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'pickup_persons' => 'required|array|min:1|max:6',
            'pickup_persons.*.name' => 'required|string|max:255',
            'pickup_persons.*.relation' => 'required|string|in:Father,Mother,Brother,Sister,Grand Father,Grand Mother',
            'pickup_persons.*.contact_number' => 'required|digits:10',
        ], [
            'photo.max' => 'The photo must not exceed 1 MB.', 
            'photo.dimensions' => 'The photo must be at least 100x100 pixels.',
            'zip_code.digits' => 'The zip code must be exactly 7 digits.',
            'pickup_persons.*.contact_number.digits' => 'The contact number must be exactly 10 digits.',
        ]);

        $this->validateImageDimensions($request->file('photo'));

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $child = new Child();
        $child->name = $request->name;
        $child->date_of_birth = $request->date_of_birth;
        $child->class = $request->class;
        $child->address = $request->address;
        $child->city = $request->city;
        $child->zip_code = $request->zip_code;        
        $child->country = $request->country;
        $child->state = $request->state;
        if ($request->hasFile('photo')) {
            $child->photo_path = $request->file('photo')->store('photos', 'public'); 
        }
        $child->save();

        foreach ($request->input('pickup_persons') as $pickedUpPersonData) {
            $child->pickedUpPersons()->create($pickedUpPersonData);
        }

        return redirect()->route('child.details', $child->id)->with('success','Thank you for registering. Here are the details you provided: ');
    }


    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->pluck('name', 'id');
        return response()->json($states);
    }
}
