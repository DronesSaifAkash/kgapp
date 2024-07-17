<!-- resources/views/child-details.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6">Child Details</h2>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <p><strong>Name:</strong> {{ $child->name }}</p>
        <p><strong>Date of Birth:</strong> {{ $child->dob }}</p>
        <p><strong>Class:</strong> {{ $child->class }}</p>
        <p><strong>Address:</strong> {{ $child->address }}</p>
        <p><strong>City:</strong> {{ $child->city }}</p>
        <p><strong>State:</strong> {{ getStateName($child->state) }}</p>
        <p><strong>Country:</strong> {{ getCountryName($child->country) }}</p>
        <p><strong>Zip Code:</strong> {{ $child->zip_code }}</p>
        <img src="{{ asset('storage/' . $child->photo) }}" alt="Child Photo" class="mt-4" />

        <h3 class="text-xl font-bold mt-6 mb-4">Pickup Persons</h3>
        <form method="POST" action="{{ route('update_pickup_persons', $child->id) }}">
            @csrf
            @method('PUT')

            <div id="pickup-persons" class="mb-4">
                @if(isset($child->pickupPersons))
                @foreach($child->pickupPersons as $index => $person)
                    <div class="pickup-person mb-4 flex space-x-2">
                        <input type="text" name="pickup_persons[{{ $index }}][name]" value="{{ $person->name }}" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <select name="pickup_persons[{{ $index }}][relation]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="Father" {{ $person->relation == 'Father' ? 'selected' : '' }}>Father</option>
                            <option value="Mother" {{ $person->relation == 'Mother' ? 'selected' : '' }}>Mother</option>
                            <option value="Brother" {{ $person->relation == 'Brother' ? 'selected' : '' }}>Brother</option>
                            <option value="Sister" {{ $person->relation == 'Sister' ? 'selected' : '' }}>Sister</option>
                            <option value="Grand Father" {{ $person->relation == 'Grand Father' ? 'selected' : '' }}>Grand Father</option>
                            <option value="Grand Mother" {{ $person->relation == 'Grand Mother' ? 'selected' : '' }}>Grand Mother</option>
                        </select>
                        <input type="text" name="pickup_persons[{{ $index }}][contact_no]" value="{{ $person->contact_no }}" placeholder="Contact No" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <button type="button" class="remove-pickup-person bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                    </div>
                @endforeach
                @endif
            </div>

            <button type="button" id="add-more" class="bg-gray-200 text-gray-700 py-2 px-4 rounded">Add More</button>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">Update</button>
        </form>
        <a href="{{ route('listChildren') }}" class="text-blue-500 mt-4 inline-block">Back to List</a>
    </div>
</div>

<script>
    let count = {{ $child->pickupPersons? $child->pickupPersons->count() : 0 }};
    document.getElementById('add-more').onclick = function() {
        if (count < 6) {
            const pickupPersonHtml = `
                <div class="pickup-person mb-4 flex space-x-2">
                    <input type="text" name="pickup_persons[${count}][name]" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <select name="pickup_persons[${count}][relation]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Relation</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Brother">Brother</option>
                        <option value="Sister">Sister</option>
                        <option value="Grand Father">Grand Father</option>
                        <option value="Grand Mother">Grand Mother</option>
                    </select>
                    <input type="text" name="pickup_persons[${count}][contact_no]" placeholder="Contact No" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <button type="button" class="remove-pickup-person bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                </div>
            `;
            document.getElementById('pickup-persons').insertAdjacentHTML('beforeend', pickupPersonHtml);
            count++;
        } else {
            alert('You can only add up to 6 pickup persons.');
        }
    };

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-pickup-person')) {
            event.target.closest('.pickup-person').remove();
            count--;
        }
    });
</script>
@endsection
