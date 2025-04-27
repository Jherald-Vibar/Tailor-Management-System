@extends('layouts.app')
@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="min-h-screen bg-gray-100 p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="relative w-full sm:w-auto">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 256 256" class="text-gray-500">
                    <path fill="currentColor" d="M188.24 67.76a6 6 0 0 1 0 8.48l-16 16a6 6 0 0 1-8.48-8.48l16-16a6 6 0 0 1 8.48 0M222 72a37.74 37.74 0 0 1-11.13 26.87l-24 24a6 6 0 0 1-3.23 1.67c-52.14 9-138.53 94.84-139.4 95.7a5.8 5.8 0 0 1-1.82 1.25A6.1 6.1 0 0 1 40 222a6 6 0 0 1-4.24-10.24c1.4-1.41 86.78-87.44 95.69-139.39a6 6 0 0 1 1.67-3.23l24-24A38 38 0 0 1 222 72m-12 0a26 26 0 0 0-44.38-18.38L142.93 76.3c-4.14 20.79-18.62 47.61-43.13 79.9c32.29-24.51 59.11-39 79.9-43.13l22.68-22.69A25.8 25.8 0 0 0 210 72"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Active Stitches</p>
                <p class="text-2xl font-bold mt-1">{{$activeStitches}}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M3.5 9.368c0-3.473 0-5.21 1.025-6.289S7.2 2 10.5 2h3c3.3 0 4.95 0 5.975 1.08C20.5 4.157 20.5 5.894 20.5 9.367v5.264c0 3.473 0 5.21-1.025 6.289S16.8 22 13.5 22h-3c-3.3 0-4.95 0-5.975-1.08C3.5 19.843 3.5 18.106 3.5 14.633z"/><path d="m8 2l.082.493c.2 1.197.3 1.796.72 2.152C9.22 5 9.827 5 11.041 5h1.917c1.213 0 1.82 0 2.24-.355c.42-.356.52-.955.719-2.152L16 2M8 16h4m-4-5h8"/></g></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Current Tailor</p>
                <p class="text-2xl font-bold mt-1">{{$currentTailors}}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <p class="text-sm text-gray-500">In Progress Stitch</p>
            <p class="text-2xl font-bold mt-2">{{$inProgressStitch}}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <p class="text-sm text-gray-500">Customers</p>
            <p class="text-2xl font-bold mt-2">{{$customers}}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Total Stitch</h2>
                <span class="text-sm text-gray-400">Last 30 Days</span>
            </div>
            <canvas id="totalProcessesChart" class="h-48"></canvas>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Status Count</h2>
            <canvas id="processStatusChart" class="h-48"></canvas>
        </div>
    </div>


    <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
        <h2 class="text-lg font-semibold mb-4">Recent Activities</h2>
        <table class="w-full text-sm text-left text-gray-700 min-w-[600px]">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th scope="col" class="px-6 py-3">Garment Name</th>
                    <th scope="col" class="px-6 py-3">Section</th>
                    <th scope="col" class="px-6 py-3">Last Active</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stitches as $stitch)
                <tr class="bg-white border-b">
                    <td class="px-6 py-4">{{$stitch->garment_name}}</td>
                    <td class="px-6 py-4">{{$stitch->section_name}}</td>
                    <td class="px-6 py-4">{{Carbon\Carbon::parse($stitch->created_at)}}</td>
                    <td class="px-6 py-4">
                        @if($stitch->status == "In Progress")
                        <span class="px-3 py-1 bg-blue-500 text-white rounded-full text-xs">Ongoing</span>
                        @elseif($stitch->status == "Completed")
                        <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs">Completed</span>
                        @else
                        <span class="px-3 py-1 bg-gray-500 text-white rounded-full text-xs">Not Started</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    const weeklyCounts = @json($weeklyCounts);
    const stitchStatusCounts = @json(array_values($stitchStatusCounts));
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const totalProcessesCtx = document.getElementById('totalProcessesChart').getContext('2d');
    new Chart(totalProcessesCtx, {
        type: 'line',
        data: {
            labels: ['Week -3', 'Week -2', 'Week -1', 'This Week'],
            datasets: [{
                label: 'Processes By Week',
                data: weeklyCounts,
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    });


    const processStatusCtx = document.getElementById('processStatusChart').getContext('2d');
    new Chart(processStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Not Started', 'In Progress', 'Completed'],
            datasets: [{
                label: 'Stitches',
                data: stitchStatusCounts,
                backgroundColor: ['#F59E0B', '#3B82F6', '#10B981']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

@endsection
