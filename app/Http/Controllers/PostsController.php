<?php

namespace App\Http\Controllers;

use visits;
use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Requests\Post\CreatePostsRequest;

class PostsController extends Controller
{

    public function __construct()
    {
        // apply the verifyCategoriesCount middleware only on the create and store routes for this resourceful controller
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = new Post;
        // $visits = Post::with('visits')->get(); 
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        // Upload the image 

        // dd($request->image->store('posts')); //this generates the path to the stored uploaded image. posts is the folder where the file is stored. check file in storage/app/posts

        $image = $request->image->store('posts');

        // Create post
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'category_id' => $request->category,
            'image' => $image //path to the image
        ]);

        if ($request->tags) {
            $post->tags()->attach($request->tags); //the attach is used for the many to many relationship. It will attach the tags selected on the frontend with the newly created post
        }

        // Flash success message
        session()->flash('success', 'Post Created Successfully!');

        // Redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        views($post)->record();

        return view('posts.show')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // dd($post->tags->pluck('id')->toArray());

        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content']);

        // check for new image
        if ($request->hasFile('image')) {
            // upload it
            $image = $request->image->store('posts');

            // delete old image
            // Storage::delete($post->image);
            $post->deleteImage();

            $data['image'] = $image;
        }

        if ($request->tags) {
            $post->tags()->sync($request->tags); //this will check for any new incoming tags and attach them to the post. If a current tag already associated with the post wasn't selected when editing (updating), then it detaches from the post.
        }

        // update attributes
        $post->update($data);

        // flash message
        session()->flash('success', 'Post Updated Successfully');

        // redirect user
        return redirect(route('posts.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //This would be used instead of route model binding because route model binding wouldn't find a soft deleted post
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if ($post->trashed()) {
            // Delete Post Image
            // Storage::delete($post->image);
            $post->deleteImage();
            //remember $post->image is the path to the image location

            //Delete Post
            $post->forceDelete();

            // Flash success message
            session()->flash('success', 'Post Deleted Successfully!');
        } else {
            $post->delete();

            // Flash success message
            session()->flash('success', 'Post Trashed Successfully!');
        }

        // Redirect user
        return redirect(route('posts.index'));
    }


    /**
     * Displays a list of all trashed posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        // $trashed = Post::withTrashed()->get();//withTrashed shows all including trashed
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed); //same as with('posts', $trashed)
    }

    /**
     * Restores a trashed post.
     *
     *
     */

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post Restored Successfully!');

        return redirect()->back();
    }

}
