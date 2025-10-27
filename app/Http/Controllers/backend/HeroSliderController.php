<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlider;
use Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class HeroSliderController extends Controller
{
    //





    public function HeroSlider() {

        $ImageData = HeroSlider::all();

        return view('HeroSlider.AllHeroSlider', compact('ImageData'));

    }   


    public function AddHeroSlider() {

        return view('HeroSlider.AddHeroSlider');

    }






public function StoreHeroSlider(Request $request)
{
    $request->validate([
        'position' => 'nullable|integer|min:0|max:' . \App\Models\HeroSlider::count(),
        'title' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10248',
        'link' => 'nullable|url|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    // Handle Cloudinary upload
    $save_url = null;
    if ($request->hasFile('image')) {
        $uploadedFileUrl = Cloudinary::upload(
            $request->file('image')->getRealPath(),
            ['folder' => 'heroslider']
        )->getSecurePath();

        $save_url = $uploadedFileUrl;
    }

    // Determine position
    $totalSlides = HeroSlider::count();
    $position = $request->position;

    if (is_null($position) || $position > $totalSlides) {
        $position = $totalSlides;
    }

    // Shift positions if needed
    HeroSlider::where('position', '>=', $position)->increment('position');

    // Insert into database
    HeroSlider::create([
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'link' => $request->link,
        'position' => $position ?? 0,
        'is_active' => $request->is_active ?? 'inactive',
        'image' => $save_url, // Cloudinary URL here
    ]);

    $notification = [
        'message' => 'Hero Slider created successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->route('heroslider.show')->with($notification);
}








    public function EditHeroSlider($id) {

        $editData = HeroSlider::findOrFail($id);
        $totalSlides = HeroSlider::count();

        return view('HeroSlider.EditHeroSlider', compact('editData', 'totalSlides'));

    }



 public function UpdateHeroSlider(Request $request)
{
    $sliderID = $request->id;
    $slider = HeroSlider::findOrFail($sliderID);

    $request->validate([
        'position' => 'nullable|integer|min:0|max:' . HeroSlider::count(),
        'title' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10248',
        'link' => 'nullable|url|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    $data = [
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'link' => $request->link,
        'is_active' => $request->is_active ?? 0,
    ];



    $totalSlides = HeroSlider::count();
    $position = $request->position;

    if (is_null($position) || $position > $totalSlides) {
        $position = $totalSlides;
    }

    // Only shift positions if changed
    if ($position !== $slider->position) {
        HeroSlider::where('position', '>=', $position)
            ->where('id', '!=', $sliderID)
            ->increment('position');
        $data['position'] = $position;
    }

    if ($request->hasFile('image')) {
        // Optional: Delete old image from Cloudinary if it exists
        if ($slider->image && str_contains($slider->image, 'res.cloudinary.com')) {
            try {
                $publicId = basename(parse_url($slider->image, PHP_URL_PATH));
                $publicId = pathinfo($publicId, PATHINFO_FILENAME);
                Cloudinary::destroy('heroslider/' . $publicId);
            } catch (\Exception $e) {
                // You can log the error if needed
            }
        }

        $uploadedFileUrl = Cloudinary::upload(
            $request->file('image')->getRealPath(),
            ['folder' => 'heroslider']
        )->getSecurePath();

        $data['image'] = $uploadedFileUrl;
    }

    $slider->update($data);

    $notification = [
        'message' => 'Hero Slider updated successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->route('heroslider.show')->with($notification);
}


public function DeleteHeroSlider($id)
{
    $slider = HeroSlider::findOrFail($id);

    if ($slider->image && str_contains($slider->image, 'res.cloudinary.com')) {
        try {
            // Extract the public ID from the Cloudinary URL
            $publicId = basename(parse_url($slider->image, PHP_URL_PATH));
            $publicId = pathinfo($publicId, PATHINFO_FILENAME);

            // Delete from Cloudinary folder 'heroslider'
            Cloudinary::destroy('heroslider/' . $publicId);
        } catch (\Exception $e) {
            // Optional: log the error
            \Log::error('Cloudinary delete failed: ' . $e->getMessage());
        }
    }

    $slider->delete();

    $notification = [
        'message' => 'Hero Slider deleted successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->route('heroslider.show')->with($notification);
}


}
