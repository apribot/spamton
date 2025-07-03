<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'importance',
        'status',
        'user_id',
    ];

    /**
     * Get the user that the ticket is assigned to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
