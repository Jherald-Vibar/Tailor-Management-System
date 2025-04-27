@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
        <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-indigo-100 p-4 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 14c4 0 7 3 7 7H5c0-4 3-7 7-7z"></path>
                    <path d="M12 2a4 4 0 1 0 4 4 4 4 0 0 0-4-4z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-semibold text-gray-900">Welcome, {{ $user->name }}!</h2>
                <p class="text-gray-600 mt-2">We're thrilled to have you on board. Here's your personalized dashboard.</p>
                <p class="text-gray-400 text-sm mt-2">Email: {{ $user->email }}</p>
                <p class="text-gray-400 text-sm">Member Since: {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stitches Overview Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 {{ $stitches->where('status', 'Not Started')->isEmpty() ? '' : 'shadow-gray-500' }}">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6">Not Started Stitches</h3>
            @if ($stitches->where('status', 'Not Started')->isEmpty())
                <p class="text-gray-500">You have no stitches in this category.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($stitches->where('status', 'Not Started') as $stitch)
                        <li class="flex items-center justify-between p-4 border-b border-gray-200 rounded-xl hover:bg-gray-50 transition duration-200">
                            <div class="space-y-2">
                                <p class="text-lg font-semibold text-gray-800">Stitch #{{ $stitch->id }}</p>
                                <p class="text-sm text-gray-500">Garment: {{ $stitch->garment_name }}</p>
                                <p class="text-sm text-gray-500">Section: {{ $stitch->section_name }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 {{ $stitches->where('status', 'In Progress')->isEmpty() ? '' : 'shadow-yellow-500' }}">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6">In Progress Stitches</h3>
            @if ($stitches->where('status', 'In Progress')->isEmpty())
                <p class="text-gray-500">You have no stitches in this category.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($stitches->where('status', 'In Progress') as $stitch)
                        <li class="flex items-center justify-between p-4 border-b border-gray-200 rounded-xl hover:bg-gray-50 transition duration-200">
                            <div class="space-y-2">
                                <p class="text-lg font-semibold text-gray-800">Stitch #{{ $stitch->id }}</p>
                                <p class="text-sm text-gray-500">Garment: {{ $stitch->garment_name }}</p>
                                <p class="text-sm text-gray-500">Section: {{ $stitch->section }}</p>
                            </div>
                            <div class="flex space-x-4">
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 {{ $stitches->where('status', 'Completed')->isEmpty() ? '' : 'shadow-green-500' }}">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6">Completed Stitches</h3>
            @if ($stitches->where('status', 'Completed')->isEmpty())
                <p class="text-gray-500">You have no completed stitches yet.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($stitches->where('status', 'Completed') as $stitch)
                        <li class="flex items-center justify-between p-4 border-b border-gray-200 rounded-xl hover:bg-gray-50 transition duration-200">
                            <div class="space-y-2">
                                <p class="text-lg font-semibold text-gray-800">Stitch #{{ $stitch->id }}</p>
                                <p class="text-sm text-gray-500">Garment: {{ $stitch->garment_name }}</p>
                                <p class="text-sm text-gray-500">Section: {{ $stitch->section_name }}</p>
                                <p class="text-sm text-gray-500">  Completed at: {{Carbon\Carbon::parse($stitch->completed_at)->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="flex space-x-4">
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
