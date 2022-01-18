<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\Category;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name_tag'];
    protected $appends = ['select'];
    protected $casts = [
        'select' => 'boolean',
    ];

    public function articles() {
        return $this->belongsToMany(Article::class);
    }
    public function category() {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function getSelectAttribute($value) {
        return false;
    }

}
