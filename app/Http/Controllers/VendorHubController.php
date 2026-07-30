<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorHubController extends Controller
{
    public function leads()
    {
        $leads = \App\Models\Event::active()->latest()->get();
        return view('vendor.hub.leads', compact('leads'));
    }

    public function proposals()
    {
        // Mock data for proposals
        $proposals = [
            (object)[
                'id' => 1,
                'event_name' => 'Sarah & John Wedding',
                'event_date' => now()->addDays(14)->format('M d, Y'),
                'amount' => 1500,
                'status' => 'Pending',
                'submitted_at' => now()->subDays(2)->format('M d, Y'),
            ],
            (object)[
                'id' => 2,
                'event_name' => 'Tech Innovators Summit',
                'event_date' => now()->addDays(45)->format('M d, Y'),
                'amount' => 2500,
                'status' => 'Accepted',
                'submitted_at' => now()->subDays(10)->format('M d, Y'),
            ],
            (object)[
                'id' => 3,
                'event_name' => 'Corporate Gala Dinner',
                'event_date' => now()->addDays(30)->format('M d, Y'),
                'amount' => 1800,
                'status' => 'Rejected',
                'submitted_at' => now()->subDays(15)->format('M d, Y'),
            ]
        ];

        return view('vendor.hub.proposals', compact('proposals'));
    }

    public function bookings()
    {
        // Mock data for booked events
        $bookings = [
            (object)[
                'id' => 1,
                'event_name' => 'Tech Innovators Summit',
                'event_date' => now()->addDays(45)->format('M d, Y'),
                'location' => 'Dar es Salaam International Conference Center',
                'amount' => 2500,
                'client_name' => 'Innovate TZ',
            ],
            (object)[
                'id' => 2,
                'event_name' => 'Aisha & Kevin Anniversary',
                'event_date' => now()->addDays(60)->format('M d, Y'),
                'location' => 'Zanzibar Beach Resort',
                'amount' => 1200,
                'client_name' => 'Aisha M.',
            ]
        ];

        return view('vendor.hub.bookings', compact('bookings'));
    }
}
