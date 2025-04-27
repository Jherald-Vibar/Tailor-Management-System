@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M12 14c4 0 7 3 7 7H5c0-4 3-7 7-7z"></path>
                    <path d="M12 2a4 4 0 1 0 4 4 4 4 0 0 0-4-4z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Hello, {{ auth()->user()->name }}!</h2>
                <p class="text-gray-500 text-sm mt-1">Here’s an overview of your stitches.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-indigo-50 p-6 rounded-2xl shadow text-center">
            <h3 class="text-3xl font-bold text-indigo-600">{{ $pendingStitches }}</h3>
            <p class="text-gray-600 mt-2">Pending Stitches</p>
        </div>
        <div class="bg-yellow-50 p-6 rounded-2xl shadow text-center">
            <h3 class="text-3xl font-bold text-yellow-600">{{ $inProgressStitches }}</h3>
            <p class="text-gray-600 mt-2">In Progress</p>
        </div>
        <div class="bg-green-50 p-6 rounded-2xl shadow text-center">
            <h3 class="text-3xl font-bold text-green-600">{{ $completedStitches }}</h3>
            <p class="text-gray-600 mt-2">Completed Stitches</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Stitches</h3>
        @if($recentStitches->isEmpty())
            <p class="text-gray-500">You have no recent stitches.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($recentStitches as $stitch)
                    <li class="py-4 flex justify-between items-center hover:bg-gray-50 rounded-xl px-2 transition duration-200">
                        <div>
                            <p class="font-semibold text-gray-800">Stitch #{{ $stitch->id }} - {{ $stitch->garment_name }}</p>
                            <p class="text-sm text-gray-500">{{ $stitch->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="text-sm font-medium px-3 py-1 rounded-full
                            @if($stitch->status == 'Not Started') bg-indigo-100 text-indigo-700
                            @elseif($stitch->status == 'In Progress') bg-yellow-100 text-yellow-700
                            @else bg-green-100 text-green-700
                            @endif">
                            {{ $stitch->status }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
@endsection
