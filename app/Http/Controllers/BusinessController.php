<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessStoreRequest;
use App\Models\Business;
use App\Models\BusinessImage;
use App\Models\Category;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class BusinessController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index()
    {
        $categories = Category::active()->get();
        
        $businesses = Business::with(['categories', 'images'])
                             ->when(request('search'), function($query) {
                                 $query->where('business_name', 'like', '%' . request('search') . '%')
                                       ->orWhere('description', 'like', '%' . request('search') . '%');
                             })
                             ->when(request('category'), function($query) {
                                 $query->whereHas('categories', function($q) {
                                     $q->where('slug', request('category'));
                                 });
                             })
                             ->approved()
                             ->latest()
                             ->paginate(12);

        return view('businesses.index', compact('businesses', 'categories'));
    }

    public function show($slug)
    {
        $business = Business::where('slug', $slug)
                           ->with(['categories', 'images'])
                           ->approved()
                           ->firstOrFail();
        
        $relatedBusinesses = Business::with(['categories', 'images'])
                                   ->where('id', '!=', $business->id)
                                   ->whereHas('categories', function($q) use ($business) {
                                       $q->whereIn('categories.id', $business->categories->pluck('id'));
                                   })
                                   ->approved()
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
        try {
            $business = Business::create($request->validated());
            
            if ($request->has('categories')) {
                $business->categories()->attach($request->categories);
            }
            
            // Upload slika iz session-a (ako postoje)
            if (session()->has('uploaded_images')) {
                $this->attachUploadedImages($business, session('uploaded_images'));
                session()->forget('uploaded_images');
            }
            
            return redirect()->route('business.success')
                            ->with('success', 'Vaš biznis je uspešno prijavljen i čeka odobrenje administratora.');
                            
        } catch (Exception $e) {
            \Log::error('Business creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->withErrors(['general' => 'Došlo je do greške prilikom čuvanja biznisa.']);
        }
    }

    /**
     * AJAX upload slika
     */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240'
            ]);

            $uploadedPath = $this->imageUploadService->uploadBusinessImage($request->file('image'));
            
            // Sačuvaj u session za kasnije korišćenje
            $uploadedImages = session('uploaded_images', []);
            $imageData = [
                'path' => $uploadedPath,
                'original_name' => $request->file('image')->getClientOriginalName(),
                'url' => $this->imageUploadService->getImageUrl($uploadedPath),
                'info' => $this->imageUploadService->getImageInfo($uploadedPath)
            ];
            
            $uploadedImages[] = $imageData;
            session(['uploaded_images' => $uploadedImages]);

            return response()->json([
                'success' => true,
                'message' => 'Slika je uspešno uploadovana.',
                'image' => $imageData,
                'total_images' => count($uploadedImages)
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * AJAX brisanje slike
     */
    public function deleteImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'image_path' => 'required|string'
            ]);

            $imagePath = $request->image_path;
            $uploadedImages = session('uploaded_images', []);

            // Pronađi i ukloni sliku iz session-a
            $uploadedImages = array_filter($uploadedImages, function($image) use ($imagePath) {
                if ($image['path'] === $imagePath) {
                    // Obriši fizički fajl
                    $this->imageUploadService->deleteImage($imagePath);
                    return false;
                }
                return true;
            });

            // Re-index array
            $uploadedImages = array_values($uploadedImages);
            session(['uploaded_images' => $uploadedImages]);

            return response()->json([
                'success' => true,
                'message' => 'Slika je uspešno obrisana.',
                'total_images' => count($uploadedImages)
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Greška pri brisanju slike: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Dobij uploadovane slike iz session-a
     */
    public function getUploadedImages(): JsonResponse
    {
        $uploadedImages = session('uploaded_images', []);
        
        return response()->json([
            'success' => true,
            'images' => $uploadedImages,
            'total_images' => count($uploadedImages)
        ]);
    }

    /**
     * Očisti sve uploadovane slike iz session-a
     */
    public function clearUploadedImages(): JsonResponse
    {
        $uploadedImages = session('uploaded_images', []);
        
        // Obriši sve fizičke fajlove
        foreach ($uploadedImages as $image) {
            $this->imageUploadService->deleteImage($image['path']);
        }
        
        session()->forget('uploaded_images');
        
        return response()->json([
            'success' => true,
            'message' => 'Sve slike su obrisane.'
        ]);
    }

    /**
     * Dodeli uploadovane slike biznis-u
     */
    protected function attachUploadedImages($business, $uploadedImages)
    {
        foreach ($uploadedImages as $index => $imageData) {
            BusinessImage::create([
                'business_id' => $business->id,
                'image_path' => $imageData['path'],
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