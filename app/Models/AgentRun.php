<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentRun extends Model
{
    protected $fillable = [
        'user_id',
        'agent_key',
        'source',
        'status',
        'payload',
        'result',
        'error_message',
        'requested_ip',
        'user_agent',
        'executed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'result' => 'array',
        'executed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
