<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
            public function Inventory() {

                $inventory = Inventory::all();

                return view('Inventory.stocks', compact('inventory'));
            }

}
