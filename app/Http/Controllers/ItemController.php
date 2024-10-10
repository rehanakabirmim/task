<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Create a new item
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = new Item();
        $item->title = $request->title;
        $item->description = $request->description;
        $item->status = 'pending'; // Default status is pending
        $item->user_id = auth()->id(); // Assign current user
        $item->save();

        return response()->json('item created successfully');
    }

    // Get all items created by the logged-in user
    public function index()
    {
        $items = Item::where('user_id', auth()->id())->where('status', 'approved')->get();
        return response()->json($items);
    }

    //update item
    public function update(Request $request, $id)
    {

        $item = Item::where('user_id', auth()->id())->findOrFail($id);


        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $item->title = $request->input('title');
        $item->description = $request->input('description');
        $item->save();

        return response()->json($item);


        // Return success message
        return response()->json(['message' => 'Item updated successfully!']);
    }




    // Delete an item if it belongs to the logged-in user
    public function destroy($id)
    {
        $item = Item::where('user_id', auth()->id())->findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully!']);
    }
}
