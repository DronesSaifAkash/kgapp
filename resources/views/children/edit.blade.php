<!-- resources/views/child-details.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Child Details</h2>
    <form method="POST" action="{{ route('child.details', $child->id) }}">
        @csrf
        <!-- Child details form fields with pre-filled values -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <h3>Pick-up Person Details</h3>
    <form method="POST" action="{{ route('child.addPickupPerson', $child->id) }}">
        @csrf
        <div class="form-group">
            <label for="pickup_name">Name</label>
            <input type="text" class="form-control" id="pickup_name" name="pickup_name" required>
        </div>

        <div class="form-group">
            <label for="pickup_relation">Relation</label>
            <select class="form-control" id="pickup_relation" name="pickup_relation" required>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Brother">Brother</option>
                <option value="Sister">Sister</option>
                <option value="Grand Father">Grand Father</option>
                <option value="Grand Mother">Grand Mother</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pickup_contact">Contact No</label>
            <input type="text" class="form-control" id="pickup_contact" name="pickup_contact" pattern="\d{10}" required>
        </div>

        <button type="submit" class="btn btn-secondary">Add Pick-up Person</button>
    </form>

    <h4>Current Pick-up Persons</h4>
    <ul>
        @foreach($child->pickedUpPeople as $person)
        <li>
            {{ $person->name }} ({{ $person->relation }}) - {{ $person->contact_no }}
            <form method="POST" action="{{ route('child.removePickupPerson', [$child->id, $person->id]) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection
