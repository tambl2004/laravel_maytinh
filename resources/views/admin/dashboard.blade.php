@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Chào mừng, {{ Auth::user()->name }}!</h1>
    <p>Đây là khu vực quản trị của bạn.</p>
@endsection