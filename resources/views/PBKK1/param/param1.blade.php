@extends('PBKK1.param')

@section('title', '1 Param')

@section('param-content')
<div class="card">
    <div class="card-header bg-success">
        <h5 class="card-title">Hasil</h5>
    </div>
    <div class="card-body">
        <div>URL : {{ url()->current() }}</div>
        <div> Parameter 1 : {{ $data['param1'] }}</div>
    </div>
    <div class="card-footer">
        <a href="{{ url('/PBKK1/param') }}">
            <button class="btn btn-success">Remove</button>
        </a>
    </div>
</div>
@endsection
