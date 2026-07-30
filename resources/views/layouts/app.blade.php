<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — EVENTA</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg-main: #13141F;
  --bg-sidebar: #0C0D15;
  --bg-card: #1A1C29;
  --bg-card-hover: #222436;
  
  --border: #2A2D3E;
  
  --text-main: #FFFFFF;
  --text-muted: #8A8D9E;
  --text-faint: #5A5D70;
  
  --brand-purple: #8B5CF6;
  --brand-magenta: #D946EF;
  
  --status-green: #10B981;
  --status-blue: #3B82F6;
  --status-orange: #F59E0B;
}

body {
  font-family: 'Inter', sans-serif;
  background: var(--bg-main);
  color: var(--text-main);
  min-height: 100vh;
  display: flex;
  overflow: hidden;
  -webkit-font-smoothing: antialiased;
}

::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
::-webkit-scrollbar-thumb:hover { background: #3A3D52; }

/* ─── Sidebar ─────────────────────────────────────────────── */
.sidebar {
  width: 260px;
  background: var(--bg-sidebar);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  height: 100vh;
  flex-shrink: 0;
}

.sidebar-header {
  padding: 24px 20px;
}
.brand-title {
  font-size: 20px;
  font-weight: 700;
  letter-spacing: -0.5px;
  background: linear-gradient(90deg, #A855F7, #D946EF);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.brand-tag {
  font-size: 10px;
  letter-spacing: 2px;
  color: var(--text-faint);
  text-transform: uppercase;
  margin-top: 2px;
}

.sidebar-profile {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 20px 24px;
}
.sidebar-profile img {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  object-fit: cover;
}
.sp-name { font-size: 14px; font-weight: 500; }
.sp-role { font-size: 11px; color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 2px;}

.sidebar-nav {
  flex: 1;
  overflow-y: auto;
  padding: 0 12px;
}
.nav-section {
  font-size: 10px;
  font-weight: 600;
  color: var(--text-faint);
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 16px 12px 8px;
}
.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  border-radius: 8px;
  color: var(--text-muted);
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s;
  margin-bottom: 2px;
}
.nav-item i { width: 16px; text-align: center; font-size: 14px; }
.nav-item:hover {
  color: var(--text-main);
  background: rgba(255,255,255,0.03);
}
.nav-item.active {
  background: linear-gradient(90deg, var(--brand-purple), var(--brand-magenta));
  color: #fff;
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
}
.nav-badge {
  margin-left: auto;
  background: var(--brand-magenta);
  color: #fff;
  font-size: 10px;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 99px;
}

.sidebar-upgrade {
  margin: 20px 12px;
  padding: 16px;
  background: linear-gradient(135deg, #A855F7, #D946EF);
  border-radius: 12px;
  position: relative;
  overflow: hidden;
}
.sidebar-upgrade .su-icon {
  width: 28px; height: 28px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
}
.sidebar-upgrade h4 { font-size: 13px; font-weight: 600; margin-bottom: 4px; }
.sidebar-upgrade p { font-size: 11px; color: rgba(255,255,255,0.8); line-height: 1.4; margin-bottom: 12px; }
.sidebar-upgrade button {
  width: 100%; padding: 8px; background: #fff; color: #000; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;
}

/* ─── Main Area ───────────────────────────────────────────── */
.main-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  height: 100vh;
}

.topbar {
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 32px;
  border-bottom: 1px solid var(--border);
}
.tb-left { display: flex; align-items: center; gap: 24px; }
.breadcrumb {
  font-size: 13px;
  color: var(--text-muted);
}
.breadcrumb span.current { color: var(--text-main); font-weight: 500; }
.weather {
  font-size: 12px;
  color: var(--text-muted);
  display: flex;
  align-items: center;
  gap: 6px;
}

.tb-right { display: flex; align-items: center; gap: 16px; }
.search-bar {
  position: relative;
}
.search-bar i {
  position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-faint); font-size: 12px;
}
.search-bar input {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 8px 16px 8px 32px;
  color: var(--text-main);
  font-size: 13px;
  width: 240px;
  outline: none;
  transition: all 0.2s;
}
.search-bar input:focus { border-color: var(--brand-purple); }

.action-btn {
  width: 32px; height: 32px; border-radius: 8px; background: var(--bg-card); border: 1px solid var(--border);
  display: flex; align-items: center; justify-content: center; color: var(--text-muted); cursor: pointer; transition: all 0.2s;
}
.action-btn:hover { color: var(--text-main); background: var(--bg-card-hover); }

.tb-profile { position: relative; display: flex; align-items: center; gap: 8px; cursor: pointer; }
.tb-profile img { width: 28px; height: 28px; border-radius: 50%; }
.tb-profile span { font-size: 13px; font-weight: 500; }
.tb-profile i { font-size: 10px; color: var(--text-muted); }

.profile-dropdown {
  position: absolute;
  top: 100%; right: 0;
  margin-top: 12px;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 12px;
  width: 220px;
  box-shadow: 0 12px 32px rgba(0,0,0,0.3);
  opacity: 0; visibility: hidden;
  transform: translateY(10px);
  transition: all 0.2s;
  z-index: 100;
}
.profile-dropdown.show { opacity: 1; visibility: visible; transform: translateY(0); }
.pd-header { padding: 16px; border-bottom: 1px solid var(--border); }
.pd-item {
  display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: var(--text-muted); font-size: 13px; text-decoration: none; transition: all 0.2s;
}
.pd-item:hover { background: rgba(255,255,255,0.03); color: #fff; }
.pd-logout:hover { color: #EF4444; }
.pd-divider { height: 1px; background: var(--border); margin: 4px 0; }

/* ─── Content ─────────────────────────────────────────────── */
.content-area {
  flex: 1;
  overflow-y: auto;
  padding: 32px;
}

/* ─── Mobile Responsiveness ─────────────────────────────── */
.mobile-nav-toggle {
  display: none;
}
.sidebar-backdrop {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px);
  z-index: 998;
}

@media (max-width: 992px) {
  body {
    overflow-x: hidden;
  }
  .sidebar {
    position: fixed;
    left: 0; top: 0; bottom: 0;
    z-index: 999;
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .sidebar.show {
    transform: translateX(0);
    box-shadow: 0 0 40px rgba(0,0,0,0.5);
  }
  .sidebar-backdrop.show {
    display: block;
  }
  .mobile-nav-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s;
  }
  .mobile-nav-toggle:hover {
    background: rgba(255,255,255,0.08);
  }
  .topbar {
    padding: 0 16px;
  }
  .content-area {
    padding: 24px 16px;
  }
}

@media (max-width: 768px) {
  .breadcrumb, .weather {
    display: none;
  }
  .search-bar input {
    width: 140px;
    font-size: 12px;
    padding: 6px 12px 6px 28px;
  }
  .search-bar i {
    left: 10px;
  }
  .tb-profile span, .tb-profile i {
    display: none;
  }
  .tb-profile {
    padding: 4px;
  }
  .topbar-new-event {
    display: none !important;
  }
}

@media (max-width: 480px) {
  .search-bar {
    display: none;
  }
  .content-area {
    padding: 16px 12px;
  }
}
</style>
@yield('extra_css')
</head>
<body>
<div class="sidebar-backdrop" id="sidebar-backdrop" onclick="toggleSidebar()"></div>

<aside class="sidebar">
  <div class="sidebar-header">
    <div class="brand-title">EVENTA</div>
    <div class="brand-tag">BY SPACITEK</div>
  </div>

  <div class="sidebar-profile">
    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->full_name) }}&background=10B981&color=fff" alt="User">
    <div>
      <div class="sp-name">{{ explode(' ', auth()->user()->full_name)[0] }}</div>
      <div class="sp-role">Event Planner</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">Overview</div>
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fa-solid fa-border-all"></i> Dashboard
    </a>
    
    @if(auth()->user()->canManage())
    <a href="{{ route('events.index') }}" class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
      <i class="fa-regular fa-calendar"></i> My Events
    </a>
    <a href="{{ route('calendar.index') }}" class="nav-item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
      <i class="fa-regular fa-calendar-days"></i> Calendar
    </a>

    <div class="nav-section">Management</div>
    <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
      <i class="fa-solid fa-list-check"></i> Tasks - Timeline
    </a>
    <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
      <i class="fa-solid fa-chart-line"></i> Budget Tracker
    </a>
    <a href="{{ route('vendors.index') }}" class="nav-item {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
      <i class="fa-solid fa-handshake"></i> Vendors
    </a>
    <a href="{{ route('contributors.index') }}" class="nav-item {{ request()->routeIs('contributors.*') ? 'active' : '' }}">
      <i class="fa-solid fa-user-group"></i> Guests - RSVPs
    </a>

    <div class="nav-section">Communications</div>
    <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
      <i class="fa-regular fa-message"></i> Messages
      <span class="nav-badge">3</span>
    </a>
    <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
      <i class="fa-regular fa-bell"></i> Notifications
    </a>

    @elseif(auth()->user()->isVendor())
    <div class="nav-section">Vendor Hub</div>
    <a href="{{ route('vendor.leads') }}" class="nav-item {{ request()->routeIs('vendor.leads') ? 'active' : '' }}">
      <i class="fa-solid fa-briefcase"></i> Marketplace Leads
    </a>
    <a href="{{ route('vendor.proposals') }}" class="nav-item {{ request()->routeIs('vendor.proposals') ? 'active' : '' }}">
      <i class="fa-solid fa-file-signature"></i> My Proposals
    </a>
    <a href="{{ route('vendor.bookings') }}" class="nav-item {{ request()->routeIs('vendor.bookings') ? 'active' : '' }}">
      <i class="fa-regular fa-calendar"></i> Booked Events
    </a>
    @endif

    <div class="nav-section">Settings</div>
    <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
      <i class="fa-solid fa-gear"></i> Profile Settings
    </a>
    <a href="{{ route('help.index') }}" class="nav-item {{ request()->routeIs('help.*') ? 'active' : '' }}">
      <i class="fa-solid fa-headset"></i> Help - Support
    </a>
  </nav>

  <div class="sidebar-upgrade">
    <div class="su-icon"><i class="fa-solid fa-rocket" style="color:#fff;"></i></div>
    <h4>You're on Free Plan</h4>
    <p>Unlock AI scheduling & unlimited events.</p>
    <button>Upgrade to Pro</button>
  </div>
</aside>

<main class="main-wrapper">
  <header class="topbar">
    <div class="tb-left">
      <button class="mobile-nav-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="breadcrumb">
        Events <i class="fa-solid fa-chevron-right" style="font-size:8px;margin:0 6px;"></i> <span class="current">@yield('title', 'Dashboard')</span>
      </div>
      <div class="weather">
        <i class="fa-solid fa-sun"></i> 22°C · Clear sky
      </div>
    </div>
    <div class="tb-right">
      <form action="{{ route('events.index') }}" method="GET" class="search-bar" style="display:flex; align-items:center;">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}" style="background:transparent; border:none; outline:none; color:#fff; margin-left:8px;">
      </form>
      @if(auth()->user()->canManage())
      <a href="{{ route('events.create') }}" class="topbar-new-event" style="background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; width: fit-content;">
        <i class="fa-solid fa-plus"></i> New Event
      </a>
      @endif
      <div class="action-btn">
        <i class="fa-regular fa-bell"></i>
      </div>
      <div class="tb-profile" onclick="document.getElementById('profile-dropdown').classList.toggle('show')">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->full_name) }}&background=10B981&color=fff" alt="User">
        <span>{{ explode(' ', auth()->user()->full_name)[0] }}</span>
        <i class="fa-solid fa-chevron-down"></i>
        
        <div id="profile-dropdown" class="profile-dropdown">
          <div class="pd-header">
            <div style="font-weight:600; color:#fff;">{{ auth()->user()->full_name }}</div>
            <div style="font-size:11px; color:var(--text-muted);">{{ auth()->user()->email }}</div>
          </div>
          <a href="{{ route('settings.index') }}" class="pd-item"><i class="fa-solid fa-gear"></i> Workspace Settings</a>
          <div class="pd-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="pd-item pd-logout" style="width:100%; text-align:left; background:transparent; border:none; cursor:pointer; font-family:inherit;">
              <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
            </button>
          </form>
      </div>
    </div>
  </header>

  <div class="content-area">
    @yield('content')
  </div>
</main>

<script>
function toggleSidebar() {
  document.querySelector('.sidebar').classList.toggle('show');
  document.getElementById('sidebar-backdrop').classList.toggle('show');
}
</script>
@yield('scripts')
</body>
</html>
