<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeRequest extends Model
{
    protected $table = 'exchange_request'; // Set the table name if it's different

    protected $fillable = [
        'sender_id', 'receiver_id', 'post_id', 'accepted',
    ];

    /**
     * Get the sender of this exchange request.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of this exchange request.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the post associated with this exchange request.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}

