@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex items-center justify-between mb-4 mx-3 pt-4">
            <h2 class="text-2xl font-bold mb-6">Child Details</h2>
            <a href="{{ route('children_edit', $child->id) }}" type="button" id="update"
                class="bg-blue-500 text-white py-1 px-3 rounded">Update Children</a>
        </div>
        @if (session('success'))
            <div id="success-message" class="bg-green-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                {{ session('success') }}
                <button id="close-button" class="text-white ml-4">
                    &times;
                </button>
            </div>
        @endif

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <p><strong>Name:</strong> {{ $child->name }}</p>
            <p><strong>Date of Birth:</strong> {{ $child->date_of_birth }}</p>
            <p><strong>Class:</strong> Class {{ numberToRoman($child->class) }}</p>
            <p><strong>Address:</strong> {{ $child->address }}</p>
            <p><strong>City:</strong> {{ $child->city }}</p>
            <p><strong>State:</strong> {{ getStateName($child->state) }}</p>
            <p><strong>Country:</strong> {{ getCountryName($child->country) }}</p>
            <p><strong>Zip Code:</strong> {{ $child->zip_code }}</p>
            <img src="{{ asset('storage/' . $child->photo_path) }}" width="250px" alt="Child Photo" class="mt-4" />

            <h3 class="text-xl font-bold mt-6 mb-4">Pickup Persons</h3>
            <form method="POST" action="{{ route('update_pickup_persons', $child->id) }}">
                @csrf
                @method('PUT')

                <div id="pickup-persons" class="mb-4">
                    @foreach ($child->pickedUpPersons as $index => $person)
                        <div class="pickup-person mb-4 flex space-x-2" data-id="{{ $person->id }}">
                            <input type="hidden" name="pickup_persons[{{ $index }}][id]"
                                value="{{ $person->id }}">
                            <input type="text" name="pickup_persons[{{ $index }}][name]"
                                value="{{ $person->name }}" placeholder="Name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            <select name="pickup_persons[{{ $index }}][relation]"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="Father" {{ $person->relation == 'Father' ? 'selected' : '' }}>Father
                                </option>
                                <option value="Mother" {{ $person->relation == 'Mother' ? 'selected' : '' }}>Mother
                                </option>
                                <option value="Brother" {{ $person->relation == 'Brother' ? 'selected' : '' }}>Brother
                                </option>
                                <option value="Sister" {{ $person->relation == 'Sister' ? 'selected' : '' }}>Sister
                                </option>
                                <option value="Grand Father" {{ $person->relation == 'Grand Father' ? 'selected' : '' }}>
                                    Grand Father</option>
                                <option value="Grand Mother" {{ $person->relation == 'Grand Mother' ? 'selected' : '' }}>
                                    Grand Mother</option>
                            </select>
                            <input type="text" name="pickup_persons[{{ $index }}][contact_number]"
                                value="{{ $person->contact_number }}" pattern="\d{10}" placeholder="Contact No"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            <button type="button"
                                class="remove-pickup-person bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-more" class="bg-gray-200 text-gray-700 py-2 px-4 rounded">Add More</button>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">Update</button>
            </form>
            <a href="{{ route('listChildren') }}" class="text-blue-500 mt-4 inline-block">Back to List</a>
        </div>
    </div>

    <script>
        let count = {{ $child->pickedUpPersons->count() }};
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
                    <input type="text" name="pickup_persons[${count}][contact_number]" placeholder="Contact No" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" pattern="\\d{10}" required>
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
                const pickupPersons = document.querySelectorAll('.pickup-person');
                const pickupPersonDiv = event.target.closest('.pickup-person');
                const pickupPersonId = pickupPersonDiv.dataset.id;

                if (pickupPersons.length <= 1) {
                    alert('At least one pickup person must be present.');
                    return;
                }

                if (!confirm('Are you sure you want to delete this pickup person?')) {
                    return;
                }
                pickupPersonDiv.remove();
                count--;

                fetch(`{{ url('/pickup-persons/') }}/${pickupPersonId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pickup person deleted successfully.');
                        } else {
                            alert(data.message);
                            document.getElementById('pickup-persons').appendChild(pickupPersonDiv);
                            count++;
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('pickup-persons').appendChild(pickupPersonDiv);
                        count++;
                    });
            }
        });




        document.addEventListener('DOMContentLoaded', function() {

            setTimeout(function() {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 5000);

            document.getElementById('close-button').onclick = function() {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            };
        });
    </script>
@endsection
