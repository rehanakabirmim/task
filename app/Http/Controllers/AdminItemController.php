<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class AdminItemController extends Controller
{
    // View all unapproved items (status: 'pending')
    public function getUnapprovedItems()
    {
        $unapprovedItems = Item::where('status', 'pending')->get();
        return response()->json([
            'message' => 'Unapproved items fetched successfully',
            'data' => $unapprovedItems
        ], 200);
    }

    // Approve a user's item (status: 'approved')
    public function approveItem($id)
    {
        $item = Item::findOrFail($id);

        if ($item->status === 'approved') {
            return response()->json(['message' => 'Item is already approved'], 400);
        }

        $item->status = 'approved';
        $item->save();

        return response()->json([
            'message' => 'Item approved successfully',
            'data' => $item
        ], 200);
    }

    // Reject a user's item (status: 'rejected')
    public function rejectItem($id)
    {
        $item = Item::findOrFail($id);

        if ($item->status === 'rejected') {
            return response()->json(['message' => 'Item is already rejected'], 400);
        }

        $item->status = 'rejected';
        $item->save();

        return response()->json([
            'message' => 'Item rejected successfully',
            'data' => $item
        ], 200);
    }

    // Delete any user's item (by admin)
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully'
        ], 200);
    }
}
