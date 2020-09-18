@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">Categories</div>
    <div class="card-body">
        @if($categories->count() > 0)

            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('categories.create') }}" class="btn btn-success float-right">Add Category</a>
            </div>

            <table class="table">
                <thead>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                    <tr scope="row">
                        <td>
                            {{ $category->name }}
                        </td>
                        <td class="float-right">
                            <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $category->id }})">Delete</button>
                        </td>
                        <td class="float-right">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="" method="POST" id="deleteCategoryForm">
                @csrf
                @method('DELETE')

                <!-- Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-bold">Are you sure you want to delete this category?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Return</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <h1 class="text-center display-5 m-3 mb-5">No Category Created</h1>
            
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('categories.create') }}" class="btn btn-success float-right">Add Category</a>
            </div>
        @endif

    </div>
</div>

@endsection

@section('scripts')

<script>
    const handleDelete = (id) => {

        let form = document.getElementById('deleteCategoryForm');
        form.action = `/categories/${id}`;

        $('#deleteModal').modal('show');

    };
</script>
@endsection