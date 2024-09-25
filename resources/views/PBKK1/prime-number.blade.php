@extends('layout.base')

@section('title', 'Prime Number')

@section('content')
<div class="container">
    <h1 class="mb-4">Prime Number</h1>

    <!-- Prime Number Form -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">Prime Number Calculator</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('prime-number') }}" method="GET">
                <div class="form-group">
                    <label for="n">Enter a number (n):</label>
                    <input type="number" class="form-control" name="n" id="n" min="1" required>
                </div>
                <div class="form-group mt-3">
                    <label>Choose mode:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="mode_sequence" value="sequence" checked>
                        <label class="form-check-label" for="mode_sequence">
                            Generate prime numbers up to n
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="mode_nth" value="nth">
                        <label class="form-check-label" for="mode_nth">
                            Find nth prime number
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="mode_check" value="check">
                        <label class="form-check-label" for="mode_check">
                            Check if n is prime
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Submit</button>
            </form>
        </div>
    </div>

    <!-- Result for Sequence -->
    @if (isset($primeSequence) && count($primeSequence) > 0)
        <h2 class="mb-3">Prime Numbers Sequence</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Position</th>
                    <th>Prime Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($primeSequence as $position => $prime)
                    <tr>
                        <td>{{ $position }}</td>
                        <td>{{ $prime }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Result for Nth Prime -->
    @if (isset($nthPrime))
        <h2 class="mb-3">Nth Prime Number</h2>
        <div class="alert alert-info">
            The {{ request('n') }}th prime number is: {{ $nthPrime }}
        </div>
    @endif

    <!-- Result for Prime Check -->
    @if (isset($isPrime))
        <h2 class="mb-3">Prime Number Check</h2>
        <div class="alert alert-{{ $isPrime ? 'success' : 'warning' }}">
            {{ request('n') }} is {{ $isPrime ? 'a prime number' : 'not a prime number' }}.
            @if ($isPrime)
                It is the {{ $position }}th prime number.
            @endif
        </div>
    @endif
</div>
@endsection