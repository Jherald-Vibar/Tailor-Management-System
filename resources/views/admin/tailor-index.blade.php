@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Tailor List</h2>
        <button onclick="openTailorModal()"
            class="px-5 py-2 bg-indigo-600 text-white rounded-full text-sm font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            + Add Tailor
        </button>
    </div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700 font-bold">
                @foreach($tailors as $tailor)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $tailor->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $tailor->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $tailor->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $tailor->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <button type="button" onclick="openEditTailorModal('{{$tailor->id}}', '{{$tailor->name}}', '{{$tailor->email}}', '{{$tailor->phone}}')"
                                class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded-full hover:bg-blue-600 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <div class="flex space-x-2">
                                <form id="deleteOrderForm-{{ $tailor->id }}" action="{{route('admin-tailor-delete', ['id' => $tailor->id])}}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-full hover:bg-red-600 transition" onclick="confirmDelete({{ $tailor->id }})">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="tailorModal" class="fixed inset-0 hidden flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Add New Tailor</h2>
            <form action="{{ route('admin-tailor-store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-600">Tailor Name</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-600">Phone</label>
                    <input type="text" name="phone" id="phone" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                </div>

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="closeTailorModal()"
                        class="px-4 py-2 bg-gray-300 rounded-full text-sm font-medium hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-full text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="tailorEditModal" class="fixed inset-0 hidden flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Edit Tailor</h2>

            <form id="EditTailorForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <input type="hidden" id="tailor_id" name="tailor_id" value="">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
                    <input type="text" id="edit_name" name="name" value="" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" >
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                    <input type="text" id="edit_email" name="email" value="" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" >
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone:</label>
                    <input type="text" id="edit_phone" name="phone" value="" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" >
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                        Update Tailor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function openTailorModal() {
        document.getElementById('tailorModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTailorModal() {
        document.getElementById('tailorModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('click', function(e) {
        var modal = document.getElementById('tailorModal');
        if (e.target === modal) {
            closeTailorModal();
        }
    });

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

     function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the tailor permanently!",
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

    function openEditTailorModal(id, name, email, phone) {
        console.log(id);
        document.getElementById('tailorEditModal').classList.remove('hidden');
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone;

        let form = document.getElementById('EditTailorForm');
        form.action = "{{ url('admin/tailor-update') }}/" + id;


        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        document.getElementById('tailorEditModal').classList.add('hidden');
    }
</script>
@endsection
