@extends('layouts.app')

@section('title', 'Natural Language Queries')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-brain"></i> Natural Language Query System
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Query Examples</h5>
            <p>Try these natural language queries:</p>
            <ul>
                <li>"Show students with attendance below 60%"</li>
                <li>"List students failing in database course"</li>
                <li>"Show top performing students"</li>
                <li>"Students with marks below 40"</li>
                <li>"Show students at high academic risk"</li>
            </ul>
            <a href="{{ route('nlp.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Query
            </a>
        </div>
    </div>
</div>

<!-- Previous Queries -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Your Queries</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Query</th>
                            <th>Status</th>
                            <th>Execution Time</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queries as $query)
                            <tr>
                                <td>{{ Str::limit($query->natural_language_query, 50) }}</td>
                                <td>
                                    @if($query->query_status === 'success')
                                        <span class="badge bg-success">Success</span>
                                    @elseif($query->query_status === 'error')
                                        <span class="badge bg-danger">Error</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $query->execution_time }}ms</td>
                                <td>{{ $query->created_at->format('M d, Y g:i A') }} IST</td>
                                <td>
                                    <a href="{{ route('nlp.show', $query) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No queries yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $queries->links() }}
        </div>
    </div>
</div>
@endsection
