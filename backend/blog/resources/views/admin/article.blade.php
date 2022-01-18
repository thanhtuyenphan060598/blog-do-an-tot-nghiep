@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')

@stop

@section('content')
<div class="card">
        <div class="card-header">
            <h3 class="card-title">Quản lý bài viết</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Người viết</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Chuyên mục</th>
                    <th scope="col">Thẻ</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    <tr>
                        <th scope="row">{{$article->id}}</th>
                        <td>{{$article->user->name}}</td>
                        <td>{{$article->title}}</td>
                        <td><span style="
                            border: 1px solid rgb(3, 15, 119);
                            padding: 5px 20px;
                            background-color: rgb(3, 15, 119);
                            color: white;
                            margin-bottom:10px;
                            width:140px;
                            display:block;
                            ">{{$article->category->name_category}}</span></td>
                        <td>
                            @foreach ($article->tags as $tag )
                            <span style="
                            border: 1px solid black;
                            padding: 5px 20px;
                            border-radius: 10%;
                            background-color: black;
                            color: white;
                            margin-bottom:10px;
                            display:inline-block;
                            "
                            >{{$tag->name_tag}}</span>
                            @endforeach
                        </td>

                        <td>
                            <form action="{{route('article.destroy',['article'=>$article])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Xóa</button>
                            </form>

                        </td>
                        @if (!$article->is_accept)
                            <td>
                                <form action="{{route('acceptArticle',['article'=>$article])}}" method="POST">

                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i> Duyệt</button>
                                </form>
                            </td>
                        @endif



                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item"><a class="page-link" href="{{$articles->previousPageUrl()}}">«</a></li>
                @for ($i = 1; $i <= $articles -> lastPage(); $i++)
                    <li class="page-item"><a class="page-link" href="{{$articles->url($i)}}">{{$i}}</a></li>
                @endfor
                <li class="page-item"><a class="page-link" href="{{$articles->nextPageUrl()}}">»</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
