<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Brick\Math\BigInteger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

class InventoryItemController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::all();
        return view('inventory.createInventory', compact('inventoryItems'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            
        ]);

       $inventory= new InventoryItem();
       $inventory->name=$request->name;
       $inventory->description=$request->description;
       $inventory->quantity=$request->quantity;
       $inventory->price=$request->price;
       $inventory->user_id=Auth::user()->id;
       $inventory->save();

        return redirect()->route('home')->with('success', 'Inventory item created successfully.');
    }

    public function edit(InventoryItem $inventoryItem)
    {
        return view('inventory.editInventory', compact('inventoryItem'));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $inventoryItem->update($validatedData);

        return redirect()->route('home')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();

        return redirect()->route('home')->with('success', 'Inventory item deleted successfully.');
    }

    public function inventoryTracker()
    {
        $inventory = InventoryItem::all();
        return view('inventory.tracker', compact('inventory'));
    }
  
    public function inventoryUpdate(Request $request, $InventoryId)
    {

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory= InventoryItem::where('id',$InventoryId)->first();
        $inventory->quantity= $request->quantity;
        $inventory->update();
        return redirect()->route('inventory.tracker')->with('success', 'Inventory item deleted successfully.');
    }

    public function exportToCSV()
    {
        $inventoryItems = InventoryItem::all();

        $csvFileName = 'inventory_items.csv';
        if(!storage::exists($csvFileName))
        {
            $csvHeader=[
                "name",
                "description",
                "quantity",
                "price",
                

            ];
            Storage::put($csvFileName,implode(",",$csvHeader));
        }
        $counter = 1;
        foreach($inventoryItems as $items)
        {
            $csvData=[
               $items->name,
               $items->description,
               $items->quantity,
               $items->price,

            ];
            Storage::append($csvFileName,implode(',',$csvData));
        
        }

        $csvFilePath=Storage::path($csvFileName);

        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }

    public function importFromCSV(Request $request)
    {
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:10240', 
    ]);

    $file = $request->file('csv_file');
    $csvData = array_map('str_getcsv', file($file));
     
    foreach ($csvData as $row) {

        if (
            $row[0] === 'name' || 
            $row[1] === 'description' || 
            (int) $row[2] === 0 ||
            (float) $row[3] === 0 
        ) {
            continue; 
        }
        
        InventoryItem::create([
            'name' => $row[0],
            'description' => $row[1],
            'quantity' =>(Integer) $row[2],
            'price' =>(float) $row[3],
            'user_id'=>Auth::user()->id,
        ]);
    }

    return redirect()->back()->with('success', 'Inventory data imported successfully.');
}


}
