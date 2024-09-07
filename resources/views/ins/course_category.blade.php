@extends('layout.app')
@section('title', 'Add Category')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ isset($single_data) ? 'Edit Category' : 'Add Category' }}</h5>
            </div>
            <div class="card-body">
                <form id="categoryForm" method="post" action="{{ isset($single_data) ? route('update_category', $single_data->id) : route('store_category') }}">
                    @csrf
                    @if(isset($single_data))
                        @method('PUT') <!-- This is needed for update operations -->
                    @endif
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="col-form-label" for="course">Course</label>
                            <select name="course_id" class="form-control" id="course">
                                <option value="">-- Select a Course --</option>
                                @isset($courses)
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ isset($single_data->course_id) && $single_data->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label" for="name">Category Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Category Name" value="{{ isset($single_data->name) ? $single_data->name : '' }}" />
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label" for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3" placeholder="Enter Description">{{ isset($single_data->description) ? $single_data->description : '' }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 d-flex align-items-end">
                            <input type="submit" class="btn btn-primary" value="{{ isset($single_data) ? 'Update Category' : 'Add Category' }}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Course Categories</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped shadow-sm" id="categoriesTable">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Course</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('course_category.data') }}',
            columns: [
                {
                    data: null,
                    name: null,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Serial number starts from 1
                    }
                },
                { data: 'course_id', name: 'course.name' }, // Adjust based on your relationship
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush

@endsection
