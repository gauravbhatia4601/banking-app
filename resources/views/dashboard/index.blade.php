@extends('layouts.main', ['title' => 'Home'])
@section('content')
    <div class="container-xl w-50">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Welcome {{$user->name}}</h3>
            </div>
            <div class="card-table table-responsive">
                <table class="table table-vcenter">
                    <tr>
                    <td>
                    <span class="text-secondary">YOUR ID</span>
                        
                    </td>
                    <td class="text-muted">{{$user->email}}</td>
                    </tr>
                    <tr>
                    <td>
                        <span class="text-secondary">YOUR BALANCE</span>
                        
                    </td>
                    <td class="text-muted">{{$balance->balance}} INR</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection