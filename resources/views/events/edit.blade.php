@extends('layouts.app')
@section('title', 'Edit Event')
@section('heading', 'Edit Event')
@section('subheading', 'Update configuration for ' . $event->couple_name)

@section('topbar_actions')
  <a href="{{ route('events.show', $event) }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back
  </a>
@endsection

@section('content')
<div class="form-card" style="max-width: 800px; margin: 0 auto;">
  <form method="POST" action="{{ route('events.update', $event) }}">
    @csrf
    @method('PUT')
    <div class="form-card-header">
      <div class="form-card-title">Event Configuration</div>
      <div class="form-card-sub">Modify wedding event details</div>
    </div>
    <div class="form-body">
      <div class="form-grid">
        
        <div class="field span2">
          <label>Couple Name</label>
          <input type="text" name="couple_name" value="{{ old('couple_name', $event->couple_name) }}" required/>
        </div>

        <div class="field">
          <label>Bride's Full Name</label>
          <input type="text" name="bride_name" value="{{ old('bride_name', $event->bride_name) }}"/>
        </div>

        <div class="field">
          <label>Groom's Full Name</label>
          <input type="text" name="groom_name" value="{{ old('groom_name', $event->groom_name) }}"/>
        </div>

        <div class="field">
          <label>Wedding Date</label>
          <input type="date" name="wedding_date" value="{{ old('wedding_date', $event->wedding_date->format('Y-m-d')) }}" required/>
        </div>

        <div class="field">
          <label>Venue</label>
          <input type="text" name="venue" value="{{ old('venue', $event->venue) }}"/>
        </div>

        <div class="field">
          <label>Target Budget (TZS)</label>
          <input type="number" name="target_budget" value="{{ old('target_budget', $event->target_budget) }}"/>
        </div>

        <div class="field">
          <label>Status</label>
          <select name="is_active">
            <option value="1" {{ $event->is_active ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$event->is_active ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>

      </div>
    </div>
    <div class="form-actions">
      <a href="{{ route('events.show', $event) }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary">Update Event</button>
    </div>
  </form>
</div>
@endsection
