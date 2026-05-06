@extends('layouts.app')

@section('title', 'Email History')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Email History</h5>
                <a href="{{ route('email.send') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Send New Email
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" action="{{ route('email.history') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by subject or email" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Table -->
            @if ($emailLogs->count())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Recipient</th>
                                <th>Sent By</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emailLogs as $log)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($log->subject, 40) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($log->message, 60) }}</small>
                                    </td>
                                    <td>{{ $log->receiver_email }}</td>
                                    <td>{{ $log->sender->name }}</td>
                                    <td>
                                        @if ($log->status === 'sent')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Sent
                                            </span>
                                        @elseif ($log->status === 'failed')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Failed
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-hourglass"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($log->sent_at)
                                            {{ $log->sent_at->format('d M Y, g:i A') }} IST
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($log->status === 'failed')
                                            <form action="{{ route('email.resend', $log) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Resend">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                data-bs-target="#viewModal{{ $log->id }}" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Email Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>To:</strong> {{ $log->receiver_email }}</p>
                                                <p><strong>From:</strong> {{ $log->sender->name }}</p>
                                                <p><strong>Subject:</strong> {{ $log->subject }}</p>
                                                <p><strong>Status:</strong> {{ ucfirst($log->status) }}</p>
                                                <p><strong>Sent:</strong> {{ $log->sent_at ? $log->sent_at->format('d M Y, g:i A') . ' IST' : 'Not sent' }}</p>
                                                @if ($log->error_message)
                                                    <p><strong class="text-danger">Error:</strong> {{ $log->error_message }}</p>
                                                @endif
                                                <hr>
                                                <p><strong>Message:</strong></p>
                                                <div class="bg-light p-2" style="border-radius: 5px;">
                                                    {{ nl2br(e($log->message)) }}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav>
                    {{ $emailLogs->links() }}
                </nav>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-inbox"></i> No emails found
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
