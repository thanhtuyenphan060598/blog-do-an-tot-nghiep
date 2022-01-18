<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\Tag;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name_category'];

    public function articles() {
        return $this->hasMany(Article::class);
    }
    public function tags() {
        return $this->hasMany(Tag::class);
    }
}
