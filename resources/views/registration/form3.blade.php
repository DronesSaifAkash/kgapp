<!-- resources/views/register.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Child Registration Form</h2>
    <form method="POST" action="{{ route('register_submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Child Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>

        <div class="form-group">
            <label for="class">Class</label>
            <select class="form-control" id="class" name="class" required>
                @for($i = 1; $i <= 12; $i++)
                    <option value="Class {{ $i }}">Class {{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <select class="form-control" id="country" name="country" required>
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="state">State</label>
            <select class="form-control" id="state" name="state" required>
                <option value="">Select State</option>
            </select>
        </div>
        

        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label for="zip_code">Zip Code</label>
            <input type="text" class="form-control" id="zip_code" name="zip_code" pattern="\d{7}" required>
        </div>

        <div class="form-group">
            <label for="photo">Upload Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
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
    {{-- // document.getElementById('add-more').addEventListener('click', function() {
    //     var pickupCount = document.querySelectorAll('.pickup-person').length;
    //     if (pickupCount < 6) {
    //         var newPickupPerson = document.createElement('div');
    //         newPickupPerson.classList.add('pickup-person');
    //         newPickupPerson.innerHTML = `
    //             <div class="form-group">
    //                 <label for="pickup_name_${pickupCount + 1}">Name</label>
    //                 <input type="text" class="form-control" id="pickup_name_${pickupCount + 1}" name="pickup_name[]" required>
    //             </div>

    //             <div class="form-group">
    //                 <label for="pickup_relation_${pickupCount + 1}">Relation</label>
    //                 <select class="form-control" id="pickup_relation_${pickupCount + 1}" name="pickup_relation[]" required>
    //                     <option value="Father">Father</option>
    //                     <option value="Mother">Mother</option>
    //                     <option value="Brother">Brother</option>
    //                     <option value="Sister">Sister</option>
    //                     <option value="Grand Father">Grand Father</option>
    //                     <option value="Grand Mother">Grand Mother</option>
    //                 </select>
    //             </div>

    //             <div class="form-group">
    //                 <label for="pickup_contact_${pickupCount + 1}">Contact No</label>
    //                 <input type="text" class="form-control" id="pickup_contact_${pickupCount + 1}" name="pickup_contact[]" pattern="\d{10}" required>
    //             </div>
    //             <button type="button" class="btn btn-danger remove-pickup-person">Remove</button>
    //         `;
    //         document.getElementById('pickup-persons').appendChild(newPickupPerson);
    //     }
    // });

    // document.getElementById('pickup-persons').addEventListener('click', function(e) {
    //     if (e.target && e.target.classList.contains('remove-pickup-person')) {
    //         e.target.closest('.pickup-person').remove();
    //     }
    // }); --}}
</script>
@endsection
