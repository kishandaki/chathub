<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Chat HUB — Real‑Time Messaging Platform</title>
  <meta name="description" content="Chat HUB is a modern real‑time messaging platform for teams. Collaborate, communicate, and stay connected anywhere." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <style>
    /* ========================================
       Chat HUB Home Page — Design System
       Matches auth.css variables & styling
       ======================================== */

    :root {
      --bg: #f4f7ff;
      --bg-2: #edf2ff;
      --surface: #ffffff;
      --surface-2: #f7f9ff;
      --surface-3: #eef3ff;
      --text: #121826;
      --soft-text: #526070;
      --muted: #8491a6;
      --line: #e2e8f3;
      --primary: #3549CE;
      --primary-dark: #2636ad;
      --primary-soft: rgba(53, 73, 206, 0.12);
      --success: #17a673;
      --success-soft: rgba(23, 166, 115, .12);
      --warning: #e49a24;
      --warning-soft: rgba(228, 154, 36, .13);
      --danger: #dc4c64;
      --danger-soft: rgba(220, 76, 100, .13);
      --shadow: 0 24px 80px rgba(30, 41, 59, .12);
      --shadow-sm: 0 12px 34px rgba(30, 41, 59, .08);
      --radius-lg: 28px;
      --radius-md: 20px;
      --radius-sm: 14px;
      --font: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      --ease: 220ms cubic-bezier(.2,.8,.2,1);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font);
      color: var(--text);
      background: var(--bg);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    a { text-decoration: none; color: inherit; }
    img { max-width: 100%; display: block; }

    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* ---- Buttons ---- */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      height: 52px;
      min-width: 120px;
      padding: 0 24px;
      border: 0;
      border-radius: 18px;
      font-size: 14px;
      font-weight: 800;
      letter-spacing: -.2px;
      transition: transform var(--ease), box-shadow var(--ease), background var(--ease);
      cursor: pointer;
    }
    .btn:hover { transform: translateY(-2px); }
    .btn:active { transform: scale(.97); }

    .btn-primary {
      background: var(--primary);
      color: #fff;
      box-shadow: 0 14px 28px rgba(53,73,206,.26);
    }
    .btn-primary:hover { box-shadow: 0 18px 36px rgba(53,73,206,.34); }

    .btn-outline {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
    }
    .btn-outline:hover {
      background: var(--primary-soft);
    }

    .btn-white {
      background: #fff;
      color: var(--primary);
      box-shadow: 0 14px 28px rgba(0,0,0,.08);
    }
    .btn-white:hover { box-shadow: 0 18px 36px rgba(0,0,0,.12); }

    .btn-sm {
      height: 44px;
      min-width: auto;
      padding: 0 18px;
      font-size: 13px;
      border-radius: 14px;
    }

    /* ---- Section shared ---- */
    .section {
      padding: 90px 0;
    }
    .section-title {
      font-size: 36px;
      font-weight: 900;
      letter-spacing: -1px;
      text-align: center;
      margin-bottom: 16px;
      color: var(--text);
    }
    .section-subtitle {
      font-size: 16px;
      color: var(--soft-text);
      text-align: center;
      max-width: 580px;
      margin: 0 auto 56px;
      line-height: 1.7;
    }

    /* ========================================
       HEADER
       ======================================== */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 100;
      background: rgba(244,247,255,.85);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--line);
      transition: background var(--ease);
    }
    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 72px;
    }
    .header-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 22px;
      font-weight: 900;
      letter-spacing: -.6px;
      color: var(--text);
    }
    .header-logo .logo-icon {
      width: 40px;
      height: 40px;
      border-radius: 14px;
      background: linear-gradient(135deg, #7180ff, #3549CE 55%, #17216b);
      color: #fff;
      display: grid;
      place-items: center;
      font-size: 18px;
    }
    .header-nav {
      display: flex;
      align-items: center;
      gap: 32px;
    }
    .header-nav a {
      font-size: 14px;
      font-weight: 600;
      color: var(--soft-text);
      transition: color var(--ease);
    }
    .header-nav a:hover { color: var(--primary); }
    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: none;
      border: 0;
      cursor: pointer;
      padding: 4px;
    }
    .hamburger span {
      display: block;
      width: 26px;
      height: 3px;
      background: var(--text);
      border-radius: 3px;
      transition: var(--ease);
    }
    .mobile-nav {
      display: none;
      position: fixed;
      top: 72px;
      left: 0;
      right: 0;
      background: var(--surface);
      border-bottom: 1px solid var(--line);
      padding: 20px 24px;
      flex-direction: column;
      gap: 16px;
      box-shadow: var(--shadow-sm);
      z-index: 99;
    }
    .mobile-nav.open { display: flex; }
    .mobile-nav a {
      font-size: 16px;
      font-weight: 600;
      color: var(--text);
      padding: 8px 0;
    }

    /* ========================================
       HERO
       ======================================== */
    .hero {
      padding: 160px 0 90px;
      background:
        radial-gradient(circle at 10% 20%, rgba(53,73,206,.15), transparent 50%),
        radial-gradient(circle at 90% 80%, rgba(23,166,115,.08), transparent 40%),
        linear-gradient(135deg, var(--bg), var(--bg-2));
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: -40%;
      right: -10%;
      width: 600px;
      height: 600px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(53,73,206,.06), transparent 70%);
      pointer-events: none;
    }
    .hero-content { position: relative; z-index: 1; }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--primary-soft);
      color: var(--primary);
      font-size: 13px;
      font-weight: 700;
      padding: 6px 16px;
      border-radius: 100px;
      margin-bottom: 24px;
    }
    .hero-title {
      font-size: clamp(36px, 6vw, 64px);
      font-weight: 900;
      letter-spacing: -2px;
      line-height: 1.1;
      margin-bottom: 20px;
    }
    .hero-title span { color: var(--primary); }
    .hero-desc {
      font-size: 18px;
      color: var(--soft-text);
      max-width: 580px;
      margin: 0 auto 36px;
      line-height: 1.7;
    }
    .hero-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 14px;
      flex-wrap: wrap;
    }
    .hero-stats {
      display: flex;
      justify-content: center;
      gap: 48px;
      margin-top: 56px;
      flex-wrap: wrap;
    }
    .hero-stat { text-align: center; }
    .hero-stat-num {
      font-size: 32px;
      font-weight: 900;
      color: var(--primary);
    }
    .hero-stat-label {
      font-size: 13px;
      color: var(--muted);
      font-weight: 600;
      margin-top: 4px;
    }

    /* ========================================
       FEATURES
       ======================================== */
    .features { background: var(--surface); }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 28px;
    }
    .feature-card {
      background: var(--surface-2);
      border: 1px solid var(--line);
      border-radius: var(--radius-md);
      padding: 36px 28px;
      transition: transform var(--ease), box-shadow var(--ease);
    }
    .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-sm);
    }
    .feature-icon {
      width: 56px;
      height: 56px;
      border-radius: 18px;
      background: var(--primary-soft);
      color: var(--primary);
      display: grid;
      place-items: center;
      margin-bottom: 20px;
    }
    .feature-card h3 {
      font-size: 20px;
      font-weight: 800;
      margin-bottom: 10px;
    }
    .feature-card p {
      font-size: 14px;
      color: var(--soft-text);
      line-height: 1.7;
    }

    /* ========================================
       ABOUT
       ======================================== */
    .about {
      background:
        radial-gradient(circle at 80% 30%, rgba(23,166,115,.07), transparent 50%),
        var(--bg-2);
    }
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
    }
    .about-visual {
      width: 100%;
      aspect-ratio: 4/3;
      border-radius: var(--radius-lg);
      background: linear-gradient(135deg, var(--primary-soft), rgba(23,166,115,.08));
      display: grid;
      place-items: center;
      color: var(--primary);
      font-size: 80px;
      font-weight: 900;
      letter-spacing: -3px;
      border: 1px solid var(--line);
    }
    .about h2 {
      font-size: 36px;
      font-weight: 900;
      letter-spacing: -1px;
      margin-bottom: 18px;
    }
    .about p {
      font-size: 15px;
      color: var(--soft-text);
      line-height: 1.8;
      margin-bottom: 16px;
    }
    .about-features {
      list-style: none;
      margin-top: 24px;
    }
    .about-features li {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 12px;
    }
    .about-features li svg {
      flex-shrink: 0;
      color: var(--success);
    }

    /* ========================================
       STATISTICS
       ======================================== */
    .highlights {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      text-align: center;
    }
    .highlights .section-title { color: #fff; }
    .highlights .section-subtitle { color: rgba(255,255,255,.7); }
    .highlights-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 40px;
      margin-top: 48px;
    }
    .highlight-item .num {
      font-size: 48px;
      font-weight: 900;
      letter-spacing: -2px;
    }
    .highlight-item .label {
      font-size: 14px;
      opacity: .75;
      margin-top: 6px;
      font-weight: 600;
    }

    /* ========================================
       CTA
       ======================================== */
    .cta {
      background: var(--surface);
      text-align: center;
      padding: 80px 0;
    }
    .cta-card {
      max-width: 680px;
      margin: 0 auto;
      background: var(--surface-2);
      border: 1px solid var(--line);
      border-radius: var(--radius-lg);
      padding: 60px 40px;
    }
    .cta h2 {
      font-size: 34px;
      font-weight: 900;
      letter-spacing: -1px;
      margin-bottom: 14px;
    }
    .cta p {
      font-size: 15px;
      color: var(--soft-text);
      max-width: 480px;
      margin: 0 auto 32px;
      line-height: 1.7;
    }
    .cta-actions {
      display: flex;
      justify-content: center;
      gap: 14px;
      flex-wrap: wrap;
    }

    /* ========================================
       FOOTER
       ======================================== */
    .footer {
      background: #0d1530;
      color: rgba(255,255,255,.8);
      padding: 60px 0 30px;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 40px;
      margin-bottom: 40px;
    }
    .footer-brand .logo-icon {
      width: 40px;
      height: 40px;
      border-radius: 14px;
      background: linear-gradient(135deg, #7180ff, #3549CE 55%, #17216b);
      color: #fff;
      display: grid;
      place-items: center;
      font-size: 18px;
      margin-bottom: 14px;
    }
    .footer-brand p {
      font-size: 13px;
      line-height: 1.7;
      color: rgba(255,255,255,.55);
      max-width: 280px;
    }
    .footer h4 {
      font-size: 14px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 18px;
    }
    .footer ul { list-style: none; }
    .footer ul li { margin-bottom: 10px; }
    .footer ul li a {
      font-size: 13px;
      color: rgba(255,255,255,.6);
      transition: color var(--ease);
    }
    .footer ul li a:hover { color: #fff; }
    .footer-social {
      display: flex;
      gap: 12px;
      margin-top: 16px;
    }
    .footer-social a {
      width: 38px;
      height: 38px;
      border-radius: 12px;
      background: rgba(255,255,255,.08);
      color: rgba(255,255,255,.7);
      display: grid;
      place-items: center;
      transition: background var(--ease), color var(--ease);
    }
    .footer-social a:hover {
      background: var(--primary);
      color: #fff;
    }
    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.08);
      padding-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      font-size: 12px;
      color: rgba(255,255,255,.4);
    }
    .footer-bottom-links {
      display: flex;
      gap: 20px;
    }
    .footer-bottom-links a {
      color: rgba(255,255,255,.5);
      transition: color var(--ease);
    }
    .footer-bottom-links a:hover { color: #fff; }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 900px) {
      .about-grid { grid-template-columns: 1fr; gap: 40px; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .hero-stats { gap: 32px; }
    }
    @media (max-width: 768px) {
      .header-nav { display: none; }
      .header-actions .btn { display: none; }
      .hamburger { display: flex; }
      .section { padding: 60px 0; }
      .hero { padding: 130px 0 60px; }
      .hero-stats { gap: 24px; }
      .hero-stat-num { font-size: 26px; }
      .features-grid { grid-template-columns: 1fr; }
      .cta-card { padding: 40px 24px; }
    }
    @media (max-width: 600px) {
      .footer-grid { grid-template-columns: 1fr; }
      .footer-bottom { flex-direction: column; text-align: center; }
      .hero-actions .btn { width: 100%; }
    }
  </style>
</head>
<body>

  <!-- ========== HEADER ========== -->
  <header class="header" id="header">
    <div class="container header-inner">
      <a href="#" class="header-logo">
        <span class="logo-icon">CH</span>
        Chat HUB
      </a>
      <nav class="header-nav">
        <a href="#hero">Home</a>
        <a href="#features">Features</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
      </nav>
      <div class="header-actions">
        @auth
          <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Log in</a>
          <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Get Started</a>
        @endauth
        <button class="hamburger" id="hamburger" aria-label="Toggle menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
    <div class="mobile-nav" id="mobileNav">
      <a href="#hero">Home</a>
      <a href="#features">Features</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      @auth
        <a href="{{ url('/dashboard') }}" style="color:var(--primary)">Dashboard</a>
      @else
        <a href="{{ route('login') }}" style="color:var(--primary)">Log in</a>
        <a href="{{ route('login') }}" style="color:var(--primary);font-weight:800">Get Started</a>
      @endauth
    </div>
  </header>

  <!-- ========== HERO ========== -->
  <section class="hero" id="hero">
    <div class="container hero-content">
      <div class="hero-badge">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        Now available — Chat HUB v1.0
      </div>
      <h1 class="hero-title">
        Real‑time messaging<br /><span>for your entire team</span>
      </h1>
      <p class="hero-desc">
        Chat HUB brings your team together with instant messaging, secure channels,
        and powerful collaboration tools — all in one beautifully designed platform.
      </p>
      <div class="hero-actions">
        @auth
          <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn btn-primary">Get Started Free</a>
          <a href="#features" class="btn btn-outline">Learn More</a>
        @endauth
      </div>
      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-num">10K+</div>
          <div class="hero-stat-label">Active Users</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">50K+</div>
          <div class="hero-stat-label">Messages/day</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">99.9%</div>
          <div class="hero-stat-label">Uptime</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== FEATURES ========== -->
  <section class="section features" id="features">
    <div class="container">
      <h2 class="section-title">Everything your team needs</h2>
      <p class="section-subtitle">
        Powerful features designed to make communication seamless, secure, and productive.
      </p>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
          </div>
          <h3>Instant Messaging</h3>
          <p>Send messages in real‑time with read receipts, typing indicators, and rich media support.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
          </div>
          <h3>End‑to‑End Encryption</h3>
          <p>Your conversations stay private with enterprise‑grade encryption protecting every message.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
          <h3>Team Channels</h3>
          <p>Organize conversations into channels — public, private, or direct messages — with granular permissions.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 13 14 20 7"></polyline><polyline points="20 7 20 13 14 13"></polyline></svg>
          </div>
          <h3>File Sharing</h3>
          <p>Drag‑and‑drop files, images, and documents with preview support and version history.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          </div>
          <h3>Message History</h3>
          <p>Never lose a message — full searchable history with powerful filters and date range queries.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </div>
          <h3>Admin Controls</h3>
          <p>Manage users, roles, permissions, and security policies from a central admin dashboard.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== ABOUT ========== -->
  <section class="section about" id="about">
    <div class="container">
      <div class="about-grid">
        <div>
          <h2>Built for modern teams</h2>
          <p>
            Chat HUB is more than just a messaging app — it's a complete collaboration
            platform designed to help teams communicate faster, work smarter, and stay
            connected wherever they are.
          </p>
          <p>
            With a clean interface, powerful integrations, and enterprise‑grade security,
            Chat HUB adapts to the way your team works — whether you're in the office or
            distributed across the globe.
          </p>
          <ul class="about-features">
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              Unlimited messages & history
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              Integrations with your favourite tools
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              99.9% uptime SLA guarantee
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              Dedicated customer support
            </li>
          </ul>
        </div>
        <div class="about-visual">CH</div>
      </div>
    </div>
  </section>

  <!-- ========== HIGHLIGHTS / STATISTICS ========== -->
  <section class="section highlights">
    <div class="container">
      <h2 class="section-title">Trusted by teams worldwide</h2>
      <p class="section-subtitle">Join thousands of teams who rely on Chat HUB every day.</p>
      <div class="highlights-grid">
        <div class="highlight-item">
          <div class="num">10K+</div>
          <div class="label">Active Users</div>
        </div>
        <div class="highlight-item">
          <div class="num">500+</div>
          <div class="label">Companies</div>
        </div>
        <div class="highlight-item">
          <div class="num">50K+</div>
          <div class="label">Daily Messages</div>
        </div>
        <div class="highlight-item">
          <div class="num">4.9★</div>
          <div class="label">Average Rating</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CTA ========== -->
  <section class="cta" id="contact">
    <div class="container">
      <div class="cta-card">
        <h2>Ready to get started?</h2>
        <p>
          Join thousands of teams already using Chat HUB to communicate, collaborate, and
          get work done faster. Sign up free — no credit card required.
        </p>
        <div class="cta-actions">
          @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary">Get Started Free</a>
            <a href="{{ route('login') }}" class="btn btn-outline">Contact Sales</a>
          @endauth
        </div>
      </div>
    </div>
  </section>

  <!-- ========== FOOTER ========== -->
  <footer class="footer" id="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="logo-icon">CH</div>
          <p>
            Chat HUB — real‑time messaging for modern teams.
            Secure, fast, and built for collaboration.
          </p>
          <div class="footer-social">
            <a href="#" aria-label="Twitter">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
            </a>
            <a href="#" aria-label="GitHub">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
            </a>
            <a href="#" aria-label="LinkedIn">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
            </a>
          </div>
        </div>
        <div>
          <h4>Product</h4>
          <ul>
            <li><a href="#features">Features</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Integrations</a></li>
            <li><a href="#">Changelog</a></li>
          </ul>
        </div>
        <div>
          <h4>Company</h4>
          <ul>
            <li><a href="#about">About</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4>Support</h4>
          <ul>
            <li><a href="#">Help Center</a></li>
            <li><a href="#">Documentation</a></li>
            <li><a href="#">API Status</a></li>
            <li><a href="#">Community</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <span>&copy; {{ date('Y') }} Chat HUB. All rights reserved.</span>
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
          <a href="#">Cookie Policy</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ========== MOBILE NAV TOGGLE ========== -->
  <script>
    (function() {
      const hamburger = document.getElementById('hamburger');
      const mobileNav = document.getElementById('mobileNav');
      if (hamburger && mobileNav) {
        hamburger.addEventListener('click', function() {
          mobileNav.classList.toggle('open');
        });
        // Close on link click
        mobileNav.querySelectorAll('a').forEach(function(link) {
          link.addEventListener('click', function() {
            mobileNav.classList.remove('open');
          });
        });
      }
    })();
  </script>

</body>
</html>