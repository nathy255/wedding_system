@extends('layouts.app')
@section('title', 'Edit Contributor')
@section('heading', 'Edit Contributor')
@section('subheading', 'Update details for ' . $contributor->full_name)

@section('content')
<div class="form-card" style="max-width: 600px; margin: 0 auto;">
  <form method="POST" action="{{ route('contributors.update', $contributor) }}">
    @csrf
    @method('PUT')
    <div class="form-card-header">
      <div class="form-card-title">Update Profile</div>
    </div>
    <div class="form-body">
      <div class="form-grid cols-1">
        <div class="field">
          <label>Full Name</label>
          <input type="text" name="full_name" value="{{ old('full_name', $contributor->full_name) }}" required/>
        </div>
        <div class="field">
          <label>Phone Number</label>
          <input type="tel" name="phone" value="{{ old('phone', $contributor->phone) }}" required/>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $contributor->email) }}"/>
        </div>
      </div>
    </div>
    <div class="form-actions">
      <a href="{{ route('contributors.show', $contributor) }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary">Update Details</button>
    </div>
  </form>
</div>
@endsection
