<?php

namespace App\Models;

use App\Models\Orders\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property int $address_id
 * @property string $name
 * @property int $price
 * @property Currency $currency
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin Builder
 */
class Orders extends Model
{
    use HasFactory;
    /**
     * @inheritdoc
     */
    protected $table = 'orders';

    /**
     * @inheritdoc
     */
    protected $primaryKey = 'id';

    /**
     * @inheritdoc
     */
    public $incrementing = false;

    /**
     * @inheritdoc
     */
    protected $keyType = 'string';

    /**
     * @inheritdoc
     */
    protected $guarded = [];

    protected $casts = [
        'currency' => Currency::class,
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
