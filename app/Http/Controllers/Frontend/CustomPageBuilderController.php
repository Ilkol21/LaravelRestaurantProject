<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomPageBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(string $slug) : View
    {
        $page = CustomPageBuilder::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        return view('frontend.pages.custom-page', compact('page'));
    }
}
