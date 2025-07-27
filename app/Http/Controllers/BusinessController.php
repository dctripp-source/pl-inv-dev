<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\BusinessImage;
use App\Http\Requests\BusinessStoreRequest;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    protected $imageService;
    
    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = Business::with(['categories', 'primaryImage'])->approved();
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('services', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }
        
        // Filter by city
        if ($request->has('city') && $request->city) {
            $query->where('city', 'like', "%{$request->city}%");
        }
        
        $businesses = $query->orderBy('business_name')->paginate(12);
        $categories = Category::active()->withCount('approvedBusinesses')->get();
        
        // Get unique cities for filter
        $cities = Business::approved()
                         ->distinct()
                         ->orderBy('city')
                         ->pluck('city');
        
        return view('businesses.index', compact('businesses', 'categories', 'cities'));
    }

    public function show($slug)
    {
        $business = Business::with(['categories', 'images'])
                           ->where('slug', $slug)
                           ->where('status', 'approved')
                           ->firstOrFail();
        
        // Related businesses from same categories
        $relatedBusinesses = Business::with(['categories', 'primaryImage'])
                                   ->approved()
                                   ->where('id', '!=', $business->id)
                                   ->whereHas('categories', function($q) use ($business) {
                                       $q->whereIn('categories.id', $business->categories->pluck('id'));
                                   })
                                   ->limit(4)
                                   ->get();
        
        return view('businesses.show', compact('business', 'relatedBusinesses'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('businesses.create', compact('categories'));
    }

    public function store(BusinessStoreRequest $request)
    {
        $business = Business::create($request->validated());
        
        // Attach categories
        if ($request->has('categories')) {
            $business->categories()->attach($request->categories);
        }
        
        // Handle images with optimization
        if ($request->hasFile('images')) {
            $this->handleImageUploads($business, $request->file('images'));
        }
        
        return redirect()->route('business.success')
                        ->with('success', 'Vaš biznis je uspešno prijavljen i čeka odobrenje administratora.');
    }

    protected function handleImageUploads($business, $images)
    {
        foreach ($images as $index => $image) {
            // Optimize image
            $path = $this->imageService->optimizeBusinessImage($image);
            
            BusinessImage::create([
                'business_id' => $business->id,
                'image_path' => $path,
                'alt_text' => $business->business_name,
                'is_primary' => $index === 0,
                'sort_order' => $index
            ]);
        }
    }

    public function success()
    {
        return view('businesses.success');
    }
}