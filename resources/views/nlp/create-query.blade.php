@extends('layouts.app')

@section('title', 'Create Natural Language Query')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-brain"></i> Ask a Question
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="dashboard-card">
            <h5>Natural Language Query</h5>
            <p class="text-muted">Enter your query in natural language. The system will convert it to SQL and execute it.</p>

            <form action="{{ route('nlp.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="query" class="form-label">Your Query</label>
                    <textarea class="form-control @error('natural_language_query') is-invalid @enderror" 
                              id="query" name="natural_language_query" rows="4" 
                              placeholder="e.g., show students with attendance below 60%"
                              required></textarea>
                    @error('natural_language_query')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Execute Query
                </button>
            </form>

            <hr>

            <h5 class="mt-4">Example Queries</h5>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action" 
                   onclick="setQuery('show students with attendance below 60%')">
                    "show students with attendance below 60%"
                </a>
                <a href="#" class="list-group-item list-group-item-action"
                   onclick="setQuery('list students failing in database course')">
                    "list students failing in database course"
                </a>
                <a href="#" class="list-group-item list-group-item-action"
                   onclick="setQuery('show top performing students')">
                    "show top performing students"
                </a>
                <a href="#" class="list-group-item list-group-item-action"
                   onclick="setQuery('students with marks below 40')">
                    "students with marks below 40"
                </a>
                <a href="#" class="list-group-item list-group-item-action"
                   onclick="setQuery('show high risk students')">
                    "show high risk students"
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function setQuery(query) {
    document.getElementById('query').value = query;
    event.preventDefault();
}
</script>
@endsection
