<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cao_usuario;

class ComercialController extends Controller
{
    //
    public function index()
    {
        $cao_usuarios=Cao_usuario::join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
        ->where('permissao_sistema.co_sistema', '=', 1)
        ->where('permissao_sistema.in_ativo', '=', 'S')
        ->whereIn('permissao_sistema.co_tipo_usuario',[0,1,2])
        ->select('cao_usuario.co_usuario','cao_usuario.no_usuario')
        ->get()->toArray();
        return view('comercial',compact('cao_usuarios'));
    }
}
