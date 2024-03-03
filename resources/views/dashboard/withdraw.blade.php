@extends('layouts.main', ['title' => 'Withdraw Money'])
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
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header">
                <h3 class="card-title">Withdraw Money</h3>
            </div>
            
            <div class="card-body">
                <label class="form-label">Amount</label>
                <form action="{{route('withdraw')}}" method="post">
                    @csrf
                    <div>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount to withdraw">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="w-100 btn btn-primary ms-auto">Withdraw</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection