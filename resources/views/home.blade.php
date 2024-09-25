@extends('layout.base')

@section('title', 'Home')

@section('content')
<div class="container">
    @foreach ($cards as $group)
        <h2>{{ $group['parent_title'] }}</h2>
        <div class="row">
            @foreach ($group['children'] as $card)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">{{ $card['title'] }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $card['description'] }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route($card['route']) }}" class="btn btn-primary">Go to {{ $card['title'] }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
