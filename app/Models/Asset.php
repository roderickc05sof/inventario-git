<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'name',
        'serial_number',
        'model_number',
        'purchase_date',
        'inventory_tag',
        'cost',
        'notes',
        'category_id',
        'status_id',
        'manufacturer_id',
        'location_id'
    ];

    public function manufacturer(): BelongsTo{
        return $this->belongsTo(Manufacturer::class);
    }

    public function status(): BelongsTo{
        return $this->belongsTo(AssetStatus::class, "status_id");
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo{
        return $this->belongsTo(locations::class);
    }

   public function components():HasMany{
        return $this->HasMany(Component::class);
   }
}