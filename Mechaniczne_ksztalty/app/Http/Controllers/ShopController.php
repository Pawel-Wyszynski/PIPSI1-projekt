<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;

class ShopController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index(): View|Response
    {
        if(request()->category){
            $products = Product::with('category')->whereHas('category',function($query){
                $query->where('name',request()->category);
            });
            $categories = ProductCategory::all();
            $categoryName = optional($categories->where('name', request()->category)->first())->name;
        }else{
        $products = Product::take(12);
        $categories = ProductCategory::all();
        $categoryName = 'Części';
        }
        if(request()->sort== 'low_high'){
            $products = $products->orderBy('price')->paginate(6);
        }elseif(request()->sort== 'high_low'){
            $products = $products->orderBy('price','desc')->paginate(6);
        }else{
            $products = $products->paginate(9);
        }
        return view('welcome')->with([
            'products'=>$products,
            'categories'=> ProductCategory::orderBy('name', 'ASC')->get(),
            'categoryName'=>$categoryName,
    ]);
    }
}
