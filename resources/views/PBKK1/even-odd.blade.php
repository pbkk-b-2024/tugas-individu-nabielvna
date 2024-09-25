@extends('layout.base')

@section('title', 'Even Odd')

@section('content')
    <div class="container">
        <h1 class="mb-4">Even / Odd</h1>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">Even / Odd Checker</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('even-odd') }}" method="GET">
                    <div class="form-group">
                        <label for="n">Enter a number (n):</label>
                        <input type="number" class="form-control" name="n" id="n" min="1" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Choose mode:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="mode_sequence" value="sequence" checked>
                            <label class="form-check-label" for="mode_sequence">
                                Generate sequence from 1 to n
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="mode_single" value="single">
                            <label class="form-check-label" for="mode_single">
                                Check single number
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-3">Submit</button>
                </form>
            </div>
        </div>

        <!-- Result for Sequence -->
        @if (isset($numberDetails) && count($numberDetails) > 0)
            <h2 class="mb-3">Sequence Result</h2>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($numberDetails as $detail)
                        <tr>
                            <td>{{ $detail['number'] }}</td>
                            <td>{{ $detail['type'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Result for Single Number -->
        @if (isset($singleResult))
            <h2 class="mb-3">Single Number Result</h2>
            <div class="alert alert-info">
                The number {{ $singleResult['number'] }} is {{ $singleResult['type'] }}.
            </div>
        @endif
    </div>
@endsection