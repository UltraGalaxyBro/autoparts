<?php

namespace App\Http\Controllers;

use App\Models\Automaker;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductLocation;
use Illuminate\Support\Facades\DB;

class ProductStoreController extends Controller
{

    public function suggestions(Request $request)
    {
        $search = $request->input('query');

        $suggestions = Product::where('visible', 'Sim')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('inside_code', 'like', "%$search%")
                    ->orWhere('original_code', 'like', "%$search%")
                    ->orWhere('brand_code', 'like', "%$search%")
                    ->orWhere('cross_code', 'like', "%$search%");
            })
            ->get();

        return response()->json($suggestions);
    }


    public function search(Request $request)
    {
        $request->validate([
            'value' => 'required'
        ], [
            'value.required' => 'Insira o nome ou código do produto.'
        ]);

        $search = $request->input('value');

        return redirect()->route('products', ['search' => $search]);
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        $query = Product::where('visible', 'Sim');

        $search = $request->query('search');
        $category_id = $request->query('category_id');
        $automaker_id = $request->query('automaker_id');
        $brand_id = $request->query('brand_id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('inside_code', 'like', "%$search%")
                    ->orWhere('original_code', 'like', "%$search%")
                    ->orWhere('brand_code', 'like', "%$search%")
                    ->orWhere('cross_code', 'like', "%$search%");
            });
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($automaker_id) {
            $query->where('automaker_id', $automaker_id);
        }

        if ($brand_id) {
            $query->where('brand_id', $brand_id);
        }

        $products = $query->get();

        if (!$category_id) {
            $categoryIds = $products->pluck('category_id')->unique();
        } else {
            $categoryIds = [];
        }

        if (!$automaker_id) {
            $automakerIds = $products->pluck('automaker_id')->unique();
        } else {
            $automakerIds = [];
        }

        if (!$brand_id) {
            $brandIds = $products->pluck('brand_id')->unique();
        } else {
            $brandIds = [];
        }

        $products = $query->paginate(6)->appends(request()->query());

        $categories = Category::whereIn('id', $categoryIds)->get();
        $automakers = Automaker::whereIn('id', $automakerIds)->get();
        $brands = Brand::whereIn('id', $brandIds)->get();

        return view('products', compact('products', 'categories', 'automakers', 'brands'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $quantities = ProductLocation::select('headquarter_id', DB::raw('SUM(quantity) as total_quantity'))
            ->where('product_id', $id)
            ->groupBy('headquarter_id')
            ->get();

        $categorizedProducts = Product::where('category_id', $product->category_id)->get();
        $codes = [];
        foreach (['brand_code', 'original_code', 'cross_code'] as $column) {
            $codes = array_merge($codes, explode(' ', $product->{$column}));
        }
        $codes = array_unique(array_filter($codes));

        $relatedProducts = Product::where(function ($query) use ($codes) {
            foreach ($codes as $code) {

                $query->orWhere('brand_code', 'like', "%$code%")
                    ->orWhere('original_code', 'like', "%$code%")
                    ->orWhere('cross_code', 'like', "%$code%");
            }
        })
            ->where('id', '!=', $id)
            ->get();

        return view('product', compact('product', 'quantities', 'categorizedProducts', 'relatedProducts'));
    }
}
