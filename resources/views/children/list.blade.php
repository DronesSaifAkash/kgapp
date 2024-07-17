<!-- resources/views/children-list.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6">Registered Children</h2>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-300 text-center">
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
            @foreach($children as $child)
            <tr>
                <td class="py-2 px-4 border-b">{{ $child->name }}</td>
                <td class="py-2 px-4 border-b">{{ $child->date_of_birth }}</td>
                <td class="py-2 px-4 border-b">{{ $child->class }}</td>
                <td class="py-2 px-4 border-b">{{ $child->city }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('child.details', $child->id) }}" class="text-blue-500">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
