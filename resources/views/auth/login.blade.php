@extends('layouts.auth', ['title' => 'Login'])
@section('content')
<div class="page-body">
    <div class="container-lg" style="width:30%;">
        <div class="text-center mb-4">
            <h1 class="text-secondary">ABC BANK</h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <fieldset class="form-fieldset mx-auto my-0" style="background:#fff;box-shadow:1px 1px 21px -15px #000;">
            <form class="p-4" method="post" action="{{route('login')}}">
                @csrf
                <h2 class="mb-4 font-weight-light">Login to your account</h2>
                <div class="mb-4">
                    <label class="form-label required">Email Address</label>
                    <input type="text" class="form-control" placeholder="Enter Email" autocomplete="off" name="email" value="{{old('email')}}"/>
                </div>
                <div class="mb-4">
                    <label class="form-label required">Password</label>
                    <input type="text" class="form-control" placeholder="Password" autocomplete="off" name="password"/>
                </div>
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember"/>
                    <span class="form-check-label">Remember Me</span>
                </label>
                <div class="mt-4">
                    <button type="Submit" class="w-100 btn btn-primary">Sign in</button>
                </div>
            <form>
        </fieldset>
        <div class="mt-4 text-center">
            <p>Don't have account yet? <a class="link" href="{{route('register')}}">Sign up</a></p>
        </div>
    </div>
</div>
@endsection