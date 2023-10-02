<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    /** @var array */
    protected $guarded = []; /* @phpstan-ignore-line */

    /** @var array */
    protected $with = ['euribors']; /* @phpstan-ignore-line */
    
    public function euribors(): HasMany
    {
        return $this->hasMany(Euribor::class);
    }
}
