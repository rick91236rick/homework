<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property int $address_id
 * @property string $name
 * @property int $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Address $address
 * @mixin Builder
 */
class OrdersTwd extends Model
{

    /**
     * @inheritdoc
     */
    protected $table = 'orders_twd';

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

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
