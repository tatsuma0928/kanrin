
<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
@extends('layout')
@section('title', '予定設定')
@section('content')

    <h1>予定入力</h1>
    <!-- 休日入力フォーム -->
    <form method="POST" action="/holiday"> 
    <div class="calendar-group">
    {{csrf_field()}}    
    <label for="day" class="calendar-font">日付 </label>
    <input type="text" name="day" class="form-control" id="day" value="{{$data->day}}">
    <label for="description" class="calendar-font">詳細</label>
    <input type="text" name="description" class="form-control" id="description" value="{{$data->description}}"> 
    </div>
    <button type="submit" class="btn btn-primary btn-lg">登録</button> 
    <input type="hidden" name="id" value="{{$data->id}}">
    </form>  
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- 休日一覧表示 -->
    <table class="table">
    <thead>
    <tr>
    <th scope="col">日付</th>
    <th scope="col">説明</th>
    <th scope="col">作成日</th>
    <th scope="col">更新日</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $val)
    <tr>
    <th>{{$val->day}}</th>
    <th>{{$val->description}}</th>
    <th>{{$val->created_at}}</th>
    <th>{{$val->updated_at}}</th>
    <th scope="row"><a href="{{ url('/holiday/'.$val->id) }}">編集</a></th>
    <th><form action="/holiday" method="post">
            <input type="hidden" name="id" value="{{$val->id}}">
            {{ method_field('delete') }}
            {{csrf_field()}} 
            <button class="btn btn-default" type="submit">Delete</button>
    </form></th>
    </tr>
    @endforeach
    </tbody>
    </table>
    <a href="{{ url('/') }}" class="calendar-btn">カレンダーへ</a>
    <script>
  $( function() {
    $( "#day" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );
</script>
@endsection
