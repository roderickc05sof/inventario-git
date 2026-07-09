<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable=[
        'serial_number',
        'asset_id',
        'component_type_id',
        'brand',
        'specifications'

    ];
    protected $casts = [
        'specifications' => 'array', 
    ];

    public function componentType ():BelongsTo{
        return $this->belongsTo(ComponentType::class);
    }
    public function asset():BelongsTo{
        return $this->belongsTo(Asset::class);

    }
}
