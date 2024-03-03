@extends('layouts.main', ['title' => 'Transfer Money'])
@section('content')
    <div class="container-xl w-50">
        <div class="card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header">
                <h3 class="card-title">Transfer Money</h3>
            </div>
            
            <div class="card-body">
                
                <form action="{{route('transfer')}}" method="post">
                    @csrf
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="text" name="receiver_email" class="form-control" placeholder="Enter email" value="{{old('receiver_email')}}">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount to transfer" value="{{old('amount')}}">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="w-100 btn btn-primary ms-auto">Transfer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection