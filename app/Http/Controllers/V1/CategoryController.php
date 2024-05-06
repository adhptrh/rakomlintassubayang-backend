<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get() {
        return response()->json([
            "message"=>"success",
            "data"=>Category::all()
        ]);
    }
}
