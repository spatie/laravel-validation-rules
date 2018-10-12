<?php

namespace Spatie\ValidationRules\Tests\TestClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

class TestModel extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}