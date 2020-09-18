@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">Posts</div>
    <div class="card-body">
        @if($posts->count() > 0)
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('posts.create') }}" class="btn btn-success float-right">Add Posts</a>
            </div>

            <table class="table">
                <thead>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach($posts as $post)
                    <tr scope="row">
                        <td>
                            <img src="{{ asset('storage/'.$post->image) }}" alt="img" width="120px" height="60px">
                        </td>
                        <td>
                            {{ $post->title }}
                        </td>
                        <td class="float-right">
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    {{ $post->trashed() ? 'Delete' : 'Trash' }}
                                </button>

                            </form>
                        </td>
                        <td class="float-right">
                            @if(!$post->trashed())
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center display-5 m-3 mb-5">No Posts At The Moment...</h1>
            
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('posts.create') }}" class="btn btn-success float-right">Add Posts</a>
            </div>

        @endif

    </div>
</div>

@endsection