<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;


class UsersManagerController extends Controller
{
     /**
     * Lấy danh sách người dùng của admin.
     *
     * @return array
     */
    public function listUsers() {
        $users = User::whereNotIn('name',['admin',auth()->user()->name])->paginate(20);
        //dd($users);
        return view('admin.user')->with('users',$users);
    }

     /**
     * Khóa 1 người dùng của admin
     *
     * @return void
     */
    public function blocked(User $user) {
        $user->blocked = !$user->blocked?true:false;
        $user->save();
        return redirect('/admin/users');
    }

     /**
     * Thống kê tất cả của admin.
     *
     * @return array
     */
    public function dashboardAdmin() {
        if(auth()->user()->blocked) {
            return Auth::logout();
        }
        $user = User::whereNotIn('name',['admin',auth()->user()->name])->count();
        $article = Article::count();
        $rate = Rate::count();
        $category = Category::count();
        return view('admin.dashboard')->with([
            'user' => $user,
            'article' => $article,
            'rate' => $rate,
            'category' => $category
        ]);
    }
}
