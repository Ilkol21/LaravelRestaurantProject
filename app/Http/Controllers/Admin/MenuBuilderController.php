<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index() : View {
        return view('admin.menu-builder.index');
    }
}
