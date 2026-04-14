<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Municipio;
use App\Models\Produtor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalMarcas' => Marca::count(),
            'totalProdutores' => Produtor::count(),
            'totalMunicipios' => Municipio::has('marcas')->count(),
            'ultimasMarcas' => Marca::with('produtor', 'municipio')->latest()->take(5)->get()
        ]);
    }
}
