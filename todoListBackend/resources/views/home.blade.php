@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <todos user_id="{{auth()->user()->id}}"></todos>
    </div>
</div>

@endsection