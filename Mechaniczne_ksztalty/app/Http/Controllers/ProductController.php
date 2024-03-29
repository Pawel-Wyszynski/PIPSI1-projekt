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
use App\Http\Requests\ValidateCartRequest;

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
    public function cart()
    {
        return view('cart');
    }
    
    public function addToCart($id)
{

    $product = Product::findOrFail($id);
 
    $cart = session()->get('cart', []);
 
    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
    }  else {
        $cart[$id] = [
            "product_name" => $product->name,
            "photo" => $product->image_path,
            "price" => $product->price,
            "quantity" => 1
        ];
    }
 
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product add to cart successfully!');
}
public function remove(Request $request)
{
    if($request->id) {
        $cart = session()->get('cart');
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        session()->flash('success', 'Product successfully removed!');
    }
}

public function update_cart(Request $request, ValidateCartRequest $validateCartRequest)
{
    $validateCartRequest->validated();

    if($request->id && $request->quantity){
        $cart = session()->get('cart');
        $cart[$request->id]["quantity"] = $request->quantity;
        session()->put('cart', $cart);
        session()->flash('success', 'Cart successfully updated!');
    }
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
        return redirect(route('products.index'))->with('status','Product successfully created!');
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
        return redirect(route('products.index'))->with('status','Product successfully updated!');
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
