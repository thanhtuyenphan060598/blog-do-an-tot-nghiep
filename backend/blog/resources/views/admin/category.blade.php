@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')

@stop

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Quản lý danh mục</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 300px">id</th>
            <th>Tên danh mục</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name_category}}</td>
                <td>
                </td>
                <td>

                    <form action="{{route('category.destroy',['category'=>$category])}}" method="POST">
                        <a href="{{route('category.edit',['category'=>$category])}}"><i class="fas fa-edit"  style=></i></a>
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
                <form action="{{route('category.store')}}" method="POST">
                    @csrf
                <td style="width: 930px;">
                    <div class="form-group">
                        <input type="text" name="category"  class="form-control" placeholder="Enter user name" required>
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
  @if (request()->get('category_name'))
  <form action="{{route('category.update',['category'=> request()->get('category_id')])}}" method="post">
      @csrf
      @method('put')
    <div class="form-group">
        <label>Sua <span class="text-danger">*</span></label>
        <input type="text" name="category_name" value="{{request()->get('category_name')}}" id="username" class="form-control" placeholder="Enter user name" required>
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
