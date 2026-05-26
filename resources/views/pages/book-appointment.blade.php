{{-- resources/views/pages/consultation.blade.php --}}
@extends('layouts.app', ['active' => 'consultation'])

@php
  $appointmentPage = $appointmentPage ?? null;
@endphp

@section('title', 'Book a Consultation – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Book a free in-person consultation at any HASU Educational Consultancy branch — Bhairahawa, Kathmandu, Pokhara, or Chitwan.')

@push('head')
<style>
/* ====== RESET ====== */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;color:#333;background:#fff;overflow-x:hidden;line-height:1.6}
img{max-width:100%;display:block}
a{text-decoration:none;color:inherit}
ul{list-style:none}
input,textarea,select,button{font-family:inherit}

/* ====== VARIABLES ====== */
:root{
  --blue:#2952e3;--blue-dark:#1a3ed4;--blue-light:#e8edfd;
  --red:#cc2222;--red-dark:#a81a1a;--red-light:#fdeaea;
  --navy:#0d1560;--text:#555;--light:#f0f4fd;
  --border:#e2e8f0;--radius:8px;--shadow:0 4px 24px rgba(0,0,0,.09);
}

/* ====== UTILITIES ====== */
.container{max-width:1160px;margin:0 auto;padding:0 24px}
.section{padding:88px 0}
.section-label{display:inline-flex;align-items:center;gap:10px;font-size:12px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--red);margin-bottom:10px}
.section-label::before,.section-label::after{content:'';display:block;width:32px;height:2px;background:var(--red)}
.section-title{font-family:'Playfair Display',serif;font-size:clamp(24px,3.2vw,40px);color:var(--navy);line-height:1.22;margin-bottom:14px}
.section-sub{font-size:15px;color:var(--text);max-width:600px;margin:0 auto}
.fade-up{opacity:0;transform:translateY(28px);transition:opacity .65s,transform .65s}
.fade-up.visible{opacity:1;transform:none}
.fade-left{opacity:0;transform:translateX(-32px);transition:opacity .65s,transform .65s}
.fade-left.visible{opacity:1;transform:none}
.fade-right{opacity:0;transform:translateX(32px);transition:opacity .65s,transform .65s}
.fade-right.visible{opacity:1;transform:none}

/* ====== PAGE HERO ====== */
.page-hero{background:linear-gradient(120deg,#0d1560 0%,#1a237e 45%,#283593 70%,#3949ab 100%);padding:72px 0 80px;position:relative;overflow:hidden}
.page-hero::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.06) 1px,transparent 1px);background-size:28px 28px;pointer-events:none}
.page-hero-wave{position:absolute;bottom:-2px;left:0;right:0;height:64px;background:#fff;clip-path:ellipse(55% 100% at 50% 100%)}
.page-hero-inner{position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px}
.breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.6);margin-bottom:16px}
.breadcrumb a{color:rgba(255,255,255,.6)}
.breadcrumb a:hover{color:#fff}
.breadcrumb span{color:rgba(255,255,255,.35)}
.page-hero-title{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,52px);color:#fff;line-height:1.15;margin-bottom:12px}
.page-hero-title span{color:#f4c842}
.page-hero-sub{font-size:15px;color:rgba(255,255,255,.78);max-width:480px;margin-bottom:28px}
.hero-quick-contacts{display:flex;gap:20px;flex-wrap:wrap}
.hero-qc{display:flex;align-items:center;gap:12px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:10px;padding:12px 18px;backdrop-filter:blur(6px);transition:background .25s}
.hero-qc:hover{background:rgba(255,255,255,.18)}
.hero-qc-icon{font-size:22px}
.hero-qc-text strong{display:block;font-size:13px;font-weight:700;color:#fff}
.hero-qc-text span{font-size:11px;color:rgba(255,255,255,.65)}

/* ====== QUICK INFO STRIP ====== */
.info-strip{background:#fff;border-bottom:1px solid var(--border)}
.info-strip-inner{display:grid;grid-template-columns:repeat(4,1fr);gap:0}
.info-strip-item{display:flex;align-items:center;gap:16px;padding:24px 28px;border-right:1px solid var(--border);transition:background .25s}
.info-strip-item:last-child{border-right:none}
.info-strip-item:hover{background:var(--light)}
.info-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
.info-icon.blue{background:var(--blue-light)}
.info-icon.red{background:var(--red-light)}
.info-icon.gold{background:#fffbea}
.info-icon.navy{background:linear-gradient(135deg,var(--blue-light),var(--red-light))}
.info-text strong{display:block;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:2px}
.info-text span{font-size:12px;color:var(--text)}
.info-text a{font-size:12px;color:var(--blue);font-weight:500}
.info-text a:hover{color:var(--red)}

/* ====== MAIN LAYOUT ====== */
#booking-main{background:var(--light)}
/* booking section children are always visible — no scroll-reveal delay */
#booking-main .fade-up,
#booking-main .fade-left,
#booking-main .fade-right{opacity:1;transform:none}
.booking-grid{display:grid;grid-template-columns:1.15fr 1fr;gap:40px;align-items:start}

/* ====== STEP WIZARD ====== */
.booking-card{background:#fff;border-radius:16px;padding:40px;box-shadow:var(--shadow);border:1px solid var(--border)}
.booking-card h3{font-family:'Playfair Display',serif;font-size:24px;color:var(--navy);margin-bottom:6px}
.booking-card > p{font-size:14px;color:var(--text);margin-bottom:28px}

/* step indicator */
.steps-indicator{display:flex;align-items:center;margin-bottom:32px}
.step-ind{display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;position:relative}
.step-ind::after{content:'';position:absolute;top:16px;left:50%;width:100%;height:2px;background:var(--border);z-index:0;transition:background .35s}
.step-ind:last-child::after{display:none}
.step-ind.done::after{background:var(--blue)}
.step-circle{width:32px;height:32px;border-radius:50%;border:2px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--text);z-index:1;transition:all .3s;position:relative}
.step-ind.active .step-circle{border-color:var(--blue);background:var(--blue);color:#fff}
.step-ind.done .step-circle{border-color:var(--blue);background:var(--blue);color:#fff}
.step-label{font-size:11px;font-weight:600;color:var(--text);text-align:center;white-space:nowrap}
.step-ind.active .step-label{color:var(--blue)}
.step-ind.done .step-label{color:var(--blue)}

/* step panels */
.step-panel{display:none !important}
.step-panel.active{display:block !important}

/* branch selector */
.branch-cards{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px}
.branch-card{border:2px solid var(--border);border-radius:10px;padding:16px;cursor:pointer;transition:all .25s;background:#fff}
.branch-card:hover{border-color:var(--blue);background:var(--blue-light)}
.branch-card.selected{border-color:var(--blue);background:var(--blue-light)}
.branch-card-header{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.bc-icon{width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:var(--light)}
.branch-card.selected .bc-icon{background:var(--blue);filter:grayscale(0)}
.bc-name{font-size:14px;font-weight:700;color:var(--navy)}
.bc-badge{font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:2px 8px;border-radius:20px;margin-left:4px}
.badge-hq{background:var(--blue-light);color:var(--blue)}
.badge-branch{background:var(--red-light);color:var(--red)}
.bc-address{font-size:12px;color:var(--text);line-height:1.5}
.bc-hours{display:inline-block;margin-top:6px;font-size:11px;font-weight:600;color:var(--blue)}

/* calendar */
.cal-wrap{border:1.5px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:20px}
.cal-header{background:var(--navy);color:#fff;display:flex;align-items:center;justify-content:space-between;padding:12px 16px}
.cal-header span{font-size:14px;font-weight:700}
.cal-header button{background:none;border:none;color:rgba(255,255,255,.7);cursor:pointer;font-size:18px;padding:0 4px;transition:color .2s}
.cal-header button:hover{color:#fff}
.cal-grid{display:grid;grid-template-columns:repeat(7,1fr);background:#fff}
.cal-day-name{text-align:center;font-size:11px;font-weight:700;color:var(--text);padding:10px 0 6px;text-transform:uppercase;letter-spacing:.04em}
.cal-day{text-align:center;font-size:13px;padding:8px 4px;cursor:pointer;color:var(--navy);border-radius:6px;transition:background .15s;margin:2px}
.cal-day:hover:not(.empty):not(.past){background:var(--blue-light);color:var(--blue)}
.cal-day.selected{background:var(--blue);color:#fff;border-radius:6px}
.cal-day.today{font-weight:700;position:relative}
.cal-day.today::after{content:'';display:block;width:4px;height:4px;border-radius:50%;background:var(--red);margin:2px auto 0}
.cal-day.past{color:#ccc;pointer-events:none}
.cal-day.empty{pointer-events:none}
.cal-day.sunday{color:#e24b4a}
.cal-day.sunday.past{color:#f5c4c4}

/* time slots */
.slots-label{font-size:13px;font-weight:600;color:var(--navy);margin-bottom:10px}
.slots-label span{font-weight:400;color:var(--text)}
.time-slots{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:20px}
.slot{padding:9px 4px;border:1.5px solid var(--border);border-radius:6px;font-size:12px;font-weight:600;text-align:center;cursor:pointer;color:var(--navy);background:#fff;transition:all .2s}
.slot:hover:not(.disabled){border-color:var(--blue);color:var(--blue);background:var(--blue-light)}
.slot.selected{background:var(--blue);color:#fff;border-color:var(--blue)}
.slot.disabled{background:#f8f8f8;color:#ccc;pointer-events:none;border-color:#eee}
.slot.disabled span{display:block;font-size:9px;font-weight:400;color:#bbb}
.no-slots{font-size:13px;color:var(--text);padding:16px;text-align:center;background:var(--light);border-radius:8px}

/* form fields */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:13px;font-weight:600;color:var(--navy);margin-bottom:6px}
.form-group input,
.form-group select,
.form-group textarea{
  width:100%;padding:12px 14px;border:1.5px solid var(--border);
  border-radius:6px;font-size:14px;color:var(--navy);
  background:#fff;transition:border-color .25s,box-shadow .25s;outline:none
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.12)}
.form-group textarea{resize:vertical;min-height:90px}
.form-group select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M0 0l6 8 6-8z' fill='%23555'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;cursor:pointer}
.form-check{display:flex;align-items:flex-start;gap:10px;margin-bottom:22px;font-size:13px;color:var(--text)}
.form-check input{margin-top:3px;accent-color:var(--blue);flex-shrink:0}
.field-error{font-size:12px;color:var(--red);margin-top:4px;display:none}
.form-group.has-error input,
.form-group.has-error select,
.form-group.has-error textarea{border-color:var(--red)}
.form-group.has-error .field-error{display:block}

/* step navigation */
.step-actions{display:flex;justify-content:space-between;align-items:center;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)}
.btn-back{background:none;border:2px solid var(--border);border-radius:6px;padding:11px 22px;font-size:14px;font-weight:600;color:var(--text);cursor:pointer;transition:all .25s;display:flex;align-items:center;gap:8px}
.btn-back:hover{border-color:var(--navy);color:var(--navy)}
.btn-next{background:var(--blue);color:#fff;border:2px solid var(--blue);border-radius:6px;padding:11px 26px;font-size:14px;font-weight:700;cursor:pointer;transition:all .25s;display:flex;align-items:center;gap:8px}
.btn-next:hover{background:var(--blue-dark);border-color:var(--blue-dark)}
.btn-submit{background:var(--red);color:#fff;border:2px solid var(--red);border-radius:6px;padding:13px 30px;font-size:15px;font-weight:700;cursor:pointer;transition:all .25s;display:flex;align-items:center;gap:10px;letter-spacing:.3px}
.btn-submit:hover{background:var(--red-dark);border-color:var(--red-dark)}
.btn-submit:disabled{opacity:.6;pointer-events:none}

/* ====== REVIEW CARD ====== */
.review-block{background:var(--light);border-radius:10px;padding:22px;margin-bottom:20px}
.review-block h4{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:14px;text-transform:uppercase;letter-spacing:1px}
.review-row{display:flex;align-items:flex-start;gap:12px;margin-bottom:12px}
.review-row:last-child{margin-bottom:0}
.rv-icon{width:32px;height:32px;border-radius:8px;background:#fff;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.rv-text strong{display:block;font-size:12px;font-weight:700;color:var(--navy);margin-bottom:1px}
.rv-text span{font-size:13px;color:var(--text)}

/* ====== SUCCESS SCREEN ====== */
.success-screen{display:none;text-align:center;padding:48px 24px}
.success-icon-wrap{width:72px;height:72px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 20px}
.success-screen h2{font-family:'Playfair Display',serif;font-size:28px;color:var(--navy);margin-bottom:10px}
.success-screen p{font-size:15px;color:var(--text);max-width:380px;margin:0 auto 24px;line-height:1.7}
.ref-number{font-family:monospace;font-size:20px;font-weight:700;color:var(--blue);letter-spacing:.15em;background:var(--blue-light);padding:12px 24px;border-radius:8px;display:inline-block;margin-bottom:24px}
.success-details{background:var(--light);border-radius:10px;padding:18px 24px;text-align:left;max-width:360px;margin:0 auto 28px;display:grid;gap:10px}
.sd-row{display:flex;justify-content:space-between;font-size:13px}
.sd-row span:first-child{color:var(--text)}
.sd-row span:last-child{font-weight:600;color:var(--navy)}
.btn-new{background:var(--navy);color:#fff;border:none;border-radius:6px;padding:12px 28px;font-size:14px;font-weight:700;cursor:pointer;transition:background .25s}
.btn-new:hover{background:#1a237e}

/* ====== SIDEBAR ====== */
.sidebar-col{}
.sidebar-sticky{position:sticky;top:88px;display:flex;flex-direction:column;gap:20px}
.side-card{background:#fff;border-radius:16px;padding:28px;box-shadow:var(--shadow);border:1px solid var(--border)}
.side-card h4{font-family:'Playfair Display',serif;font-size:18px;color:var(--navy);margin-bottom:18px}

/* booking summary sidebar */
.summary-list{display:flex;flex-direction:column;gap:0}
.sl-row{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border)}
.sl-row:last-child{border-bottom:none}
.sl-icon{width:34px;height:34px;border-radius:8px;background:var(--light);display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}
.sl-text strong{display:block;font-size:11px;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:.6px;margin-bottom:2px}
.sl-text span{font-size:13px;color:var(--navy);font-weight:500}
.sl-text span.empty{color:#bbb;font-weight:400;font-style:italic}

/* branch map mini */
.mini-map-wrap{border-radius:10px;overflow:hidden;border:1.5px solid var(--border);margin-bottom:14px}
.mini-map-wrap iframe{width:100%;height:180px;display:block;border:none}
.map-branch-name{font-size:13px;font-weight:600;color:var(--navy);margin-bottom:4px}
.map-branch-addr{font-size:12px;color:var(--text)}

/* what to bring */
.bring-list{display:flex;flex-direction:column;gap:10px}
.bring-item{display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--text)}
.bring-bullet{width:22px;height:22px;border-radius:50%;background:var(--blue-light);color:var(--blue);font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}

/* ====== FAQ ====== */
#faq-strip{background:#fff}
.faq-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:48px}
.faq-item{background:var(--light);border-radius:10px;padding:20px 22px;border-left:3px solid transparent;transition:border-color .25s,box-shadow .25s;cursor:pointer}
.faq-item:hover{border-left-color:var(--blue);box-shadow:var(--shadow)}
.faq-item.open{border-left-color:var(--red);background:#fff;box-shadow:var(--shadow)}
.faq-q{display:flex;justify-content:space-between;align-items:flex-start;gap:12px}
.faq-q span{font-size:14px;font-weight:600;color:var(--navy)}
.faq-toggle{width:26px;height:26px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;flex-shrink:0;transition:all .25s}
.faq-item.open .faq-toggle{background:var(--red);color:#fff;transform:rotate(45deg)}
.faq-a{font-size:13px;color:var(--text);line-height:1.7;max-height:0;overflow:hidden;transition:max-height .35s,padding .3s}
.faq-item.open .faq-a{max-height:160px;padding-top:12px}

/* ====== CTA BANNER ====== */
.cta-section{background:linear-gradient(120deg,#0d1560 0%,#283593 60%,#cc2222 130%);padding:60px 0}
.cta-inner{display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap}
.cta-text h2{font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,34px);color:#fff;margin-bottom:8px}
.cta-text p{font-size:15px;color:rgba(255,255,255,.75)}
.cta-actions{display:flex;gap:14px;flex-wrap:wrap;margin-top:20px}
.btn-cta-primary{background:var(--red);color:#fff;border:2px solid var(--red);border-radius:6px;padding:13px 30px;font-size:15px;font-weight:700;cursor:pointer;transition:all .25s}
.btn-cta-primary:hover{background:var(--red-dark);border-color:var(--red-dark)}
.btn-ghost{background:transparent;border:2px solid rgba(255,255,255,.55);color:#fff;padding:12px 28px;border-radius:6px;font-weight:600;font-size:14px;cursor:pointer;transition:all .25s;display:inline-block}
.btn-ghost:hover{background:rgba(255,255,255,.15)}

/* ====== RESPONSIVE ====== */
@media(max-width:960px){
  .nav-links,.nav-right{display:none}
  .hamburger{display:flex}
  .booking-grid{grid-template-columns:1fr}
  .info-strip-inner{grid-template-columns:1fr 1fr}
  .info-strip-item:nth-child(2){border-right:none}
  .info-strip-item:nth-child(3){border-right:1px solid var(--border)}
  .sidebar-sticky{position:static}
  .faq-grid{grid-template-columns:1fr}
}
@media(max-width:560px){
  .info-strip-inner{grid-template-columns:1fr}
  .info-strip-item{border-right:none;border-bottom:1px solid var(--border)}
  .form-row{grid-template-columns:1fr}
  .branch-cards{grid-template-columns:1fr}
  .time-slots{grid-template-columns:repeat(3,1fr)}
  .hero-quick-contacts{flex-direction:column}
}
</style>
@endpush

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
  <div class="page-hero-wave"></div>
  <div class="container">
    <div class="page-hero-inner">
      <div class="fade-up">
        <div class="breadcrumb">
          <a href="{{ route('home') }}">Home</a><span>›</span>
          <span style="color:rgba(255,255,255,.9)">Book a Consultation</span>
        </div>
        <h1 class="page-hero-title">{!! str_replace($appointmentPage?->hero_highlight ?: 'Free', '<span>' . e($appointmentPage?->hero_highlight ?: 'Free') . '</span>', e($appointmentPage?->hero_title ?: 'Book Your Free Consultation')) !!}</h1>
        <p class="page-hero-sub">{{ $appointmentPage?->hero_subtitle ?: 'Schedule a visit at your nearest HASU branch. Our expert counselors will guide you on universities, visas, and the best study abroad pathway for you.' }}</p>
        <div class="hero-quick-contacts">
          <a href="tel:+97756493528" class="hero-qc">
            <div class="hero-qc-icon">📞</div>
            <div class="hero-qc-text"><strong>Call Us</strong><span>056-493528</span></div>
          </a>
          <a href="mailto:info@hasuedu.com" class="hero-qc">
            <div class="hero-qc-icon">✉️</div>
            <div class="hero-qc-text"><strong>Email Us</strong><span>info@hasuedu.com</span></div>
          </a>
          <a href="https://wa.me/9779853646493" target="_blank" class="hero-qc">
            <div class="hero-qc-icon">💬</div>
            <div class="hero-qc-text"><strong>WhatsApp</strong><span>9853646493</span></div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== QUICK INFO STRIP ===== --}}
<div class="info-strip">
  <div class="container">
    <div class="info-strip-inner">
      <div class="info-strip-item">
        <div class="info-icon blue">🆓</div>
        <div class="info-text">
          <strong>Free Consultation</strong>
          <span>No charge for your session</span>
        </div>
      </div>
      <div class="info-strip-item">
        <div class="info-icon gold">⏱️</div>
        <div class="info-text">
          <strong>45–60 Minutes</strong>
          <span>Dedicated one-on-one session</span>
        </div>
      </div>
      <div class="info-strip-item">
        <div class="info-icon red">📍</div>
        <div class="info-text">
          <strong>4 Branch Locations</strong>
          <span>Bhairahawa, Kathmandu, Pokhara, Chitwan</span>
        </div>
      </div>
      <div class="info-strip-item">
        <div class="info-icon navy">📅</div>
        <div class="info-text">
          <strong>Sun–Fri, 9 AM – 5 PM</strong>
          <span>Saturday 10 AM – 3 PM (HQ only)</span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ===== MAIN BOOKING SECTION ===== --}}
<section id="booking-main" class="section">
  <div class="container">
    <div class="booking-grid">

      {{-- ===== BOOKING FORM CARD ===== --}}
      <div class="booking-card">
        <h3>{{ $appointmentPage?->form_title ?: 'Schedule Your Visit' }}</h3>
        <p>{{ $appointmentPage?->form_subtitle ?: 'Complete the steps below to book your in-person consultation at any HASU branch.' }}</p>

        {{-- Step Indicator --}}
        <div class="steps-indicator" id="stepsIndicator">
          <div class="step-ind active" id="sind-1">
            <div class="step-circle">1</div>
            <div class="step-label">Branch</div>
          </div>
          <div class="step-ind" id="sind-2">
            <div class="step-circle">2</div>
            <div class="step-label">Date & Time</div>
          </div>
          <div class="step-ind" id="sind-3">
            <div class="step-circle">3</div>
            <div class="step-label">Your Details</div>
          </div>
          <div class="step-ind" id="sind-4">
            <div class="step-circle">4</div>
            <div class="step-label">Confirm</div>
          </div>
        </div>

        {{-- STEP 1: Choose Branch --}}
        <div class="step-panel active" id="step1">
          <div style="font-size:13px;font-weight:600;color:var(--navy);margin-bottom:14px;">Select your preferred branch</div>
          <div class="branch-cards" id="branchCards">
            <div class="branch-card selected" data-branch="0">
              <div class="branch-card-header">
                <div class="bc-icon">🏢</div>
                <div>
                  <div class="bc-name">Bhairahawa <span class="bc-badge badge-hq">HQ</span></div>
                </div>
              </div>
              <div class="bc-address">Birendra Campus Gate, Bhairahawa-11, Rupandehi</div>
              <div class="bc-hours">⏰ Sun–Fri 9AM–5PM · Sat 10AM–3PM</div>
            </div>
            <div class="branch-card" data-branch="1">
              <div class="branch-card-header">
                <div class="bc-icon">🏙️</div>
                <div>
                  <div class="bc-name">Kathmandu <span class="bc-badge badge-branch">Branch</span></div>
                </div>
              </div>
              <div class="bc-address">New Baneshwor, Kathmandu, Bagmati Province</div>
              <div class="bc-hours">⏰ Sun–Fri 9AM–5PM · Sat 10AM–2PM</div>
            </div>
            <div class="branch-card" data-branch="2">
              <div class="branch-card-header">
                <div class="bc-icon">⛰️</div>
                <div>
                  <div class="bc-name">Pokhara <span class="bc-badge badge-branch">Branch</span></div>
                </div>
              </div>
              <div class="bc-address">Lakeside, Pokhara-8, Kaski, Gandaki Province</div>
              <div class="bc-hours">⏰ Sun–Fri 9AM–5PM · Sat 10AM–2PM</div>
            </div>
            <div class="branch-card" data-branch="3">
              <div class="branch-card-header">
                <div class="bc-icon">🌿</div>
                <div>
                  <div class="bc-name">Chitwan <span class="bc-badge badge-branch">Branch</span></div>
                </div>
              </div>
              <div class="bc-address">Narayangadh, Bharatpur-10, Chitwan</div>
              <div class="bc-hours">⏰ Sun–Fri 9AM–5PM · Sat 10AM–2PM</div>
            </div>
          </div>
          <div class="step-actions">
            <span></span>
            <button class="btn-next" id="btn-step1-next">Next: Pick a Date →</button>
          </div>
        </div>

        {{-- STEP 2: Date & Time --}}
        <div class="step-panel" id="step2">
          <div style="font-size:13px;font-weight:600;color:var(--navy);margin-bottom:14px;">Pick a date for your visit</div>
          <div class="cal-wrap">
            <div class="cal-header">
              <button id="btn-prev-month">‹</button>
              <span id="calMonthLabel"></span>
              <button id="btn-next-month">›</button>
            </div>
            <div class="cal-grid" id="calGrid"></div>
          </div>
          <div class="slots-label" id="slotsLabel">Select a date above to see available time slots</div>
          <div class="time-slots" id="timeSlots"></div>
          <div class="step-actions">
            <button class="btn-back" id="btn-step2-back">← Back</button>
            <button class="btn-next" id="btn-step2-next" disabled style="opacity:.5;pointer-events:none;">Next: Your Details →</button>
          </div>
        </div>

        {{-- STEP 3: Personal Details --}}
        <div class="step-panel" id="step3">
          <div class="form-row">
            <div class="form-group" id="fg-fname">
              <label>First Name *</label>
              <input type="text" id="fname" placeholder="Your first name">
              <div class="field-error">Please enter your first name.</div>
            </div>
            <div class="form-group" id="fg-lname">
              <label>Last Name *</label>
              <input type="text" id="lname" placeholder="Your last name">
              <div class="field-error">Please enter your last name.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group" id="fg-email">
              <label>Email Address *</label>
              <input type="email" id="email" placeholder="your@email.com">
              <div class="field-error">Please enter a valid email address.</div>
            </div>
            <div class="form-group" id="fg-phone">
              <label>Phone Number *</label>
              <input type="tel" id="phone" placeholder="+977-98XXXXXXXX">
              <div class="field-error">Please enter your phone number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Education Level</label>
              <select id="education">
                <option value="">-- Select level --</option>
                <option>SEE / Class 10</option>
                <option>+2 / A-Levels</option>
                <option>Bachelor's Degree</option>
                <option>Master's Degree</option>
                <option>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>Preferred Destination</label>
              <select id="destination">
                <option value="">-- Select country --</option>
                <option>🇯🇵 Japan</option>
                <option>🇦🇺 Australia</option>
                <option>🇬🇧 United Kingdom</option>
                <option>🇨🇦 Canada</option>
                <option>🇺🇸 United States</option>
                <option>🇳🇿 New Zealand</option>
                <option>Other / Not sure yet</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Service Interested In</label>
            <select id="service">
              <option value="">-- Select a service --</option>
              <option>Admission Guidance</option>
              <option>Study Visa Counseling</option>
              <option>IELTS / PTE Preparation</option>
              <option>Japanese Language Course</option>
              <option>Financial Assistance</option>
              <option>General Inquiry</option>
            </select>
          </div>
          <div class="form-group">
            <label>Additional Notes (optional)</label>
            <textarea id="notes" placeholder="Any specific questions or topics you'd like to discuss during your visit…"></textarea>
          </div>
          <div class="form-check">
            <input type="checkbox" id="consent">
            <label for="consent">I agree to be contacted by HASU Educational Consultancy. My information will not be shared with third parties.</label>
          </div>
          <div class="step-actions">
            <button class="btn-back" id="btn-step3-back">← Back</button>
            <button class="btn-next" id="btn-step3-next">Next: Review →</button>
          </div>
        </div>

        {{-- STEP 4: Review & Confirm --}}
        <div class="step-panel" id="step4">
          <div class="review-block">
            <h4>📍 Branch & Schedule</h4>
            <div class="review-row">
              <div class="rv-icon">🏢</div>
              <div class="rv-text"><strong>Branch</strong><span id="rv-branch">—</span></div>
            </div>
            <div class="review-row">
              <div class="rv-icon">📅</div>
              <div class="rv-text"><strong>Date</strong><span id="rv-date">—</span></div>
            </div>
            <div class="review-row">
              <div class="rv-icon">⏰</div>
              <div class="rv-text"><strong>Time</strong><span id="rv-time">—</span></div>
            </div>
          </div>
          <div class="review-block">
            <h4>👤 Your Information</h4>
            <div class="review-row">
              <div class="rv-icon">🙍</div>
              <div class="rv-text"><strong>Name</strong><span id="rv-name">—</span></div>
            </div>
            <div class="review-row">
              <div class="rv-icon">✉️</div>
              <div class="rv-text"><strong>Email</strong><span id="rv-email">—</span></div>
            </div>
            <div class="review-row">
              <div class="rv-icon">📞</div>
              <div class="rv-text"><strong>Phone</strong><span id="rv-phone">—</span></div>
            </div>
            <div class="review-row">
              <div class="rv-icon">🎯</div>
              <div class="rv-text"><strong>Interested In</strong><span id="rv-service">—</span></div>
            </div>
          </div>
          <div style="font-size:13px;color:var(--text);line-height:1.7;margin-bottom:20px;">
            By confirming, you agree to our <a href="#" style="color:var(--blue)">privacy policy</a>. We'll send a confirmation to your email and a reminder the day before your appointment.
          </div>
          <div class="step-actions">
            <button class="btn-back" id="btn-step4-back">← Back</button>
            <button class="btn-submit" id="btn-submit">✅ Confirm Booking</button>
          </div>
        </div>

        {{-- SUCCESS SCREEN --}}
        <div class="success-screen" id="successScreen">
          <div class="success-icon-wrap">✅</div>
          <h2>Booking Confirmed!</h2>
          <p>Your consultation appointment has been booked. Check your email for a confirmation with full details.</p>
          <div class="ref-number" id="refNumber">HASU-0000</div>
          <div class="success-details">
            <div class="sd-row"><span>Branch</span><span id="sd-branch">—</span></div>
            <div class="sd-row"><span>Date</span><span id="sd-date">—</span></div>
            <div class="sd-row"><span>Time</span><span id="sd-time">—</span></div>
            <div class="sd-row"><span>Name</span><span id="sd-name">—</span></div>
          </div>
          <button class="btn-new" id="btn-reset">Book Another Appointment</button>
        </div>
      </div>

      {{-- ===== SIDEBAR ===== --}}
      <div class="sidebar-col">
        <div class="sidebar-sticky">

          {{-- Live Summary --}}
          <div class="side-card">
            <h4>Booking Summary</h4>
            <div class="summary-list">
              <div class="sl-row">
                <div class="sl-icon">📍</div>
                <div class="sl-text">
                  <strong>Branch</strong>
                  <span id="sum-branch" class="empty">Not selected</span>
                </div>
              </div>
              <div class="sl-row">
                <div class="sl-icon">📅</div>
                <div class="sl-text">
                  <strong>Date</strong>
                  <span id="sum-date" class="empty">Not selected</span>
                </div>
              </div>
              <div class="sl-row">
                <div class="sl-icon">⏰</div>
                <div class="sl-text">
                  <strong>Time</strong>
                  <span id="sum-time" class="empty">Not selected</span>
                </div>
              </div>
              <div class="sl-row">
                <div class="sl-icon">🆓</div>
                <div class="sl-text">
                  <strong>Consultation Fee</strong>
                  <span style="color:#16a34a;font-weight:700">Free</span>
                </div>
              </div>
            </div>
          </div>

          {{-- Branch Map --}}
          <div class="side-card">
            <h4>Branch Location</h4>
            <div class="mini-map-wrap">
              <iframe id="sideMap"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56519.23!2d83.38!3d27.505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3996864c32d4b3f1%3A0xf1eb7a94dba73b72!2sBhairahawa%2C%20Rupandehi!5e0!3m2!1sen!2snp!4v1700000000001!5m2!1sen!2snp"
                allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
            <div class="map-branch-name" id="mapBranchName">🏢 Bhairahawa Headquarters</div>
            <div class="map-branch-addr" id="mapBranchAddr">Birendra Campus Gate, Bhairahawa-11, Rupandehi</div>
          </div>

          {{-- What to Bring --}}
          <div class="side-card">
            <h4>What to Bring</h4>
            <div class="bring-list">
              <div class="bring-item">
                <div class="bring-bullet">1</div>
                <span>Academic transcripts or mark sheets</span>
              </div>
              <div class="bring-item">
                <div class="bring-bullet">2</div>
                <span>Passport (if available)</span>
              </div>
              <div class="bring-item">
                <div class="bring-bullet">3</div>
                <span>IELTS / PTE / Japanese test scores (if taken)</span>
              </div>
              <div class="bring-item">
                <div class="bring-bullet">4</div>
                <span>Any previous visa refusal letters</span>
              </div>
              <div class="bring-item">
                <div class="bring-bullet">5</div>
                <span>List of questions you'd like answered</span>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

{{-- ===== FAQ ===== --}}
<section id="faq-strip" class="section">
  <div class="container">
    <div style="text-align:center;margin-bottom:0" class="fade-up">
      <div class="section-label">{{ $appointmentPage?->faq_label ?: 'Quick Answers' }}</div>
      <h2 class="section-title">{{ $appointmentPage?->faq_title ?: 'Frequently Asked Questions' }}</h2>
      <p class="section-sub" style="margin-bottom:0">{{ $appointmentPage?->faq_subtitle ?: 'Common questions about in-person consultations at HASU.' }}</p>
    </div>
    <div class="faq-grid">
      <div class="faq-item fade-up">
        <div class="faq-q"><span>Is the consultation really free?</span><div class="faq-toggle">+</div></div>
        <div class="faq-a">Yes, the initial in-person consultation at any HASU branch is completely free. There are no hidden charges. Service fees only apply if you proceed with a formal application.</div>
      </div>
      <div class="faq-item fade-up" style="transition-delay:.05s">
        <div class="faq-q"><span>Can I reschedule or cancel my appointment?</span><div class="faq-toggle">+</div></div>
        <div class="faq-a">Yes. Contact us by phone or WhatsApp at least 24 hours before your appointment to reschedule or cancel. We'll do our best to find you the next available slot.</div>
      </div>
      <div class="faq-item fade-up" style="transition-delay:.1s">
        <div class="faq-q"><span>How long does the session take?</span><div class="faq-toggle">+</div></div>
        <div class="faq-a">A typical initial consultation is 45–60 minutes. We cover your academic background, destination options, visa requirements, and answer any specific questions you have.</div>
      </div>
      <div class="faq-item fade-up" style="transition-delay:.15s">
        <div class="faq-q"><span>What if I can't visit in person?</span><div class="faq-toggle">+</div></div>
        <div class="faq-a">We also offer online consultations via Zoom or Google Meet for students outside our branch locations. Contact us on WhatsApp to arrange an online session.</div>
      </div>
      <div class="faq-item fade-up" style="transition-delay:.2s">
        <div class="faq-q"><span>Which branch should I choose?</span><div class="faq-toggle">+</div></div>
        <div class="faq-a">Choose the branch closest to you. All branches provide the same quality of counseling. The Bhairahawa HQ has the most senior counselors and is also open on Saturdays.</div>
      </div>
      <div class="faq-item fade-up" style="transition-delay:.25s">
        <div class="faq-q"><span>Do I need to confirm before visiting?</span><div class="faq-toggle">+</div></div>
        <div class="faq-a">Booking in advance ensures you get a dedicated slot with a counselor. Walk-ins are welcome but may need to wait. We recommend booking at least 24 hours ahead.</div>
      </div>
    </div>
  </div>
</section>

{{-- ===== CTA ===== --}}
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-text fade-up">
        <h2>{{ $appointmentPage?->cta_title ?: 'Have Questions Before Booking?' }}</h2>
        <p>{{ $appointmentPage?->cta_subtitle ?: 'Our team is available on call, email, and WhatsApp to answer any questions before your visit.' }}</p>
        <div class="cta-actions">
          <a href="{{ route('contact') }}" class="btn-cta-primary">Contact Us</a>
          <a href="https://wa.me/9779853646493" target="_blank" class="btn-ghost">💬 WhatsApp Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
(function() {
/* ================================================================
   BRANCH DATA
================================================================ */
const branches = [
  {
    name: 'Bhairahawa Headquarters',
    short: 'Bhairahawa HQ',
    emoji: '🏢',
    address: 'Birendra Campus Gate, Bhairahawa-11, Rupandehi',
    mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56519.23!2d83.38!3d27.505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3996864c32d4b3f1%3A0xf1eb7a94dba73b72!2sBhairahawa%2C%20Rupandehi!5e0!3m2!1sen!2snp!4v1700000000001!5m2!1sen!2snp',
    // Sunday=closed (index 0). busySlots = slot indexes unavailable.
    schedule: { closedDays:[0], busySlots:[1,4] }
  },
  {
    name: 'Kathmandu Branch',
    short: 'Kathmandu',
    emoji: '🏙️',
    address: 'New Baneshwor, Kathmandu, Bagmati Province',
    mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56516.31!2d85.3131!3d27.7172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb198a307baabf%3A0xb96f1f9986b7c3f9!2sKathmandu!5e0!3m2!1sen!2snp!4v1700000000002!5m2!1sen!2snp',
    schedule: { closedDays:[0], busySlots:[0,3,6] }
  },
  {
    name: 'Pokhara Branch',
    short: 'Pokhara',
    emoji: '⛰️',
    address: 'Lakeside, Pokhara-8, Kaski, Gandaki Province',
    mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112968.64!2d83.9564!3d28.2096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3995937bbf0376ff%3A0xf6cf823b25802164!2sPokhara!5e0!3m2!1sen!2snp!4v1700000000003!5m2!1sen!2snp',
    schedule: { closedDays:[0], busySlots:[2,5] }
  },
  {
    name: 'Chitwan Branch',
    short: 'Chitwan',
    emoji: '🌿',
    address: 'Narayangadh, Bharatpur-10, Chitwan',
    mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56604.27!2d84.4322!3d27.6868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3994fb4069a78c65%3A0xd5fc2e29a3d0cb96!2sBharatpur%2C%20Chitwan!5e0!3m2!1sen!2snp!4v1700000000004!5m2!1sen!2snp',
    schedule: { closedDays:[0], busySlots:[1,3] }
  }
];

const ALL_SLOTS = [
  '9:00 AM','10:00 AM','11:00 AM','12:00 PM',
  '2:00 PM','3:00 PM','4:00 PM','5:00 PM'
];
const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const DAYS   = ['Su','Mo','Tu','We','Th','Fr','Sa'];

/* ================================================================
   STATE
================================================================ */
let currentStep     = 1;
let selectedBranch  = 0;
let selectedDate    = null; // {d, m, y}
let selectedTime    = null;

const today = new Date();
let calYear  = today.getFullYear();
let calMonth = today.getMonth();

/* ================================================================
   STEP NAVIGATION
================================================================ */
function goStep(n) {
  // validate step 3 before proceeding to 4
  if (n === 4 && currentStep === 3) {
    if (!validateStep3()) return;
  }
  // require date + time before step 3
  if (n === 3 && (!selectedDate || !selectedTime)) {
    alert('Please select a date and time slot before continuing.'); return;
  }

  document.querySelectorAll('.step-panel').forEach((p, i) => p.classList.toggle('active', i === n - 1));

  document.querySelectorAll('[id^="sind-"]').forEach((el, i) => {
    el.classList.remove('active', 'done');
    if (i < n - 1) { el.classList.add('done'); el.querySelector('.step-circle').textContent = '✓'; }
    else if (i === n - 1) { el.classList.add('active'); el.querySelector('.step-circle').textContent = i + 1; }
    else el.querySelector('.step-circle').textContent = i + 1;
  });

  currentStep = n;
  if (n === 4) populateReview();
  window.scrollTo({ top: document.getElementById('booking-main').offsetTop - 80, behavior: 'smooth' });
}

/* ================================================================
   STEP 1 — BRANCH
================================================================ */
function selectBranch(index, el) {
  selectedBranch = index;
  document.querySelectorAll('.branch-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');

  // update sidebar map
  const b = branches[index];
  document.getElementById('sideMap').src = b.mapSrc;
  document.getElementById('mapBranchName').textContent = b.emoji + ' ' + b.name;
  document.getElementById('mapBranchAddr').textContent = b.address;

  // update live summary
  setSum('sum-branch', b.short);

  // reset date/time when branch changes
  selectedDate = null;
  selectedTime = null;
  setSum('sum-date', null);
  setSum('sum-time', null);
  disableStep2Next();
  renderCal();
}

/* ================================================================
   STEP 2 — CALENDAR
================================================================ */
function renderCal() {
  const grid  = document.getElementById('calGrid');
  const label = document.getElementById('calMonthLabel');
  label.textContent = MONTHS[calMonth] + ' ' + calYear;
  grid.innerHTML = '';

  DAYS.forEach(d => {
    const el = document.createElement('div');
    el.className = 'cal-day-name';
    el.textContent = d;
    grid.appendChild(el);
  });

  const firstDay = new Date(calYear, calMonth, 1).getDay();
  const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
  const branch = branches[selectedBranch];

  for (let i = 0; i < firstDay; i++) {
    const el = document.createElement('div');
    el.className = 'cal-day empty';
    grid.appendChild(el);
  }

  for (let d = 1; d <= daysInMonth; d++) {
    const el   = document.createElement('div');
    const date = new Date(calYear, calMonth, d);
    const dow  = date.getDay();
    const past = date < new Date(today.getFullYear(), today.getMonth(), today.getDate());
    const closed = branch.schedule.closedDays.includes(dow);

    el.className = 'cal-day';
    el.textContent = d;

    if (dow === 0) el.classList.add('sunday');
    if (past || closed) { el.classList.add('past'); }
    if (d === today.getDate() && calMonth === today.getMonth() && calYear === today.getFullYear()) el.classList.add('today');
    if (selectedDate && selectedDate.d === d && selectedDate.m === calMonth && selectedDate.y === calYear) el.classList.add('selected');

    if (!past && !closed) el.addEventListener('click', () => pickDate(d, el));
    grid.appendChild(el);
  }
}

function prevMonth() {
  calMonth--;
  if (calMonth < 0) { calMonth = 11; calYear--; }
  renderCal();
}
function nextMonth() {
  calMonth++;
  if (calMonth > 11) { calMonth = 0; calYear++; }
  renderCal();
}

function pickDate(d, el) {
  document.querySelectorAll('.cal-day').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
  selectedDate = { d, m: calMonth, y: calYear };
  selectedTime = null;

  const dateStr = MONTHS[calMonth] + ' ' + d + ', ' + calYear;
  setSum('sum-date', dateStr);
  setSum('sum-time', null);

  const label = document.getElementById('slotsLabel');
  label.innerHTML = 'Available slots for <strong>' + dateStr + '</strong>';
  renderSlots();
  disableStep2Next();
}

function renderSlots() {
  const container = document.getElementById('timeSlots');
  container.innerHTML = '';
  const branch = branches[selectedBranch];

  ALL_SLOTS.forEach((s, i) => {
    const el  = document.createElement('div');
    const busy = branch.schedule.busySlots.includes(i);
    el.className = 'slot' + (busy ? ' disabled' : '');
    el.innerHTML = busy ? s + '<span>Booked</span>' : s;
    if (!busy) el.addEventListener('click', () => pickSlot(s, el));
    container.appendChild(el);
  });
}

function pickSlot(s, el) {
  document.querySelectorAll('.slot').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
  selectedTime = s;
  setSum('sum-time', s);
  enableStep2Next();
}

function enableStep2Next() {
  const btn = document.getElementById('btn-step2-next');
  btn.disabled = false;
  btn.style.opacity = '1';
  btn.style.pointerEvents = 'auto';
}
function disableStep2Next() {
  const btn = document.getElementById('btn-step2-next');
  btn.disabled = true;
  btn.style.opacity = '.5';
  btn.style.pointerEvents = 'none';
}

/* ================================================================
   STEP 3 — VALIDATE
================================================================ */
function validateStep3() {
  let ok = true;
  const fields = [
    { id:'fg-fname', inputId:'fname' },
    { id:'fg-lname', inputId:'lname' },
    { id:'fg-email', inputId:'email' },
    { id:'fg-phone', inputId:'phone' }
  ];
  fields.forEach(f => {
    const fg  = document.getElementById(f.id);
    const val = document.getElementById(f.inputId).value.trim();
    const empty = !val;
    const emailBad = f.inputId === 'email' && val && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    if (empty || emailBad) {
      fg.classList.add('has-error'); ok = false;
    } else {
      fg.classList.remove('has-error');
    }
  });
  if (!document.getElementById('consent').checked) {
    alert('Please agree to the consent checkbox.'); ok = false;
  }
  return ok;
}

/* ================================================================
   STEP 4 — REVIEW
================================================================ */
function populateReview() {
  const b = branches[selectedBranch];
  const dateStr = selectedDate ? MONTHS[selectedDate.m] + ' ' + selectedDate.d + ', ' + selectedDate.y : '—';
  document.getElementById('rv-branch').textContent  = b.emoji + ' ' + b.name;
  document.getElementById('rv-date').textContent    = dateStr;
  document.getElementById('rv-time').textContent    = selectedTime || '—';
  document.getElementById('rv-name').textContent    = (document.getElementById('fname').value + ' ' + document.getElementById('lname').value).trim();
  document.getElementById('rv-email').textContent   = document.getElementById('email').value;
  document.getElementById('rv-phone').textContent   = document.getElementById('phone').value;
  const svc = document.getElementById('service').value;
  document.getElementById('rv-service').textContent = svc || 'Not specified';
}

/* ================================================================
   SUBMIT
================================================================ */
async function handleSubmit() {
  const btn = document.getElementById('btn-submit');
  btn.textContent = 'Confirming...';
  btn.disabled = true;

  try {
    const b = branches[selectedBranch];
    const dateStr = selectedDate ? MONTHS[selectedDate.m] + ' ' + selectedDate.d + ', ' + selectedDate.y : '-';
    const dateValue = selectedDate ? `${selectedDate.y}-${String(selectedDate.m + 1).padStart(2, '0')}-${String(selectedDate.d).padStart(2, '0')}` : '';

    const response = await fetch('{{ route('book-appointment.submit') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        branch: b.name,
        appointment_date: dateValue,
        appointment_time: selectedTime,
        first_name: document.getElementById('fname').value,
        last_name: document.getElementById('lname').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        education: document.getElementById('education').value,
        destination: document.getElementById('destination').value,
        service: document.getElementById('service').value,
        notes: document.getElementById('notes').value,
        consent: document.getElementById('consent').checked ? 1 : ''
      })
    });

    if (!response.ok) throw new Error('Booking failed');
    const result = await response.json();

    document.getElementById('refNumber').textContent = result.reference;
    document.getElementById('sd-branch').textContent = b.short;
    document.getElementById('sd-date').textContent   = dateStr;
    document.getElementById('sd-time').textContent   = selectedTime;
    document.getElementById('sd-name').textContent   = (document.getElementById('fname').value + ' ' + document.getElementById('lname').value).trim();

    document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('stepsIndicator').style.display = 'none';
    document.querySelector('.booking-card h3').style.display = 'none';
    document.querySelector('.booking-card > p').style.display = 'none';
    document.getElementById('successScreen').style.display = 'block';
  } catch (error) {
    alert('Please check your booking details and try again.');
    btn.textContent = 'Confirm Booking';
    btn.disabled = false;
  }
}
function resetForm() {
  location.reload();
}

/* ================================================================
   LIVE SUMMARY HELPER
================================================================ */
function setSum(id, val) {
  const el = document.getElementById(id);
  if (val) {
    el.textContent = val;
    el.classList.remove('empty');
  } else {
    el.textContent = 'Not selected';
    el.classList.add('empty');
  }
}

/* ================================================================
   FAQ
================================================================ */
function toggleFaq(el) {
  const isOpen = el.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) el.classList.add('open');
}

/* ================================================================
   INIT
================================================================ */
// Set initial summary state
setSum('sum-branch', branches[0].short);

// Render calendar
renderCal();

/* ================================================================
   NAVBAR SCROLL
================================================================ */
const navbar = document.getElementById('navbar');
if (navbar) window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 20));

/* ================================================================
   MOBILE NAV
================================================================ */
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav  = document.getElementById('closeNav');
if (hamburger) hamburger.addEventListener('click', () => mobileNav.classList.add('open'));
if (closeNav)  closeNav.addEventListener('click',  () => mobileNav.classList.remove('open'));
if (mobileNav) mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mobileNav.classList.remove('open')));

/* ================================================================
   SCROLL REVEAL
================================================================ */
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('visible'); revealObserver.unobserve(e.target); }
  });
}, { threshold: 0.05, rootMargin: '0px 0px 0px 0px' });
document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => revealObserver.observe(el));

/* ================================================================
   WIRE BUTTONS — no onclick attributes needed
================================================================ */
function wire(id, fn) {
  const el = document.getElementById(id);
  if (el) el.addEventListener('click', fn);
}

wire('btn-step1-next',  () => goStep(2));
wire('btn-step2-back',  () => goStep(1));
wire('btn-step2-next',  () => goStep(3));
wire('btn-step3-back',  () => goStep(2));
wire('btn-step3-next',  () => goStep(4));
wire('btn-step4-back',  () => goStep(3));
wire('btn-submit',      () => handleSubmit());
wire('btn-reset',       () => resetForm());
wire('btn-prev-month',  () => prevMonth());
wire('btn-next-month',  () => nextMonth());

document.querySelectorAll('.faq-item').forEach(el => {
  el.addEventListener('click', () => toggleFaq(el));
});

document.querySelectorAll('.branch-card').forEach((card, i) => {
  card.addEventListener('click', () => selectBranch(i, card));
});

/* also keep window exports as fallback */
window.goStep        = goStep;
window.selectBranch  = selectBranch;
window.prevMonth     = prevMonth;
window.nextMonth     = nextMonth;
window.handleSubmit  = handleSubmit;
window.resetForm     = resetForm;
window.toggleFaq     = toggleFaq;
window.pickDate      = pickDate;
window.pickSlot      = pickSlot;

})();
</script>
@endpush

