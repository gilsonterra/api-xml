<?php

namespace App\Http\Controllers;

use App\Models\Importations;

class ImportationsController extends Controller
{
    public function all()
    {
        return Importations::all();
    }

    public function show(int $id)
    {
        return Importations::findOrFail($id);
    }
}
