{{-- resources/views/pages/about.blade.php --}}
@extends('layouts.app', ['active' => 'about'])

@section('title', 'About Us – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description', 'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why thousands of Nepali students trust us.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<x-frontend.page-hero
    badge="Est. {{ setting('general_established', '2013') }} · Chitwan, Nepal"
    title="Your Trusted Partner in"
    highlight="Global Education"
    subtitle="For over a decade, HASU Educational Consultancy has been guiding Nepali students toward world-class academic opportunities and brighter futures."
    :breadcrumbs="[['label'=>'Home','url'=> route('home')], ['label'=>'About Us']]"
/>



{{-- ===== OUR STORY ===== --}}
<section id="story" class="section">
  <div class="container">
    <div class="story-inner">
      <div class="story-img-wrap fade-up">
        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b6175?w=700&q=80" alt="HASU Office">
        <div class="story-img-float">
          <div class="icon">🏆</div>
          <div>
            <strong>Best Consultancy</strong>
            <small>Bhairahawa Region, 2023</small>
          </div>
        </div>
        <div class="story-exp-badge">
          <strong>{{ date('Y') - (int)setting('general_established','2013') }}</strong>
          <span>Years of Excellence</span>
        </div>
      </div>
      <div class="story-content fade-up" style="transition-delay:.15s">
        <div class="section-label">Our Story</div>
        <h2 class="section-title">How HASU Began Its Journey</h2>
        <p>Founded in {{ setting('general_established','2013') }} and officially registered in 2015, HASU International Educational Pvt. Ltd. started with a single mission: make world-class education accessible to every Nepali student. From a small office in Bhairahawa, we have grown into one of the most trusted educational consultancies in the region.</p>
        <p>We specialize in guiding students to top universities in Japan, Australia, Canada, the USA, UK, and New Zealand — providing comprehensive support from counseling and application to visa processing and pre-departure orientation.</p>
        <div class="story-milestones">
          @php
          $milestones = [
            ['year'=>'2013','title'=>'Founded by Educational Visionaries','desc'=>'HASU was established with a vision to bridge the gap between Nepali students and global universities.'],
            ['year'=>'2015','title'=>'Officially Registered & Expanded','desc'=>'Received official government registration and expanded services to include Japanese language training.'],
            ['year'=>'2018','title'=>'Launched HASU Language Institute','desc'=>'Opened a dedicated language training center for NAT, JLPT, J-TEST, IELTS, and PTE preparation.'],
            ['year'=>'2024','title'=>'5,000+ Students Successfully Placed','desc'=>'Crossed the milestone of placing over five thousand students in universities across 10+ countries.'],
          ];
          @endphp
          @foreach($milestones as $m)
          <div class="milestone">
            <div class="milestone-year">{{ $m['year'] }}</div>
            <div class="milestone-info">
              <h5>{{ $m['title'] }}</h5>
              <p>{{ $m['desc'] }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== STATS ROW ===== --}}
<section id="stats">
  <div class="container" style="padding:0 24px">
    <div class="stats-inner">
      <div class="stat-item fade-up">
        <span class="stat-num">{{ date('Y') - (int)setting('general_established','2013') }}<span class="accent">+</span></span>
        <span class="stat-label">Years of Experience</span>
      </div>
      <div class="stat-item fade-up" style="transition-delay:.1s">
        <span class="stat-num">5000<span class="accent">+</span></span>
        <span class="stat-label">Students Placed Abroad</span>
      </div>
      <div class="stat-item fade-up" style="transition-delay:.2s">
        <span class="stat-num">98<span class="accent">%</span></span>
        <span class="stat-label">Visa Success Rate</span>
      </div>
      <div class="stat-item fade-up" style="transition-delay:.3s">
        <span class="stat-num">10<span class="accent">+</span></span>
        <span class="stat-label">Destination Countries</span>
      </div>
    </div>
  </div>
</section>

{{-- ===== MISSION VISION ===== --}}
<section id="mission" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Who We Are</div>
      <h2 class="section-title">Mission, Vision & Purpose</h2>
      <p class="section-sub">Everything we do is guided by a commitment to student success, integrity, and global opportunity.</p>
    </div>
    <div class="mv-grid">
      <div class="mv-card fade-up">
        <div class="mv-icon">🎯</div>
        <h3>Our Mission</h3>
        <p>To empower Nepali students with genuine, expert guidance that opens doors to world-class universities — making study abroad accessible, affordable, and achievable for every aspiring learner.</p>
      </div>
      <div class="mv-card fade-up" style="transition-delay:.1s">
        <div class="mv-icon">🔭</div>
        <h3>Our Vision</h3>
        <p>To be Nepal's most trusted educational consultancy — known for transforming student dreams into global realities through transparent processes, expert counseling, and unwavering dedication.</p>
      </div>
      <div class="mv-card fade-up" style="transition-delay:.2s">
        <div class="mv-icon">🌐</div>
        <h3>Our Purpose</h3>
        <p>We believe every student deserves access to the best education the world has to offer. We exist to break down barriers — geographic, financial, and informational — standing between students and their potential.</p>
      </div>
    </div>
  </div>
</section>

{{-- ===== WHY CHOOSE US ===== --}}
<section id="why-us">
  <div class="container">
    <div class="why-inner">
      <div class="why-left fade-up">
        <div class="section-label">Why Choose HASU</div>
        <h2 class="section-title" style="color:#fff">Reasons Students Trust Us</h2>
        <p>With over a decade of experience and thousands of successful placements, HASU stands apart from the rest. We don't just process applications — we build futures.</p>
        <div class="why-features">
          @php $whyFeats = [
            ['icon'=>'✅','title'=>'100% Genuine Assistance','desc'=>'No false promises. Every piece of advice we give is honest, verified, and in your best interest.'],
            ['icon'=>'⚡','title'=>'Fast & Reliable Execution','desc'=>'We process applications swiftly and accurately, never missing critical deadlines or intake windows.'],
            ['icon'=>'🏅','title'=>'Expert Team','desc'=>'Our counselors are certified specialists with first-hand knowledge of destination countries.'],
            ['icon'=>'🤝','title'=>'End-to-End Support','desc'=>'From first consultation to pre-departure briefing, we are by your side every single step.'],
            ['icon'=>'🛂','title'=>'High Visa Success Rate','desc'=>'Our meticulous document preparation and strategic counseling ensure a 98% visa approval rate.'],
            ['icon'=>'🌏','title'=>'Global University Network','desc'=>'Official partnerships with leading universities across Japan, Australia, UK, Canada, USA, and more.'],
          ]; @endphp
          @foreach($whyFeats as $feat)
          <div class="why-feat">
            <div class="why-feat-icon">{{ $feat['icon'] }}</div>
            <h5>{{ $feat['title'] }}</h5>
            <p>{{ $feat['desc'] }}</p>
          </div>
          @endforeach
        </div>
      </div>
      <div class="why-img-wrap fade-up" style="transition-delay:.15s">
        <img src="https://images.unsplash.com/photo-1529400971008-f566de0e6dfc?w=700&q=80" alt="HASU students">
        <div class="why-img-badge">
          <strong>98%</strong>
          <span>Visa Success Rate</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== CORE VALUES ===== --}}
<section id="values" class="section">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Core Values</div>
      <h2 class="section-title">The Principles We Live By</h2>
      <p class="section-sub">Our values aren't just words on a wall — they shape every interaction, every decision, every outcome.</p>
    </div>
    <div class="values-grid">
      @php $values = [
        ['icon'=>'🔍','title'=>'Transparency','desc'=>'We share honest timelines, realistic expectations, and complete information so students can make truly informed decisions.'],
        ['icon'=>'💡','title'=>'Excellence','desc'=>'We hold ourselves to the highest standards in counseling, documentation, and every service we provide.'],
        ['icon'=>'❤️','title'=>'Student-First','desc'=>'Every policy, every process, every decision is made with one question in mind: what is best for our student?'],
        ['icon'=>'🔒','title'=>'Integrity','desc'=>'We do the right thing — even when it\'s difficult. Our reputation is built on trust earned one student at a time.'],
        ['icon'=>'🌱','title'=>'Empowerment','desc'=>'We equip students with knowledge, skills, and confidence to thrive academically and professionally overseas.'],
        ['icon'=>'🤲','title'=>'Community','desc'=>'Our alumni network stays connected — supporting each other and inspiring the next generation of global Nepali students.'],
      ]; @endphp
      @foreach($values as $i => $val)
      <div class="value-card fade-up" @if($i > 0) style="transition-delay:{{ $i * 0.08 }}s" @endif>
        <div class="value-icon">{{ $val['icon'] }}</div>
        <div>
          <h4>{{ $val['title'] }}</h4>
          <p>{{ $val['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== TEAM ===== --}}
<section id="team" class="section" style="background:var(--light)">
  <div class="container">
    <div class="section-head fade-up">
      <div class="section-label">Our People</div>
      <h2 class="section-title">Meet the HASU Team</h2>
      <p class="section-sub">Our dedicated counselors and specialists bring years of experience, genuine care, and insider knowledge.</p>
    </div>
    <div class="team-grid">
      @php $team = [
        ['emoji'=>'👨‍💼','name'=>'Ram Prasad Sharma','role'=>'Founder & CEO','bio'=>'With 11+ years guiding students abroad, Ram founded HASU to make global education a reality for every Nepali student.'],
        ['emoji'=>'👩‍💼','name'=>'Sunita Adhikari','role'=>'Senior Counselor – Japan','bio'=>'Sunita specializes in Japanese university admissions and language training, having placed 1,200+ students in Japan.'],
        ['emoji'=>'👨‍🏫','name'=>'Bikash Poudel','role'=>'Head of Visa Processing','bio'=>'Bikash leads our visa team with a meticulous, detail-first approach that maintains our 98% approval rate.'],
        ['emoji'=>'👩‍🎓','name'=>'Priya Khanal','role'=>'IELTS & PTE Trainer','bio'=>'Priya is a certified IELTS instructor passionate about helping students achieve the scores they need.'],
      ]; @endphp
      @foreach($team as $i => $member)
      <div class="team-card fade-up" @if($i > 0) style="transition-delay:{{ $i * 0.1 }}s" @endif>
        <div class="team-photo">
          <div class="team-photo-placeholder">{{ $member['emoji'] }}</div>
          <div class="team-overlay">
            <div class="team-socials">
              <a href="#">in</a>
              <a href="#">f</a>
            </div>
          </div>
        </div>
        <div class="team-body">
          <div class="team-name">{{ $member['name'] }}</div>
          <div class="team-role">{{ $member['role'] }}</div>
          <div class="team-bio">{{ $member['bio'] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== CTA BANNER ===== --}}
<x-frontend.cta-banner
    title="Ready to Begin Your Global Journey?"
    subtitle="Book a free counseling session today — let HASU guide you to the education you deserve."
    btn-label="Book Free Counseling"
    btn-link="#"
    btn2-label="Our Services"
    btn2-link="{{ route('home') }}#services"
/>

@endsection

@push('scripts')
<script>
// Stat counter animation
const statNums = document.querySelectorAll('.stat-num');
const statObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const el = entry.target;
      const accent = el.querySelector('.accent');
      const accentText = accent ? accent.textContent : '';
      const target = parseInt(el.textContent.replace(accentText,'').replace(/\D/g,''));
      if (isNaN(target)) return;
      let start = 0;
      const step = (ts) => {
        if (!start) start = ts;
        const progress = Math.min((ts - start) / 1400, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.innerHTML = Math.floor(eased * target).toLocaleString() + (accent ? `<span class="accent">${accentText}</span>` : '');
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
      statObserver.unobserve(el);
    }
  });
}, { threshold: 0.5 });
statNums.forEach(el => statObserver.observe(el));
</script>
@endpush