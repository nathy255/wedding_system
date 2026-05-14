<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>WeddingIS — Sign In</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
<style>
/* Full CSS from the polished login page */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root { --rose:#8B2A4A; --rose-mid:#C4607C; --rose-light:#E8A0B0; --gold:#B8932A; --gold-light:#D4B060; --gold-pale:#F5EDD8; --ink:#1C1210; --ink-muted:#4A3A36; --ink-faint:#7C6560; --surface:rgba(255,255,255,0.92); --border:rgba(139,42,74,0.15); }
html,body { height:100%; font-family:'DM Sans',sans-serif; }
body { display:flex; align-items:stretch; min-height:100vh; background:#0D0608; overflow:hidden; }
.left-panel { flex:1; position:relative; display:flex; flex-direction:column; justify-content:flex-end; padding:56px 52px; overflow:hidden; }
.left-panel::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 80% 70% at 30% 40%,rgba(139,42,74,.55) 0%,transparent 70%),radial-gradient(ellipse 60% 60% at 75% 80%,rgba(184,147,42,.25) 0%,transparent 60%),radial-gradient(ellipse 50% 80% at 10% 90%,rgba(28,10,16,.9) 0%,transparent 70%),linear-gradient(160deg,#1C0A10 0%,#2A0E1C 40%,#120608 100%); z-index:0; }
.deco-ring { position:absolute; border-radius:50%; border:1px solid rgba(184,147,42,.18); pointer-events:none; z-index:1; }
.ring-1 { width:520px; height:520px; top:-120px; left:-80px; }
.ring-2 { width:380px; height:380px; top:-40px; left:-20px; border-color:rgba(139,42,74,.2); }
.ring-3 { width:700px; height:700px; top:40%; right:-280px; border-color:rgba(184,147,42,.1); }
.orb { position:absolute; border-radius:50%; filter:blur(60px); pointer-events:none; z-index:1; }
.orb-1 { width:300px; height:300px; top:5%; left:10%; background:rgba(139,42,74,.35); animation:floatUp 6s ease-in-out infinite; }
.orb-2 { width:200px; height:200px; top:55%; right:5%; background:rgba(184,147,42,.2); animation:floatUp 8s ease-in-out 2s infinite; }
.orb-3 { width:150px; height:150px; top:30%; left:55%; background:rgba(196,96,124,.2); animation:floatUp 7s ease-in-out 1s infinite; }
.petal-pattern { position:absolute; top:0; left:0; right:0; bottom:0; z-index:1; opacity:.07; background-image:radial-gradient(ellipse 3px 6px at 15% 20%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 22% 35%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 8% 55%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 35% 15%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 50% 28%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 65% 40%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 28% 70%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 72% 18%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 45% 80%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 18% 90%,#D4B060 100%,transparent 0),radial-gradient(ellipse 3px 6px at 82% 65%,#D4B060 100%,transparent 0); }
.ornament { position:absolute; top:52px; left:52px; z-index:2; }
.ornament-line { display:flex; align-items:center; gap:10px; }
.ornament-line::before { content:''; flex:1; height:1px; background:linear-gradient(to right,rgba(184,147,42,.6),transparent); }
.ornament-line::after  { content:''; flex:1; height:1px; background:linear-gradient(to right,transparent,rgba(184,147,42,.6)); }
.ornament-diamond { width:7px; height:7px; background:var(--gold-light); transform:rotate(45deg); flex-shrink:0; }
.left-content { position:relative; z-index:3; }
.left-eyebrow { font-size:11px; font-weight:500; letter-spacing:3px; text-transform:uppercase; color:var(--gold-light); margin-bottom:18px; display:flex; align-items:center; gap:12px; }
.left-eyebrow::before { content:''; width:32px; height:1px; background:var(--gold-light); opacity:.6; }
.left-headline { font-family:'Cormorant Garamond',serif; font-size:56px; font-weight:600; color:#fff; line-height:1.08; letter-spacing:-1px; margin-bottom:10px; }
.left-headline em { font-style:italic; color:var(--rose-light); }
.left-sub { font-size:15px; font-weight:300; color:rgba(255,255,255,.45); line-height:1.7; max-width:380px; margin-bottom:40px; }
.left-stats { display:flex; gap:32px; padding-top:32px; border-top:1px solid rgba(255,255,255,.08); }
.left-stat .val { font-family:'Cormorant Garamond',serif; font-size:30px; font-weight:600; color:#fff; }
.left-stat .lbl { font-size:11px; color:rgba(255,255,255,.35); letter-spacing:.5px; margin-top:2px; }
.stat-divider { width:1px; background:rgba(255,255,255,.08); align-self:stretch; }
.right-panel { width:50%; flex-shrink:0; background:#FAF7F2; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:40px 52px; position:relative; overflow-y:auto; }
.right-panel::before { content:''; position:absolute; top:-60px; right:-60px; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle,rgba(139,42,74,.06) 0%,transparent 70%); }
.form-wrap { width:100%; max-width:380px; position:relative; z-index:1; }
.auth-tabs { display:flex; background:rgba(139,42,74,.07); border-radius:12px; padding:4px; margin-bottom:24px; }
.auth-tab { flex:1; padding:9px 6px; border-radius:9px; font-size:13.5px; font-weight:500; text-align:center; cursor:pointer; color:var(--ink-faint); transition:all .2s; border:none; background:transparent; font-family:'DM Sans',sans-serif; }
.auth-tab.active { background:#fff; color:var(--rose); box-shadow:0 2px 8px rgba(139,42,74,.12); }
.logo-mark { display:flex; flex-direction:column; align-items:center; margin-bottom:24px; }
.logo-icon { width:50px; height:50px; border-radius:13px; background:linear-gradient(135deg,var(--rose) 0%,#5C1230 100%); display:flex; align-items:center; justify-content:center; margin-bottom:12px; box-shadow:0 4px 16px rgba(139,42,74,.3); }
.logo-icon svg { width:24px; height:24px; color:#fff; }
.logo-name { font-family:'Cormorant Garamond',serif; font-size:21px; font-weight:600; color:var(--ink); }
.logo-tag { font-size:10px; font-weight:500; letter-spacing:2px; text-transform:uppercase; color:var(--ink-faint); }
.form-heading { font-family:'Cormorant Garamond',serif; font-size:26px; font-weight:600; color:var(--ink); text-align:center; margin-bottom:4px; }
.form-sub { font-size:13px; color:var(--ink-faint); text-align:center; margin-bottom:22px; }
.role-tabs { display:flex; background:rgba(139,42,74,.06); border-radius:10px; padding:4px; margin-bottom:22px; gap:2px; }
.role-tab { flex:1; padding:7px 4px; border-radius:7px; font-size:12px; font-weight:500; text-align:center; cursor:pointer; color:var(--ink-faint); transition:all .2s; border:none; background:transparent; font-family:'DM Sans',sans-serif; }
.role-tab.active { background:#fff; color:var(--rose); box-shadow:0 1px 4px rgba(0,0,0,.08); }
.field-group { margin-bottom:16px; }
.field-label { font-size:12px; font-weight:500; color:var(--ink-muted); margin-bottom:6px; display:flex; align-items:center; gap:5px; }
.field-label svg { width:13px; height:13px; opacity:.6; }
.field-input-wrap { position:relative; }
.field-input { width:100%; padding:11px 16px 11px 40px; font-size:13.5px; font-family:'DM Sans',sans-serif; color:var(--ink); background:#fff; border:1.5px solid var(--border); border-radius:10px; outline:none; transition:all .2s; }
.field-input::placeholder { color:var(--ink-faint); }
.field-input:focus { border-color:var(--rose); box-shadow:0 0 0 3px rgba(139,42,74,.08); }
.field-input.error { border-color:#C62828; }
.field-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--ink-faint); pointer-events:none; }
.field-icon svg { width:15px; height:15px; display:block; }
.eye-toggle { position:absolute; right:13px; top:50%; transform:translateY(-50%); cursor:pointer; color:var(--ink-faint); background:none; border:none; padding:0; transition:color .15s; }
.eye-toggle:hover { color:var(--rose); }
.eye-toggle svg { width:15px; height:15px; display:block; }
.field-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.options-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.checkbox-wrap { display:flex; align-items:center; gap:7px; cursor:pointer; }
.checkbox-wrap input { width:14px; height:14px; accent-color:var(--rose); }
.checkbox-label { font-size:12.5px; color:var(--ink-muted); }
.forgot-link { font-size:12.5px; color:var(--rose); text-decoration:none; font-weight:500; }
.btn-login { width:100%; padding:13px; border:none; border-radius:10px; font-size:14px; font-weight:600; font-family:'DM Sans',sans-serif; color:#fff; cursor:pointer; position:relative; overflow:hidden; background:linear-gradient(135deg,var(--rose) 0%,#6A1830 100%); transition:transform .15s,box-shadow .15s; }
.btn-login::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(212,176,96,.25) 0%,transparent 60%); pointer-events:none; }
.btn-login:hover { transform:translateY(-1px); box-shadow:0 8px 24px rgba(139,42,74,.35); }
.divider { display:flex; align-items:center; gap:14px; margin:18px 0; }
.divider::before,.divider::after { content:''; flex:1; height:1px; background:var(--border); }
.divider span { font-size:11px; color:var(--ink-faint); white-space:nowrap; }
.alt-btn { width:100%; padding:11px; border:1.5px solid var(--border); border-radius:10px; background:#fff; font-size:13px; font-weight:500; font-family:'DM Sans',sans-serif; color:var(--ink-muted); cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; transition:all .15s; }
.alt-btn:hover { border-color:var(--rose); color:var(--rose); }
.alt-btn svg { width: 18px; height: 18px; flex-shrink: 0; }
.form-footer { text-align:center; margin-top:20px; font-size:12px; color:var(--ink-faint); line-height:1.7; }
.form-footer a { color:var(--rose); text-decoration:none; font-weight:500; }
.error-text { font-size:11.5px; color:#C62828; margin-top:4px; display:block; }
.form-panel { display:none; }
.form-panel.active { display:block; }
.terms-check { display:flex; align-items:flex-start; gap:8px; margin-bottom:18px; }
.terms-check input { width:14px; height:14px; margin-top:2px; accent-color:var(--rose); }
.terms-check span { font-size:12px; color:var(--ink-muted); line-height:1.5; }
.terms-check a { color:var(--rose); font-weight:500; }
@keyframes fadeUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes slideLeft{ from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:translateX(0)} }
@keyframes floatUp  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
.left-content { animation:fadeUp .7s ease both; }
.form-wrap    { animation:slideLeft .6s ease .1s both; }
@media(max-width:900px) { .left-panel{display:none} .right-panel{width:100%;padding:40px 28px} }
</style>
</head>
<body>

<div class="left-panel">
  <div class="deco-ring ring-1"></div>
  <div class="deco-ring ring-2"></div>
  <div class="deco-ring ring-3"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>
  <div class="petal-pattern"></div>
  <div class="ornament"><div class="ornament-line"><div class="ornament-diamond"></div></div></div>
  <div class="left-content">
    <div class="left-eyebrow">Wedding Innovation System</div>
    <div class="left-headline">Every gift.<br/>Every <em>shilling.</em><br/>Accounted for.</div>
    <div class="left-sub">Manage wedding contributions seamlessly — cash, gifts, and confirmations all in one transparent, real-time platform.</div>
    <div class="left-stats">
      <div class="left-stat"><div class="val">2,400+</div><div class="lbl">Contributions tracked</div></div>
      <div class="stat-divider"></div>
      <div class="left-stat"><div class="val">98%</div><div class="lbl">Confirmation rate</div></div>
      <div class="stat-divider"></div>
      <div class="left-stat"><div class="val">150+</div><div class="lbl">Happy families</div></div>
    </div>
  </div>
</div>

<div class="right-panel">
  <div class="form-wrap">

    <div class="logo-mark">
      <div class="logo-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
      </div>
      <div class="logo-name">WeddingIS</div>
      <div class="logo-tag">Innovation System</div>
    </div>

    <div class="auth-tabs">
      <button class="auth-tab {{ ($tab ?? 'login') === 'login' ? 'active' : '' }}" onclick="switchAuth('login',this)">Sign In</button>
      <button class="auth-tab {{ ($tab ?? 'login') === 'register' ? 'active' : '' }}" onclick="switchAuth('signup',this)">Create Account</button>
    </div>

    {{-- ── SIGN IN ── --}}
    <div class="form-panel {{ ($tab ?? 'login') === 'login' ? 'active' : '' }}" id="panel-login">
      <div class="form-heading">Welcome back</div>
      <div class="form-sub">Select your role and sign in</div>

      <div class="role-tabs">
        <button class="role-tab active" onclick="setRole(this)">Admin</button>
        <button class="role-tab" onclick="setRole(this)">Committee</button>
        <button class="role-tab" onclick="setRole(this)">Contributor</button>
        <button class="role-tab" onclick="setRole(this)">Couple</button>
      </div>

      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="field-group">
          <div class="field-label">Email or Phone</div>
          <div class="field-input-wrap">
            <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
            <input class="field-input {{ $errors->has('email') ? 'error' : '' }}" name="email" type="text" placeholder="admin@weddingis.co.tz" value="{{ old('email') }}" id="login-email"/>
          </div>
          @error('email')<span class="error-text">{{ $message }}</span>@enderror
        </div>

        <div class="field-group">
          <div class="field-label">Password</div>
          <div class="field-input-wrap">
            <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
            <input class="field-input" name="password" type="password" placeholder="••••••••••" id="login-pass" autocomplete="current-password"/>
            <button type="button" class="eye-toggle" onclick="toggleVis('login-pass',this)">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>

        <div class="options-row">
          <label class="checkbox-wrap"><input type="checkbox" name="remember"/><span class="checkbox-label">Remember me</span></label>
          <a class="forgot-link" href="#">Forgot password?</a>
        </div>

        <button type="submit" class="btn-login">Sign In to Dashboard</button>
      </form>

      <div class="divider"><span>or continue with</span></div>
      <button class="alt-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
        Sign in with M-Pesa Verification
      </button>

      <div class="form-footer">
        Don't have an account? <a href="#" onclick="switchAuthByName('signup'); return false;">Create one here</a>
        <br/><br/><span style="font-size:11px;opacity:.6;">Arusha Technical College · JANABOY Project · NTA Level 6</span>
      </div>
    </div>

    {{-- ── SIGN UP ── --}}
    <div class="form-panel {{ ($tab ?? 'login') === 'register' ? 'active' : '' }}" id="panel-signup">
      <div class="form-heading">Create account</div>
      <div class="form-sub">Join your wedding event platform</div>

      <div class="role-tabs">
        <button class="role-tab active" onclick="setRole(this)">Contributor</button>
        <button class="role-tab" onclick="setRole(this)">Committee</button>
        <button class="role-tab" onclick="setRole(this)">Couple</button>
        <button class="role-tab" onclick="setRole(this)">Admin</button>
      </div>

      <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <input type="hidden" name="role" id="selected-role" value="contributor"/>

        <div class="field-row">
          <div class="field-group">
            <div class="field-label">First Name</div>
            <div class="field-input-wrap">
              <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
              <input class="field-input" name="first_name" type="text" placeholder="Amina" value="{{ old('first_name') }}"/>
            </div>
            @error('first_name')<span class="error-text">{{ $message }}</span>@enderror
          </div>
          <div class="field-group">
            <div class="field-label">Last Name</div>
            <div class="field-input-wrap">
              <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
              <input class="field-input" name="last_name" type="text" placeholder="Juma" value="{{ old('last_name') }}"/>
            </div>
          </div>
        </div>

        <div class="field-group">
          <div class="field-label">Phone Number</div>
          <div class="field-input-wrap">
            <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></div>
            <input class="field-input" name="phone" type="tel" placeholder="+255 7XX XXX XXX" value="{{ old('phone') }}"/>
          </div>
          @error('phone')<span class="error-text">{{ $message }}</span>@enderror
        </div>

        <div class="field-group">
          <div class="field-label">Email (optional)</div>
          <div class="field-input-wrap">
            <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
            <input class="field-input" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}"/>
          </div>
        </div>

        <div class="field-row">
          <div class="field-group">
            <div class="field-label">Password</div>
            <div class="field-input-wrap">
              <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
              <input class="field-input" name="password" type="password" placeholder="••••••••" id="su-pass" autocomplete="new-password"/>
              <button type="button" class="eye-toggle" onclick="toggleVis('su-pass',this)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password')<span class="error-text">{{ $message }}</span>@enderror
          </div>
          <div class="field-group">
            <div class="field-label">Confirm Password</div>
            <div class="field-input-wrap">
              <div class="field-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
              <input class="field-input" name="password_confirmation" type="password" placeholder="••••••••" autocomplete="new-password"/>
            </div>
          </div>
        </div>

        <label class="terms-check">
          <input type="checkbox" required/>
          <span>I agree to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a></span>
        </label>

        <button type="submit" class="btn-login">Create My Account</button>
      </form>

      <div class="form-footer">
        Already have an account? <a href="#" onclick="switchAuthByName('login'); return false;">Sign in here</a>
        <br/><br/><span style="font-size:11px;opacity:.6;">Arusha Technical College · JANABOY Project · NTA Level 6</span>
      </div>
    </div>

  </div>
</div>

<script>
function switchAuth(name, el) {
  document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('panel-' + name).classList.add('active');
}
function switchAuthByName(name) {
  const tabs = document.querySelectorAll('.auth-tab');
  switchAuth(name, tabs[name === 'login' ? 0 : 1]);
}
function setRole(el) {
  el.closest('.role-tabs').querySelectorAll('.role-tab').forEach(r => r.classList.remove('active'));
  el.classList.add('active');
  const roleInput = document.getElementById('selected-role');
  if (roleInput) roleInput.value = el.textContent.toLowerCase();
}
function toggleVis(id, btn) {
  const inp = document.getElementById(id);
  const show = inp.type === 'password';
  inp.type = show ? 'text' : 'password';
  btn.innerHTML = show
    ? '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'
    : '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
}
</script>
</body>
</html>
