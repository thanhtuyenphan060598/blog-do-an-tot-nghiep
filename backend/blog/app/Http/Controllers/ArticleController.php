<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Tag;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return json
     */
    public function index(Request $request)
    {
        //

        $articles = Article::query();
        if($request->get('search')) {
            $articles->where('title','like',"%{$request->get('search')}%");
        }
        if($request->get('category')) {
            $articles->where('category_id','=',$request->get('category'));
        }
        if($request->get('tag')) {
            $tag = Tag::where('id','=',$request->get('tag'))->first();
            $articles = $tag->articles();
        }
        $resultArticles = $articles
                        ->with([
                            'user',
                            'tags',
                            'rates'
                            ])
                        ->withCount(['comments'])
                        ->orderBy('id','DESC')
                        ->whereNotIn('is_accept',[0])
                        ->paginate(15);
        return response()->json(['articles' => $resultArticles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return json
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function store(Request $request)
    {
        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id
        ]);
        $article->tags()->attach($request->tagsId);

        return response()->json(['request'=>$article]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function show(Article $article)
    {
        //
        $rate = $article->load(['rates','tags','user'])->loadCount('comments');
        $postContact = Article::inRandomOrder()->where('category_id','=',$article->category_id)
                        ->with('user',function($query){
                            $query->whereNotIn('blocked',[1]);
                        })
                        ->withCount('comments')
                        ->whereNotIn('id',[$article->id])
                        ->take(4)
                        ->get();
        $postNew = Article::whereNotIn('id',[$article->id])->with('user',function($query){
            $query->whereNotIn('blocked',[1]);
        })
                        ->withCount('comments')->orderByDesc('id')->take(10)->get();
        return response()->json([
                            'article' => $rate,
                            'postContact' => $postContact,
                            'postNew'=>$postNew]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function edit(Article $article)
    {
        //
        $articleEdit=$article->load(['category','tags']);
        return response()->json(array('article' => $articleEdit));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function update(Request $request, Article $article)
    {
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id
        ]);
        $article->tags()->sync($request->tagsId);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return json
     */
    public function destroy(Article $article)
    {
        //
        $tags = $article->tags;
        $article->tags()->detach($tags);
        $article->comments;
        $article->delete();
        return 'ok';
    }
    public function updateView(Request $request, Article $article)
    {
        //
        $article->view = $request->view;
        $article->update();

    }
}
