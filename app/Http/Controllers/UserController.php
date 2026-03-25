<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produto;
use App\Models\Tipo;

class UserController extends Controller
{
    public function Dashboard()
    {
        if (Auth::check() && Auth::user()->user_type === 'user') {
            return view('dashboard');
        }

        if (Auth::check() && Auth::user()->user_type === 'admin') {

            $produtos = Produto::all();
            $tipos = Tipo::all();

            return view('admin.dashboard', [
                'produtos' => $produtos,
                'tipos' => $tipos,
            ]);

            
        }

        return redirect('/');
    }
}
