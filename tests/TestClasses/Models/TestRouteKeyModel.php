<?php

namespace Spatie\ValidationRules\Tests\TestClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

class TestRouteKeyModel extends Model
{
    protected $guarded = [];

    protected $table = 'test_models';

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
