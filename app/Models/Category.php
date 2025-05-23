<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_categories', 'category_id', 'post_id');
    }
}
