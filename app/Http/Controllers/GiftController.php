<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function index()
    {
        $event = Event::active()->latest()->first();
        $gifts = Gift::when($event, fn($q) => $q->where('event_id', $event->id))
                     ->latest()->paginate(20);
        return view('gifts.index', compact('gifts', 'event'));
    }

    public function create()
    {
        $event = Event::active()->latest()->first();
        return view('gifts.create', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'        => ['required', 'exists:events,id'],
            'donor_name'      => ['required', 'string', 'max:100'],
            'donor_phone'     => ['required', 'string', 'max:20'],
            'item_name'       => ['required', 'string', 'max:200'],
            'category'        => ['required', 'string'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'description'     => ['nullable', 'string'],
            'status'          => ['required', 'in:pledged,received,cancelled'],
        ]);

        if ($validated['status'] === 'received') {
            $validated['received_by'] = Auth::id();
            $validated['received_at'] = now();
        }

        Gift::create($validated);
        return redirect()->route('gifts.index')->with('success', 'Gift registered successfully!');
    }

    public function show(Gift $gift)
    {
        return view('gifts.show', compact('gift'));
    }

    public function edit(Gift $gift)
    {
        $event = Event::active()->latest()->first();
        return view('gifts.edit', compact('gift', 'event'));
    }

    public function update(Request $request, Gift $gift)
    {
        $validated = $request->validate([
            'donor_name'      => ['required', 'string', 'max:100'],
            'donor_phone'     => ['required', 'string', 'max:20'],
            'item_name'       => ['required', 'string', 'max:200'],
            'category'        => ['required', 'string'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'description'     => ['nullable', 'string'],
            'status'          => ['required', 'in:pledged,received,cancelled'],
        ]);

        $gift->update($validated);
        return redirect()->route('gifts.index')->with('success', 'Gift updated!');
    }

    public function destroy(Gift $gift)
    {
        $gift->delete();
        return back()->with('success', 'Gift removed.');
    }

    public function receive(Gift $gift)
    {
        $gift->update([
            'status'      => 'received',
            'received_by' => Auth::id(),
            'received_at' => now(),
        ]);
        return back()->with('success', 'Gift marked as received!');
    }
}
