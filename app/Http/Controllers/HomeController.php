<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $json = file_get_contents(resource_path('json/frases.json'));
        $quotes = json_decode($json, true);
        $quote = $quotes[array_rand($quotes)];

        return view('admin.home', compact('quote'));
    }
}
