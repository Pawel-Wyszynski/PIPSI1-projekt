<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Http\Requests\ValidateProductRequest;

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
        return view("products.create", [
            'categories' => ProductCategory::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  ValidateProductRequest  $request
     * @return RedirectResponse
     */
    public function store(ValidateProductRequest $request): RedirectResponse
    {
        $product = new Product($request->validated());
        if($request->hasFile('image')){
        $product->image_path = Storage::disk('public')->put('products', $request->file('image'));
        }
        $product->save();
        return redirect(route('products.index'))->with('status','Produkt został zapisany!');
    }

    /**
     * Display the specified resource.
     * 
     * @return View
     */
    public function show(Product $product): View
    {
        $meta_title=$product->name;
        $meta_description=$product->description;
        $meta_category=$product->category->name;
        $meta_keywords="$meta_title,  $meta_description, $meta_category";
        
        return view("products.show", [
            'product' => $product,
            'categories' => ProductCategory::all()
        ])->with(compact('meta_title','meta_description','meta_keywords'));
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
            'product' => $product,
            'categories' => ProductCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  ValidateProductRequest  $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(ValidateProductRequest $request, Product $product): RedirectResponse
    {
        $product->fill($request->validated());
        if($request->hasFile('image')){
            $product->image_path = Storage::disk('public')->put('products', $request->file('image'));
        }
        $product->save();
        return redirect(route('products.index'))->with('status','Produkt został zapisany!');
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
