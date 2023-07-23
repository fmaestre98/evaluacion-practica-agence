<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cao_usuario;

class ComercialController extends Controller
{
    //
    public function index()
    {
        $cao_usuarios=Cao_usuario::listConsultores()->get()->toArray();
        return view('comercial',compact('cao_usuarios'));
    }
}
