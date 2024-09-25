@extends('layout.base')

@section('title', 'Routing Parameter')

@section('content')
<div class="container">
    <h1 class="mb-4">Routing Parameters</h1>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="paramTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="one-param-tab" data-bs-toggle="tab" href="#one-param" role="tab" aria-controls="one-param" aria-selected="true">1 Param</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="two-param-tab" data-bs-toggle="tab" href="#two-param" role="tab" aria-controls="two-param" aria-selected="false">2 Params</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-4" id="paramTabContent">
        <!-- 1 Parameter Tab -->
        <div class="tab-pane fade show active" id="one-param" role="tabpanel" aria-labelledby="one-param-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">1 Parameter</h5>
                </div>
                <div class="card-body">
                    <form id="form1" method="GET" action="">
                        <div class="mb-3">
                            <label for="param1" class="form-label">Parameter 1:</label>
                            <input type="text" class="form-control" id="param1" name="param1" placeholder="Enter parameter 1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preview URL:</label>
                            <p id="preview-1" class="form-text text-muted">URL preview will appear here.</p>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2 Parameters Tab -->
        <div class="tab-pane fade" id="two-param" role="tabpanel" aria-labelledby="two-param-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">2 Parameters</h5>
                </div>
                <div class="card-body">
                    <form id="form2" method="GET" action="">
                        <div class="d-flex flex-column flex-md-row w-100 gap-3">
                            <div class="mb-3 flex-grow-1">
                                <label for="param1-2" class="form-label">Parameter 1:</label>
                                <input type="text" class="form-control" id="param1-2" name="param1" placeholder="Enter parameter 1" required>
                            </div>
                            <div class="mb-3 flex-grow-1">
                                <label for="param2-2" class="form-label">Parameter 2:</label>
                                <input type="text" class="form-control" id="param2-2" name="param2" placeholder="Enter parameter 2" required>
                            </div>
                        </div>                        
                        <div class="mb-3">
                            <label class="form-label">Preview URL:</label>
                            <p id="preview-2" class="form-text text-muted">URL preview will appear here.</p>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- param result -->
    @yield('param-content')
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form1 = document.getElementById('form1');
        const param1Input = document.getElementById('param1');
        const preview1Span = document.getElementById('preview-1');

        const form2 = document.getElementById('form2');
        const param1Input2 = document.getElementById('param1-2');
        const param2Input2 = document.getElementById('param2-2');
        const preview2Span = document.getElementById('preview-2');

        function updatePreview1() {
            const param1 = encodeURIComponent(param1Input.value);
            const previewUrl1 = `{{ url('/PBKK1/param') }}/${param1}`;
            preview1Span.textContent = previewUrl1;
        }

        function updatePreview2() {
            const param1 = encodeURIComponent(param1Input2.value);
            const param2 = encodeURIComponent(param2Input2.value);
            const previewUrl2 = `{{ url('/PBKK1/param') }}/${param1}/${param2}`;
            preview2Span.textContent = previewUrl2;
        }

        param1Input.addEventListener('input', updatePreview1);
        param1Input2.addEventListener('input', updatePreview2);
        param2Input2.addEventListener('input', updatePreview2);

        form1.addEventListener('submit', function(e) {
            e.preventDefault();
            const param1 = encodeURIComponent(param1Input.value);
            const url = `{{ url('/PBKK1/param') }}/${param1}`;
            window.location.href = url;
        });

        form2.addEventListener('submit', function(e) {
            e.preventDefault();
            const param1 = encodeURIComponent(param1Input2.value);
            const param2 = encodeURIComponent(param2Input2.value);
            const url = `{{ url('/PBKK1/param') }}/${param1}/${param2}`;
            window.location.href = url;
        });

        // Initialize previews
        updatePreview1();
        updatePreview2();
    });
</script>
@endsection
