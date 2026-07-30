<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contribution;
use App\Models\Gift;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index()
    {
        $event = Event::active()->latest()->first();

        $data = [];
        if ($event) {
            $data = [
                'contributions_by_method' => Contribution::where('event_id', $event->id)
                    ->confirmed()->selectRaw('payment_method, SUM(amount) as total, COUNT(*) as count')
                    ->groupBy('payment_method')->get(),

                'daily_totals' => Contribution::where('event_id', $event->id)
                    ->confirmed()->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                    ->groupBy('date')->orderBy('date')->get(),

                'top_contributors' => Contribution::where('event_id', $event->id)
                    ->confirmed()
                    ->with('contributor')
                    ->get()
                    ->groupBy('contributor_id')
                    ->map(function ($contributions) {
                        return [
                            'name' => $contributions->first()->contributor?->first_name . ' ' . $contributions->first()->contributor?->last_name,
                            'phone' => $contributions->first()->contributor?->phone,
                            'total' => $contributions->sum('amount')
                        ];
                    })
                    ->sortByDesc('total')
                    ->take(10),
            ];
        }

        return view('reports.index', compact('event', 'data'));
    }

    public function exportPdf()
    {
        $event         = Event::active()->latest()->first();
        $contributions = Contribution::where('event_id', $event?->id)->with('recordedBy', 'contributor')->get();
        $gifts         = Gift::where('event_id', $event?->id)->with('contributor')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('event','contributions','gifts'));
        return $pdf->download('wedding_report_' . now()->format('Y_m_d') . '.pdf');
    }

    public function exportCsv()
    {
        $event         = Event::active()->latest()->first();
        $contributions = Contribution::where('event_id', $event?->id)->with('contributor')->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="contributions.csv"'];

        $callback = function () use ($contributions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['#', 'Name', 'Phone', 'Type', 'Amount (TZS)', 'Method', 'Reference', 'Status', 'Date']);
            foreach ($contributions as $i => $c) {
                fputcsv($file, [
                    $i + 1, 
                    $c->contributor?->first_name . ' ' . $c->contributor?->last_name, 
                    $c->contributor?->phone,
                    $c->type, $c->amount, $c->payment_method,
                    $c->payment_reference, $c->status, $c->created_at->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
