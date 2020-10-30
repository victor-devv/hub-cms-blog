@extends('layouts.app')

@section('css')
<!-- DATEPICKER -FLATPICKR -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- MULTI SELECT TOOL -SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<div class="card card-default">
    <div class="card-header">
        {{ isset($post) ? 'Edit Post' : 'Create Post' }}
    </div>
    <div class="card-body">
        @include('partials.errors')
        <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(isset($post))
            @method('PUT')
            @endif
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" class="form-control" name="title" value="{{ isset($post) ? $post->title : '' }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="5" rows="5" class="form-control">{{ isset($post) ? $post->description : '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}" />
                <trix-editor input="content"></trix-editor>
            </div>

            <div class="form-group">
                <label for="published_at">Published At</label>
                <input type="text" id="published_at" class="form-control" name="published_at" value="{{ isset($post) ? $post->published_at : '' }}">
            </div>

            <!-- <div class="form-group">
                </div> -->
            <div class="form-group">
                <label for="image">Image</label>
                @if(isset($post))
                <img src="{{ asset('storage/'.$post->image) }}" alt="post image" style="width: 100%">
                @endif

                <input type="file" id="image" class="form-control" name="image">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category" id="category">
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
                <select name="tags[]" id="tags" class="form-control tags-selector" multiple>

                    @foreach($tags as $tag)

                    <option value="{{ $tag->id }}"
                        @if(isset($post)) 
                            @if($post->hasTag($tag->id))
                                selected
                            @endif
                        @endif
                    >{{ $tag->name }}</option>

                    @endforeach

                </select>
            </div>
            @endif

            <div class="form-group">
                <button class="btn btn-success">{{ isset($post) ? 'Update Post' : 'Add Post' }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<!-- DATEPICKER -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr('#published_at', {
        enableTime: true
    })
</script>

<!-- MULTI SELECT TOOL -SELECT2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(() => {
        $(".tags-selector").select2({
            tags: true
        });
    })
</script>
@endsection