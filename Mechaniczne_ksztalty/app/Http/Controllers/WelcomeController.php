<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index():View
    {
        return view("welcome", [
            'products' => Product::paginate(10)
        ]);
    }
}
