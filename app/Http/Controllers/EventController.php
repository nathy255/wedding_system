<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount(['contributions','gifts'])->latest()->paginate(10);
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

        Event::create([...$validated, 'created_by' => Auth::id()]);

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

        $event->update($validated);
        return redirect()->route('events.index')->with('success', 'Event updated!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }
}
