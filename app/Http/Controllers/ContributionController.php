<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Event;
use App\Models\Confirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $event = Event::active()->latest()->first();

        $contributions = Contribution::with(['recordedBy'])
            ->when($event, fn($q) => $q->where('event_id', $event->id))
            ->when($request->status,  fn($q, $v) => $q->where('status', $v))
            ->when($request->type,    fn($q, $v) => $q->where('type', $v))
            ->when($request->search,  fn($q, $v) => $q->where(function($q) use ($v) {
                $q->where('contributor_name', 'like', "%$v%")
                  ->orWhere('contributor_phone', 'like', "%$v%")
                  ->orWhere('payment_reference', 'like', "%$v%");
            }))
            ->latest()
            ->paginate(20);

        return view('contributions.index', compact('contributions', 'event'));
    }

    public function create()
    {
        $event = Event::active()->latest()->first();
        return view('contributions.create', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'            => ['required', 'exists:events,id'],
            'contributor_name'    => ['required', 'string', 'max:100'],
            'contributor_phone'   => ['required', 'string', 'max:20'],
            'type'                => ['required', 'in:cash,gift'],
            'amount'              => ['nullable', 'numeric', 'min:0'],
            'payment_method'      => ['nullable', 'string'],
            'payment_reference'   => ['nullable', 'string', 'max:100'],
            'status'              => ['required', 'in:pending,confirmed,rejected'],
            'notes'               => ['nullable', 'string'],
        ]);

        $contribution = Contribution::create([
            ...$validated,
            'recorded_by' => Auth::id(),
            'confirmed_by'  => $validated['status'] === 'confirmed' ? Auth::id() : null,
            'confirmed_at'  => $validated['status'] === 'confirmed' ? now() : null,
        ]);

        // Send confirmation if status is confirmed
        if ($contribution->status === 'confirmed') {
            $this->sendConfirmation($contribution);
        }

        return redirect()->route('contributions.index')
                         ->with('success', 'Contribution recorded successfully!');
    }

    public function show(Contribution $contribution)
    {
        return view('contributions.show', compact('contribution'));
    }

    public function edit(Contribution $contribution)
    {
        $event = Event::active()->latest()->first();
        return view('contributions.edit', compact('contribution', 'event'));
    }

    public function update(Request $request, Contribution $contribution)
    {
        $validated = $request->validate([
            'contributor_name'  => ['required', 'string', 'max:100'],
            'contributor_phone' => ['required', 'string', 'max:20'],
            'amount'            => ['nullable', 'numeric', 'min:0'],
            'payment_method'    => ['nullable', 'string'],
            'payment_reference' => ['nullable', 'string', 'max:100'],
            'status'            => ['required', 'in:pending,confirmed,rejected'],
            'notes'             => ['nullable', 'string'],
        ]);

        $wasNotConfirmed = $contribution->status !== 'confirmed';

        if ($validated['status'] === 'confirmed' && empty($contribution->confirmed_by)) {
            $validated['confirmed_by'] = Auth::id();
            $validated['confirmed_at'] = now();
        }

        $contribution->update($validated);

        // Send confirmation SMS if just confirmed
        if ($wasNotConfirmed && $contribution->status === 'confirmed') {
            $this->sendConfirmation($contribution);
        }

        return redirect()->route('contributions.index')
                         ->with('success', 'Contribution updated successfully!');
    }

    public function destroy(Contribution $contribution)
    {
        $contribution->delete();
        return back()->with('success', 'Contribution deleted.');
    }

    public function confirm(Contribution $contribution)
    {
        $contribution->update([
            'status'       => 'confirmed',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
        ]);
        $this->sendConfirmation($contribution);
        return back()->with('success', 'Contribution confirmed and receipt sent!');
    }

    public function reject(Contribution $contribution)
    {
        $contribution->update(['status' => 'rejected']);
        return back()->with('success', 'Contribution marked as rejected.');
    }

    public function receipt(Contribution $contribution)
    {
        return view('contributions.receipt', compact('contribution'));
    }

    // ── Private helper ────────────────────────────────────────
    private function sendConfirmation(Contribution $contribution)
    {
        // TODO: integrate Africa's Talking SMS API
        // For now just log the confirmation
        Confirmation::updateOrCreate(
            ['contribution_id' => $contribution->id],
            [
                'sent_to_phone' => $contribution->contributor_phone,
                'sent_via'      => 'sms',
                'message_body'  => "Asante {$contribution->contributor_name}! Mchango wako wa TZS " . number_format($contribution->amount) . " kwa {$contribution->event->couple_name} umethibitishwa. - WeddingIS",
                'status'        => 'sent',
            ]
        );
    }
}
