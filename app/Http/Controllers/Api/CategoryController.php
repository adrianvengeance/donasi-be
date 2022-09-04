<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data categories
        $categories = Category::latest()->paginate(12);
        //return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data' => $categories,
        ], 200);
    }
    /**
     * show
     *
     * @param mixed $slug
     * @return void
     */
    public function show($slug)
    {
        //get detail data category with campaign
        $category = Category::with('campaigns.user', 'campaigns.sumDonation')->where('slug', $slug)->first();
        if ($category) {
            //return with response JSON
            return response()->json([
                'success' => true,
                'message' => 'List Data Campaign Berdasarkan Category :' . $category->name,
                'data' => $category,
            ], 200);
        }
        //return with response JSON
        return response()->json([
            'success' => false,
            'message' => 'Data Category Tidak Ditemukan!',
        ], 404);
    }
    /**
     * categoryHome
     *
     * @return void
     */
    public function categoryHome()
    {
        //get data categories
        $categories = Category::latest()->take(3)->get();
        //return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Category Home',
            'data' => $categories,
        ], 200);
    }
}
