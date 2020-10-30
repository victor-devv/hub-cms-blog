@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">Tags</div>
    <div class="card-body">
        @if($tags->count() > 0)

        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('tags.create') }}" class="btn btn-success float-right">Add Tag</a>
        </div>

        <table class="table">
            <thead>
                <th scope="col">Name</th>
                <th scope="col">Posts Count</th>
                <th scope="col"></th>
            </thead>

            <tbody>
                @foreach($tags as $tag)
                <tr scope="row">
                    <td>
                        {{ $tag->name }}
                    </td>

                    <td>
                        {{ $tag->posts->count() }}
                    </td>

                    <td class="float-right">
                        <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $tag->id }})">Delete</button>
                    </td>
                    <td class="float-right">
                        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form action="" method="POST" id="deleteTagForm">
            @csrf
            @method('DELETE')

            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Tag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center text-bold">Are you sure you want to delete this tag?</p>
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
        <h1 class="text-center display-5 m-3 mb-5">No Tag Created</h1>

        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('tags.create') }}" class="btn btn-success float-right">Add Tag</a>
        </div>
        @endif

    </div>
</div>

@endsection

@section('scripts')

<script>
    const handleDelete = (id) => {

        let form = document.getElementById('deleteTagForm');
        form.action = `/tags/${id}`;

        $('#deleteModal').modal('show');

    };
</script>
@endsection