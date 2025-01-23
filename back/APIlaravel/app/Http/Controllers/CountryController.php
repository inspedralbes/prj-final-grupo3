<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function create(Request $request)
    {
        $validate = $request->validate([
            "name"=> "required|string",
            "code" => "required|string|min:2|max:4"
        ]);


    }
}
