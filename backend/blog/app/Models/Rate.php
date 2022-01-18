<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Article;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','article_id','like'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function article() {
        return $this->belongsTo(Article::class);
    }

}
