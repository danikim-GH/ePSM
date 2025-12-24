<?php
// app/Http/Controllers/Admin/CarouselController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CarouselController extends Controller
{
    public function index()
    {
        $carouselItems = Carousel::orderBy('order', 'asc')->get();
        return view('admin.carousel', compact('carouselItems'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $path = $request->file('image')->store('carousel', 'public');
            
            $carousel = Carousel::create([
                'title' => $request->title,
                'description' => $request->description,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'order' => $request->order,
                'image_path' => 'storage/'.$path,
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Carousel image added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function edit($id)
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->image_path = asset($carousel->image_path);
        return response()->json($carousel);
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:carousels,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $carousel = Carousel::findOrFail($request->id);
            
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'order' => $request->order
            ];
            
            if ($request->hasFile('image')) {
                // Delete old image
                if ($carousel->image_path) {
                    $relativePath = str_replace('storage/','',$carousel->image_path);
                    Storage::disk('public')->delete($relativePath);
                }
                
                $path = $request->file('image')->store('carousel', 'public');
                $data['image_path'] = 'storage/' . $path;
            }
            
            $carousel->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Carousel image updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $carousel = Carousel::findOrFail($id);
            
            // Delete image file
            if ($carousel->image_path) {
                $relativePath = str_replace('storage/', '', $carousel->image_path);
                Storage::disk('public')->delete($relativePath);
            }

            $carousel->delete();
            
            return response()->json([
                'success' => true,
                'id_carousel' => $carousel->id,
                'title'=>$carousel->title,
                'message' => 'Carousel image deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function list()
    {
        $carouselItems = Carousel::orderBy('order', 'asc')->get();

        $carouselItems->transform(function($item){
            $item->image_path = asset($item->image_path);
            return $item;
        });

        return response()->json($carouselItems);
    }
}