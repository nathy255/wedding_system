@extends('layouts.app')
@section('title', 'Add Contributor')
@section('heading', 'Add Contributor')
@section('subheading', 'Manually register a new contributor')

@section('content')
<div class="form-card" style="max-width: 600px; margin: 0 auto;">
  <form method="POST" action="{{ route('contributors.store') }}">
    @csrf
    <div class="form-card-header">
      <div class="form-card-title">Contributor Profile</div>
    </div>
    <div class="form-body">
      <div class="form-grid cols-1">
        <div class="field">
          <label>Full Name</label>
          <input type="text" name="full_name" placeholder="e.g. John Doe" required/>
        </div>
        <div class="field">
          <label>Phone Number</label>
          <input type="tel" name="phone" placeholder="+255 7XX XXX XXX" required/>
        </div>
        <div class="field">
          <label>Email (Optional)</label>
          <input type="email" name="email" placeholder="john@example.com"/>
        </div>
      </div>
    </div>
    <div class="form-actions">
      <a href="{{ route('contributors.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary">Save Contributor</button>
    </div>
  </form>
</div>
@endsection
