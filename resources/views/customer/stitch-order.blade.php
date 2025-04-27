@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Stitches</h2>
        <button onclick="openStitchModal()"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Add Stitch Order
        </button>
    </div>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Garment Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed Time</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($stitches as $stitch)
                <tr class="transition duration-200 ease-in-out hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap">{{$stitch->garment_name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{$stitch->section_name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($stitch->status == 'Completed')
                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Completed</span>
                        @elseif($stitch->status == 'In Progress')
                            <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">In Progress</span>
                        @elseif($stitch->status == 'Not Started')
                            <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Not Started</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Unknown</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{Carbon\Carbon::parse($stitch->start_time)->format('M d, Y')}}</td>
                    @if($stitch->status != "Completed")
                    <td class="px-6 py-4 whitespace-nowrap">Not Completed</td>
                    @else
                    <td class="px-6 py-4 whitespace-nowrap">{{Carbon\Carbon::parse($stitch->completed_time)}}</td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <button type="button" onclick="openStitchEditModal('{{$stitch->id}}', '{{$stitch->section_name}}', '{{$stitch->garment_name}}')" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">Edit</button>
                        <form id="deleteOrderForm-{{ $stitch->id }}" action="{{ route('customer-order-delete', ['id' => $stitch->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="px-4 py-2 bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br  text-white rounded-lg text-sm hover:bg-red-600 transition"
                                    onclick="confirmDelete({{ $stitch->id }})">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No stitches found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div id="stitchModal" class="fixed inset-0 hidden flex items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Add Stitch</h2>
        <form action="{{route('customer-stitch-store')}}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="garment_name" class="block text-sm font-medium text-gray-700">Garment Name</label>
                <input type="text" name="garment_name" id="garment_name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div>
                <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                <input name="section" id="section" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input name="start_time" id="start_time" type="date" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeStitchModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<div id="stitchEditModal" class="fixed inset-0 hidden flex items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Edit Tailor Stitch</h2>

        <form id="EditStitchForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="stitch_id" name="stitch_id" value="">
            <div>
                <label for="edit_garment_name" class="block text-sm font-medium text-gray-700 mb-1">Garment Name:</label>
                <input type="text" id="edit_garment_name" name="garment_name" value="" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" >
            </div>

            <div>
                <label for="edit_section" class="block text-sm font-medium text-gray-700 mb-1">Section:</label>
                <input type="text" id="edit_section" name="section" value="" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" >
            </div>


            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeStitchEditModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                    Update Stitch
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    function openStitchModal() {
        document.getElementById('stitchModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }


    function closeStitchModal() {
        document.getElementById('stitchModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }


    window.addEventListener('click', function(e) {
        var modal = document.getElementById('stitchModal');
        if (e.target === modal) {
            closeStitchModal();
        }
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the order permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteOrderForm-${id}`).submit();
            }
        });
    }

    function openStitchEditModal(id, section, garmentName) {
    console.log(id);
    document.getElementById('stitchEditModal').classList.remove('hidden');
    document.getElementById('edit_section').value = section;
    document.getElementById('edit_garment_name').value = garmentName;

    let form = document.getElementById('EditStitchForm');
    form.action = "{{ url('customer/stitch-update') }}/" + id;


    document.body.classList.add('overflow-hidden');
}

    function closeStitchEditModal() {
        document.getElementById('stitchEditModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }


    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'success',
            });
        });
    @endif

    @if (session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error',
            });
        });
    @endif
</script>
@endsection
