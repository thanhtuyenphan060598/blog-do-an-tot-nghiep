<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_name','commentable_type','commentable_id','description'];
    public function commentable()
    {
        return $this->morphTo();
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function getCreatedAtAttribute($value) {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $dt2 = Carbon::create($now);
        $dt = Carbon::create($value);

        return $dt->diffForHumans($dt2);
    }

}
