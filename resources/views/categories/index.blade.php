@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">Categories</div>
    <div class="card-body">
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
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection