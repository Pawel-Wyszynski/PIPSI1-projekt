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
        $meta_title=$categoryName;
        $meta_description="Tutaj jest nasz bardzo specjalny pomysł na kategorię. Pozdrawiam z rodzinką.";
        $meta_keywords="kategoria, motoryzacja, filtry, płyny, paski, klocki hamulcowe, układy wydechowe, wycieraczki samochodowe";
        return view('welcome')->with([
            'products'=>$products,
            'categories'=> ProductCategory::orderBy('name', 'ASC')->get(),
            'categoryName'=>$categoryName,
    ])->with(compact('meta_title','meta_description','meta_keywords'));
    }
}
