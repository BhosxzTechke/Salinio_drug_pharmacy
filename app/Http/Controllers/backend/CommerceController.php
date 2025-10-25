<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Vat;
use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Validation\Rule;


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
    try {
        // Validate input
        $validated = $request->validate([
            'discountname' => [
                'required',
                'string',
                'max:255',
                'regex:/[a-zA-Z]/', // must contain at least one letter Black Friday 50% is valid, 50% is not
                Rule::unique('discounts', 'name') // unique in DB
            ],
            'discountrate' => 'required|numeric|min:0|max:100',
            'vat_exempt' => 'required|boolean',
            'is_active' => 'required|boolean',
        ], [
            'discountname.required' => 'Please enter a discount name.',
            'discountname.unique' => 'This discount name already exists.',
            'discountname.regex' => 'Discount name must contain at least one letter and cannot be only numbers.',
            'discountrate.required' => 'Please enter the discount rate.',
            'discountrate.numeric' => 'Discount rate must be a number.',
            'discountrate.min' => 'Discount rate cannot be less than 0.',
            'discountrate.max' => 'Discount rate cannot exceed 100.',
            'vat_exempt.required' => 'VAT exemption status is required.',
            'is_active.required' => 'Active status is required.',
        ]);

        // Convert percentage to decimal if needed
        $rate = (float) $validated['discountrate'];

        // Save discount
        $discount = Discount::create([
            'name' => $validated['discountname'],
            'rate' => $rate,
            'vat_exempt' => $validated['vat_exempt'],
            'active' => $validated['is_active'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discount added successfully!',
            'data' => $discount
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Return validation errors as JSON
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        // Log and return generic error
        \Log::error('Error adding discount: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong while adding the discount.'
        ], 500);
    }
}







public function UpdateAjaxDiscount(Request $request)
{
    // Validate frontend field names
    $validated = $request->validate([
        'id' => 'required|exists:discounts,id',
        'discountname' => [
            'required',
            'string',
            'max:255',
            'regex:/[a-zA-Z]/', // ensures at least one letter (not purely numeric)
            Rule::unique('discounts', 'name')->ignore($request->id), // unique except current
        ],
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

    // Log activity (Spatie)
    activity('discount')
        ->performedOn($discount)
        ->causedBy(auth()->user())
        ->withProperties([
            'old' => $oldData,
            'new' => $newData,
        ])
        ->log('Updated Discount information.');

    // Return AJAX JSON response
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