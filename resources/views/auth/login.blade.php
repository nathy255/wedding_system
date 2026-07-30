<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>EVENTA by SPACITEK — Sign In</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --brand-purple: #8B5CF6;
  --brand-magenta: #D946EF;
  --bg-dark: #0A0A10;
  --glass-bg: rgba(20, 22, 35, 0.6);
  --glass-border: rgba(255, 255, 255, 0.08);
  --text-main: #FFFFFF;
  --text-muted: #8A8D9E;
}

body {
  font-family: 'Inter', sans-serif;
  background-color: var(--bg-dark);
  color: var(--text-main);
  height: 100vh;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

/* Stunning Animated Aurora Background */
.aurora-bg {
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  overflow: hidden;
  z-index: 0;
  background: var(--bg-dark);
}
.aurora-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(120px);
  opacity: 0.6;
  animation: moveBlob 20s infinite alternate;
}
.blob-1 {
  width: 600px; height: 600px;
  background: var(--brand-purple);
  top: -200px; left: -100px;
  animation-delay: 0s;
}
.blob-2 {
  width: 500px; height: 500px;
  background: var(--brand-magenta);
  bottom: -150px; right: -100px;
  animation-delay: -5s;
}
.blob-3 {
  width: 400px; height: 400px;
  background: #3B82F6;
  top: 40%; left: 40%;
  animation-duration: 25s;
}

@keyframes moveBlob {
  0% { transform: translate(0, 0) scale(1); }
  33% { transform: translate(100px, -50px) scale(1.2); }
  66% { transform: translate(-50px, 100px) scale(0.8); }
  100% { transform: translate(0, 0) scale(1); }
}

/* Grid Overlay for texture */
.grid-overlay {
  position: absolute;
  inset: 0;
  background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
  linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
  background-size: 40px 40px;
  z-index: 1;
  pointer-events: none;
}

/* Glassmorphic Login Card */
.auth-wrapper {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 440px;
  padding: 48px;
  background: var(--glass-bg);
  backdrop-filter: blur(40px);
  -webkit-backdrop-filter: blur(40px);
  border: 1px solid var(--glass-border);
  border-radius: 24px;
  box-shadow: 0 24px 64px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
  animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  opacity: 0;
  transform: translateY(40px);
}

@keyframes slideUp {
  to { opacity: 1; transform: translateY(0); }
}

.brand-header {
  text-align: center;
  margin-bottom: 40px;
}
.brand-title {
  font-size: 32px;
  font-weight: 700;
  letter-spacing: -1px;
  background: linear-gradient(90deg, #A855F7, #D946EF);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 8px;
}
.brand-tag {
  font-size: 11px;
  letter-spacing: 2px;
  color: var(--text-muted);
  text-transform: uppercase;
}

.form-group {
  margin-bottom: 24px;
  position: relative;
}
.form-group label {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: var(--text-muted);
  margin-bottom: 8px;
}
.form-input {
  width: 100%;
  background: rgba(0,0,0,0.2);
  border: 1px solid var(--glass-border);
  border-radius: 12px;
  padding: 14px 16px;
  color: #fff;
  font-size: 14px;
  font-family: 'Inter', sans-serif;
  transition: all 0.3s ease;
  outline: none;
}
.form-input:focus {
  background: rgba(0,0,0,0.4);
  border-color: var(--brand-purple);
  box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
}
.form-input::placeholder { color: rgba(255,255,255,0.2); }

.options-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
}
.checkbox-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}
.checkbox-wrap input {
  width: 16px; height: 16px; accent-color: var(--brand-purple);
}
.checkbox-wrap span { font-size: 13px; color: var(--text-muted); }
.forgot-link { font-size: 13px; color: var(--brand-magenta); text-decoration: none; font-weight: 500; transition: color 0.2s;}
.forgot-link:hover { color: #fff; }

.btn-submit {
  width: 100%;
  padding: 16px;
  border-radius: 12px;
  border: none;
  background: linear-gradient(90deg, #A855F7, #D946EF);
  color: #fff;
  font-size: 15px;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
  transition: all 0.3s ease;
}
.btn-submit::after {
  content: '';
  position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  transition: all 0.5s ease;
}
.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(139, 92, 246, 0.5);
}
.btn-submit:hover::after { left: 200%; }

.form-footer {
  text-align: center;
  margin-top: 32px;
  font-size: 13px;
  color: var(--text-muted);
}
.form-footer a { color: var(--text-main); font-weight: 500; text-decoration: none; transition: color 0.2s;}
.form-footer a:hover { color: var(--brand-magenta); }

.error-msg { font-size: 12px; color: #EF4444; margin-top: 6px; display: block; }
</style>
</head>
<body>

<div class="aurora-bg">
  <div class="aurora-blob blob-1"></div>
  <div class="aurora-blob blob-2"></div>
  <div class="aurora-blob blob-3"></div>
</div>
<div class="grid-overlay"></div>

<div class="auth-wrapper">
  <div class="brand-header">
    <div class="brand-title">EVENTA</div>
    <div class="brand-tag">Every Event. One Platform.</div>
  </div>

  @if(isset($tab) && $tab === 'register')
  <form method="POST" action="{{ route('register.post') }}">
    @csrf
    
    <div style="display:flex; gap:16px;">
      <div class="form-group" style="flex:1;">
        <label>First Name</label>
        <input type="text" name="first_name" class="form-input" placeholder="Jane" value="{{ old('first_name') }}" required autofocus>
        @error('first_name')<span class="error-msg">{{ $message }}</span>@enderror
      </div>
      <div class="form-group" style="flex:1;">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-input" placeholder="Doe" value="{{ old('last_name') }}" required>
        @error('last_name')<span class="error-msg">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-group">
      <label>Phone Number</label>
      <input type="text" name="phone" class="form-input" placeholder="+255..." value="{{ old('phone') }}" required>
      @error('phone')<span class="error-msg">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label>Email (Optional)</label>
      <input type="email" name="email" class="form-input" placeholder="name@example.com" value="{{ old('email') }}">
      @error('email')<span class="error-msg">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" class="form-input" placeholder="••••••••" required>
      @error('password')<span class="error-msg">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
    </div>

    <input type="hidden" name="role" value="contributor">

    <button type="submit" class="btn-submit">Create Account</button>
  </form>

  <div class="form-footer">
    Already have an account? <a href="{{ route('login') }}">Sign In</a>
  </div>

  @else
  <form method="POST" action="{{ route('login.post') }}">
    @csrf
    
    <div class="form-group">
      <label>Email or Phone</label>
      <input type="text" name="email" class="form-input" placeholder="name@example.com or +255..." value="{{ old('email') }}" required autofocus>
      @error('email')<span class="error-msg">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" class="form-input" placeholder="••••••••" required>
    </div>

    <div class="options-row">
      <label class="checkbox-wrap">
        <input type="checkbox" name="remember">
        <span>Remember me</span>
      </label>
      <a href="#" class="forgot-link">Forgot password?</a>
    </div>

    <button type="submit" class="btn-submit">Sign In to Workspace</button>
  </form>

  <div class="form-footer">
    New guest? <a href="{{ route('register') }}">Create an Account</a>
  </div>
  @endif
</div>

</body>
</html>
