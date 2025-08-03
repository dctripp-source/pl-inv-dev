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
                             ->when(request('city'), function($query) {
                                 $query->where('city', 'like', '%' . request('city') . '%');
                             })
                             ->approved()
                             ->latest()
                             ->paginate(12);


        $cities = Business::approved()
                         ->distinct()
                         ->orderBy('city')
                         ->pluck('city')
                         ->filter()
                         ->sort();

        return view('businesses.index', compact('businesses', 'categories', 'cities'));
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

        \Log::info('=== BUSINESS STORE ATTEMPT ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        \Log::info('Request all data: ', $request->all());
        \Log::info('Request validated data: ', $request->validated());
        \Log::info('Session uploaded images: ', session('uploaded_images', []));
        \Log::info('Session ID: ' . session()->getId());
        \Log::info('CSRF Token: ' . $request->header('X-CSRF-TOKEN'));
        
        try {

            $uploadedImages = session('uploaded_images', []);
            
            \Log::info('Uploaded images count: ' . count($uploadedImages));
            
            if (empty($uploadedImages)) {
                \Log::error('No images in session');
                return back()
                    ->withInput()
                    ->withErrors(['images' => 'Morate uploadovati najmanje jednu sliku.']);
            }

            \Log::info('Creating business with data: ', $request->validated());
            $business = Business::create($request->validated());
            
            \Log::info('Business created successfully', [
                'business_id' => $business->id,
                'business_name' => $business->business_name
            ]);

            if ($request->has('categories')) {
                $categories = $request->categories;
                \Log::info('Attaching categories: ', $categories);
                $business->categories()->attach($categories);
                \Log::info('Categories attached successfully');
            }
            
            \Log::info('Attaching images: ' . count($uploadedImages));
            $this->attachUploadedImages($business, $uploadedImages);
            session()->forget('uploaded_images');
            
            \Log::info('Images attached successfully');
            \Log::info('=== BUSINESS STORE SUCCESS ===');
            
            return redirect()->route('business.success')
                            ->with('success', 'Vaš biznis je uspešno prijavljen i čeka odobrenje administratora.');
                            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('=== VALIDATION EXCEPTION ===');
            \Log::error('Validation errors: ', $e->errors());
            
            return back()
                ->withInput()
                ->withErrors($e->errors());
                
        } catch (\Exception $e) {
            \Log::error('=== GENERAL EXCEPTION ===');
            \Log::error('Exception message: ' . $e->getMessage());
            \Log::error('Exception trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->withErrors(['general' => 'Došlo je do greške: ' . $e->getMessage()]);
        }
    }

    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240'
            ]);


            $imagePath = $this->imageUploadService->uploadBusinessImage($request->file('file'));
            

            $imageUrl = asset('storage/' . $imagePath);
            

            $uploadedImages = session('uploaded_images', []);
            $uploadedImages[] = [
                'path' => $imagePath,
                'url' => $imageUrl,
                'name' => $request->file('file')->getClientOriginalName(),
                'size' => $request->file('file')->getSize()
            ];
            session(['uploaded_images' => $uploadedImages]);

            return response()->json([
                'success' => true,
                'message' => 'Slika je uspešno uploadovana.',
                'image' => [
                    'path' => $imagePath,
                    'url' => $imageUrl,
                    'name' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize()
                ],
                'total_images' => count($uploadedImages)
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Greška pri upload-u slike: ' . $e->getMessage()
            ], 422);
        }
    }


    public function deleteImage(Request $request): JsonResponse
    {
        try {
            $imagePath = $request->input('path');
            
            if (!$imagePath) {
                throw new Exception('Putanja slike nije prosleđena');
            }

            $uploadedImages = session('uploaded_images', []);
            

            $uploadedImages = array_filter($uploadedImages, function($img) use ($imagePath) {
                return $img['path'] !== $imagePath;
            });
            

            $uploadedImages = array_values($uploadedImages);
            session(['uploaded_images' => $uploadedImages]);


            $this->imageUploadService->deleteImage($imagePath);

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


    public function getUploadedImages(): JsonResponse
    {
        $uploadedImages = session('uploaded_images', []);
        
        return response()->json([
            'success' => true,
            'images' => $uploadedImages,
            'total_images' => count($uploadedImages)
        ]);
    }


    public function clearUploadedImages(): JsonResponse
    {
        $uploadedImages = session('uploaded_images', []);

        foreach ($uploadedImages as $image) {
            $this->imageUploadService->deleteImage($image['path']);
        }
        
        session()->forget('uploaded_images');
        
        return response()->json([
            'success' => true,
            'message' => 'Sve slike su obrisane.'
        ]);
    }

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