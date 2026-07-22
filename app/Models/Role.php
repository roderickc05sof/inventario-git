<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{   
     use HasFactory;
      protected $primaryKey = 'id_role';

      protected $fillable = [
        'descripcion'
      ];

     public function users(): HasMany{
        return $this->hasMany(User::class,'id_role');
     }
      public function vistas (): BelongsToMany{
        return $this->BelongsToMany(Vista::class,'permisos','id_role','id_vista');
     }
     
}
