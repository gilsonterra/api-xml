<?php

namespace App\Http\Controllers;

use App\Models\People;

class PeopleController extends Controller
{
    public function all()
    {
        return People::all();
    }

    public function show(int $id)
    {
        return People::findOrFail($id);
    }
}
