<!-- resources/views/children-list.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-5">
        <h2 class="text-2xl font-bold mb-6">Registered Children</h2>

        @if (session('success'))
            <div id="success-message" class="bg-green-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                {{ session('success') }}
                <button id="close-button" class="text-white ml-4">
                    &times;
                </button>
            </div>
        @endif

        <table id="children-table" class="min-w-full bg-white border border-gray-300 text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Date of Birth</th>
                    <th class="py-2 px-4 border-b">Class</th>
                    <th class="py-2 px-4 border-b">City</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($children as $child)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $child->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $child->date_of_birth }}</td>
                        <td class="py-2 px-4 border-b">Class {{ numberToRoman($child->class) }}</td>
                        <td class="py-2 px-4 border-b">{{ $child->city }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('child.details', $child->id) }}" class="text-blue-500">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#children-table').DataTable();
        setTimeout(function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);

        document.getElementById('close-button').onclick = function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        };
    });
    </script>
@endsection
