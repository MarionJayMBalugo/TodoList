<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <script>window.Laravel={csrfToken:'{{csrf_token()}}'}</script>
        <title>Laravel</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('css/landingPageStyle.css') }}" rel="stylesheet">

    </head>
    <body>
    <div class="container" style="margin-top:20%;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    
                    <div class="card-body">

                        <center>
                            <h2>Todo</h2>
                            @guest
                                <button class="btn btn btn-outline-success "><a href="{{route('login')}}">Log In</a></button><br>
                                <button class="bbtn btn-outline-info"><a href="{{route('register')}}">Register</a></button>
                            @else
                                <button class="btn btn btn-outline-info md-3"><a href="{{route('register')}}">Home</a></button>
                            @endguest
                        </center>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
