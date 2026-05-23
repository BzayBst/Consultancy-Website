{{-- resources/views/components/frontend/topbar.blade.php --}}
<div class="topbar">
  <div class="topbar-left">
    <a href="mailto:{{ setting('contact_email_primary', 'info@hasuedu.com') }}">
      ✉ {{ setting('contact_email_primary', 'info@hasuedu.com') }}
    </a>
    @if(setting('contact_phone_primary'))
    <a href="tel:{{ preg_replace('/[^+\d]/', '', setting('contact_phone_primary')) }}">
      📞 {{ setting('contact_phone_primary') }}
    </a>
    @endif
    @if(setting('contact_phone_secondary'))
    <a href="tel:{{ preg_replace('/[^+\d]/', '', setting('contact_phone_secondary')) }}">
      📞 {{ setting('contact_phone_secondary') }}
    </a>
    @endif
  </div>
  <div class="topbar-right">
    <a href="#">FAQs</a>
    <a href="#">Privacy Policy</a>
  </div>
</div>