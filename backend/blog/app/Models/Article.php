<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Rate;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title','content','user_id','category_id'];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function rates() {
        return $this->hasMany(Rate::class);
    }

    public function getCreatedAtAttribute($value) {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $dt2 = Carbon::create($now);
        $dt = Carbon::create($value);

        return $dt->diffForHumans($dt2);
    }
    public function getUpdatedAtAttribute($value) {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $dt2 = Carbon::create($now);
        $dt = Carbon::create($value);

        return $dt->diffForHumans($dt2);
    }
}
