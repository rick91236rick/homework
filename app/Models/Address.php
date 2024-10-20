<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $city
 * @property string $district
 * @property string $street
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin Builder
 */
class Address extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $table = 'address';

    /**
     * @inheritdoc
     */
    protected $guarded = [];

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }
}
