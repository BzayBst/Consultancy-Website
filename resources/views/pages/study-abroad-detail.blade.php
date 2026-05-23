@extends('layouts.app', ['active' => 'study-abroad'])

@section('title', 'Study Abroad – ' . setting('general_site_name', 'HASU Educational Consultancy'))
@section('meta_description',
    'Learn about HASU Educational Consultancy — our story, mission, vision, team, and why
    thousands of Nepali students trust us.')

@push('head')
<style>
  /* Extra styles for new sections to match your theme */
  .detail-section { padding: 60px 0; }
  .detail-section:nth-child(even) { background-color: #f8f9fa; }
  
  .uni-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: 30px; }
  .uni-card { background: #fff; border: 1px solid #eaeaea; border-radius: 8px; padding: 24px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .uni-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: var(--blue); }
  .uni-card img { max-width: 100%; height: 60px; object-fit: contain; margin-bottom: 15px; }
  .uni-card h5 { font-size: 15px; margin: 0; color: #333; }

  .faq-container { max-width: 800px; margin: 0 auto; }
  .faq-item { background: #fff; border: 1px solid #eaeaea; border-radius: 6px; margin-bottom: 12px; }
  .faq-item summary { font-weight: 600; padding: 18px 20px; cursor: pointer; outline: none; list-style: none; display: flex; justify-content: space-between; align-items: center; }
  .faq-item summary::after { content: '+'; font-size: 20px; color: var(--blue); }
  .faq-item[open] summary::after { content: '−'; }
  .faq-item p { padding: 0 20px 20px; margin: 0; color: #555; font-size: 15px; line-height: 1.6; }
</style>
@endpush
@section('content')

    {{-- ===== PAGE HERO ===== --}}
    <x-frontend.page-hero badge="Global Opportunities"
        title="Choose Your Dream" highlight="Destination"
        subtitle="Explore top study abroad destinations and unlock world-class education with our expert visa and admission guidance."
        :breadcrumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Study Abroad']]" />

        <section class="detail-section">
  <div class="container fade-up">
    <div style="max-width: 800px; margin: 0 auto; text-align: center;">
      <div class="section-label">Overview</div>
      <h2 class="section-title">Your Pathway to Japan</h2>
      <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">
        Japan is home to some of the world's most innovative companies and prestigious academic institutions. With a unique blend of traditional heritage and ultra-modern technology, studying in Japan offers an unparalleled experience. The Japanese government actively welcomes international students, providing robust support systems, allowing part-time work, and offering excellent post-graduation career tracks.
      </p>
    </div>
  </div>
</section>

<section id="courses-why" class="detail-section" style="padding-top: 0;">
  <div class="container">
    <div class="courses-why-inner fade-up">
      <div class="courses-why-text">
        <div class="section-label courses-why-label">Benefits</div>
        <h2 class="courses-why-title">Why Study in Japan?</h2>
        <p>From affordable tuition compared to Western countries to high safety standards, Japan is an ideal choice for ambitious students.</p>
      </div>
      <div class="courses-why-grid">
        <div class="courses-why-item">
          <div class="icon-wrap">🎓</div>
          <h5>Top-Tier Education</h5>
          <p>Global recognition for degrees in STEM, Business, and Arts.</p>
        </div>
        <div class="courses-why-item">
          <div class="icon-wrap">💼</div>
          <h5>Work Opportunities</h5>
          <p>International students can work up to 28 hours per week part-time.</p>
        </div>
        <div class="courses-why-item">
          <div class="icon-wrap">🛡️</div>
          <h5>Safe Environment</h5>
          <p>Consistently ranked as one of the safest countries in the world.</p>
        </div>
        <div class="courses-why-item">
          <div class="icon-wrap">🌸</div>
          <h5>Rich Culture</h5>
          <p>Experience a beautiful balance of ancient traditions and modern life.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="detail-section">
  <div class="container">
    <div class="courses-listing-head fade-up">
      <div>
        <div class="section-label">Academics</div>
        <h2 class="section-title" style="text-align: left; margin-bottom: 0;">Popular Courses in Japan</h2>
      </div>
    </div>
    <div class="courses-grid fade-up">
      <div class="course-card course-list-card">
        <div class="course-body">
          <span class="course-list-tag" style="background:var(--blue-light);color:var(--blue)">Technology</span>
          <h4>IT & Engineering</h4>
          <p>Robotics, Computer Science, and Automotive Engineering are highly sought after in Japan.</p>
        </div>
      </div>
      <div class="course-card course-list-card">
        <div class="course-body">
          <span class="course-list-tag" style="background:var(--blue-light);color:var(--blue)">Business</span>
          <h4>Business Management</h4>
          <p>Learn global supply chain and business strategies from leading corporate hubs.</p>
        </div>
      </div>
      <div class="course-card course-list-card">
        <div class="course-body">
          <span class="course-list-tag" style="background:var(--blue-light);color:var(--blue)">Arts</span>
          <h4>Animation & Design</h4>
          <p>World-renowned programs in graphic design, anime, and digital illustration.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="detail-section">
  <div class="container">
    <div class="fade-up" style="background: var(--blue); color: white; padding: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
      <div style="flex: 1; min-width: 300px;">
        <h2 style="margin-top: 0;">Scholarship Opportunities</h2>
        <p style="color: rgba(255,255,255,0.9); margin-bottom: 0; font-size: 1.1rem;">Financial aid is widely available for international students. Popular options include the <strong>MEXT Scholarship</strong> (Government funded), JASSO scholarships, and various university-specific tuition fee waivers ranging from 30% to 100%.</p>
      </div>
      <div>
        <a href="contact.html" class="btn" style="background: #fff; color: var(--blue); font-weight: 600;">Check Your Eligibility</a>
      </div>
    </div>
  </div>
</section>

<section class="detail-section">
  <div class="container">
    <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
      <div class="section-label">Locations</div>
      <h2 class="section-title">Popular Student Cities</h2>
    </div>
    <div class="courses-grid fade-up">
      <div class="course-card">
        <div class="course-img"><img src="https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=600&q=80" alt="Tokyo"></div>
        <div class="course-body">
          <h4>Tokyo</h4>
          <p>The bustling capital, offering endless tech and business opportunities.</p>
        </div>
      </div>
      <div class="course-card">
        <div class="course-img"><img src="https://images.unsplash.com/photo-1570459027562-4a916cc6113f?w=600&q=80" alt="Osaka"></div>
        <div class="course-body">
          <h4>Osaka</h4>
          <p>Known for its friendly locals, amazing food scene, and vibrant economy.</p>
        </div>
      </div>
      <div class="course-card">
        <div class="course-img"><img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&q=80" alt="Kyoto"></div>
        <div class="course-body">
          <h4>Kyoto</h4>
          <p>The cultural heart of Japan, perfect for arts and humanities students.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="detail-section">
  <div class="container">
    <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
      <div class="section-label">Institutions</div>
      <h2 class="section-title">Partner Universities & Language Schools</h2>
      <p>We work with top-rated institutions across Japan to secure your admission.</p>
    </div>
    <div class="uni-grid fade-up">
      <div class="uni-card">
        <img src="https://via.placeholder.com/150x60/ffffff/333333?text=University+Logo" alt="Uni Logo">
        <h5>Tokyo International University</h5>
      </div>
      <div class="uni-card">
        <img src="https://via.placeholder.com/150x60/ffffff/333333?text=University+Logo" alt="Uni Logo">
        <h5>Waseda University</h5>
      </div>
      <div class="uni-card">
        <img src="https://via.placeholder.com/150x60/ffffff/333333?text=University+Logo" alt="Uni Logo">
        <h5>Osaka University</h5>
      </div>
      <div class="uni-card">
        <img src="https://via.placeholder.com/150x60/ffffff/333333?text=School+Logo" alt="Uni Logo">
        <h5>ISI Japanese Language School</h5>
      </div>
      <div class="uni-card">
        <img src="https://via.placeholder.com/150x60/ffffff/333333?text=School+Logo" alt="Uni Logo">
        <h5>Sendagaya Institute</h5>
      </div>
    </div>
  </div>
</section>

<section class="detail-section">
  <div class="container">
    <div style="text-align: center; margin-bottom: 40px;" class="fade-up">
      <div class="section-label">Questions?</div>
      <h2 class="section-title">Frequently Asked Questions</h2>
    </div>
    <div class="faq-container fade-up">
      <details class="faq-item">
        <summary>Do I need to know Japanese to study in Japan?</summary>
        <p>While many universities now offer degree programs taught entirely in English, learning basic Japanese is highly recommended for daily life and finding part-time jobs. If you attend a language school first, no prior Japanese is strictly required, but basics help.</p>
      </details>
      <details class="faq-item">
        <summary>How much does it cost to study in Japan?</summary>
        <p>Tuition fees typically range from $5,000 to $15,000 USD per year depending on the institution type (National vs Private). Living expenses average around $700–$1,000 per month, depending on the city.</p>
      </details>
      <details class="faq-item">
        <summary>Can I work part-time while studying?</summary>
        <p>Yes, international students holding a valid student visa can apply for "Permission to Engage in Activity Other than that Permitted under the Status of Residence," allowing them to work up to 28 hours per week.</p>
      </details>
    </div>
  </div>
</section>

<section id="cta-banner" class="cta-courses">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-text fade-up">
        <h2>Ready to Start Your Application?</h2>
        <p>Let HASU Educational Consultancy guide you through document preparation, language classes, and visa filing.</p>
        <div class="cta-actions">
          <a href="contact.html" class="btn btn-cta-primary">Apply Now</a>
          <a href="tel:+9779856040895" class="btn btn-cta-ghost">Call Our Advisors</a>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection