@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Quản lý người dùng</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
        <thead>
            <tr>
            <th style="width: 10px">id</th>
            <th>Name</th>
            <th>Username</th>
            <th style="width: 40px">Email</th>
            <th style="width: 40px">Role</th>
            <th style="width: 40px">Blocked</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)

            <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role->name_role}}</td>
            <td>

                    <form action="{{ route('blocked',['user'=> $user]) }}" method="POST">
                        @csrf
                        @if (!$user->blocked)
                            <button type="submit" class="badge bg-success">lock</button>
                        @else
                            <button type="submit" class="badge bg-danger">unlock</button>
                        @endif
                    </form>

            </td>
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item"><a class="page-link" href="{{$users->previousPageUrl()}}">«</a></li>
        @for ($i = 1; $i <= $users -> lastPage(); $i++)
            <li class="page-item"><a class="page-link" href="{{$users->url($i)}}">{{$i}}</a></li>
        @endfor
        <li class="page-item"><a class="page-link" href="{{$users->nextPageUrl()}}">»</a></li>
        </ul>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
