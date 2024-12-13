<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sheet;

class SheetController extends Controller
{
    public function index()
    {
        $sheets = Sheet::all()->groupBy('row');
        return view('sheets', compact('sheets'));
    }
}
