<style>
.sa-wrap { padding:24px; }
.sa-header { display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:18px; }
.sa-header h1 { font-family:'Playfair Display',serif;font-size:28px;color:var(--navy);margin:0 0 4px; }
.sa-header p { color:var(--text);font-size:14px;margin:0; }
.sa-header-actions { display:flex;gap:10px;flex-wrap:wrap; }
.btn-preview,.btn-add,.btn-save,.btn-cancel,.btn-confirm-delete,.btn-confirm-restore { border:none;border-radius:8px;padding:10px 16px;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer; }
.btn-preview { background:#fff;color:var(--navy);border:1px solid var(--border); }
.btn-add { background:var(--navy);color:#fff; }
.btn-save { background:var(--red);color:#fff; }
.btn-cancel { background:#f1f5f9;color:var(--navy); }
.btn-confirm-delete,.btn-delete-confirm { background:var(--red);color:#fff; }
.btn-confirm-restore,.btn-restore,.btn-restore-confirm { background:#dcfce7;color:#166534; }
.alert-success { background:#dcfce7;color:#166534;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px; }
.sa-tabs,.destination-subtabs { display:flex;gap:4px;border-bottom:2px solid var(--border);margin-bottom:20px;overflow-x:auto; }
.sa-tab,.destination-subtab { border:none;background:transparent;padding:11px 20px;border-bottom:2px solid transparent;margin-bottom:-2px;border-radius:7px 7px 0 0;color:var(--text);font-weight:700;cursor:pointer;white-space:nowrap; }
.sa-tab.active,.destination-subtab.active { color:var(--navy);background:#fff;border-bottom-color:var(--red); }
.sa-tab span { background:#e8edfd;color:var(--blue);border-radius:999px;padding:2px 8px;font-size:11px;margin-left:6px; }
.sa-card { background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 4px 14px rgba(15,23,42,.05);margin-bottom:18px;overflow:hidden; }
.sa-card-header { padding:18px 22px;border-bottom:1px solid var(--border);background:#f8fafc; }
.sa-card-header.with-action { display:flex;align-items:center;justify-content:space-between;gap:12px; }
.sa-card-header h2 { margin:0 0 3px;color:var(--navy);font-size:17px; }
.sa-card-header p { margin:0;color:var(--text);font-size:13px; }
.sa-preview { margin:20px 22px 0;padding:20px;border-radius:10px;background:var(--navy);color:#fff; }
.sa-preview span { display:block;color:#ffcccc;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:2px;margin-bottom:8px; }
.sa-preview strong { display:block;font-family:'Playfair Display',serif;font-size:24px;margin-bottom:8px; }
.sa-preview p { color:rgba(255,255,255,.78);margin:0; }
.form-grid { display:grid;grid-template-columns:1fr 1fr;gap:14px 18px;padding:22px; }
.form-grid.no-pad { padding:0; }
.form-group { display:flex;flex-direction:column;gap:6px;margin-bottom:14px; }
.form-group.full,.full { grid-column:1/-1; }
.form-group label { color:var(--navy);font-size:13px;font-weight:800; }
.form-group label span { color:var(--red); }
.form-group input,.form-group textarea,.form-group select,.sa-filters select { border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font:inherit;outline:none;background:#fff; }
.form-group textarea { resize:vertical;line-height:1.5; }
.form-group input:focus,.form-group textarea:focus,.form-group select:focus { border-color:var(--blue);box-shadow:0 0 0 3px rgba(41,82,227,.1); }
.form-group small,.upload-error { color:var(--red);font-size:12px; }
.form-error-summary { background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;padding:11px 13px;margin-bottom:16px;font-size:13px;font-weight:700; }
.sa-actions { display:flex;justify-content:flex-end;margin-top:-4px; }
.sa-filters { display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:16px; }
.sa-search { flex:1;min-width:240px;background:#fff;border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;gap:10px;padding:9px 12px; }
.sa-search span { font-size:12px;font-weight:800;color:var(--navy); }
.sa-search input { flex:1;border:none;outline:none;font:inherit;background:transparent; }
.sa-list { display:flex;flex-direction:column;gap:10px; }
.sa-row { display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:10px;padding:13px 14px;box-shadow:0 4px 14px rgba(15,23,42,.04); }
.sa-row.is-trashed { opacity:.65;background:#fff5f5; }
.sa-thumb { width:92px;height:62px;border-radius:8px;overflow:hidden;background:#e8edfd;color:var(--navy);display:flex;align-items:center;justify-content:center;font-weight:800;flex-shrink:0; }
.sa-thumb img { width:100%;height:100%;object-fit:cover; }
.sa-row-body { flex:1;min-width:0; }
.sa-row-body strong { color:var(--navy);font-size:15px;display:block;margin-bottom:3px; }
.sa-row-body p { color:var(--text);font-size:13px;margin:0 0 3px; }
.sa-row-body small { color:#64748b;font-size:11px; }
.sa-row-actions { display:flex;align-items:center;gap:6px;flex-wrap:wrap;justify-content:flex-end; }
.sa-row-actions button,.btn-link { border:none;border-radius:7px;padding:7px 10px;font-size:12px;font-weight:800;cursor:pointer;text-decoration:none; }
.btn-link { background:#fff;color:var(--navy);border:1px solid var(--border); }
.btn-toggle.on { background:#dcfce7;color:#166534; }
.btn-toggle.off { background:#fee2e2;color:#991b1b; }
.btn-edit { background:#e8edfd;color:var(--blue); }
.btn-delete { background:#fee2e2;color:var(--red); }
.trashed-label { color:#991b1b;font-size:12px;font-weight:800; }
.sa-empty,.repeat-empty { background:#fff;border:1px dashed var(--border);border-radius:10px;padding:28px;text-align:center;color:#64748b; }
.sa-empty { display:flex;flex-direction:column;gap:5px; }
.sa-empty strong { color:var(--navy); }
.sa-pagination { background:#fff;border:1px solid var(--border);border-radius:8px;margin-top:14px;padding:12px 16px; }
.modal-backdrop { position:fixed;inset:0;z-index:1000;background:rgba(13,21,96,.45);display:flex;align-items:center;justify-content:center;padding:20px; }
.modal-box,.confirm-box { background:#fff;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:100%; }
.modal-box { max-width:980px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column; }
.modal-box form { display:flex;flex-direction:column;flex:1;min-height:0; }
.confirm-box { max-width:390px;padding:24px;text-align:center; }
.confirm-box h2 { font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin-bottom:8px; }
.confirm-box p { color:var(--text);font-size:14px;line-height:1.5;margin-bottom:18px; }
.confirm-actions { display:flex;justify-content:center;gap:10px; }
.confirm-actions button { border:none;border-radius:8px;padding:10px 14px;font-weight:800;cursor:pointer; }
.modal-head,.modal-foot { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;border-bottom:1px solid var(--border); }
.modal-foot { justify-content:flex-end;border-top:1px solid var(--border);border-bottom:0; }
.modal-head h2 { font-family:'Playfair Display',serif;color:var(--navy);font-size:20px;margin:0; }
.modal-close { border:none;background:#f1f5f9;border-radius:6px;width:30px;height:30px;cursor:pointer;color:var(--navy); }
.modal-head,.modal-foot { flex-shrink:0; }
.modal-body { padding:20px;overflow-y:auto;flex:1;min-height:0; }
.modal-section-title { color:var(--navy);font-size:14px;font-weight:900;margin:8px 0 14px;padding-bottom:8px;border-bottom:1px solid var(--border); }
.modal-section-title.with-action { display:flex;align-items:center;justify-content:space-between;gap:12px; }
.btn-add-inline { border:none;border-radius:7px;background:var(--navy);color:#fff;padding:8px 12px;font-size:12px;font-weight:800;cursor:pointer; }
.upload-box { border:2px dashed var(--border);border-radius:10px;min-height:190px;display:flex;align-items:center;justify-content:center;text-align:center;cursor:pointer;overflow:hidden;position:relative;background:#f8fafc;margin:8px 0 18px; }
.upload-box:hover { border-color:var(--blue);background:#eef3ff; }
.upload-box img { width:100%;height:230px;object-fit:contain;padding:10px; }
.upload-box input { position:absolute;inset:0;opacity:0;cursor:pointer; }
.upload-box strong { display:block;color:var(--navy);margin-bottom:4px; }
.upload-box span,.uploading { color:#64748b;font-size:12px; }
.toggle-row { display:flex;align-items:center;gap:9px;margin-top:16px;color:var(--navy);font-size:14px;font-weight:700; }
.repeat-list { display:flex;flex-direction:column;gap:12px;padding:22px; }
.subtab-panel .repeat-list { padding:0; }
.repeat-card { border:1px solid var(--border);border-radius:10px;padding:14px;background:#f8fafc; }
.repeat-head { display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px; }
.repeat-head strong { color:var(--navy);font-size:14px; }
.repeat-head button { border:none;background:#fee2e2;color:var(--red);border-radius:7px;padding:6px 10px;font-size:12px;font-weight:800;cursor:pointer; }
@media(max-width:760px){
  .sa-wrap { padding:16px; }
  .sa-header,.sa-row { align-items:flex-start;flex-direction:column; }
  .form-grid { grid-template-columns:1fr; }
  .sa-row-actions { justify-content:flex-start; }
}
</style>
