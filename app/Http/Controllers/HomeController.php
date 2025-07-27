<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured businesses (newest approved)
        $featuredBusinesses = Business::with(['categories', 'primaryImage'])
                                     ->approved()
                                     ->latest('approved_at')
                                     ->limit(6)
                                     ->get();
        
        // Popular categories (with most businesses)
        $popularCategories = Category::active()
                                   ->withCount('approvedBusinesses')
                                   ->orderByDesc('approved_businesses_count')
                                   ->limit(8)
                                   ->get();
        
        // Statistics
        $stats = [
            'total_businesses' => Business::approved()->count(),
            'total_categories' => Category::active()->count(),
            'total_cities' => Business::approved()->distinct('city')->count('city'),
        ];
        
        return view('welcome', compact('featuredBusinesses', 'popularCategories', 'stats'));
    }
}