<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::all();
        
        // If there are no vendors, redirect to marketplace or show page without contact
        if ($vendors->isEmpty()) {
            return view('messages.index', [
                'vendors' => collect(),
                'activeVendor' => null,
                'messages' => collect()
            ]);
        }

        // Determine active vendor
        $activeVendorId = $request->input('vendor_id', $vendors->first()->id);
        $activeVendor = Vendor::find($activeVendorId) ?? $vendors->first();

        // Get messages between logged-in user and active vendor
        $messages = Message::where('user_id', Auth::id())
            ->where('vendor_id', $activeVendor->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // If no messages exist yet, seed a welcome message from the vendor
        if ($messages->isEmpty()) {
            $welcomeMessage = Message::create([
                'user_id' => Auth::id(),
                'vendor_id' => $activeVendor->id,
                'body' => "Hello! Thanks for checking out our services. Let us know if you have any questions about packages, pricing, or availability.",
                'is_from_vendor' => true
            ]);
            $messages = collect([$welcomeMessage]);
        }

        return view('messages.index', compact('vendors', 'activeVendor', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'body'      => ['required', 'string'],
        ]);

        // Create user's message
        Message::create([
            'user_id' => Auth::id(),
            'vendor_id' => $validated['vendor_id'],
            'body' => $validated['body'],
            'is_from_vendor' => false
        ]);

        // Simulation: after 1 second, a vendor automatically replies. We can insert this immediately in the controller
        // to make it instant for the demo!
        $replies = [
            "Thank you! That sounds like a wonderful plan. Let's schedule a call tomorrow to discuss details.",
            "I'm checking our calendar for that date. It looks like we have tentative availability! What is your venue location?",
            "Yes, we can absolutely customize that package to better suit your budget. What is the approximate guest count?",
            "Great! Our team is available. Let's finalize the contract milestone so we can lock in the dates."
        ];
        $randomReply = $replies[array_rand($replies)];

        Message::create([
            'user_id' => Auth::id(),
            'vendor_id' => $validated['vendor_id'],
            'body' => $randomReply,
            'is_from_vendor' => true
        ]);

        return back()->with('success', 'Message sent!');
    }
}
