@extends('layouts.app')
@section('title', 'Messages')

@section('extra_css')
<style>
.messenger-layout { display: grid; grid-template-columns: 320px 1fr; background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; overflow: hidden; height: calc(100vh - 140px); min-height: 600px; }

/* Sidebar List */
.msg-sidebar { border-right: 1px solid var(--border); display: flex; flex-direction: column; }
.msg-header { padding: 20px; border-bottom: 1px solid var(--border); }
.msg-title { font-size: 20px; font-weight: 700; color: #fff; display: flex; justify-content: space-between; align-items: center; }
.msg-title-btn { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--text-main); cursor: pointer; transition: all 0.2s; }
.msg-title-btn:hover { background: var(--bg-card-hover); color: #fff; }

.search-box { margin-top: 16px; background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; display: flex; align-items: center; gap: 8px; }
.search-box input { background: transparent; border: none; color: #fff; outline: none; width: 100%; font-size: 13px; }

.chat-list { flex: 1; overflow-y: auto; }
.chat-list::-webkit-scrollbar { width: 4px; }
.chat-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }

.chat-item { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.02); display: flex; gap: 12px; cursor: pointer; transition: background 0.2s; text-decoration: none; color: inherit; }
.chat-item:hover, .chat-item.active { background: rgba(255,255,255,0.03); }
.ci-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
.ci-content { flex: 1; overflow: hidden; }
.ci-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
.ci-name { font-size: 14px; font-weight: 600; color: #fff; }
.ci-time { font-size: 11px; color: var(--text-muted); }
.ci-preview { font-size: 13px; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* Main Chat Area */
.msg-main { display: flex; flex-direction: column; background: rgba(0,0,0,0.1); }
.chat-header { padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--bg-card); }
.ch-info { display: flex; align-items: center; gap: 12px; }
.ch-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
.ch-name { font-size: 16px; font-weight: 600; color: #fff; }
.ch-status { font-size: 12px; color: var(--status-green); display: flex; align-items: center; gap: 4px; }
.ch-status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--status-green); }
.ch-actions { display: flex; gap: 12px; }

.chat-body { flex: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 24px; }

.msg-bubble-wrap { display: flex; flex-direction: column; max-width: 70%; }
.msg-bubble-wrap.incoming { align-self: flex-start; }
.msg-bubble-wrap.outgoing { align-self: flex-end; align-items: flex-end; }
.msg-bubble { padding: 12px 16px; border-radius: 16px; font-size: 14px; line-height: 1.5; }
.incoming .msg-bubble { background: var(--bg-card-hover); border: 1px solid var(--border); color: #fff; border-bottom-left-radius: 4px; }
.outgoing .msg-bubble { background: linear-gradient(135deg, var(--brand-purple), var(--brand-magenta)); color: #fff; border-bottom-right-radius: 4px; }
.msg-time { font-size: 11px; color: var(--text-faint); margin-top: 6px; }

.chat-input-area { padding: 20px; border-top: 1px solid var(--border); background: var(--bg-card); }
.chat-form { display: flex; gap: 12px; align-items: center; width: 100%; }
.ci-btn { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.05); color: var(--text-muted); border: none; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
.ci-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }
.ci-input-wrapper { flex: 1; background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 20px; padding: 10px 16px; }
.ci-input-wrapper input { width: 100%; background: transparent; border: none; color: #fff; outline: none; font-size: 14px; font-family: 'Inter', sans-serif; }
.ci-send { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--brand-purple), var(--brand-magenta)); color: #fff; border: none; cursor: pointer; transition: transform 0.2s; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); display: flex; align-items: center; justify-content: center; }
.ci-send:hover { transform: scale(1.05); }

@media(max-width: 768px) {
  .messenger-layout { grid-template-columns: 1fr; height: auto; min-height: auto; }
  .msg-sidebar { height: 100%; max-height: 50vh; }
  .msg-main { display: flex; min-height: 50vh; }
  .chat-body { max-height: 300px; }
}

@media(max-width: 480px) {
  .msg-sidebar { max-height: 45vh; }
  .chat-body { max-height: 250px; }
  .ci-btn { width: 34px; height: 34px; }
}
</style>
@endsection

@section('content')

<div class="messenger-layout">
  
  <!-- Sidebar -->
  <div class="msg-sidebar">
    <div class="msg-header">
      <div class="msg-title">
        Messages 
        <div class="msg-title-btn"><i class="fa-solid fa-pen-to-square" style="font-size:14px;"></i></div>
      </div>
      <div class="search-box">
        <i class="fa-solid fa-magnifying-glass text-muted"></i>
        <input type="text" placeholder="Search conversations...">
      </div>
    </div>
    
    <div class="chat-list">
      @forelse($vendors as $vendor)
        <a href="{{ route('messages.index', ['vendor_id' => $vendor->id]) }}" class="chat-item {{ $activeVendor && $activeVendor->id == $vendor->id ? 'active' : '' }}">
          <img src="{{ $vendor->cover_image ?? 'https://ui-avatars.com/api/?name='.urlencode($vendor->name).'&background=A855F7&color=fff' }}" class="ci-avatar">
          <div class="ci-content">
            <div class="ci-top">
              <div class="ci-name">{{ $vendor->name }}</div>
              <div class="ci-time">Online</div>
            </div>
            <div class="ci-preview">{{ $vendor->category }}</div>
          </div>
        </a>
      @empty
        <div style="text-align:center; padding:32px 0; color:var(--text-muted); font-size:13px;">No vendors available.</div>
      @endforelse
    </div>
  </div>

  <!-- Main Chat -->
  <div class="msg-main">
    @if(!$activeVendor)
      <div style="flex:1; display:flex; align-items:center; justify-content:center; flex-direction:column; color:var(--text-muted);">
        <i class="fa-regular fa-message" style="font-size:48px; opacity:0.3; margin-bottom:16px;"></i>
        <div>Select a conversation to start messaging</div>
      </div>
    @else
      <div class="chat-header">
        <div class="ch-info">
          <img src="{{ $activeVendor->cover_image ?? 'https://ui-avatars.com/api/?name='.urlencode($activeVendor->name).'&background=A855F7&color=fff' }}" class="ch-avatar">
          <div>
            <div class="ch-name">{{ $activeVendor->name }}</div>
            <div class="ch-status">Online</div>
          </div>
        </div>
        <div class="ch-actions">
          <button class="msg-title-btn" onclick="alert('Voice call simulation initialized...')"><i class="fa-solid fa-phone"></i></button>
          <button class="msg-title-btn" onclick="alert('Video call simulation initialized...')"><i class="fa-solid fa-video"></i></button>
          <button class="msg-title-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
        </div>
      </div>

      <div class="chat-body" id="chat-body">
        <div style="text-align:center; font-size:11px; color:var(--text-faint); margin-bottom: 8px;">CONVERSATION START</div>
        
        @foreach($messages as $msg)
          <div class="msg-bubble-wrap {{ $msg->is_from_vendor ? 'incoming' : 'outgoing' }}">
            <div class="msg-bubble">
              {{ $msg->body }}
            </div>
            <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
          </div>
        @endforeach
      </div>

      <div class="chat-input-area">
        <form class="chat-form" method="POST" action="{{ route('messages.store') }}">
          @csrf
          <input type="hidden" name="vendor_id" value="{{ $activeVendor->id }}">
          
          <button type="button" class="ci-btn" onclick="alert('File upload simulation...')"><i class="fa-solid fa-paperclip"></i></button>
          <button type="button" class="ci-btn" onclick="alert('Media upload simulation...')"><i class="fa-regular fa-image"></i></button>
          <div class="ci-input-wrapper">
            <input type="text" name="body" placeholder="Type your message to {{ $activeVendor->name }}..." required autocomplete="off">
          </div>
          <button type="submit" class="ci-send"><i class="fa-solid fa-paper-plane"></i></button>
        </form>
      </div>
    @endif
  </div>

</div>

@endsection

@section('scripts')
<script>
  // Automatically scroll chat body to the bottom on load
  document.addEventListener('DOMContentLoaded', function() {
    const chatBody = document.getElementById('chat-body');
    if (chatBody) {
      chatBody.scrollTop = chatBody.scrollHeight;
    }
  });
</script>
@endsection
