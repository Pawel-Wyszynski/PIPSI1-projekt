<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class WelcomeController extends Controller
{
        /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        $filters = $request->query('filter');
        $query = Product::query();
        if(!is_null($filters)){
            if(array_key_exists('categories', $filters)){  
            $query=$query->whereIn('category_id', $filters['categories']);
            }
            if(!is_null($filters['price_min'])){   
            $query=$query->where('price', '>=' ,$filters['price_min']);
            }
            if(!is_null($filters['price_max'])){
            $query=$query->where('price', '<=' ,$filters['price_max']);
            }
            return response()->json([
                'data' => $query->get()
            ]);
        }
        $meta_title="Sklep Mechaniczne kształty";
        $meta_description="Sklep z częściami samochodowymi w najlepszych cenach i z najszybszą dostawą";
        $meta_keywords="sklep z częściami, sklep motoryzacyjny, części do Opla, części do Jaguara, opony, silnik, uszczelka pod głowicą,";
        return view("welcome", [
            'products' => Product::paginate(10),
            'categories'=> ProductCategory::orderBy('name', 'ASC')->get()
        ])->with(compact('meta_title','meta_description','meta_keywords'));
    }
}
