@section('styles')
<style>
    .email-analytics-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-top: 3px solid #667eea;
    }
    
    .email-stat-box {
        text-align: center;
        padding: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .email-stat-box h4 {
        margin: 10px 0 5px 0;
        font-size: 24px;
        font-weight: bold;
    }
    
    .email-stat-box p {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }
</style>
@endsection

<div class="email-analytics-card">
    <h5 class="mb-4">
        <i class="fas fa-envelope"></i> Email Notifications Analytics
    </h5>
    
    <!-- Email Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="email-stat-box">
                <i class="fas fa-envelope" style="font-size: 24px;"></i>
                <h4>{{ $emailStats['total_emails'] ?? 0 }}</h4>
                <p>Total Emails</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="email-stat-box" style="background: linear-gradient(135deg, #51cf66, #37b24d);">
                <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                <h4>{{ $emailStats['sent_emails'] ?? 0 }}</h4>
                <p>Successfully Sent</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="email-stat-box" style="background: linear-gradient(135deg, #ff6b6b, #fa5252);">
                <i class="fas fa-times-circle" style="font-size: 24px;"></i>
                <h4>{{ $emailStats['failed_emails'] ?? 0 }}</h4>
                <p>Failed</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="email-stat-box" style="background: linear-gradient(135deg, #ffa500, #fd7e14);">
                <i class="fas fa-clock" style="font-size: 24px;"></i>
                <h4>{{ $emailStats['pending_emails'] ?? 0 }}</h4>
                <p>Pending</p>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row">
        <!-- Emails by Date Chart -->
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="emailsDateChart"></canvas>
            </div>
            <p class="text-center text-muted"><small>Emails Sent (Last 7 Days)</small></p>
        </div>
        
        <!-- Emails by Status Chart -->
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="emailsStatusChart"></canvas>
            </div>
            <p class="text-center text-muted"><small>Email Status Distribution</small></p>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Emails by Date Chart
    const emailDateCtx = document.getElementById('emailsDateChart');
    if (emailDateCtx) {
        const emailsByDate = @json($emailsByDate ?? []);
        
        new Chart(emailDateCtx, {
            type: 'line',
            data: {
                labels: emailsByDate.map(item => new Date(item.date).toLocaleDateString()),
                datasets: [
                    {
                        label: 'Sent',
                        data: emailsByDate.map(item => item.sent || 0),
                        borderColor: '#51cf66',
                        backgroundColor: 'rgba(81, 207, 102, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Failed',
                        data: emailsByDate.map(item => item.failed || 0),
                        borderColor: '#ff6b6b',
                        backgroundColor: 'rgba(255, 107, 107, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
    
    // Emails by Status Chart
    const emailStatusCtx = document.getElementById('emailsStatusChart');
    if (emailStatusCtx) {
        const emailsByStatus = @json($emailsByStatus ?? []);
        const statusColors = {
            'sent': '#51cf66',
            'failed': '#ff6b6b',
            'pending': '#ffa500'
        };
        
        new Chart(emailStatusCtx, {
            type: 'doughnut',
            data: {
                labels: emailsByStatus.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
                datasets: [{
                    data: emailsByStatus.map(item => item.count),
                    backgroundColor: emailsByStatus.map(item => statusColors[item.status] || '#667eea'),
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
</script>
@endsection
