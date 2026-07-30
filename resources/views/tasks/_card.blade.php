<div class="task-card task-{{ $task->priority }}" draggable="true" ondragstart="dragStart(event, {{ $task->id }})" ondragend="dragEnd(event)">
  <div class="tc-title">{{ $task->title }}</div>
  
  <div class="tc-meta">
    @if($task->due_date)
      <div class="tc-date" style="{{ $task->priority == 'urgent' ? 'color:#EF4444;' : '' }}">
        <i class="fa-regular fa-clock"></i> 
        @if($task->due_date->isToday())
          Today
        @elseif($task->due_date->isTomorrow())
          Tomorrow
        @else
          {{ $task->due_date->format('M d') }}
        @endif
      </div>
    @else
      <div class="tc-date"><i class="fa-regular fa-calendar"></i> No date</div>
    @endif

    <div class="tc-assignees">
      @if($task->assignee)
        <div class="tc-avatar" title="Assigned to {{ $task->assignee }}" style="background: {{ $task->priority == 'urgent' ? '#A855F7' : '#3B82F6' }}">
          {{ substr($task->assignee, 0, 1) }}
        </div>
      @else
        <div class="tc-avatar" style="background:#555;" title="Unassigned"><i class="fa-solid fa-user" style="font-size:8px;"></i></div>
      @endif
    </div>
  </div>

  <div class="tc-actions">
    @if($task->status !== 'todo')
      <button class="tc-btn" onclick="updateTaskStatus({{ $task->id }}, 'todo')"><i class="fa-solid fa-arrow-left"></i> Todo</button>
    @endif
    @if($task->status !== 'in_progress')
      <button class="tc-btn" onclick="updateTaskStatus({{ $task->id }}, 'in_progress')"><i class="fa-solid fa-spinner"></i> Work</button>
    @endif
    @if($task->status !== 'completed')
      <button class="tc-btn" onclick="updateTaskStatus({{ $task->id }}, 'completed')"><i class="fa-solid fa-circle-check"></i> Done</button>
    @endif
    
    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" onsubmit="return confirm('Delete this task?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="tc-btn tc-delete"><i class="fa-solid fa-trash"></i></button>
    </form>
  </div>
</div>
