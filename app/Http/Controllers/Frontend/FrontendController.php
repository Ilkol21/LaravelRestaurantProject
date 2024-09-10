<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FrontendController extends Controller
{
    function index():View{
        $sectionTitles = $this->getSectionTitles();

        $sliders = Slider::where('status', 1)->get();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();
        return view('frontend.home.index',
            compact(
                'sliders',
                'sectionTitles',
                'whyChooseUs',
                'categories',
            ));
    }

    function getSectionTitles() : Collection {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
        ];

        return SectionTitle::whereIn('key', $keys)->pluck('value','key');
    }
    function products(Request $request) : View {

        $products = Product::where(['status' => 1])->orderBy('id', 'DESC');

        if($request->has('search') && $request->filled('search')) {
            $products->where(function($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('long_description', 'like', '%'.$request->search.'%');
            });
        }

        if($request->has('category') && $request->filled('category')) {
            $products->whereHas('category', function($query) use ($request){
                $query->where('slug', $request->category);
            });
        }

        $products = $products->withAvg('reviews', 'rating')->withCount('reviews')->paginate(12);

        $categories = Category::where('status', 1)->get();

        return view('frontend.pages.product', compact('products', 'categories'));
    }
    function showProduct(string $slug) : View {
        $product = Product::with(['productImages', 'productSizes', 'productOptions'])->where(['slug' => $slug, 'status' => 1])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->take(8)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()->get();
//        $reviews = ProductRating::where(['product_id' => $product->id, 'status' => 1])->paginate(30);
      return view('frontend.pages.product-view', compact('product', 'relatedProducts',));
    }
    function loadProductModal($productId) {
        $product = Product::with(['productSizes', 'productOptions'])->findOrFail($productId);

        return view('frontend.layouts.ajax-files.product-popup-modal', compact('product'))->render();
    }
}
