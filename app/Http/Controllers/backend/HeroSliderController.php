<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlider;
use Image;


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

    public function StoreHeroSlider(Request $request) {

        $request->validate([
            'position' => 'nullable|integer|min:0|max:'.\App\Models\HeroSlider::count(),
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url|max:255',
            'position' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $save_url = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $path = public_path('backend/assets/heroslider/'.$name_gen);
            Image::make($image)->resize(300,300)->save($path);
            $save_url = 'backend/assets/heroslider/'.$name_gen;
        }

      // Determine position
    $totalSlides = HeroSlider::count();
    $position = $request->position;

    if (is_null($position) || $position > $totalSlides) {
        $position = $totalSlides; // Add to the end if empty or too high
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
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Hero Slider created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('heroslider.show')->with($notification);

    }

    public function EditHeroSlider($id) {

        $editData = HeroSlider::findOrFail($id);
        $totalSlides = HeroSlider::count();

        return view('HeroSlider.EditHeroSlider', compact('editData', 'totalSlides'));

    }



    public function UpdateHeroSlider(Request $request) {

        $sliderID = $request->id;

        $request->validate([
            'position' => 'nullable|integer|min:0|max:'.\App\Models\HeroSlider::count(),
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url|max:255',
            'position' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'position' => $request->position ?? 0,
            'is_active' => $request->is_active ?? 'inactive',
        ];

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $path = public_path('backend/assets/heroslider/'.$name_gen);
            Image::make($image)->resize(300,300)->save($path);
            $data['image'] = 'backend/assets/heroslider/'.$name_gen;
        }

        HeroSlider::findOrFail($sliderID)->update($data);

        $notification = array(
            'message' => 'Hero Slider updated successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('heroslider.show')->with($notification);

    }




    public function DeleteHeroSlider($id) {

        $slider = HeroSlider::findOrFail($id);
        $img = $slider->image;
        if ($img) {
            unlink($img);
        }

        $slider->delete();

        $notification = array(
            'message' => 'Hero Slider deleted successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('heroslider.show')->with($notification);

    }
        


}
