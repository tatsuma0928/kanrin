@extends('layout')
@section('title', 'カレンダー')
@section('content')
    {!!$cal_tag!!}
    <a href="{{ url('/holiday') }}">予定入力へ</a>
@endsection