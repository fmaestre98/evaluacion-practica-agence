<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cao_usuario extends Model
{
    use HasFactory;
     
    protected $table="cao_usuario";
    protected $primaryKey="co_usuario";
    protected $keyType = 'string';
}
