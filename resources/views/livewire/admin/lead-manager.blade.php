<div class="lm-wrap">

{{-- ══ INLINE STYLES — no @push dependency ══════════════════════════════ --}}
<style>
:root {
    --lm-navy:#0d1560; --lm-blue:#2952e3; --lm-blue-lt:#e8edfd;
    --lm-red:#cc2222;  --lm-red-dk:#a81a1a;
    --lm-green:#166534; --lm-green-lt:#dcfce7;
    --lm-amber:#92400e; --lm-amber-lt:#fef3c7;
    --lm-purple:#5b21b6; --lm-purple-lt:#f5f3ff;
    --lm-border:#e2e8f0; --lm-text:#555; --lm-light:#f5f7fb;
    --lm-r:8px; --lm-shadow:0 2px 12px rgba(0,0,0,.07);
}
/* ── Wrap ── */
.lm-wrap { padding:28px 32px; font-family:'DM Sans',system-ui,sans-serif; color:#333; }

/* ── Header ── */
.lm-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
.lm-header h1 { font-family:'Playfair Display',Georgia,serif; font-size:22px; font-weight:700; color:var(--lm-navy); margin:0 0 4px; }
.lm-header p  { font-size:13px; color:var(--lm-text); margin:0; }
.lm-unread-badge { background:var(--lm-red); color:#fff; font-size:12px; font-weight:700; padding:5px 14px; border-radius:20px; animation:lm-pulse 2s infinite; }

/* ── Toast ── */
.lm-toast { position:fixed; top:20px; right:20px; z-index:9999; padding:10px 18px; border-radius:var(--lm-r); font-size:13px; font-weight:500; box-shadow:0 4px 20px rgba(0,0,0,.12); }
.lm-toast--ok  { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
.lm-toast--err { background:#fef2f2; color:#991b1b; border:1px solid #fca5a5; }

/* ── Stat Cards ── */
.lm-stats { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:22px; }
.lm-sc { background:#fff; border:1px solid var(--lm-border); border-radius:var(--lm-r); padding:12px 18px; display:flex; flex-direction:column; min-width:80px; box-shadow:var(--lm-shadow); }
.lm-sc--blue   { background:#eff6ff; border-color:#bfdbfe; }
.lm-sc--amber  { background:#fffbeb; border-color:#fde68a; }
.lm-sc--green  { background:#f0fdf4; border-color:#bbf7d0; }
.lm-sc--purple { background:var(--lm-purple-lt); border-color:#ddd6fe; }
.lm-sc__n { font-size:20px; font-weight:700; color:var(--lm-navy); line-height:1.1; }
.lm-sc--blue   .lm-sc__n { color:#1d4ed8; }
.lm-sc--amber  .lm-sc__n { color:var(--lm-amber); }
.lm-sc--green  .lm-sc__n { color:var(--lm-green); }
.lm-sc--purple .lm-sc__n { color:var(--lm-purple); }
.lm-sc__l { font-size:10px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:.04em; margin-top:3px; }

/* ── Tabs ── */
.lm-tabs { display:flex; gap:2px; border-bottom:2px solid var(--lm-border); margin-bottom:18px; overflow-x:auto; }
.lm-tab  { display:flex; align-items:center; gap:7px; padding:10px 20px; background:none; border:none; font-family:inherit; font-size:13px; font-weight:500; color:var(--lm-text); cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-2px; white-space:nowrap; transition:all .2s; border-radius:6px 6px 0 0; }
.lm-tab:hover  { color:var(--lm-navy); background:var(--lm-light); }
.lm-tab.active { color:var(--lm-navy); border-bottom-color:var(--lm-red); background:#fff; font-weight:700; }
.lm-tab__c { font-size:11px; font-weight:700; background:var(--lm-blue-lt); color:var(--lm-blue); padding:2px 8px; border-radius:20px; }
.lm-tab.active .lm-tab__c { background:#fee2e2; color:var(--lm-red); }

/* ── Filters ── */
.lm-filters { display:flex; gap:8px; align-items:center; flex-wrap:wrap; margin-bottom:18px; }
.lm-search { display:flex; align-items:center; gap:8px; background:#fff; border:1.5px solid var(--lm-border); border-radius:var(--lm-r); padding:8px 14px; transition:border-color .2s; flex:1; min-width:180px; }
.lm-search:focus-within { border-color:var(--lm-blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.lm-search input { border:none; outline:none; font-family:inherit; font-size:13px; color:#333; background:transparent; width:100%; }
.lm-fsel { padding:8px 28px 8px 10px; border:1.5px solid var(--lm-border); border-radius:var(--lm-r); font-family:inherit; font-size:12px; color:#333; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23777'/%3E%3C/svg%3E") no-repeat right 8px center; appearance:none; outline:none; cursor:pointer; transition:border-color .2s; white-space:nowrap; }
.lm-fsel:focus { border-color:var(--lm-blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.lm-date-in { padding:8px 10px; border:1.5px solid var(--lm-border); border-radius:var(--lm-r); font-family:inherit; font-size:12px; color:#555; background:#fff; outline:none; transition:border-color .2s; }
.lm-date-in:focus { border-color:var(--lm-blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.lm-sort-dir { display:flex; align-items:center; justify-content:center; width:34px; height:34px; border:1.5px solid var(--lm-border); border-radius:var(--lm-r); background:#fff; cursor:pointer; color:var(--lm-text); transition:all .2s; }
.lm-sort-dir:hover { border-color:var(--lm-blue); color:var(--lm-blue); }
.lm-btn-reset { padding:8px 14px; border:1.5px solid var(--lm-border); border-radius:var(--lm-r); font-size:12px; font-weight:600; color:var(--lm-text); background:#fff; cursor:pointer; transition:all .2s; white-space:nowrap; }
.lm-btn-reset:hover { border-color:var(--lm-navy); color:var(--lm-navy); }

/* ── Bulk Bar ── */
.lm-bulk { display:flex; align-items:center; gap:10px; background:var(--lm-blue-lt); border:1px solid #c7d7fa; border-radius:var(--lm-r); padding:10px 16px; font-size:13px; margin-bottom:12px; flex-wrap:wrap; }
.lm-bulk__n { font-weight:700; color:var(--lm-blue); }
.lm-bulk-btn { padding:5px 14px; border:1.5px solid #c7d7fa; border-radius:20px; background:#fff; font-size:12px; font-weight:600; color:var(--lm-blue); cursor:pointer; transition:all .2s; white-space:nowrap; font-family:inherit; }
.lm-bulk-btn:hover { background:var(--lm-blue); color:#fff; border-color:var(--lm-blue); }

/* ── Card ── */
.lm-card { background:#fff; border-radius:12px; border:1px solid var(--lm-border); box-shadow:var(--lm-shadow); overflow:visible; }
.lm-card-hd { display:flex; justify-content:space-between; align-items:center; padding:16px 22px 14px; border-bottom:1px solid var(--lm-border); background:var(--lm-light); border-radius:12px 12px 0 0; flex-wrap:wrap; gap:8px; }
.lm-card-hd h2 { font-size:15px; font-weight:700; color:var(--lm-navy); margin:0 0 2px; }
.lm-card-hd p  { font-size:12px; color:var(--lm-text); margin:0; }
.lm-select-bar { display:flex; align-items:center; padding:8px 18px; border-bottom:1px solid var(--lm-border); background:var(--lm-light); }
.lm-chk-lbl { display:flex; align-items:center; gap:8px; font-size:12px; color:var(--lm-text); cursor:pointer; }
.lm-chk { width:14px; height:14px; accent-color:var(--lm-blue); cursor:pointer; }

/* ── List Items ── */
.lm-list { padding:10px 14px 14px; display:flex; flex-direction:column; gap:8px; }
.lm-item { display:grid; grid-template-columns:28px 38px 1fr auto auto; align-items:center; gap:12px; background:#fff; border:1px solid var(--lm-border); border-radius:var(--lm-r); padding:12px 14px; transition:box-shadow .2s, border-color .2s; }
.lm-item:hover { box-shadow:0 3px 14px rgba(0,0,0,.08); border-color:#c7d7fa; }
.lm-item.is-unread { border-left:3px solid var(--lm-blue); background:#fafeff; }
.lm-item.is-active { background:var(--lm-blue-lt) !important; border-color:var(--lm-blue); }

/* Avatar */
.lm-av { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
.lm-av--b { background:#dbeafe; color:#1d4ed8; }
.lm-av--p { background:var(--lm-purple-lt); color:var(--lm-purple); }

/* Item body */
.lm-item-body { min-width:0; }
.lm-item-top  { display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px; }
.lm-iname     { font-size:13px; font-weight:600; color:var(--lm-navy); }
.lm-iname--r  { font-size:13px; color:#374151; }
.lm-item-meta { display:flex; flex-wrap:wrap; gap:8px; font-size:12px; color:#94a3b8; }

/* Pills */
.lm-pill { font-size:10px; font-weight:700; padding:2px 9px; border-radius:20px; white-space:nowrap; }
.lm-pill--contact     { background:#dbeafe; color:#1e40af; }
.lm-pill--appointment { background:var(--lm-purple-lt); color:var(--lm-purple); }
.lm-pill--appt        { background:var(--lm-green-lt); color:var(--lm-green); }

/* Dot */
.lm-dot { display:inline-block; width:8px; height:8px; border-radius:50%; flex-shrink:0; }
.lm-dot--blue   { background:#3b82f6; }
.lm-dot--amber  { background:#f59e0b; }
.lm-dot--purple { background:#8b5cf6; }
.lm-dot--green  { background:#22c55e; }
.lm-dot--gray   { background:#9ca3af; }

/* Status button */
.lm-st-btn { display:flex; align-items:center; gap:5px; background:var(--lm-light); border:1.5px solid var(--lm-border); border-radius:20px; padding:5px 11px; font-size:11px; font-weight:600; color:#374151; cursor:pointer; white-space:nowrap; font-family:inherit; transition:border-color .2s; }
.lm-st-btn:hover { border-color:var(--lm-blue); }

/* Right col */
.lm-item-r { display:flex; flex-direction:column; align-items:flex-end; gap:6px; flex-shrink:0; }
.lm-idate  { font-size:11px; color:#94a3b8; white-space:nowrap; }
.lm-iacts  { display:flex; gap:5px; }
.lm-ibtn { display:flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:var(--lm-r); border:1.5px solid var(--lm-border); background:#fff; color:#9ca3af; cursor:pointer; transition:all .15s; }
.lm-ibtn:hover { border-color:var(--lm-blue); color:var(--lm-blue); background:var(--lm-blue-lt); }
.lm-ibtn--p { color:var(--lm-blue); border-color:#c7d2fe; background:var(--lm-blue-lt); }
.lm-ibtn--p:hover { background:#ddd6fe; }

/* Dropdown */
.lm-dd { position:relative; display:inline-block; }
.lm-dd-menu { position:absolute; z-index:200; top:calc(100% + 4px); left:0; background:#fff; border:1px solid var(--lm-border); border-radius:var(--lm-r); box-shadow:0 8px 24px rgba(0,0,0,.12); min-width:148px; overflow:hidden; }
.lm-dd-item { display:flex; align-items:center; gap:8px; width:100%; padding:9px 14px; font-size:12px; color:#374151; cursor:pointer; border:none; background:none; text-align:left; font-family:inherit; transition:background .1s; }
.lm-dd-item:hover    { background:var(--lm-blue-lt); }
.lm-dd-item.is-sel   { background:var(--lm-blue-lt); color:var(--lm-blue); font-weight:700; }

/* Empty */
.lm-empty { display:flex; flex-direction:column; align-items:center; gap:10px; padding:52px 24px; text-align:center; color:#94a3b8; }
.lm-empty span { font-size:42px; }
.lm-empty p    { font-size:13px; color:var(--lm-text); margin:0; }

/* Pagination */
.lm-pager { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-top:1px solid var(--lm-border); flex-wrap:wrap; gap:8px; }
.lm-pager-info { font-size:12px; color:var(--lm-text); }

/* Loading indicator */
.lm-loading { font-size:12px; color:var(--lm-blue); animation:lm-pulse 1.2s infinite; }

/* ══ SLIDE-OVER ══════════════════════════════════════════════════════ */
.lm-overlay { position:fixed; inset:0; z-index:500; pointer-events:none; display:flex; justify-content:flex-end; }
.lm-overlay--on { pointer-events:all; }
.lm-backdrop { position:absolute; inset:0; background:rgba(13,21,96,.4); opacity:0; transition:opacity .25s; }
.lm-overlay--on .lm-backdrop { opacity:1; }
.lm-panel { position:relative; width:480px; max-width:100vw; height:100%; background:#fff; box-shadow:-8px 0 32px rgba(0,0,0,.12); transform:translateX(100%); transition:transform .28s cubic-bezier(.4,0,.2,1); display:flex; flex-direction:column; overflow-y:auto; }
.lm-panel--on { transform:translateX(0); }

.lm-ph { display:flex; align-items:center; gap:12px; padding:18px 20px 14px; border-bottom:1px solid var(--lm-border); position:sticky; top:0; background:#fff; z-index:1; }
.lm-ph-av { flex-shrink:0; }
.lm-ph-name { font-family:'Playfair Display',Georgia,serif; font-size:17px; font-weight:700; color:var(--lm-navy); margin:0 0 4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.lm-ph-close { margin-left:auto; flex-shrink:0; width:30px; height:30px; border-radius:var(--lm-r); border:1.5px solid var(--lm-border); background:#fff; font-size:14px; color:#94a3b8; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; }
.lm-ph-close:hover { background:var(--lm-light); color:var(--lm-navy); }

.lm-chips { display:flex; flex-wrap:wrap; gap:6px; padding:12px 20px; border-bottom:1px solid var(--lm-border); }
.lm-chip { display:flex; align-items:center; gap:5px; font-size:11px; font-weight:500; padding:4px 11px; border-radius:20px; cursor:pointer; border:1.5px solid var(--lm-border); background:var(--lm-light); color:var(--lm-text); font-family:inherit; transition:all .15s; }
.lm-chip:hover { border-color:var(--lm-blue); }
.lm-chip--on { font-weight:700; border-width:2px; }
.lm-chip--on.lm-chip--blue   { background:#dbeafe; border-color:#3b82f6; color:#1d4ed8; }
.lm-chip--on.lm-chip--amber  { background:var(--lm-amber-lt); border-color:#f59e0b; color:var(--lm-amber); }
.lm-chip--on.lm-chip--purple { background:var(--lm-purple-lt); border-color:#8b5cf6; color:var(--lm-purple); }
.lm-chip--on.lm-chip--green  { background:var(--lm-green-lt); border-color:#22c55e; color:var(--lm-green); }
.lm-chip--on.lm-chip--gray   { background:#f3f4f6; border-color:#9ca3af; color:#374151; }

.lm-psec { padding:14px 20px; border-bottom:1px solid var(--lm-border); }
.lm-psec--last { flex:1; border-bottom:none; }
.lm-psec-t { font-size:10px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.07em; margin:0 0 10px; }
.lm-dl { display:grid; grid-template-columns:110px 1fr; gap:7px 10px; font-size:13px; }
.lm-dl dt { color:#6b7280; font-weight:600; }
.lm-dl dd { color:var(--lm-navy); margin:0; word-break:break-word; }
.lm-plink { color:var(--lm-blue); text-decoration:none; }
.lm-plink:hover { text-decoration:underline; }
.lm-ref { font-family:ui-monospace,monospace; font-size:11px; background:var(--lm-light); padding:2px 6px; border-radius:4px; }
.lm-appt-t { font-weight:600; color:var(--lm-blue); }

.lm-msg { font-size:13px; color:#374151; line-height:1.65; white-space:pre-wrap; background:var(--lm-light); border:1px solid var(--lm-border); border-radius:var(--lm-r); padding:12px 14px; }

.lm-nh { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.lm-btn-addnote { padding:4px 12px; background:var(--lm-blue-lt); color:var(--lm-blue); border:1.5px solid #c7d7fa; border-radius:20px; font-size:11px; font-weight:600; cursor:pointer; font-family:inherit; transition:all .2s; }
.lm-btn-addnote:hover { background:var(--lm-blue); color:#fff; border-color:var(--lm-blue); }
.lm-neditor { background:var(--lm-light); border:1px solid var(--lm-border); border-radius:var(--lm-r); padding:12px; margin-bottom:12px; }
.lm-ta { width:100%; box-sizing:border-box; border:1.5px solid var(--lm-border); border-radius:var(--lm-r); padding:9px 12px; font-size:13px; color:#333; font-family:inherit; resize:vertical; outline:none; transition:border-color .2s; }
.lm-ta:focus { border-color:var(--lm-blue); box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.lm-nacts { display:flex; gap:8px; margin-top:8px; }
.lm-btn-save { padding:7px 16px; background:var(--lm-navy); color:#fff; border:none; border-radius:var(--lm-r); font-size:12px; font-weight:600; cursor:pointer; font-family:inherit; transition:background .2s; }
.lm-btn-save:hover { background:var(--lm-blue); }
.lm-btn-cancel { padding:7px 12px; background:#fff; color:var(--lm-text); border:1.5px solid var(--lm-border); border-radius:var(--lm-r); font-size:12px; font-weight:500; cursor:pointer; font-family:inherit; transition:all .2s; }
.lm-btn-cancel:hover { border-color:var(--lm-navy); }
.lm-nlist { display:flex; flex-direction:column; gap:8px; }
.lm-nentry { background:var(--lm-light); border:1px solid var(--lm-border); border-left:3px solid var(--lm-navy); border-radius:var(--lm-r); padding:10px 12px; }
.lm-nts   { display:block; font-size:11px; color:#94a3b8; margin-bottom:4px; }
.lm-nbody { font-size:12px; color:#374151; margin:0; white-space:pre-wrap; line-height:1.55; }
.lm-btn-clr { margin-top:6px; padding:4px 12px; font-size:11px; font-weight:600; background:#fee2e2; color:var(--lm-red); border:none; border-radius:20px; cursor:pointer; font-family:inherit; transition:all .2s; }
.lm-btn-clr:hover { background:var(--lm-red); color:#fff; }
.lm-nonotes { font-size:13px; color:#94a3b8; margin:0; }

.lm-pfoot { display:flex; align-items:center; gap:8px; padding:14px 20px; border-top:1px solid var(--lm-border); position:sticky; bottom:0; background:#fff; }
.lm-btn-p  { display:inline-flex; align-items:center; gap:5px; padding:8px 16px; background:var(--lm-navy); color:#fff; border:none; border-radius:var(--lm-r); font-size:12px; font-weight:600; text-decoration:none; cursor:pointer; font-family:inherit; transition:background .2s; }
.lm-btn-p:hover { background:var(--lm-blue); }
.lm-btn-o  { display:inline-flex; align-items:center; gap:5px; padding:8px 14px; background:#fff; color:var(--lm-navy); border:1.5px solid var(--lm-border); border-radius:var(--lm-r); font-size:12px; font-weight:600; text-decoration:none; cursor:pointer; font-family:inherit; transition:all .2s; }
.lm-btn-o:hover { border-color:var(--lm-navy); }
.lm-btn-g  { display:inline-flex; align-items:center; padding:8px 12px; background:transparent; color:var(--lm-text); border:1.5px solid transparent; border-radius:var(--lm-r); font-size:12px; font-weight:500; cursor:pointer; font-family:inherit; transition:all .2s; }
.lm-btn-g:hover { background:var(--lm-light); border-color:var(--lm-border); }

.lm-spinner-wrap { display:flex; align-items:center; justify-content:center; flex:1; padding:3rem; }
.lm-spinner { width:26px; height:26px; border:2px solid var(--lm-border); border-top-color:var(--lm-blue); border-radius:50%; animation:lm-spin .7s linear infinite; }

@keyframes lm-spin  { to { transform:rotate(360deg); } }
@keyframes lm-pulse { 0%,100%{opacity:1} 50%{opacity:.65} }

@media(max-width:900px){
    .lm-item { grid-template-columns:24px 34px 1fr auto; }
    .lm-item-r { display:none; }
}
@media(max-width:640px){
    .lm-wrap { padding:16px; }
    .lm-item { grid-template-columns:24px 32px 1fr; gap:8px; }
    .lm-dd, .lm-item-r { display:none; }
    .lm-panel { width:100vw; }
    .lm-stats { gap:6px; }
    .lm-sc { padding:10px 12px; min-width:70px; }
}
</style>

    {{-- ── Header ─────────────────────────────────────────────────────── --}}
    <div class="lm-header">
        <div>
            <h1>Lead Management</h1>
            <p>All contact form submissions and book-consultation requests in one place</p>
        </div>
        @if($stats['unread'] > 0)
            <span class="lm-unread-badge">{{ $stats['unread'] }} unread</span>
        @endif
    </div>

    {{-- ── Toast ──────────────────────────────────────────────────────── --}}
    <div
        x-data="{
            show:false, msg:'', type:'ok',
            init(){
                $wire.on('notify',({message,type})=>{
                    this.msg=message; this.type=type==='success'?'ok':'err';
                    this.show=true; setTimeout(()=>this.show=false,3000);
                });
            }
        }"
        x-show="show"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        :class="'lm-toast lm-toast--'+type"
        style="display:none"
        x-text="msg"
    ></div>

    {{-- ── Stat Cards ─────────────────────────────────────────────────── --}}
    <div class="lm-stats">
        <div class="lm-sc">
            <span class="lm-sc__n">{{ $stats['total'] }}</span>
            <span class="lm-sc__l">Total Leads</span>
        </div>
        <div class="lm-sc lm-sc--blue">
            <span class="lm-sc__n">{{ $stats['new'] }}</span>
            <span class="lm-sc__l">New</span>
        </div>
        <div class="lm-sc lm-sc--amber">
            <span class="lm-sc__n">{{ $stats['unread'] }}</span>
            <span class="lm-sc__l">Unread</span>
        </div>
        <div class="lm-sc lm-sc--green">
            <span class="lm-sc__n">{{ $stats['converted'] }}</span>
            <span class="lm-sc__l">Converted</span>
        </div>
        <div class="lm-sc lm-sc--purple">
            <span class="lm-sc__n">{{ $stats['appointments'] }}</span>
            <span class="lm-sc__l">Consultations</span>
        </div>
        <div class="lm-sc">
            <span class="lm-sc__n">{{ $stats['contacts'] }}</span>
            <span class="lm-sc__l">Contact Forms</span>
        </div>
        <div class="lm-sc">
            <span class="lm-sc__n">{{ $stats['today'] }}</span>
            <span class="lm-sc__l">Today</span>
        </div>
    </div>

    {{-- ── Tabs ────────────────────────────────────────────────────────── --}}
    <div class="lm-tabs">
        @foreach([
            ['key'=>'all',          'icon'=>'📋', 'label'=>'All Leads',      'n'=>$stats['total']],
            ['key'=>'contacts',     'icon'=>'✉️', 'label'=>'Contact Forms',  'n'=>$stats['contacts']],
            ['key'=>'appointments', 'icon'=>'📅', 'label'=>'Consultations',  'n'=>$stats['appointments']],
        ] as $t)
        <button wire:click="setTab('{{ $t['key'] }}')" class="lm-tab {{ $activeTab===$t['key']?'active':'' }}">
            {{ $t['icon'] }} {{ $t['label'] }}
            <span class="lm-tab__c">{{ $t['n'] }}</span>
        </button>
        @endforeach
    </div>

    {{-- ── Filters ─────────────────────────────────────────────────────── --}}
    <div class="lm-filters">
        <div class="lm-search">
            <span>🔍</span>
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search name, email, phone…">
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <select wire:model.live="statusFilter" class="lm-fsel">
                <option value="">All Statuses</option>
                @foreach($statuses as $k=>$m) <option value="{{ $k }}">{{ $m['label'] }}</option> @endforeach
            </select>
            @if(count($availableServices))
            <select wire:model.live="serviceFilter" class="lm-fsel">
                <option value="">All Services</option>
                @foreach($availableServices as $s) <option value="{{ $s }}">{{ $s }}</option> @endforeach
            </select>
            @endif
            @if(count($availableDestinations))
            <select wire:model.live="destinationFilter" class="lm-fsel">
                <option value="">All Destinations</option>
                @foreach($availableDestinations as $d) <option value="{{ $d }}">{{ $d }}</option> @endforeach
            </select>
            @endif
            <input wire:model.live="dateFrom" type="date" class="lm-date-in" title="From">
            <input wire:model.live="dateTo"   type="date" class="lm-date-in" title="To">
            <select wire:change="sortBy($event.target.value)" class="lm-fsel">
                <option value="created_at" {{ $sortBy==='created_at'?'selected':'' }}>Sort: Date</option>
                <option value="first_name" {{ $sortBy==='first_name'?'selected':'' }}>Sort: Name</option>
                <option value="status"     {{ $sortBy==='status'?'selected':'' }}>Sort: Status</option>
            </select>
            <button wire:click="sortBy('{{ $sortBy }}')" class="lm-sort-dir" title="Toggle direction">
                @if($sortDir==='desc')
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"><path stroke-linecap="round" d="M8 3v10M4 9l4 4 4-4"/></svg>
                @else
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"><path stroke-linecap="round" d="M8 13V3M4 7l4-4 4 4"/></svg>
                @endif
            </button>
            <button wire:click="resetFilters" class="lm-btn-reset">↺ Reset</button>
            <div wire:loading class="lm-loading">Loading…</div>
        </div>
    </div>

    {{-- ── Bulk Bar ─────────────────────────────────────────────────────── --}}
    @if(count($selected))
    <div class="lm-bulk" wire:key="bulk-bar">
        <span class="lm-bulk__n">{{ count($selected) }} selected</span>
        <button wire:click="bulkMarkRead" class="lm-bulk-btn">✅ Mark Read</button>
        <div x-data="{open:false}" style="position:relative">
            <button @click="open=!open" class="lm-bulk-btn">Set Status ▾</button>
            <div x-show="open" @click.outside="open=false" class="lm-dd-menu" style="display:none">
                @foreach($statuses as $k=>$m)
                <button wire:click="bulkUpdateStatus('{{ $k }}')" @click="open=false" class="lm-dd-item">
                    <span class="lm-dot lm-dot--{{ $m['color'] }}"></span>{{ $m['label'] }}
                </button>
                @endforeach
            </div>
        </div>
        <button wire:click="$set('selected',[])" class="lm-bulk-btn" style="margin-left:auto">✕ Clear</button>
    </div>
    @endif

    {{-- ── Lead Card ───────────────────────────────────────────────────── --}}
    <div class="lm-card">
        <div class="lm-card-hd">
            <div>
                <h2>{{ $activeTab==='all'?'All Leads':($activeTab==='contacts'?'Contact Form Submissions':'Consultation Bookings') }}</h2>
                <p>Click any row to view full details · toggle read status · update pipeline stage</p>
            </div>
        </div>

        @if($leads->isEmpty())
        <div class="lm-empty">
            <span>📭</span>
            <p>No leads match your current filters.</p>
            <button wire:click="resetFilters" style="padding:7px 16px;border:1.5px solid var(--lm-border);border-radius:var(--lm-r);font-size:12px;font-weight:600;color:var(--lm-navy);background:#fff;cursor:pointer;">Reset Filters</button>
        </div>
        @else

        <div class="lm-select-bar">
            <label class="lm-chk-lbl">
                <input type="checkbox" wire:model.live="selectAll" class="lm-chk">
                Select all on this page
            </label>
        </div>

        <div class="lm-list">
        @foreach($leads as $lead)
        @php
            $rk    = "{$lead['type']}:{$lead['id']}";
            $isAct = $selectedId===$lead['id'] && $selectedType===$lead['type'];
            $clr   = $statuses[$lead['status']]['color'] ?? 'gray';
        @endphp
        <div
            wire:key="{{ $rk }}"
            class="lm-item {{ !$lead['is_read']?'is-unread':'' }} {{ $isAct?'is-active':'' }}"
            wire:click="openDetail({{ $lead['id'] }},'{{ $lead['type'] }}')"
            style="cursor:pointer"
        >
            {{-- Checkbox --}}
            <div wire:click.stop style="display:flex;align-items:center">
                <input type="checkbox" wire:model.live="selected" value="{{ $rk }}" class="lm-chk">
            </div>

            {{-- Avatar --}}
            <div class="lm-av lm-av--{{ $lead['type']==='contact'?'b':'p' }}">
                {{ strtoupper(substr($lead['first_name'],0,1)) }}{{ strtoupper(substr($lead['last_name'],0,1)) }}
            </div>

            {{-- Body --}}
            <div class="lm-item-body">
                <div class="lm-item-top">
                    @if(!$lead['is_read'])
                        <strong class="lm-iname">{{ $lead['full_name'] }}</strong>
                    @else
                        <span class="lm-iname--r">{{ $lead['full_name'] }}</span>
                    @endif
                    <span class="lm-pill lm-pill--{{ $lead['type'] }}">{{ $lead['type_label'] }}</span>
                    @if($lead['type']==='appointment' && $lead['appointment_date'])
                        <span class="lm-pill lm-pill--appt">📅 {{ $lead['appointment_date'] }}</span>
                    @endif
                    @if(!$lead['is_read'])
                        <span style="width:7px;height:7px;border-radius:50%;background:var(--lm-blue);display:inline-block;flex-shrink:0"></span>
                    @endif
                </div>
                <div class="lm-item-meta">
                    <span>✉️ {{ $lead['email'] }}</span>
                    @if($lead['phone'])      <span>📞 {{ $lead['phone'] }}</span>      @endif
                    @if($lead['service'])    <span>🎯 {{ $lead['service'] }}</span>    @endif
                    @if($lead['destination'])<span>🌏 {{ $lead['destination'] }}</span>@endif
                </div>
            </div>

            {{-- Status dropdown --}}
            <div wire:click.stop>
                <div x-data="{open:false}" class="lm-dd">
                    <button @click="open=!open" class="lm-st-btn">
                        <span class="lm-dot lm-dot--{{ $clr }}"></span>
                        {{ $statuses[$lead['status']]['label'] ?? 'New' }}
                        <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="9" height="9"><path stroke-linecap="round" d="M2 3.5l3 3 3-3"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open=false" class="lm-dd-menu" style="display:none">
                        @foreach($statuses as $k=>$m)
                        <button
                            wire:click="updateStatus({{ $lead['id'] }},'{{ $lead['type'] }}','{{ $k }}')"
                            @click="open=false"
                            class="lm-dd-item {{ $lead['status']===$k?'is-sel':'' }}"
                        ><span class="lm-dot lm-dot--{{ $m['color'] }}"></span>{{ $m['label'] }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Date + actions --}}
            <div class="lm-item-r">
                <span class="lm-idate">{{ $lead['created_at']?->diffForHumans() }}</span>
                <div class="lm-iacts" wire:click.stop>
                    <button wire:click="toggleRead({{ $lead['id'] }},'{{ $lead['type'] }}')" class="lm-ibtn" title="{{ $lead['is_read']?'Mark unread':'Mark read' }}">
                        @if($lead['is_read'])
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path stroke-linecap="round" d="M3 8l7 5 7-5M3 8v8a1 1 0 001 1h12a1 1 0 001-1V8"/></svg>
                        @else
                            <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        @endif
                    </button>
                    <button wire:click="openDetail({{ $lead['id'] }},'{{ $lead['type'] }}')" class="lm-ibtn lm-ibtn--p" title="View details">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2v-1m-4-9h2m2 0a2 2 0 012 2v1m-4-3V4a1 1 0 011-1h2a1 1 0 011 1v1m-4 0h4"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        </div>

        @if($leads->hasPages())
        <div class="lm-pager">
            <span class="lm-pager-info">Showing {{ $leads->firstItem() }}–{{ $leads->lastItem() }} of {{ $leads->total() }}</span>
            {{ $leads->links() }}
        </div>
        @endif
        @endif
    </div>


    {{-- ══ DETAIL SLIDE-OVER ══════════════════════════════════════════════ --}}
    <div
        x-data
        class="lm-overlay {{ $showDetail ? 'lm-overlay--on' : '' }}"
        @keydown.escape.window="$wire.closeDetail()"
    >
        <div class="lm-backdrop" wire:click="closeDetail"></div>
        <div class="lm-panel {{ $showDetail ? 'lm-panel--on' : '' }}">

        @if($selectedLead)
        @php $lead=$selectedLead; $clr=$statuses[$lead['status']]['color']??'gray'; @endphp

        {{-- Head --}}
        <div class="lm-ph">
            <div class="lm-av lm-av--{{ $lead['type']==='contact'?'b':'p' }} lm-ph-av" style="width:44px;height:44px;font-size:14px">
                {{ strtoupper(substr($lead['first_name'],0,1)) }}{{ strtoupper(substr($lead['last_name'],0,1)) }}
            </div>
            <div style="flex:1;min-width:0">
                <div class="lm-ph-name">{{ $lead['full_name'] }}</div>
                <span class="lm-pill lm-pill--{{ $lead['type'] }}">{{ $lead['type_label'] }}</span>
            </div>
            <button wire:click="closeDetail" class="lm-ph-close" title="Close">✕</button>
        </div>

        {{-- Status chips --}}
        <div class="lm-chips">
            @foreach($statuses as $k=>$m)
            <button
                wire:click="updateStatus({{ $lead['id'] }},'{{ $lead['type'] }}','{{ $k }}')"
                class="lm-chip {{ $lead['status']===$k?'lm-chip--on lm-chip--'.$m['color']:'' }}"
            ><span class="lm-dot lm-dot--{{ $m['color'] }}"></span>{{ $m['label'] }}</button>
            @endforeach
        </div>

        {{-- Contact info --}}
        <div class="lm-psec">
            <h3 class="lm-psec-t">Contact Information</h3>
            <dl class="lm-dl">
                <dt>Email</dt>   <dd><a href="mailto:{{ $lead['email'] }}" class="lm-plink">{{ $lead['email'] }}</a></dd>
                @if($lead['phone'])
                <dt>Phone</dt>   <dd><a href="tel:{{ $lead['phone'] }}" class="lm-plink">{{ $lead['phone'] }}</a></dd>
                @endif
                @if($lead['destination'])
                <dt>Destination</dt><dd>{{ $lead['destination'] }}</dd>
                @endif
                @if($lead['service'])
                <dt>Service</dt><dd>{{ $lead['service'] }}</dd>
                @endif
                <dt>Received</dt><dd>{{ $lead['created_at']?->format('M j, Y \a\t g:i A') }}</dd>
            </dl>
        </div>

        {{-- Appointment details --}}
        @if($lead['type']==='appointment')
        <div class="lm-psec">
            <h3 class="lm-psec-t">Consultation Details</h3>
            <dl class="lm-dl">
                @if($lead['reference']) <dt>Reference</dt><dd><span class="lm-ref">{{ $lead['reference'] }}</span></dd> @endif
                @if($lead['branch'])    <dt>Branch</dt>   <dd>{{ $lead['branch'] }}</dd> @endif
                @if($lead['appointment_date'])
                <dt>Date &amp; Time</dt>
                <dd><span class="lm-appt-t">📅 {{ $lead['appointment_date'] }}{{ $lead['appointment_time']?' · '.$lead['appointment_time']:'' }}</span></dd>
                @endif
                @if($lead['education']) <dt>Education</dt><dd>{{ $lead['education'] }}</dd> @endif
            </dl>
        </div>
        @endif

        {{-- Message --}}
        @if($lead['message'])
        <div class="lm-psec">
            <h3 class="lm-psec-t">{{ $lead['type']==='contact'?'Message':'Notes from Client' }}</h3>
            <div class="lm-msg">{{ $lead['message'] }}</div>
        </div>
        @endif

        {{-- Internal notes --}}
        <div class="lm-psec lm-psec--last">
            <div class="lm-nh">
                <h3 class="lm-psec-t" style="margin:0">Internal Notes</h3>
                <button wire:click="$set('editingNote',true)" class="lm-btn-addnote">+ Add Note</button>
            </div>

            @if($editingNote)
            <div class="lm-neditor">
                <textarea wire:model="newNote" class="lm-ta" rows="4" placeholder="Write an internal note…" autofocus></textarea>
                <div class="lm-nacts">
                    <button wire:click="saveNote" class="lm-btn-save">💾 Save</button>
                    <button wire:click="$set('editingNote',false)" class="lm-btn-cancel">Cancel</button>
                </div>
            </div>
            @endif

            @if($lead['notes'])
            <div class="lm-nlist">
                @foreach(array_filter(explode("\n\n",$lead['notes'])) as $note)
                @php preg_match('/^\[(.+?)\]\n(.+)$/s',trim($note),$m); $ts=$m[1]??null; $body=$m[2]??trim($note); @endphp
                <div class="lm-nentry">
                    @if($ts)<span class="lm-nts">{{ $ts }}</span>@endif
                    <p class="lm-nbody">{{ $body }}</p>
                </div>
                @endforeach
                <button wire:click="deleteNote({{ $lead['id'] }},'{{ $lead['type'] }}')" wire:confirm="Clear all notes?" class="lm-btn-clr">🗑 Clear all notes</button>
            </div>
            @elseif(!$editingNote)
            <p class="lm-nonotes">No internal notes yet.</p>
            @endif
        </div>

        {{-- Footer --}}
        <div class="lm-pfoot">
            <a href="mailto:{{ $lead['email'] }}" class="lm-btn-p">✉️ Send Email</a>
            @if($lead['phone'])
            <a href="tel:{{ $lead['phone'] }}" class="lm-btn-o">📞 Call</a>
            @endif
            <button wire:click="toggleRead({{ $lead['id'] }},'{{ $lead['type'] }}')" class="lm-btn-g" style="margin-left:auto">
                {{ $lead['is_read']?'⭕ Mark Unread':'✅ Mark Read' }}
            </button>
        </div>

        @else
        <div class="lm-spinner-wrap"><div class="lm-spinner"></div></div>
        @endif

        </div>
    </div>

</div>
