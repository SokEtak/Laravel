<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ['cart_session_id', 'product_id']; // Define composite key

    /**
     * Indicates if the model should be timestamped.
     * This table does not have created_at/updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_session_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the cart session that owns the cart item.
     */
    public function cartSession(): BelongsTo
    {
        return $this->belongsTo(CartSession::class, 'cart_session_id', 'id');
    }

    /**
     * Get the product that owns the cart item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Override setKeysForSaveQuery to handle composite primary keys for saving/updating
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    // Override getKeyForSaveQuery to handle composite primary keys for saving/updating
    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (is_array($keyName)) {
            $key = [];
            foreach ($keyName as $name) {
                $key[$name] = $this->getAttribute($name);
            }
            return $key;
        }

        return $this->getAttribute($keyName);
    }
}
