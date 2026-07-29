<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';

    protected $fillable = ['name'];

    public function assets(): HasMany
    {
        // 2. Corregido: hasMany con "h" minúscula
        return $this->hasMany(Asset::class);
    }
}