<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vista extends Model
{   
    use HasFactory;

    protected $primaryKey = 'id_vista';

   
    protected $fillable = [
        'name'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permisos', 'id_vista', 'id_role');
    }
}