@extends('layouts.app')
@section('title', 'Tasks & Timeline')

@section('extra_css')
<style>
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
.ph-title { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: all 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

.kanban-board { display: flex; gap: 24px; overflow-x: auto; padding-bottom: 24px; }
.kanban-board::-webkit-scrollbar { height: 6px; }
.kanban-board::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 99px; }

.k-column { min-width: 300px; flex: 1; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 16px; padding: 20px; transition: background 0.2s; min-height: 500px; }
.k-column.drag-over { background: rgba(139, 92, 246, 0.05); border-color: var(--brand-purple); }
.k-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.k-title { font-size: 14px; font-weight: 600; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; }
.k-badge { background: rgba(255,255,255,0.1); color: #fff; padding: 2px 8px; border-radius: 99px; font-size: 11px; font-weight: 600; }

.task-list { min-height: 400px; }

.task-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 12px; cursor: grab; transition: transform 0.2s, box-shadow 0.2s; position: relative; overflow: hidden; }
.task-card:active { cursor: grabbing; }
.task-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); }
.task-card::before { content: ''; position: absolute; top: 0; left: 0; width: 3px; height: 100%; }
.task-urgent::before { background: #EF4444; }
.task-normal::before { background: #3B82F6; }

.tc-title { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 8px; line-height: 1.4; }
.tc-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
.tc-date { font-size: 11px; font-weight: 500; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
.tc-assignees { display: flex; align-items: center; }
.tc-avatar { width: 24px; height: 24px; border-radius: 50%; border: 2px solid var(--bg-card); background: #3B82F6; color: #fff; font-size: 10px; font-weight: 600; display: flex; align-items: center; justify-content: center; text-transform: uppercase; }

.tc-actions { display: flex; gap: 6px; margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.03); padding-top: 8px; justify-content: flex-end; }
.tc-btn { background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 12px; padding: 4px 8px; border-radius: 4px; transition: all 0.2s; }
.tc-btn:hover { background: rgba(255,255,255,0.05); color: #fff; }
.tc-delete:hover { color: #EF4444; }

/* Modal Styles */
.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
.modal.show { display: flex; }
.modal-content { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; width: 100%; max-width: 500px; padding: 32px; box-shadow: 0 24px 64px rgba(0,0,0,0.4); }
.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.modal-title { font-size: 18px; font-weight: 700; color: #fff; }
.modal-close { background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 20px; }
.modal-close:hover { color: #fff; }

.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
label { font-size: 12px; font-weight: 500; color: var(--text-muted); }
.form-input, .form-select {
  background: rgba(0,0,0,0.15); border: 1px solid var(--border); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none; width: 100%;
}
.form-input:focus, .form-select:focus { border-color: var(--brand-purple); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; margin-bottom: 32px; }
  .ph-title { font-size: 22px; }
  .kanban-board { flex-direction: column; gap: 16px; }
  .k-column { min-width: 100%; min-height: auto; }
  .task-list { min-height: 100px; }
  .modal-content { margin: 16px; padding: 24px; border-radius: 16px; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 20px; }
  .btn-primary { padding: 10px 16px; font-size: 12px; }
  .k-column { padding: 14px; }
  .task-card { padding: 12px; }
  .tc-meta { flex-direction: column; align-items: flex-start; gap: 8px; }
  .modal-content { padding: 20px; }
}
</style>
@endsection

@section('content')

@if(session('success'))
  <div style="background: rgba(16, 185, 129, 0.12); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.2); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 500;">
    {{ session('success') }}
  </div>
@endif

<div class="page-header">
  <div>
    <h1 class="ph-title">Tasks & Timeline</h1>
    <p class="ph-sub">Manage your event planning checklist and coordinate with your team.</p>
  </div>
  @if($event)
    <button class="btn-primary" onclick="openModal()">
      <i class="fa-solid fa-plus"></i> Create Task
    </button>
  @endif
</div>

@if(!$event)
  <div style="text-align: center; padding: 80px 20px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px;">
    <i class="fa-solid fa-calendar-xmark" style="font-size: 40px; color: var(--text-muted); margin-bottom: 16px;"></i>
    <h3 style="color:#fff; margin-bottom:8px;">No active event workspace found</h3>
    <p style="color:var(--text-muted); margin-bottom:24px;">Please create an event first to start managing planning tasks.</p>
    <a href="{{ route('events.create') }}" class="btn-primary" style="display:inline-flex;">Create New Event</a>
  </div>
@else

<div class="kanban-board">
  
  <!-- Column: To Do -->
  <div class="k-column" data-status="todo" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">
    <div class="k-header">
      <div class="k-title">To Do</div>
      <div class="k-badge">{{ $tasks->where('status', 'todo')->count() }}</div>
    </div>
    <div class="task-list">
      @foreach($tasks->where('status', 'todo') as $task)
        @include('tasks._card', ['task' => $task])
      @endforeach
    </div>
  </div>

  <!-- Column: In Progress -->
  <div class="k-column" data-status="in_progress" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">
    <div class="k-header">
      <div class="k-title">In Progress</div>
      <div class="k-badge">{{ $tasks->where('status', 'in_progress')->count() }}</div>
    </div>
    <div class="task-list">
      @foreach($tasks->where('status', 'in_progress') as $task)
        @include('tasks._card', ['task' => $task])
      @endforeach
    </div>
  </div>

  <!-- Column: Completed -->
  <div class="k-column" data-status="completed" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">
    <div class="k-header">
      <div class="k-title">Completed</div>
      <div class="k-badge">{{ $tasks->where('status', 'completed')->count() }}</div>
    </div>
    <div class="task-list">
      @foreach($tasks->where('status', 'completed') as $task)
        @include('tasks._card', ['task' => $task])
      @endforeach
    </div>
  </div>

</div>

<!-- Create Task Modal -->
<div class="modal" id="createTaskModal">
  <div class="modal-content">
    <div class="modal-header">
      <div class="modal-title">Create Planning Task</div>
      <button class="modal-close" onclick="closeModal()">&times;</button>
    </div>
    <form method="POST" action="{{ route('tasks.store') }}">
      @csrf
      <input type="hidden" name="event_id" value="{{ $event->id }}">
      
      <div class="form-group">
        <label>Task Title</label>
        <input type="text" name="title" class="form-input" placeholder="e.g. Call decorators and align colors" required>
      </div>

      <div class="form-group">
        <label>Priority</label>
        <select name="priority" class="form-select" required>
          <option value="normal">Normal</option>
          <option value="urgent">Urgent</option>
        </select>
      </div>

      <div class="form-group">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-input">
      </div>

      <div class="form-group">
        <label>Assignee Name</label>
        <input type="text" name="assignee" class="form-input" placeholder="e.g. Sarah">
      </div>

      <div style="display:flex; justify-content: flex-end; gap: 12px; margin-top: 12px;">
        <button type="button" class="btn-primary" style="background:transparent; border:1px solid var(--border); color:var(--text-muted);" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn-primary">Create Task</button>
      </div>
    </form>
  </div>
</div>

@endif

@endsection

@section('scripts')
<script>
function openModal() {
  document.getElementById('createTaskModal').classList.add('show');
}
function closeModal() {
  document.getElementById('createTaskModal').classList.remove('show');
}

// Drag & Drop Operations
let draggedCard = null;

function dragStart(e, taskId) {
  draggedCard = e.currentTarget;
  e.dataTransfer.setData('text/plain', taskId);
  setTimeout(() => draggedCard.style.opacity = '0.5', 0);
}

function dragEnd(e) {
  if (draggedCard) {
    draggedCard.style.opacity = '1';
  }
}

function allowDrop(e) {
  e.preventDefault();
}

function dragEnter(e) {
  e.preventDefault();
  const col = e.currentTarget;
  col.classList.add('drag-over');
}

function dragLeave(e) {
  const col = e.currentTarget;
  col.classList.remove('drag-over');
}

function drop(e) {
  e.preventDefault();
  const col = e.currentTarget;
  col.classList.remove('drag-over');
  
  const taskId = e.dataTransfer.getData('text/plain');
  const newStatus = col.getAttribute('data-status');
  
  if (draggedCard) {
    col.querySelector('.task-list').appendChild(draggedCard);
    updateTaskStatus(taskId, newStatus);
  }
}

function updateTaskStatus(taskId, newStatus) {
  fetch(`/tasks/${taskId}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ status: newStatus })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Task status updated successfully!');
      // Reload badges/counters
      window.location.reload();
    }
  })
  .catch(err => console.error('Error updating status:', err));
}
</script>
@endsection
