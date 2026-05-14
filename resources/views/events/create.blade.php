@extends('layouts.app')
@section('title', 'Create Event')
@section('heading', 'Create Event')
@section('subheading', 'Initialize a new wedding event')

@section('topbar_actions')
  <a href="{{ route('events.index') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back
  </a>
@endsection

@section('content')
<div class="form-card" style="max-width: 800px; margin: 0 auto;">
  <form method="POST" action="{{ route('events.store') }}">
    @csrf
    <div class="form-card-header">
      <div class="form-card-title">Event Configuration</div>
      <div class="form-card-sub">Setup the couple and wedding details</div>
    </div>
    <div class="form-body">
      <div class="form-grid">
        
        <div class="field span2">
          <label>Couple Name (e.g. Samuel & Amina)</label>
          <input type="text" name="couple_name" value="{{ old('couple_name') }}" placeholder="Samuel & Amina" required/>
          @error('couple_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="field">
          <label>Bride's Full Name</label>
          <input type="text" name="bride_name" value="{{ old('bride_name') }}" placeholder="Amina Juma"/>
        </div>

        <div class="field">
          <label>Groom's Full Name</label>
          <input type="text" name="groom_name" value="{{ old('groom_name') }}" placeholder="Samuel Kimaro"/>
        </div>

        <div class="field">
          <label>Wedding Date</label>
          <input type="date" name="wedding_date" value="{{ old('wedding_date') }}" required/>
        </div>

        <div class="field">
          <label>Venue</label>
          <input type="text" name="venue" value="{{ old('venue') }}" placeholder="e.g. Blue Pearl Hotel, Arusha"/>
        </div>

        <div class="field">
          <label>Target Budget (TZS)</label>
          <input type="number" name="target_budget" value="{{ old('target_budget') }}" placeholder="0"/>
        </div>

        <div class="field">
          <label>Status</label>
          <select name="is_active">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>

        <div class="field span2">
          <label>Description / Story</label>
          <textarea name="description" placeholder="A brief description or couple's story...">{{ old('description') }}</textarea>
        </div>

      </div>
    </div>
    <div class="form-actions">
      <a href="{{ route('events.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary">Create Event</button>
    </div>
  </form>
</div>
@endsection
