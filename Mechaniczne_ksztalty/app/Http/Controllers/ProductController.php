<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index():View
    {
        return view("products.index", [
            'products' => Product::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return View
     */
    public function create(): View
    {
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $product = new Product($request->all());
        if($request->hasFile('image')){
        $product->image_path = Storage::disk('public')->put('products', $request->file('image'));
        }
        $product->save();
        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     * 
     * @return View
     */
    public function show(Product $product): View
    {
        return view("products.show", [
            'product' => $product 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  Request  $request
     * @return View
     */
    public function edit(Product $product):View
    {
        return view("products.edit", [
            'product' => $product 
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  Request  $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->fill($request->all());
        if($request->hasFile('image')){
            $product->image_path = Storage::disk('public')->put('products', $request->file('image'));
        }
        $product->save();
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
