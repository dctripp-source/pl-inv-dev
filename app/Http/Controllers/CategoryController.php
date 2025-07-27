<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Business;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()
                             ->withCount('approvedBusinesses')
                             ->orderBy('name')
                             ->get();
        
        return view('categories.index', compact('categories'));
    }

    public function show($slug, Request $request)
    {
        $category = Category::active()
                           ->where('slug', $slug)
                           ->firstOrFail();
        
        $query = $category->approvedBusinesses()->with(['categories', 'primaryImage']);
        
        // Search within category
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('services', 'like', "%{$search}%");
            });
        }
        
        // Filter by city
        if ($request->has('city') && $request->city) {
            $query->where('city', 'like', "%{$request->city}%");
        }
        
        $businesses = $query->orderBy('business_name')->paginate(12);
        
        // Get cities for this category
        $cities = $category->approvedBusinesses()
                          ->distinct()
                          ->orderBy('city')
                          ->pluck('city');
        
        return view('categories.show', compact('category', 'businesses', 'cities'));
    }
}