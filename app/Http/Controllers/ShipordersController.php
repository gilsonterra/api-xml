<?php

namespace App\Http\Controllers;

use App\Models\Shiporders;
use Illuminate\Http\Request;

class ShipordersController extends Controller
{
    public function all()
    {
        return Shiporders::all();
    }

    public function show(int $id)
    {
        return Shiporders::findOrFail($id);
    }
}
