<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contribution;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get active event (first active, or latest)
        $event = Event::active()->latest()->first();

        $stats = [
            'total_confirmed'     => 0,
            'total_pending'       => 0,
            'total_contributors'  => 0,
            'total_gifts'         => 0,
            'receipts_sent'       => 0,
            'progress_percent'    => 0,
            'days_to_go'          => 0,
        ];

        $recent_contributions = collect();
        $recent_gifts         = collect();
        $upcoming_milestones  = collect();

        if ($event) {
            $stats['total_confirmed']    = $event->total_confirmed;
            $stats['total_pending']      = $event->total_pending;
            $stats['total_contributors'] = $event->contributions()->distinct('contributor_phone')->count();
            $stats['total_gifts']        = $event->gifts()->count();
            $stats['receipts_sent']      = $event->contributions()->whereHas('confirmation', fn($q) => $q->where('status','sent'))->count();
            $stats['progress_percent']   = $event->progress_percent;
            $stats['days_to_go']         = $event->days_to_go;

            $recent_contributions = $event->contributions()
                ->with(['recordedBy'])
                ->latest()
                ->take(10)
                ->get();

            $recent_gifts = $event->gifts()->latest()->take(5)->get();
        }

        return view('dashboard.index', compact(
            'event', 'stats', 'recent_contributions', 'recent_gifts'
        ));
    }
}
