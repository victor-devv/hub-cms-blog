@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">Categories</div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <div class="list-group">
                @foreach($errors->all() as $error)
                <li class="list-group-item text-danger">{{ $error }}</li>
                @endforeach
            </div>
        </div>
        @endif
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name"> Name</label>
                <input type="text" id="name" class="form-control" name="name">
            </div>

            <div class="form-group">
                <button class="btn btn-success">Add Category</button>
            </div>
        </form>
    </div>
</div>

@endsection