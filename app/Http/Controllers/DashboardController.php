<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contribution;
use App\Models\Gift;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Active event
        $event = Event::active()->latest()->first();
        $user = auth()->user();

        if ($user->role === 'contributor') {
            // Contributor-specific stats
            $totalContribs   = Contribution::where(function($q) use ($user) {
                $q->where('contributor_id', $user->id)
                  ->orWhere('contributor_phone', $user->phone);
            })->confirmed()->sum('amount');
            
            $pendingContribs = Contribution::where(function($q) use ($user) {
                $q->where('contributor_id', $user->id)
                  ->orWhere('contributor_phone', $user->phone);
            })->where('status', 'pending')->sum('amount');

            $stats = [
                'total_events'       => $user->events()->count(),
                'total_confirmed'    => $totalContribs,
                'total_pending'      => $pendingContribs,
                'total_guests'       => 0,
                'total_vendors'      => 0,
                'total_gifts'        => Gift::where('donor_id', $user->id)->orWhere('donor_phone', $user->phone)->count(),
                'days_to_go'         => $event ? $event->days_to_go : 0,
                'progress_percent'   => $event ? $event->progress_percent : 0,
            ];

            $recent_contributions = Contribution::with('event')
                ->where(function($q) use ($user) {
                    $q->where('contributor_id', $user->id)
                      ->orWhere('contributor_phone', $user->phone);
                })
                ->latest()
                ->take(8)
                ->get();
        } elseif ($user->role === 'vendor') {
            // Vendor-specific stats
            $vendorProfile = $user->vendorProfile;
            
            $stats = [
                'total_events'       => Event::active()->count(), // "Leads"
                'total_confirmed'    => 0,
                'total_pending'      => 0,
                'total_guests'       => 0,
                'total_vendors'      => 124, // Mock "Profile Views"
                'total_gifts'        => 2,   // Mock "Pending Proposals"
                'days_to_go'         => 0,
                'progress_percent'   => $vendorProfile ? ($vendorProfile->rating / 5) * 100 : 0,
            ];

            // Mock recent leads (active events)
            $recent_contributions = collect(); // Vendors don't see contributions
        } else {
            // Platform-wide stats (Admin/Committee/Couple)
            $totalEvents     = Event::count();
            $totalContribs   = Contribution::confirmed()->sum('amount');
            $pendingContribs = Contribution::where('status', 'pending')->sum('amount');
            $totalGuests     = User::where('role', 'contributor')->count();
            $totalVendors    = Vendor::count();
            $totalGifts      = Gift::count();

            $stats = [
                'total_events'       => $totalEvents,
                'total_confirmed'    => $totalContribs,
                'total_pending'      => $pendingContribs,
                'total_guests'       => $totalGuests,
                'total_vendors'      => $totalVendors,
                'total_gifts'        => $totalGifts,
                'days_to_go'         => $event ? $event->days_to_go : 0,
                'progress_percent'   => $event ? $event->progress_percent : 0,
            ];

            $recent_contributions = Contribution::with('event')
                ->latest()
                ->take(8)
                ->get();
        }

        // Upcoming events
        $upcoming_events = Event::where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(4)
            ->get();

        // Top vendors
        $top_vendors = Vendor::orderByDesc('rating')->take(3)->get();

        return view('dashboard.index', compact(
            'event', 'stats', 'recent_contributions', 'upcoming_events', 'top_vendors'
        ));
    }
}
