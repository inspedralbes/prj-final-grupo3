<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    public function index()
    {
        $countries = Publication::all();
        return view('admin.publicacions', compact('publicacions'));
    }
}
