<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;

class Post extends Model implements Viewable
{
    use SoftDeletes;
    use InteractsWithViews;

    protected $fillable = [
        'title', 'description', 'content', 'image', 'published_at', 'category_id'
    ];

    
    /**
     * Delete post image from storage
     * 
     * @return void
     */

    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    // RELATIONSHIPS
    // NOTE category IS THE NAME OF THE MODEL TO WHICH THE POST BELONGS TO IN LOWER CASE
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Check if post has a tag
     * 
     * @return bool
     */


    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
