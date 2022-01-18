@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')

@stop

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Quản lý thẻ</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 300px">id</th>
            <th>Tên thẻ</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag_admin)
            <tr>
                <td>{{$tag_admin->id}}</td>
                <td>{{$tag_admin->name_tag}}</td>
                <td>
                </td>
                <td>

                    <form action="{{route('tag_admin.destroy',['tag_admin'=>$tag_admin])}}" method="POST">
                        <a href="{{route('tag_admin.edit',['tag_admin'=>$tag_admin])}}"><i class="fas fa-edit"  style=></i></a>
                        @csrf
                        @method('delete')
                        <button
                        style=" background-color: transparent;
                            border: none;
                            cursor: pointer;"
                         type="submit"><a href="#"><i class="fas fa-trash" ></i></a></button>
                    </form>

                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      <table class="table table-striped">
            <tr >
                <form action="{{route('tag_admin.store')}}" method="POST">
                    @csrf
                <td style="width: 930px;">
                    <div class="form-group">
                        <input type="text" name="tag_admin"  class="form-control" placeholder="Enter user name" required>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus-circle"></i> Thêm</button>
                    </div>
                </td>
                </form>
              </tr>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  @if (request()->get('tag_admin_name'))
  <form action="{{route('tag_admin.update',['tag_admin'=> request()->get('tag_admin_id')])}}" method="post">
      @csrf
      @method('put')
    <div class="form-group">
        <label>Sua <span class="text-danger">*</span></label>
        <input type="text" name="tag_admin_name" value="{{request()->get('tag_admin_name')}}" id="username" class="form-control" placeholder="Enter user name" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus-circle"></i> Lưu</button>
    </div>
    </form>
  @endif


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
