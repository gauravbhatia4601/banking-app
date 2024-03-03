@extends('layouts.auth', ['title' => 'Register'])
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
        <fieldset class="form-fieldset mx-auto my-0" style="background:#fff;box-shadow:1px 1px 21px -15px #000;">
            <form class="p-4" action="{{route('register')}}" method="post">
                @csrf
                <h2 class="mb-4 font-weight-light">Create New account</h2>
                <div class="mb-4">
                    <label class="form-label required">Name</label>
                    <input type="text" class="form-control" placeholder="Name" autocomplete="off" name="name" value="{{old('name')}}"/>
                </div>
                
                <div class="mb-4">
                    <label class="form-label required">Email Address</label>
                    <input type="text" class="form-control" placeholder="Enter Email" autocomplete="off" name="email" value="{{old('email')}}"/>
                </div>
                <div class="mb-4">
                    <label class="form-label required">Password</label>
                    <input type="password" class="form-control" placeholder="Password" autocomplete="off" name="password"/>
                </div>
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" name="agree_term"/>
                    <span class="form-check-label">Agree the <a class="link">Term & Policy</a></span>
                </label>
                <div class="mt-4">
                    <button type="Submit" class="w-100 btn btn-primary">Create New Account</button>
                </div>
            <form>
        </fieldset>
        <div class="mt-4 text-center">
            <p>Already have account? <a class="link" href="{{route('login')}}">Sign In</a></p>
        </div>
    </div>
</div>
@endsection