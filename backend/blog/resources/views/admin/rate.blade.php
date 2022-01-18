@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')

@stop

@section('content')
<h3 class="box-title">Quản lý đánh giá</h3>
<table class="table table-dark" style="width:100%">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">Tên bài viết</th>
        <th scope="col">Người đánh giá</th>
        <th scope="col">Đánh giá</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($rateArticle as $article)
        <tr>
          <th scope="row">{{$article->id}}</th>
          <td>{{$article->title}}</td>
          <td style="width:15%">
            @foreach ($article->rates as $rateUser)
                <p>{{$rateUser->user->name}}</p>
            @endforeach
          </td>
          <td style="width:15%">
              @foreach ($article->rates as $rate)
                    <form class="mt-1" action="{{route('rate.destroy',['rate'=>$rate])}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <span >{{$rate->like}}</span>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban" aria-hidden="true"></i></button>
                    </form>
              @endforeach
          </td>
        </tr>
        @endforeach

    </tbody>
  </table>
  <div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
    <li class="page-item"><a class="page-link" href="{{$rateArticle->previousPageUrl()}}">«</a></li>
    @for ($i = 1; $i <= $rateArticle -> lastPage(); $i++)
        <li class="page-item"><a class="page-link" href="{{$rateArticle->url($i)}}">{{$i}}</a></li>
    @endfor
    <li class="page-item"><a class="page-link" href="{{$rateArticle->nextPageUrl()}}">»</a></li>
    </ul>
  </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
