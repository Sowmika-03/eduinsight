<?php

namespace App\Services;

use App\Models\EmailLog;
use Illuminate\Support\Facades\DB;

class EmailAnalyticsService
{
    /**
     * Get email statistics for dashboard (all emails - for admin)
     */
    public function getEmailStats($userId = null)
    {
        $query = EmailLog::query();
        if ($userId) {
            $query->where('sender_id', $userId);
        }
        
        return [
            'total_emails' => $query->count(),
            'sent_emails' => $query->clone()->where('status', 'sent')->count(),
            'failed_emails' => $query->clone()->where('status', 'failed')->count(),
            'pending_emails' => $query->clone()->where('status', 'pending')->count(),
        ];
    }

    /**
     * Get emails sent by date (last 7 days)
     */
    public function getEmailsByDate($userId = null)
    {
        $query = EmailLog::selectRaw('DATE(created_at) as date, COUNT(*) as count, 
                SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            ->where('created_at', '>=', now()->subDays(7));
        
        if ($userId) {
            $query->where('sender_id', $userId);
        }
        
        return $query->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Get emails by status
     */
    public function getEmailsByStatus($userId = null)
    {
        $query = EmailLog::selectRaw('status, COUNT(*) as count');
        
        if ($userId) {
            $query->where('sender_id', $userId);
        }
        
        return $query->groupBy('status')->get();
    }

    /**
     * Get top recipients
     */
    public function getTopRecipients($limit = 10, $userId = null)
    {
        $query = EmailLog::selectRaw('receiver_email, COUNT(*) as count');
        
        if ($userId) {
            $query->where('sender_id', $userId);
        }
        
        return $query->groupBy('receiver_email')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get email stats by sender (for admin dashboard only)
     */
    public function getEmailsBySender()
    {
        return EmailLog::with('sender')
            ->selectRaw('sender_id, COUNT(*) as count, 
                SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            ->groupBy('sender_id')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Get email stats for specific user (for faculty/HOD)
     */
    public function getUserEmailStats($userId)
    {
        return [
            'total_sent' => EmailLog::where('sender_id', $userId)->count(),
            'successfully_sent' => EmailLog::where('sender_id', $userId)
                ->where('status', 'sent')->count(),
            'failed_sent' => EmailLog::where('sender_id', $userId)
                ->where('status', 'failed')->count(),
        ];
    }
}
