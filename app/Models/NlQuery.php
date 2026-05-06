<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NlQuery extends Model
{
    protected $table = 'nl_queries';

    protected $fillable = [
        'user_id',
        'natural_language_query',
        'generated_sql',
        'query_result',
        'query_status',
        'error_message',
        'execution_time',
        'query_intent',
    ];

    protected $casts = [
        'query_result' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
