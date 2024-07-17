@if(isset($child))
    <h1>Thank You for Registering!</h1>
    <p>Child Name: {{ $child->name }}</p>
    <!-- Display other registered data -->
@endif