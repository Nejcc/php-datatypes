<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Nejcc\PhpDatatypes\Laravel\Casts\Int8Cast;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;

/**
 * Example Eloquent model using PHP Datatypes
 */
class ExampleModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'age',
        'user_id',
        'balance',
        'score',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => Int8Cast::class,
        'user_id' => 'integer', // Will be cast to UInt8 in accessor
        'balance' => 'decimal:2', // Will be cast to Float32 in accessor
        'score' => 'integer', // Will be cast to Int8 in accessor
    ];

    /**
     * Get the age as Int8
     */
    public function getAgeAttribute($value): Int8
    {
        return new Int8($value);
    }

    /**
     * Set the age from Int8
     */
    public function setAgeAttribute($value): void
    {
        if ($value instanceof Int8) {
            $this->attributes['age'] = $value->getValue();
        } else {
            $this->attributes['age'] = $value;
        }
    }

    /**
     * Get the user_id as UInt8
     */
    public function getUserIdAttribute($value): UInt8
    {
        return new UInt8($value);
    }

    /**
     * Set the user_id from UInt8
     */
    public function setUserIdAttribute($value): void
    {
        if ($value instanceof UInt8) {
            $this->attributes['user_id'] = $value->getValue();
        } else {
            $this->attributes['user_id'] = $value;
        }
    }

    /**
     * Get the balance as Float32
     */
    public function getBalanceAttribute($value): Float32
    {
        return new Float32((float) $value);
    }

    /**
     * Set the balance from Float32
     */
    public function setBalanceAttribute($value): void
    {
        if ($value instanceof Float32) {
            $this->attributes['balance'] = $value->getValue();
        } else {
            $this->attributes['balance'] = $value;
        }
    }

    /**
     * Get the score as Int8
     */
    public function getScoreAttribute($value): Int8
    {
        return new Int8($value);
    }

    /**
     * Set the score from Int8
     */
    public function setScoreAttribute($value): void
    {
        if ($value instanceof Int8) {
            $this->attributes['score'] = $value->getValue();
        } else {
            $this->attributes['score'] = $value;
        }
    }

    /**
     * Example method using arithmetic operations
     */
    public function addToScore(Int8 $points): Int8
    {
        $currentScore = $this->getScoreAttribute($this->attributes['score']);
        return $currentScore->add($points);
    }

    /**
     * Example method using comparison
     */
    public function isHighScore(): bool
    {
        $score = $this->getScoreAttribute($this->attributes['score']);
        $threshold = new Int8(100);
        return $score->greaterThan($threshold);
    }
}
