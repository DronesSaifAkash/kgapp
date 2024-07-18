@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6">Child Registration Form</h2>
    <form method="POST" action="{{ route('register_submit') }}" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Child Name</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" required>
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="dob" name="date_of_birth" required>
            @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="class" class="block text-gray-700 text-sm font-bold mb-2">Class</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="class" name="class" required>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">Class {{ numberToRoman($i) }}</option>
                @endfor
            </select>
            @error('class') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" name="address" required>
            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="country" class="block text-gray-700 text-sm font-bold mb-2">Country</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" name="country" required>
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="state" class="block text-gray-700 text-sm font-bold mb-2">State</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="state" name="state" required>
                <option value="">Select State</option>
            </select>
            @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="city" name="city" required>
            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="zip_code" class="block text-gray-700 text-sm font-bold mb-2">Zip Code</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="zip_code" name="zip_code" pattern="\d{7}" required>
            @error('zip_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Upload Photo</label>
            <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="photo" name="photo" accept="image/*" required>
            @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Picked-up Person Details -->
        <div class="flex items-center justify-between mb-4 mx-3 pt-4">
            <h3 class="text-xl font-bold">Picked-up Person Details</h3>
            <button type="button" id="add-more" class="bg-blue-500 text-white py-1 px-3 rounded">Add More</button>
        </div>
         <div id="picked-up-persons" class="mb-4">
             <div class="picked-up-person mb-4 flex space-x-2">
                 <input type="text" name="pickup_persons[0][name]" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                 <select name="pickup_persons[0][relation]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                     <option value="Father">Father</option>
                     <option value="Mother">Mother</option>
                     <option value="Brother">Brother</option>
                     <option value="Sister">Sister</option>
                     <option value="Grand Father">Grand Father</option>
                     <option value="Grand Mother">Grand Mother</option>
                 </select>
                 <input type="text" name="pickup_persons[0][contact_number]" placeholder="Contact No" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" pattern="\d{10}" required>
                 <button type="button" class="remove-pickup-person bg-red-500 text-white px-4 py-2 rounded" onclick="removeRow(this)">Remove</button>
             </div>
         </div>
         
 


        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Register
            </button>
        </div>
    </form>
</div>

<script>

    $(document).ready(function() {
            $('#country').change(function() {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '{{ url("/get-states") }}/' + countryId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('#state').empty();
                            $('#state').append('<option value="">Select State</option>');
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty();
                    $('#state').append('<option value="">Select State</option>');
                }
            });
        });
    </script>


<script>
    document.getElementById('add-more').addEventListener('click', function () {
    let pickedUpPersons = document.getElementById('picked-up-persons');
    let count = pickedUpPersons.children.length;
    if (count < 6) {
        let newRow = document.createElement('div');
        newRow.classList.add('picked-up-person', 'mb-4', 'flex', 'space-x-2');
        newRow.innerHTML = `
            <input type="text" name="pickup_persons[${count}][name]" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <select name="pickup_persons[${count}][relation]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Brother">Brother</option>
                <option value="Sister">Sister</option>
                <option value="Grand Father">Grand Father</option>
                <option value="Grand Mother">Grand Mother</option>
            </select>
            <input type="text" name="pickup_persons[${count}][contact_number]" placeholder="Contact No" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" pattern="\\d{10}" required>
            <button type="button" class="remove-pickup-person bg-red-500 text-white px-4 py-2 rounded" onclick="removeRow(this)">Remove</button>
        `;
        pickedUpPersons.appendChild(newRow);
    } else {
        alert('You can only add up to 6 picked-up persons.');
    }
});

    function removeRow(button) {
        let pickedUpPersons = document.getElementById('picked-up-persons');
        if (pickedUpPersons.children.length > 1) {
            let pickedUpPerson = button.parentNode;
            pickedUpPersons.removeChild(pickedUpPerson);
        } else {
            alert('At least one picked-up person must be present.');
        }
    }
    </script>
@endsection