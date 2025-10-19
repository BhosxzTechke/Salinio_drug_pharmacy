<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Vat;
use Illuminate\Http\Request;
use App\Models\Discount;

class CommerceController extends Controller
{
    //


    public function VatDiscountPage(){

        $vat = Vat::find(1);

        $discount = Discount::all();

        return view('DiscountVat.CommerceSettings', compact('vat', 'discount'));
    }


public function UpdateVat(Request $request)
{
    $validated = $request->validate([
        'id'        => 'required|exists:vats,id',
        'vatName'   => 'required|string|max:100',
        'vatRate'   => 'required|numeric|min:0|max:100', // percent input (0–100)
        'activeVat' => 'required|boolean',
    ]);

    $vat = Vat::findOrFail($validated['id']);

    $oldData = $vat->toArray();



   // store this as 15 not 0.15)
    $rate = (float) $validated['vatRate'];

    $data = [
        'name'       => $validated['vatName'],
        'rate'       => $rate,
        'active'     => $validated['activeVat'],
        'updated_at' => now(),
    ];


    $vat->update($data);
    $newData = $vat->fresh()->toArray();

    activity()
        ->performedOn($vat)
        ->causedBy($request->user())
        ->withProperties([
            'old' => $oldData,
            'new' => $newData,
        ])
        ->log('Updated VAT.');


    $notification = [
        'message'    => 'VAT updated successfully!',
        'alert-type' => 'success',
    ];

    return redirect()->back()->with($notification);
}






        public function AddAjaxDiscount(Request $request)
        {
            // Validate frontend field names
            $validated = $request->validate([
                'discountname' => 'required|string|max:255',
                'discountrate' => 'required|numeric|min:0|max:100',
                'vat_exempt' => 'required|boolean',
                'is_active' => 'required|boolean',
            ]);


             ///  (e.g., 15) to decimal fraction (0.15)
            $rate = (float) $validated['discountrate'];

            // Map frontend names → DB column names
            $discount = Discount::create([
                'name' => $validated['discountname'],   // maps to 'name' column in DB
                'rate' => $rate,  
                'vat_exempt' => $validated['vat_exempt'],
                'active' => $validated['is_active'],
            ]);

            // 3️⃣ Return JSON response for your AJAX
            return response()->json([
                'success' => true,
                'message' => 'Discount added successfully!',
                'data' => $discount
            ]);
        }



public function UpdateAjaxDiscount(Request $request)
{
    // Validate frontend field names
    $validated = $request->validate([
        'id' => 'required|exists:discounts,id',
        'discountname' => 'required|string|max:255',
        'discountrate' => 'required|numeric|min:0|max:100',
        'vat_exempt' => 'required|boolean',
        'is_active' => 'required|boolean',
    ]);

    // Find the discount by ID
    $discount = Discount::findOrFail($validated['id']);

    $oldData = $discount->toArray();

    $rate = (float) $validated['discountrate'];

    $discount->update([
        'name' => $validated['discountname'],
        'rate' => $rate,
        'vat_exempt' => $validated['vat_exempt'],
        'active' => $validated['is_active'],
    ]);

    $newData = $discount->fresh()->toArray();

    //  Log activity (Spatie)
    activity('discount') // Log name
        ->performedOn($discount) // Related model
        ->causedBy(auth()->user()) // Who made the change
        ->withProperties([
            'old' => $oldData,
            'new' => $newData,
        ])
        ->log('Updated Discount information.');

    //  Return AJAX JSON response
    return response()->json([
        'success' => true,
        'message' => 'Discount updated successfully!',
        'data' => $discount
    ]);
}




            public function DeleteAjaxDiscount(Request $request)
            {
                $discountId = $request->input('id');
    
                // Find the discount by ID
                $discount = Discount::find($discountId);
                $oldData = $discount->toArray();

                if (!$discount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Discount not found.'
                    ], 404);
                }   
                // Delete the discount
                $discount->delete();


               activity()
                ->performedOn($discount)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old' => $oldData,
                ])
                ->log('Deleted a Discount record.');

                return response()->json([
                    'success' => true,
                    'message' => 'Discount deleted successfully.'
                ]);
            }

  }