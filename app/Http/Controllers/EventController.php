<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::withCount(['contributions','gifts'])
            ->when($request->search, function($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'couple_name'   => ['required', 'string', 'max:150'],
            'bride_name'    => ['nullable', 'string', 'max:80'],
            'groom_name'    => ['nullable', 'string', 'max:80'],
            'wedding_date'  => ['required', 'date'],
            'venue'         => ['nullable', 'string', 'max:200'],
            'target_budget' => ['nullable', 'numeric', 'min:0'],
            'description'   => ['nullable', 'string'],
        ]);

        Event::create([
            'name' => $validated['couple_name'],
            'event_date' => $validated['wedding_date'],
            'venue' => $validated['venue'] ?? null,
            'target_budget' => $validated['target_budget'] ?? 0,
            'description' => $validated['description'] ?? null,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('events.index')->with('success', 'Event created!');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'couple_name'   => ['required', 'string', 'max:150'],
            'bride_name'    => ['nullable', 'string', 'max:80'],
            'groom_name'    => ['nullable', 'string', 'max:80'],
            'wedding_date'  => ['required', 'date'],
            'venue'         => ['nullable', 'string', 'max:200'],
            'target_budget' => ['nullable', 'numeric', 'min:0'],
        ]);

        $event->update([
            'name' => $validated['couple_name'],
            'event_date' => $validated['wedding_date'],
            'venue' => $validated['venue'] ?? null,
            'target_budget' => $validated['target_budget'] ?? 0,
        ]);
        return redirect()->route('events.index')->with('success', 'Event updated!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }
}
