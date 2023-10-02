<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Euribor extends Model
{
    use HasFactory;

    /** @var array */
    protected $guarded = []; /* @phpstan-ignore-line */

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
