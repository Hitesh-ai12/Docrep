@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Manage Plans</h2>

    @if(session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
    @endif

    <!-- Create Plan Form -->
    <form action="{{ route('plans.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col"><input type="text" name="name" placeholder="Plan Name" class="form-control" required></div>
            <div class="col"><input type="text" name="duration" placeholder="Duration" class="form-control" required></div>
            <div class="col"><input type="number" name="price" placeholder="Price" class="form-control" required></div>
            <div class="col"><input type="number" name="credits" placeholder="Credits" class="form-control" required></div>
            <div class="col-12 mt-2">
                <textarea name="features" class="form-control" placeholder="Features (separate by line)" rows="3"></textarea>
            </div>
        </div>
        <button class="btn btn-primary mt-3">Add Plan</button>
    </form>

    <!-- Plans Table -->
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>Name</th><th>Price</th><th>Duration</th><th>Credits</th><th>Features</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
                <tr>
                    <form action="{{ route('plans.update', $plan) }}" method="POST">
                        @csrf
                        <td><input type="text" name="name" value="{{ $plan->name }}" class="form-control"></td>
                        <td><input type="number" name="price" value="{{ $plan->price }}" class="form-control"></td>
                        <td><input type="text" name="duration" value="{{ $plan->duration }}" class="form-control"></td>
                        <td><input type="number" name="credits" value="{{ $plan->credits }}" class="form-control"></td>
                        <td><textarea name="features" class="form-control">{{ $plan->features }}</textarea></td>
                        <td>
                            <button class="btn btn-sm btn-success mb-1">Update</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deletePlan({{ $plan->id }})">Delete</button>
                        </td>
                    </form>
                    <form id="delete-form-{{ $plan->id }}" method="POST" action="{{ route('plans.delete', $plan) }}">
                        @csrf @method('DELETE')
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deletePlan(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the plan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00d2c3',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
