<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Event;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $event = Event::active()->latest()->first();
        
        if (!$event) {
            return view('tasks.index', ['event' => null, 'tasks' => collect()]);
        }

        // Seed mock tasks if empty to give user a ready-to-test board
        if ($event->tasks()->count() == 0) {
            $this->seedMockTasks($event);
        }

        $tasks = $event->tasks()->latest()->get();

        return view('tasks.index', compact('event', 'tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'title'    => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:urgent,normal'],
            'due_date' => ['nullable', 'date'],
            'assignee' => ['nullable', 'string', 'max:100'],
        ]);

        Task::create($validated);

        return back()->with('success', 'Task added to board!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:todo,in_progress,completed'],
        ]);

        $task->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted.');
    }

    private function seedMockTasks(Event $event)
    {
        $event->tasks()->createMany([
            [
                'title'    => 'Finalize catering menu and confirm dietary restrictions with vendor',
                'status'   => 'todo',
                'priority' => 'urgent',
                'due_date' => now()->addDays(2),
                'assignee' => 'Sarah'
            ],
            [
                'title'    => 'Book the photography and videography team via Marketplace',
                'status'   => 'todo',
                'priority' => 'normal',
                'due_date' => now()->addDays(7),
                'assignee' => 'John'
            ],
            [
                'title'    => 'Review the initial draft of the venue floor plan',
                'status'   => 'in_progress',
                'priority' => 'normal',
                'due_date' => now()->addDays(5),
                'assignee' => 'Sarah'
            ],
            [
                'title'    => 'Secure the down payment for the Grand Azure Venue',
                'status'   => 'completed',
                'priority' => 'urgent',
                'due_date' => now()->subDays(1),
                'assignee' => 'Alex'
            ]
        ]);
    }
}
