@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6">Edit Child Details</h2>
        @if (session('error'))
            <div id="error-message" class="bg-red-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                {{ session('error') }}
                <button id="close-button" class="text-white ml-4">
                    &times;
                </button>
            </div>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {


                document.getElementById('close-button').onclick = function() {
                    const errormessage = document.getElementById('error-message');
                    if (errormessage) {
                        errormessage.style.display = 'none';
                    }
                };
            });
        </script>

        <form method="POST" action="{{ route('update_children', $child->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input type="text" name="name" value="{{ old('name', $child->name) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">
                        Date of Birth
                    </label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $child->date_of_birth) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('date_of_birth')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="class" class="block text-gray-700 text-sm font-bold mb-2">Class</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="class" name="class" required>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" @if ($child->class == $i) selected @endif>Class
                                {{ numberToRoman($i) }}</option>
                        @endfor
                    </select>
                    @error('class')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                        Address
                    </label>
                    <input type="text" name="address" value="{{ old('address', $child->address) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('address')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="country" class="block text-gray-700 text-sm font-bold mb-2">Country</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="country" name="country" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ $country->id == $child->country ? 'selected' : '' }}>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="state" class="block text-gray-700 text-sm font-bold mb-2">State</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="state" name="state" required>
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" {{ $state->id == $child->state ? 'selected' : '' }}>
                                {{ $state->name }}</option>
                        @endforeach
                    </select>
                    @error('state')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                        City
                    </label>
                    <input type="text" name="city" value="{{ old('city', $child->city) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('city')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="zip_code">
                        Zip Code
                    </label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $child->zip_code) }}" pattern="\d{7}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('zip_code')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">
                        Photo
                    </label>
                    <input type="file" name="photo"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('photo')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if ($child->photo_path)
                        <img src="{{ asset('storage/' . $child->photo_path) }}" width="250px"
                            alt="Child Photo" class="mt-4" />
                    @endif
                </div>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update
                </button>
            </div>
        </form>
        <a href="{{ route('child.details', $child->id) }}" class="text-blue-500 mt-4 inline-block">Back to Details</a>
    </div>

    <script>
        document.getElementById('country').addEventListener('change', function() {
            var countryId = this.value;
            if (countryId) {
                fetch(`{{ url('/get-states/') }}/${countryId}`)
                    .then(response => response.json())
                    .then(data => {
                        var stateSelect = document.getElementById('state');
                        stateSelect.innerHTML = '<option value="">Select State</option>';
                        for (var id in data) {
                            stateSelect.innerHTML += `<option value="${id}">${data[id]}</option>`;
                        }
                    });
            } else {
                document.getElementById('state').innerHTML = '<option value="">Select State</option>';
            }
        });
    </script>
@endsection
