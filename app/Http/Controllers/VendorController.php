<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        // For demonstration, if no vendors exist, create a few mock ones to populate the UI
        if (\App\Models\Vendor::count() == 0) {
            $this->seedMockVendors();
        }

        $vendors = \App\Models\Vendor::latest()->get();
        return view('vendors.index', compact('vendors'));
    }

    public function show(\App\Models\Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    private function seedMockVendors()
    {
        \App\Models\Vendor::insert([
            [
                'name' => 'Serena Photography',
                'category' => 'Photography',
                'location' => 'Nairobi, Kenya',
                'starting_price' => 1200.00,
                'rating' => 4.9,
                'review_count' => 124,
                'cover_image' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=1000&auto=format&fit=crop',
                'description' => 'Award-winning wedding and corporate photography team with 10 years of experience.',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'The Grand Azure Venue',
                'category' => 'Venue',
                'location' => 'Dar es Salaam, Tanzania',
                'starting_price' => 5000.00,
                'rating' => 4.8,
                'review_count' => 89,
                'cover_image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=1000&auto=format&fit=crop',
                'description' => 'A stunning 1000-capacity hall with ocean views and world-class amenities.',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Gourmet Safari Catering',
                'category' => 'Catering',
                'location' => 'Zanzibar, Tanzania',
                'starting_price' => 45.00,
                'rating' => 5.0,
                'review_count' => 205,
                'cover_image' => 'https://images.unsplash.com/photo-1555244162-803834f70033?q=80&w=1000&auto=format&fit=crop',
                'description' => 'Premium catering specializing in fusion African and Continental cuisines. Price per plate.',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Neon Beats Entertainment',
                'category' => 'Entertainment',
                'location' => 'Mombasa, Kenya',
                'starting_price' => 800.00,
                'rating' => 4.7,
                'review_count' => 56,
                'cover_image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=1000&auto=format&fit=crop',
                'description' => 'Live band and DJ setup for an unforgettable after-party.',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }
}
