@extends('layouts.app')
@section('title', 'Help & Support')

@section('extra_css')
<style>
.page-header { margin-bottom: 40px; text-align: center; }
.ph-title { font-size: 36px; font-weight: 800; color: #fff; letter-spacing: -1px; margin-bottom: 12px; }
.ph-sub { color: var(--text-muted); font-size: 16px; max-width: 600px; margin: 0 auto; line-height: 1.6; }

/* Search Bar */
.help-search { max-width: 600px; margin: 0 auto 48px; }
.hs-wrap { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 12px 20px; display: flex; gap: 12px; align-items: center; transition: border-color 0.2s; }
.hs-wrap:focus-within { border-color: var(--brand-purple); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }
.hs-wrap input { background: transparent; border: none; color: #fff; outline: none; width: 100%; font-size: 15px; }
.hs-wrap input::placeholder { color: var(--text-faint); }

/* Category Cards */
.cat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 48px; }
.cat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; text-align: center; cursor: pointer; transition: transform 0.2s, border-color 0.2s; text-decoration: none; display: block; }
.cat-card:hover { transform: translateY(-4px); border-color: var(--brand-purple); }
.cat-icon { font-size: 28px; margin-bottom: 12px; }
.cat-name { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 4px; }
.cat-count { font-size: 12px; color: var(--text-muted); }

/* FAQ */
.faq-title { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 20px; }
.faq-item { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; margin-bottom: 12px; overflow: hidden; }
.faq-q { padding: 20px; font-size: 14px; font-weight: 600; color: #fff; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: background 0.2s; }
.faq-q:hover { background: rgba(255,255,255,0.03); }
.faq-a { padding: 0 20px 20px; font-size: 14px; color: var(--text-muted); line-height: 1.7; display: none; }
.faq-item.open .faq-a { display: block; }
.faq-item.open .faq-chevron { transform: rotate(180deg); }
.faq-chevron { transition: transform 0.2s; color: var(--text-muted); }

/* Contact Card */
.contact-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-top: 40px; }
.contact-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; display: flex; gap: 16px; align-items: flex-start; }
.cc-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.cc-title { font-size: 15px; font-weight: 600; color: #fff; margin-bottom: 4px; }
.cc-sub { font-size: 13px; color: var(--text-muted); margin-bottom: 12px; }
.cc-link { font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: gap 0.2s; }
.cc-link:hover { gap: 10px; }

@media(max-width: 768px) {
  .cat-grid { grid-template-columns: repeat(2, 1fr); }
  .contact-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <h1 class="ph-title">How can we help you?</h1>
  <p class="ph-sub">Search our knowledge base or browse the topics below to get started with EVENTA.</p>
</div>

<div class="help-search">
  <div class="hs-wrap">
    <i class="fa-solid fa-magnifying-glass" style="color:var(--text-faint);"></i>
    <input type="text" placeholder="Search for answers... e.g. 'how to add a vendor'">
    <i class="fa-solid fa-arrow-right" style="color:var(--brand-purple);"></i>
  </div>
</div>

<div class="cat-grid">
  <a href="#faq" class="cat-card">
    <div class="cat-icon">🎯</div>
    <div class="cat-name">Getting Started</div>
    <div class="cat-count">8 articles</div>
  </a>
  <a href="#faq" class="cat-card">
    <div class="cat-icon">💳</div>
    <div class="cat-name">Payments & Escrow</div>
    <div class="cat-count">12 articles</div>
  </a>
  <a href="#faq" class="cat-card">
    <div class="cat-icon">🏪</div>
    <div class="cat-name">Vendor Marketplace</div>
    <div class="cat-count">6 articles</div>
  </a>
  <a href="#faq" class="cat-card">
    <div class="cat-icon">👥</div>
    <div class="cat-name">Guest Management</div>
    <div class="cat-count">5 articles</div>
  </a>
  <a href="#faq" class="cat-card">
    <div class="cat-icon">📊</div>
    <div class="cat-name">Reports & Analytics</div>
    <div class="cat-count">9 articles</div>
  </a>
  <a href="#faq" class="cat-card">
    <div class="cat-icon">⚙️</div>
    <div class="cat-name">Account & Settings</div>
    <div class="cat-count">7 articles</div>
  </a>
</div>

<div id="faq">
  <div class="faq-title">Frequently Asked Questions</div>

  <div class="faq-item">
    <div class="faq-q" onclick="toggleFaq(this)">
      How does the Escrow payment system work?
      <i class="fa-solid fa-chevron-down faq-chevron"></i>
    </div>
    <div class="faq-a">
      When a guest or contributor pays through EVENTA, the funds are held in a secure escrow account. The money is only released to the event organizer after the agreed-upon milestone (e.g., the event date has passed). This protects both guests and organizers from fraud.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-q" onclick="toggleFaq(this)">
      How do I book a vendor from the Marketplace?
      <i class="fa-solid fa-chevron-down faq-chevron"></i>
    </div>
    <div class="faq-a">
      Navigate to the <strong>Vendors</strong> section in the sidebar. Browse or filter by category, then click on a vendor profile to view their gallery, pricing, and reviews. Click "Request to Book" and follow the payment flow. A 20% deposit is required to confirm the booking — this is held in escrow until the vendor delivers.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-q" onclick="toggleFaq(this)">
      Can I manage multiple events at the same time?
      <i class="fa-solid fa-chevron-down faq-chevron"></i>
    </div>
    <div class="faq-a">
      Yes! EVENTA Pro allows unlimited concurrent events. On the Free Plan you can manage up to 2 active events. Navigate to <strong>My Events</strong> and click "New Event" to create additional workspaces. Each event has its own financial tracking, guest list, and vendor contracts.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-q" onclick="toggleFaq(this)">
      What payment methods are supported?
      <i class="fa-solid fa-chevron-down faq-chevron"></i>
    </div>
    <div class="faq-a">
      EVENTA supports M-Pesa, Airtel Money, Card (Visa/Mastercard), Apple Pay, and bank transfers. All payments are processed securely and instantly reflected in your Financial dashboard under the Financials & Escrow section.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-q" onclick="toggleFaq(this)">
      How do I export a financial report?
      <i class="fa-solid fa-chevron-down faq-chevron"></i>
    </div>
    <div class="faq-a">
      Go to <strong>Budget Tracker</strong> in the sidebar. In the top right corner of the page, you'll find an "Export CSV" button for spreadsheet data and a "Download PDF" button for a formatted report you can share with your team or client.
    </div>
  </div>
</div>

<div class="contact-grid">
  <div class="contact-card">
    <div class="cc-icon" style="background:rgba(139,92,246,0.1); color:var(--brand-purple);">
      <i class="fa-regular fa-envelope"></i>
    </div>
    <div>
      <div class="cc-title">Email Support</div>
      <div class="cc-sub">Our team responds within 24 hours on business days.</div>
      <a href="mailto:support@eventa.io" class="cc-link" style="color:var(--brand-purple);">
        support@eventa.io <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
      </a>
    </div>
  </div>
  <div class="contact-card">
    <div class="cc-icon" style="background:rgba(16,185,129,0.1); color:#10B981;">
      <i class="fa-brands fa-whatsapp"></i>
    </div>
    <div>
      <div class="cc-title">WhatsApp Chat</div>
      <div class="cc-sub">Get instant help from our support agents via WhatsApp.</div>
      <a href="#" class="cc-link" style="color:#10B981;">
        Chat Now <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
      </a>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
function toggleFaq(el) {
  const item = el.parentElement;
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
</script>
@endsection
