<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal_Information extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','address','phone','gender','date_of_birth'];
}
