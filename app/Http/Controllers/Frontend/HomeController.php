<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHomePage()
    {
        $data = [];
        $data['products'] = Product::select(['id', 'title', 'slug', 'price', 'sale_price'])->where('active', 1)->paginate(9);

        return view('frontend.home', $data);
    }

    public function showCategoryProduct($slug)
    {
        $data = [];

        $category = Category::where('slug', $slug)->first();

        if ($category === null) {
            return redirect()->route('frontend.home');
        }

        $catName = Category::select('name')->where('slug', $slug)->first();

        $catProduct =$category->products()->where('active', 1)->paginate(9);


        return view('frontend.home', compact('catProduct','catName'));
    }

    public function getPdf()
    {
        $product = Product::find(1);
        $pdf = \PDF::loadView('welcome', ['product' => $product]);

        return $pdf->download('product.pdf');
    }
}
