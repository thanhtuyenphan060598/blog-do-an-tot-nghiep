@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')

@stop

@section('content')
          <h3 class="box-title">Quản lý bình luận</h3>


        <!-- /.box-header -->
        <table class="table">
            <thead class="thead-dark">
              <tr style="width:200px;">
                <th scope="col">id</th>
                <th scope="col">Bài viết</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Bình luận</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($articleComments as $articleComment)
                <tr>
                  <th scope="row">{{$articleComment->id}}</th>
                  <td>{{$articleComment->title}}</td>
                  <td>{{$articleComment->comments_count}}</td>
                  <td>
                      @foreach ($articleComment->comments as $comment)
                        <form class="mt-1" action="{{route('comment.destroy',['comment'=>$comment])}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <span>{{$comment->user_name}} : {{$comment->description}}</span>
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
            <li class="page-item"><a class="page-link" href="{{$articleComments->previousPageUrl()}}">«</a></li>
            @for ($i = 1; $i <= $articleComments -> lastPage(); $i++)
                <li class="page-item"><a class="page-link" href="{{$articleComments->url($i)}}">{{$i}}</a></li>
            @endfor
            <li class="page-item"><a class="page-link" href="{{$articleComments->nextPageUrl()}}">»</a></li>
            </ul>
          </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
