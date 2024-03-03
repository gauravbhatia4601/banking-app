@extends('layouts.main', ['title' => 'Statements'])
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
                <h3 class="card-title">Statement of Account</h3>
            </div>
            <div class="card-table">
            <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>DATETIME</th>
                          <th>AMOUNT</th>
                          <th>TYPE</th>
                          <th>DETAILS</th>
                          <th>BALANCE</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($transactions->isNotEmpty()) @foreach ($transactions as $transaction)
                                <tr>
                                    <td><span class="text-muted">{{ $transaction->id }}</span></td>
                                    <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>{{ number_format($transaction->amount, 2) }} INR</td>
                                    <td >{{ $transaction->type() }}</td>
                                    <td class="text-wrap"> {{ $transaction->transactionType() }}</td>
                                    <td>{{ $transaction->balance() }} INR</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No Statements Yet.</td> </tr>
                        @endif
                    </tbody>

                    </table>
                  </div></div>
        </div>
    </div>
@endsection