@extends('layouts.app')

@section('content')
{{--    <div class="text-6xl">hello world</div>--}}
    <notification></notification>
    <navbar></navbar>
    <router-view></router-view>
@endsection
