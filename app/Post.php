<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

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
}
