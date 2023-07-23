<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cao_usuario extends Model
{
    use HasFactory;

    protected $table = "cao_usuario";
    protected $primaryKey = "co_usuario";
    protected $keyType = 'string';

    public function scopeListConsultores()
    {
        return Cao_usuario::join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
            ->where('permissao_sistema.co_sistema', '=', 1)
            ->where('permissao_sistema.in_ativo', '=', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0, 1, 2])
            ->select('cao_usuario.co_usuario', 'cao_usuario.no_usuario');
    }
}
