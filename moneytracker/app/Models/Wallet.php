<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'currency_code',
        'initial_balance',
        'is_active',
        'description',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = ['balance'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'initial_balance' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all transactions for the wallet.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the wallet balance.
     * Balance = initial_balance + total income - total expense.
     */
    public function getBalanceAttribute(): float
    {
        $income = $this->transactions()->where('type', Transaction::TYPE_INCOME)->sum('amount');
        $expense = $this->transactions()->where('type', Transaction::TYPE_EXPENSE)->sum('amount');

        return (float) $this->initial_balance + (float) $income - (float) $expense;
    }

    /**
     * Scope to only active wallets.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
