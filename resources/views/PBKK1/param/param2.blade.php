@extends('PBKK1.param')

@section('title', '2 params')

@section('param-content')
<div class="card">
    <div class="card-header bg-success">
        <h5 class="card-title">Hasil</h5>
    </div>
    <div class="card-body">
        <div>URL : {{ url()->current() }}</div>
        <div> Parameter  : {{ $data['param1'] }}</div>
        <div> Parameter 2 : {{ $data['param2'] }}</div>
    </div>
    <div class="card-footer">
        <a href="{{ url('/PBKK1/param') }}">
            <button class="btn btn-success">Remove</button>
        </a>
    </div>
</div>
@endsection
