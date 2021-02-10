@extends('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
        {{ isset($post) ? $post->title : '' }}
        <button class="btn btn-primary float-right">
            Post Views: {{ views($post)->count() }} <i class="fa fa-eye"></i>
        </button>
    </div>
    <div class="card-body">
        <form action="#" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="5" rows="5" class="form-control" disabled>{{ isset($post) ? $post->description : '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}" disabled />
            </div>

            <div class="form-group">
                <label for="published_at">Published At</label>
                <input type="text" id="published_at" class="form-control" name="published_at" value="{{ isset($post) ? $post->published_at : '' }}" disabled>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                @if(isset($post))
                <img src="{{ asset('storage/'.$post->image) }}" alt="post image" style="width: 100%">
                @endif
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category" id="category" disabled>
                    @if(isset($post))

                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id === $post->category_id)
                        selected
                        @endif
                        >{{ $category->name }}</option>
                    @endforeach

                    @else
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                    @endif
                </select>
            </div>
            @if($tags->count() > 0)
            <div class="form-group">
                <label for="tags">Tags</label>
                {{-- [] is used because it is a multiselect input, and the selected options have to be passed as an array, else only one would be in the request body--}}
                <select name="tags[]" id="tags" class="form-control tags-selector" multiple disabled>

                    @foreach($tags as $tag)

                    <option value="{{ $tag->id }}" @if(isset($post)) @if($post->hasTag($tag->id))
                        selected
                        @endif
                        @endif
                        >{{ $tag->name }}</option>

                    @endforeach

                </select>
            </div>
            @endif

        </form>
    </div>
</div>

@endsection