<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — WeddingIS</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --rose:#8B2A4A; --rose-light:#C4607C; --rose-pale:#F5E6EC;
  --gold:#B8932A; --gold-light:#D4B060; --gold-pale:#FBF5E6;
  --ivory:#FAF7F2; --ink:#1C1210; --ink-muted:#5C4A46; --ink-faint:#9C8580;
  --surface:#FFFFFF; --border:#EDE0D8;
  --green:#2A6B4A; --green-pale:#E6F4EC;
  --amber:#8B5E1A; --amber-pale:#FDF3E3;
  --blue:#1A4A7A; --blue-pale:#E6EEF9;
}
body { font-family:'DM Sans',sans-serif; background:var(--ivory); color:var(--ink); min-height:100vh; display:flex; }

/* Sidebar */
.sidebar { width:240px; min-height:100vh; background:var(--ink); display:flex; flex-direction:column; position:fixed; top:0; left:0; bottom:0; z-index:10; }
.sidebar-brand { padding:32px 24px 20px; border-bottom:1px solid rgba(255,255,255,0.08); }
.brand-title { font-family:'Cormorant Garamond',serif; font-size:22px; font-weight:600; color:#fff; }
.brand-tagline { font-size:11px; color:var(--gold-light); letter-spacing:2px; text-transform:uppercase; margin-top:4px; }
.sidebar-event { margin:20px 16px; background:rgba(184,147,42,0.12); border:1px solid rgba(184,147,42,0.25); border-radius:10px; padding:14px 16px; }
.sidebar-event .ev-label { font-size:10px; font-weight:500; letter-spacing:1.5px; text-transform:uppercase; color:var(--gold-light); margin-bottom:4px; }
.sidebar-event .ev-name  { font-family:'Cormorant Garamond',serif; font-size:15px; font-weight:600; color:#fff; }
.sidebar-event .ev-date  { font-size:12px; color:rgba(255,255,255,0.45); margin-top:2px; }
.sidebar-nav { flex:1; padding:8px 12px; overflow-y:auto; }
.nav-section { font-size:10px; font-weight:500; letter-spacing:1.8px; text-transform:uppercase; color:rgba(255,255,255,0.28); padding:16px 12px 6px; }
.nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; font-size:14px; color:rgba(255,255,255,0.55); cursor:pointer; transition:all 0.15s; margin-bottom:2px; text-decoration:none; }
.nav-item:hover { background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.85); }
.nav-item.active { background:linear-gradient(135deg,rgba(139,42,74,0.55),rgba(184,147,42,0.3)); color:#fff; font-weight:500; }
.nav-item svg { width:18px; height:18px; opacity:0.7; flex-shrink:0; }
.nav-item.active svg { opacity:1; }
.sidebar-footer { padding:16px; border-top:1px solid rgba(255,255,255,0.08); }
.sf-user { display:flex; align-items:center; gap:10px; }
.sf-avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--rose),var(--gold)); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:#fff; flex-shrink:0; }
.sf-name { font-size:13px; font-weight:500; color:#fff; }
.sf-role { font-size:11px; color:rgba(255,255,255,0.4); }
.sf-logout { display:block; width:100%; margin-top:10px; padding:8px; border-radius:8px; text-align:center; font-size:12px; font-weight:500; color:rgba(255,255,255,0.45); background:rgba(255,255,255,0.05); border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.15s; }
.sf-logout:hover { background:rgba(139,42,74,0.35); color:#fff; }

/* Main */
.main { margin-left:240px; flex:1; min-height:100vh; }
.topbar { display:flex; align-items:center; justify-content:space-between; padding:22px 36px; background:var(--surface); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:5; }
.page-heading { font-family:'Cormorant Garamond',serif; font-size:28px; font-weight:600; }
.page-sub { font-size:13px; color:var(--ink-faint); margin-top:1px; }
.topbar-right { display:flex; align-items:center; gap:12px; }
.btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; border:none; transition:all 0.15s; text-decoration:none; }
.btn svg { width:15px; height:15px; }
.btn-primary { background:var(--rose); color:#fff; }
.btn-primary:hover { background:#7A2240; }
.btn-outline { background:transparent; border:1px solid var(--border); color:var(--ink-muted); }
.btn-outline:hover { border-color:var(--rose-light); color:var(--rose); }
.btn-green { background:var(--green); color:#fff; }
.btn-green:hover { background:#1F5238; }
.content { padding:32px 36px 48px; }

/* Alerts */
.alert { padding:13px 18px; border-radius:10px; margin-bottom:20px; font-size:13.5px; display:flex; align-items:center; gap:10px; }
.alert-success { background:var(--green-pale); color:var(--green); border:1px solid rgba(42,107,74,0.2); }
.alert-error   { background:#FDECEA; color:#C62828; border:1px solid rgba(198,40,40,0.2); }
.alert svg { width:16px; height:16px; flex-shrink:0; }

/* Table */
.table-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
.table-header { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid var(--border); }
.table-title { font-family:'Cormorant Garamond',serif; font-size:19px; font-weight:600; }
table { width:100%; border-collapse:collapse; }
thead th { font-size:11px; font-weight:500; letter-spacing:1px; text-transform:uppercase; color:var(--ink-faint); padding:10px 22px; text-align:left; background:var(--ivory); border-bottom:1px solid var(--border); }
tbody td { padding:13px 22px; font-size:13.5px; border-bottom:1px solid var(--border); color:var(--ink-muted); vertical-align:middle; }
tbody tr:last-child td { border-bottom:none; }
tbody tr:hover td { background:var(--ivory); }

/* Badges */
.badge { display:inline-flex; align-items:center; padding:4px 10px; border-radius:99px; font-size:11.5px; font-weight:500; }
.badge-confirmed { background:var(--green-pale); color:var(--green); }
.badge-pending   { background:var(--amber-pale); color:var(--amber); }
.badge-rejected  { background:#FEE9E9; color:#9B2B2B; }
.badge-received  { background:var(--green-pale); color:var(--green); }
.badge-pledged   { background:var(--amber-pale); color:var(--amber); }
.badge-cancelled { background:#FEE9E9; color:#9B2B2B; }
.badge-cash { background:var(--green-pale); color:var(--green); }
.badge-gift { background:var(--gold-pale); color:var(--gold); }

/* Forms */
.form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
.form-card-header { padding:22px 28px; border-bottom:1px solid var(--border); }
.form-card-title { font-family:'Cormorant Garamond',serif; font-size:20px; font-weight:600; }
.form-card-sub { font-size:13px; color:var(--ink-faint); margin-top:3px; }
.form-body { padding:28px; }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-grid.cols-1 { grid-template-columns:1fr; }
.field { display:flex; flex-direction:column; gap:7px; }
.field.span2 { grid-column:span 2; }
.field label { font-size:12px; font-weight:500; color:var(--ink-muted); letter-spacing:0.3px; }
.field input,.field select,.field textarea { padding:11px 14px; font-size:13.5px; font-family:'DM Sans',sans-serif; color:var(--ink); background:#fff; border:1.5px solid var(--border); border-radius:10px; outline:none; transition:all 0.2s; width:100%; }
.field input:focus,.field select:focus,.field textarea:focus { border-color:var(--rose); box-shadow:0 0 0 3px rgba(139,42,74,0.07); }
.field select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239C8580' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }
.field textarea { resize:vertical; min-height:90px; }
.field .error-msg { font-size:11.5px; color:#C62828; }
.form-actions { display:flex; align-items:center; justify-content:flex-end; gap:12px; padding:20px 28px; border-top:1px solid var(--border); background:var(--ivory); }

/* Pagination */
.pagination-wrap { padding:16px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; }

/* Donor avatar */
.donor-cell { display:flex; align-items:center; gap:10px; }
.d-avatar { width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; color:#fff; flex-shrink:0; }
.d-name  { font-weight:500; color:var(--ink); font-size:13.5px; }
.d-phone { font-size:11.5px; color:var(--ink-faint); }
.amount-cell { font-weight:600; color:var(--ink); font-family:'Cormorant Garamond',serif; font-size:16px; }

/* Action btns */
.action-btns { display:flex; gap:8px; }
.btn-sm { padding:5px 12px; font-size:12px; border-radius:7px; }
.btn-icon { padding:6px; border-radius:7px; }
</style>
@yield('extra_css')
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="brand-title">WeddingIS</div>
    <div class="brand-tagline">Innovation System</div>
  </div>

  @if(isset($event) && $event)
  <div class="sidebar-event">
    <div class="ev-label">Active Event</div>
    <div class="ev-name">{{ $event->couple_name }}</div>
    <div class="ev-date">{{ $event->wedding_date->format('M d, Y') }} · {{ $event->venue }}</div>
  </div>
  @endif

  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
      Dashboard
    </a>
    <a class="nav-item {{ request()->routeIs('contributions.*') ? 'active' : '' }}" href="{{ route('contributions.index') }}">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
      Contributions
    </a>
    <a class="nav-item {{ request()->routeIs('gifts.*') ? 'active' : '' }}" href="{{ route('gifts.index') }}">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/></svg>
      Gift Registry
    </a>
    <a class="nav-item {{ request()->routeIs('contributors.*') ? 'active' : '' }}" href="{{ route('contributors.index') }}">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      Contributors
    </a>
    <div class="nav-section">Reports</div>
    <a class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      Analytics
    </a>
    <div class="nav-section">System</div>
    <a class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Events
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="sf-user">
      <div class="sf-avatar">{{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}</div>
      <div>
        <div class="sf-name">{{ auth()->user()->full_name }}</div>
        <div class="sf-role">{{ ucfirst(auth()->user()->role) }}</div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="sf-logout">Sign Out</button>
    </form>
  </div>
</aside>

<main class="main">
  <div class="topbar">
    <div>
      <div class="page-heading">@yield('heading')</div>
      <div class="page-sub">@yield('subheading')</div>
    </div>
    <div class="topbar-right">@yield('topbar_actions')</div>
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </div>
</main>

@yield('scripts')
</body>
</html>
