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
        // dd($imageDimensions, $imageDimensions[0] < 100 || $imageDimensions[1] < 100);
        if ($imageDimensions[0] < 100 || $imageDimensions[1] < 100) {
            throw ValidationException::withMessages([
                'photo' => 'The photo must be at least 100x100 pixels.',
            ]);
        }
    }

    public function registerForm_submit(Request $request){
        // dd($request);
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
        ], [
            'photo.max' => 'The photo must not exceed 1 MB.', 
            'photo.dimensions' => 'The photo must be at least 100x100 pixels.',
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
        
        if ($request->hasFile('photo')) {
            $child->photo_path = $request->file('photo')->store('photos', 'public'); 
        }

        $child->country = $request->country;
        $child->state = $request->state;
        $child->save();

        return redirect()->route('registration.thankyou')->with('success', 'Registration successful!');
    }

    public function showThankYou(){
        return view('registration.thankyou');
    }


    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->pluck('name', 'id');
        return response()->json($states);
    }
}
