@extends('layout.base')

@section('title', 'Fibonacci')

@section('content')
<div class="container">
    <h1 class="mb-4">Fibonacci</h1>
    
    <!-- Fibonacci Form -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Fibonacci Calculator</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('fibonacci') }}" method="GET">
                <div class="form-group">
                    <label for="n">Enter a number (n):</label>
                    <input type="number" class="form-control" name="n" id="n" min="0" required>
                </div>
                <div class="form-group mt-3">
                    <label>Choose mode:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="mode_sequence" value="sequence" checked>
                        <label class="form-check-label" for="mode_sequence">
                            Generate Fibonacci sequence up to n
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="mode_nth" value="nth">
                        <label class="form-check-label" for="mode_nth">
                            Find nth Fibonacci number
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="mode_check" value="check">
                        <label class="form-check-label" for="mode_check">
                            Check if n is part of Fibonacci sequence
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-info mt-3">Submit</button>
            </form>
        </div>
    </div>

    <!-- Result for Sequence -->
    @if (isset($fibonacciSequence) && count($fibonacciSequence) > 0)
        <h2 class="mb-3">Fibonacci Sequence</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Position</th>
                    <th>Fibonacci Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fibonacciSequence as $position => $number)
                    <tr>
                        <td>{{ $position + 1 }}</td>
                        <td>{{ $number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Result for nth Fibonacci -->
    @if (isset($nthFibonacci))
        <h2 class="mb-3">Nth Fibonacci Number</h2>
        <div class="alert alert-info">
            The {{ request('n') }}{{ (request('n') == 1) ? 'st' : ((request('n') == 2) ? 'nd' : ((request('n') == 3) ? 'rd' : 'th')) }} Fibonacci number is: {{ $nthFibonacci }}
        </div>
    @endif

    <!-- Result for Checking if Part of Sequence -->
    @if (isset($isFibonacci))
        <h2 class="mb-3">Fibonacci Sequence Check</h2>
        <div class="alert alert-{{ $isFibonacci ? 'success' : 'warning' }}">
            {{ request('n') }} is {{ $isFibonacci ? '' : 'not' }} part of the Fibonacci sequence.
            @if ($isFibonacci && isset($position))
                It is the {{ $position }}{{ ($position == 1) ? 'st' : (($position == 2) ? 'nd' : (($position == 3) ? 'rd' : 'th')) }} Fibonacci number.
            @endif
        </div>
    @endif
</div>
@endsection