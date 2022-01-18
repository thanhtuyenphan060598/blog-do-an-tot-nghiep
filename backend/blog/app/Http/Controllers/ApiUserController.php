<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Article;
use App\Models\Personal_Information;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Comment;

class ApiUserController extends Controller
{
     /**
     * Đăng ký người dùng.
     * @param  \Illuminate\Http\RegisterUserRequest  $request
     * @return json
     */
    public function register(RegisterUserRequest $request) {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->role_id = 2;
        $user->save();
        return response()->json(['ok' => 'asdasd'],201);

    }

     /**
     * Đăng nhâp người dùng.
     * @param  \Illuminate\Http\LoginUserRequest  $request
     * @return json
     */
    public function login(LoginUserRequest $request) {
        $checkBlock = User::where('username','=',$request->username)->first();
        if($checkBlock){
            if($checkBlock->blocked && Hash::check($request->password, $checkBlock->password)) {
                return response()->json([
                    'errors' => 'Tài khoản này đã bị khóa'
                ],401);
            }
        }

       $credentials = $request->only('username','password');
       if(!Auth::attempt($credentials)) {
           return response()->json([
               'errors' => 'Username hoặc mặt khẩu không đúng'
           ],401);
       }
       $user = User::where('username', $request->username)->first();

       if (!Hash::check($request->password, $user->password)) {
           throw new \Exception('Error in Login');
       }
       $tokenResult = $user->createToken('authToken')->plainTextToken;


       return response()->json([
           'status_code' => 200,
           'access_token' => $tokenResult,
           'token_type' => 'Bearer',
           'users' => $request->user(),
       ]);
    }

     /**
     * Đăng xuất người dùng.
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function logout(Request $request) {
        $user = User::where('id', $request->id)->first();
        $user->tokens()->delete();
        return response($user);
    }

     /**
     * Tạo thông tin cá nhân của người dùng.
     * @param  \Illuminate\Http\InformationRequest  $request
     * @return json
     */
    public function information(InformationRequest $request) {
        $information = Personal_Information::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'address' => $request->address,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth
            ]
            );
            return response()->json(['information'=>$information]);
    }

     /**
     * Lấy thông tin cá nhân người dùng.
     * @param int $id
     * @return json
     */
    public function getInfo($id) {
        $userInfo = Personal_Information::where('user_id',$id)->get();
        return response()->json(['userInfo' => $userInfo]);
    }

     /**
     * Đổi mật khẩu người dùng.
     *
     * @param  \App\Models\User $user
     * @return json
     */
    public function password(Request $request,User $user) {
        // "$2y$10$rjjlbKZQb3uLiWcKVXTD..HxTdbWH9v4jeoq35kxc7tBedbw6yOeW"
        if(!Hash::check($request->passwordPresent, $user->password)) {
            return response('Mat khau hien tai khong dung',400);
        }
        $user->update([
            'password' => Hash::make($request->passwordNew)
        ]);
    }

     /**
     * Tạo bình luận của người dùng.
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function comment(Request $request,Article $article) {
        $comments = $article->comments()->create([
            'description' => $request->description,
            'user_name' => $request->user_name
        ]);
    }

     /**
     * Lấy những bình luận của 1 bài viết.
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function comments(Article $article) {
        $getComments = $article->load('comments.comments');
        return response()->json(['getComments' => $getComments]);
    }

     /**
     * Thêm đánh gia của người dùng và kiểm tra chỉ cho phép đánh giá 1 lần.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function review(Request $request) {
        if(Rate::where([
            'user_id' => $request->user_id,
            'article_id' => $request->article_id,
            ])->exists()) {

                    $check = Rate::where([
                        'user_id' => $request->user_id,
                        'article_id' => $request->article_id,
                    ])->first();
                    if($check->like === $request->like) {
                        return response()->json('likeExits') ;
                    }
                }
            $rate = Rate::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'article_id' => $request->article_id,
            ],
            [
                'like' => $request->like
            ]

        );

        return response()->json(['rate'=>$rate]);

    }
     /**
     * Lấy và đếm những đánh giá like và dislike của bài viết
     *
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function reviewGet(Article $article) {
        $like = $article->rates()->where('like','=','1')->count();
        $dislike = $article->rates()->where('like','=','0')->count();
        $result = $like-$dislike;
        return response()->json(['result' => $result]);

    }

     /**
     * Lấy và đếm những bình luận của bài viết
     *
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function commentGet(Article $article) {
        $resultComment = $article->comments()->count();
        return response()->json(['resultComment' => $resultComment]);
    }

     /**
     * Lấy ra những bài viết của 1 người dùng.
     *
     * @param  \App\Models\User $user
     * @return json
     */
    public function userArticle(User $user) {
        $result = $user->load(['articles.tags','articles.category']);
        return response()->json(['result' => $result]);
    }

     /**
     * Lấy ra những bài viết có lượt xem nhiều nhât
     *
     * @return json
     */
    public function getPostView() {
        $articles = Article::with([
            'user' => function ($query) {
                $query->whereNotIn('blocked',[1]);
            },
            ])->withCount('comments')->orderByDesc('view')->whereNotIn('is_accept',[0])->take(11)->get();
        return response()->json(['articles' => $articles]);
    }

     /**
     * Xóa bình luận của người dùng.
     *
     * @param  \App\Models\Comment $comment
     * @return json
     */
    public function commentDelete(Comment $comment) {
        $comment->comments()->delete();
        $comment->delete();
    }

     /**
     * Sửa bình luận của người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment $comment
     * @return json
     */
    public function commentEdit(Request $request,Comment $comment) {
        $comment->update([
            'description' => $request->description
        ]);
    }

     public function uploadImg(Request $request,User $user) {
        $image = base64_encode(file_get_contents($request->file('thumbnail')));
        // $user->thumbnail = $image;
        // $user->save();
        return response()->json(['img'=>$image]);
     }

      /**
     * Xóa lượt thích của người dùng.
     *
     * @param  \App\Models\User $user
     * @return json
     */
    public function deleteLike(User $user) {
        $rate = Rate::where('user_id','=',$user->id)->first();
        $rate->delete();
     }

      /**
     * Phản hồi bình luận.
     *
     * @param  \App\Models\Comment $comment
     * @return json
     */
    public function commentFeedback(Request $request,Comment $comment) {
        $commentFeedback = $comment->comments()->create([
            'description' => $request->description,
            'user_name' => $request->user_name
        ]);
        return response()->json(['commentFeedback' => $commentFeedback]);
    }
    // public function getCommentFeedbacks(Comment $comment) {
    //     $getCommentFeedback = $comment->comments()->get();
    //     return response()->json(['listCommentFeedbacks' =>  $getCommentFeedback]);
    // }

     /**
     * Kiểm tra User có bị khóa.
     *
     * @param  \App\Models\User $user
     * @return json
     */
    public function checkUser(User $user) {
        return response()->json(['user' => $user->blocked]);
    }

     /**
     * Hiển thị lượt thích của User.
     *
     * @param  \App\Models\User $user
     * @return json
     */
    public function userLike(Request $request) {
        $user = Rate::where('user_id','=',$request->get('user'))
                ->where('article_id','=',$request->get('article'))
                ->first();
        return response()->json(['userLike' => $user]);
    }


}
