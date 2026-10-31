<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Korean Language Classes | Overseas Education Lane</title>
  <link rel="preconnect" href="https://checkout.razorpay.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=DM+Sans:wght@400;500;600;700&display=swap">
  <style>
    :root {
      --primary-dark: #070758;
      --primary: #224099;
      --primary-light: #2d56c8;
      --accent: #f59e0b;
      --accent-hover: #d97706;
      --accent-light: #fef3c7;
      --bg: #f8faff;
      --ink: #0a1230;
      --mut: #4b5563;
      --card: #ffffff;
      --line: #e2e8f0;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body {
      font-family: 'DM Sans', system-ui, sans-serif;
      background: var(--bg);
      color: var(--ink);
      overflow-x: hidden;
      max-width: 100%;
      width: 100%;
      line-height: 1.6;
    }
    h1, h2, h3 {
      font-family: 'Bricolage Grotesque', sans-serif;
      line-height: 1.15;
      letter-spacing: -0.02em;
    }
    .wrap { max-width: 1100px; margin: 0 auto; padding: 0 22px; }
    section { padding: 56px 0; }
    .btn {
      display: inline-block;
      background: linear-gradient(135deg, var(--accent), var(--accent-hover));
      color: #070758;
      padding: 13px 28px;
      border-radius: 999px;
      text-decoration: none;
      font-weight: 800;
      font-size: 15.5px;
      border: 0;
      cursor: pointer;
      box-shadow: 0 8px 24px -6px rgba(245, 158, 11, 0.45);
      transition: transform .2s, box-shadow .2s;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 28px -4px rgba(245, 158, 11, 0.6);
    }
    .btn:disabled { cursor: wait; opacity: .8; transform: none; }
    .payment-spinner {
      display: inline-block;
      width: 15px;
      height: 15px;
      margin-right: 8px;
      border: 2px solid currentColor;
      border-right-color: transparent;
      border-radius: 50%;
      vertical-align: -2px;
      animation: payment-spin .7s linear infinite;
    }
    @keyframes payment-spin { to { transform: rotate(360deg); } }
    #paymentStatus[data-state="success"] { color: #087443; }
    #paymentStatus[data-state="error"] { color: #a12c20; }
    #paymentStatus[data-state="info"] { color: var(--primary); }
    .hero {
      background-color: var(--primary-dark);
      background: radial-gradient(circle at 85% 15%, var(--primary-light), transparent 50%),
                  linear-gradient(145deg, var(--primary-dark) 0%, #0d1275 60%, var(--primary) 100%);
      color: #fff;
      padding-bottom: 0;
      position: relative;
      overflow: hidden;
      min-height: 100vh;
      min-height: 100dvh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      contain: paint;
    }
    .hero > .wrap {
      width: 100%;
      flex: 1 1 auto;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    nav { display: flex; justify-content: space-between; align-items: center; padding: 18px 0; }
    nav a.logo-link {
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      background: #ffffff;
      padding: 6px 14px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }
    nav .logo-img { height: 40px; width: auto; display: block; }
    .hero-grid {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 14px 0 16px;
      margin: auto 0;
    }
    .tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(245, 158, 11, 0.16);
      border: 1px solid rgba(245, 158, 11, 0.4);
      color: var(--accent);
      padding: 6px 16px;
      border-radius: 99px;
      font-size: 13.5px;
      font-weight: 700;
      margin-bottom: 14px;
      letter-spacing: 0.04em;
    }
    .tag::before { content: ""; width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; }
    .hero h1 { font-size: clamp(34px, 5.2vw, 54px); font-weight: 800; margin-bottom: 16px; color: #ffffff; }
    .hero h1 span { color: var(--accent); }
    .hero p.lead { font-size: 17px; opacity: 0.92; margin-bottom: 26px; line-height: 1.55; max-width: 540px; }
    .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
    .stats { display: flex; gap: 26px; margin-top: 20px; }
    .stats b { font-size: 30px; display: block; font-weight: 800; color: var(--accent); }
    .stats small { font-size: 13px; opacity: 0.85; }
    .mq {
      background: #090e52;
      border-top: 1px solid rgba(245, 158, 11, 0.35);
      border-bottom: none;
      color: var(--accent-light);
      overflow: hidden;
      white-space: nowrap;
      padding: 11px 0;
      width: 100%;
      flex-shrink: 0;
    }
    .mq-in { display: inline-block; animation: mqScroll 22s linear infinite; font-weight: 700; font-size: 15px; letter-spacing: 0.03em; will-change: transform; transform: translate3d(0, 0, 0); }
    .mq-in span { margin: 0 24px; }
    .mq-in b { color: var(--accent); }
    @keyframes mqScroll { 0% { transform: translate3d(0, 0, 0); } 100% { transform: translate3d(-50%, 0, 0); } }
    #plans {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 36px 0;
    }
    #plans .wrap { width: 100%; }
    .plans {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-top: 18px;
      align-items: stretch;
    }
    .plan {
      background: var(--card);
      border: 2px solid var(--line);
      border-radius: 16px;
      padding: 22px 16px 18px;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: all .25s ease;
      box-shadow: 0 10px 28px -8px rgba(34, 64, 153, 0.09);
      cursor: pointer;
    }
    .plan:hover { box-shadow: 0 18px 36px -10px rgba(34, 64, 153, 0.18); }
    .plan.active {
      background: linear-gradient(160deg, var(--primary-dark) 0%, var(--primary) 100%);
      color: #fff;
      border-color: var(--accent);
      transform: scale(1.02);
      box-shadow: 0 22px 45px -10px rgba(7, 7, 88, 0.38);
    }
    .plan-tag {
      font-size: 12px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--primary);
      margin-bottom: 4px;
      transition: color .25s ease;
    }
    .plan.active .plan-tag { color: var(--accent); }
    .plan h3 { font-size: 21px; font-weight: 800; margin: 2px 0 6px; color: var(--primary-dark); transition: color .25s ease; }
    .plan.active h3 { color: #ffffff; }
    .plan .subtext { font-size: 13px; color: var(--mut); margin-bottom: 10px; line-height: 1.45; min-height: 38px; transition: color .25s ease; }
    .plan.active .subtext { color: rgba(255, 255, 255, 0.88); }
    .plan .dur {
      font-size: 12px;
      color: var(--primary);
      margin-bottom: 10px;
      font-weight: 700;
      background: #eef2ff;
      padding: 4px 10px;
      border-radius: 6px;
      display: inline-block;
      align-self: flex-start;
      transition: background .25s ease, color .25s ease;
    }
    .plan.active .dur { background: rgba(255, 255, 255, 0.15); color: #ffffff; }
    .plan ul { list-style: none; margin-bottom: 12px; flex: 1; font-size: 13px; line-height: 1.55; }
    .plan ul li { margin-bottom: 4px; }
    .plan ul li::before { content: "✓ "; color: #10b981; font-weight: 800; margin-right: 6px; transition: color .25s ease; }
    .plan.active ul li::before { color: var(--accent); }
    .plan .price { font-size: 26px; font-weight: 800; margin-bottom: 10px; color: var(--primary-dark); transition: color .25s ease; }
    .plan.active .price { color: #fff; }
    .plan .price small { font-size: 13.5px; font-weight: 500; opacity: 0.75; }
    .plan .btn { width: 100%; text-align: center; padding: 10px 18px; font-size: 14px; font-weight: 800; }
    .learn-sec { background: #edf2f9; }
    .feat { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; margin-top: 26px; }
    .f {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 22px;
      transition: transform .25s, border-color .25s;
    }
    .f:hover { transform: translateY(-4px); border-color: var(--primary); }
    .f .num {
      display: inline-block;
      font-family: 'Bricolage Grotesque', sans-serif;
      font-size: 13px;
      font-weight: 800;
      color: var(--primary);
      background: #e8edfb;
      padding: 3px 9px;
      border-radius: 6px;
      margin-bottom: 10px;
      letter-spacing: 0.04em;
    }
    .f h3 { font-size: 19px; margin-bottom: 6px; color: var(--primary-dark); }
    .f p { color: var(--mut); font-size: 14.5px; line-height: 1.55; }
    .rev-head { text-align: center; margin-bottom: 22px; }
    .rev-marquee {
      overflow: hidden;
      width: 100%;
      position: relative;
      padding: 10px 0 20px;
    }
    .rev-track {
      display: flex;
      gap: 22px;
      width: max-content;
      animation: revScroll 45s linear infinite;
      will-change: transform;
      transform: translate3d(0, 0, 0);
    }
    @keyframes revScroll {
      0% { transform: translate3d(0, 0, 0); }
      100% { transform: translate3d(-50%, 0, 0); }
    }
    .rev-card {
      flex: 0 0 350px;
      max-width: 350px;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 20px;
      padding: 26px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 0 8px 24px -10px rgba(34, 64, 153, 0.08);
      transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
    }
    .rev-card:hover { transform: translateY(-4px); border-color: var(--primary); box-shadow: 0 16px 36px -12px rgba(34, 64, 153, 0.16); }
    .rev-stars { color: var(--accent); margin-bottom: 10px; letter-spacing: 2px; }
    .rev-card q { font-size: 15px; color: var(--ink); line-height: 1.6; quotes: none; margin-bottom: 18px; }
    .rev-author { display: flex; align-items: center; gap: 12px; border-top: 1px solid var(--line); padding-top: 14px; }
    .avatar {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: var(--primary);
      color: #fff;
      display: grid;
      place-content: center;
      font-weight: 800;
      font-size: 15px;
      flex-shrink: 0;
    }
    .rev-meta b { font-size: 15px; display: block; color: var(--primary-dark); }
    .rev-meta small { color: var(--mut); font-size: 12.5px; }
    .formsec {
      background: radial-gradient(circle at 10% 90%, var(--primary-light), transparent 45%),
                  linear-gradient(150deg, var(--primary-dark) 0%, var(--primary) 100%);
      color: #fff;
      padding: 50px 0 16px;
    }
    .box { display: grid; grid-template-columns: 1fr 1.05fr; gap: 32px; align-items: center; }
    .formsec-left h2 { font-size: clamp(26px, 4vw, 38px); margin-bottom: 10px; }
    .formsec-left p { opacity: 0.88; font-size: 15px; line-height: 1.55; margin-bottom: 20px; }
    form {
      background: #ffffff;
      color: var(--ink);
      padding: 18px 20px;
      border-radius: 18px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      box-shadow: 0 25px 50px -20px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 100%;
      min-width: 0;
      box-sizing: border-box;
    }
    label, .field-wrap {
      font-weight: 700;
      font-size: 13px;
      display: flex;
      flex-direction: column;
      gap: 3px;
      width: 100%;
      max-width: 100%;
      min-width: 0;
      box-sizing: border-box;
    }
    input {
      padding: 8px 11px;
      border-radius: 8px;
      border: 1px solid var(--line);
      font-size: 14px;
      font-family: inherit;
      width: 100%;
      max-width: 100%;
      min-width: 0;
      box-sizing: border-box;
      transition: border-color .2s;
    }
    input:focus { outline: 0; border-color: var(--primary); }
    input.is-invalid { border-color: #ef4444 !important; background: #fffbfa; }
    .field-err { display: none; color: #ef4444; font-size: 11.5px; font-weight: 600; line-height: 1.3; margin-top: 1px; }
    .field-err.show { display: block; }
    .custom-select { position: relative; width: 100%; z-index: 90; }
    .select-btn {
      width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid var(--line);
      background: #fff; color: var(--ink); font: inherit; font-size: 13.5px; font-weight: 500;
      display: flex; align-items: center; justify-content: space-between; gap: 8px;
      cursor: pointer; box-sizing: border-box; text-align: left; transition: border-color .2s;
    }
    .select-btn:focus, .select-btn.open { outline: 0; border-color: var(--primary); }
    .select-btn svg { flex-shrink: 0; color: var(--mut); transition: transform .2s ease; }
    .select-btn.open svg { transform: rotate(180deg); }
    .select-btn span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; }
    .select-menu {
      position: absolute; top: calc(100% + 4px); left: 0; right: 0; width: 100%;
      background: #ffffff; border: 1.5px solid var(--primary); border-radius: 10px;
      box-shadow: 0 15px 35px -5px rgba(7, 7, 88, 0.25); list-style: none; padding: 5px;
      margin: 0; display: none; z-index: 999; box-sizing: border-box;
    }
    .select-menu.open { display: block; }
    .select-menu li {
      padding: 9px 12px; font-size: 13px; font-weight: 600; color: var(--ink);
      border-radius: 6px; cursor: pointer; overflow: hidden; text-overflow: ellipsis;
      white-space: nowrap; transition: background .15s ease, color .15s ease;
    }
    .select-menu li:hover, .select-menu li.selected { background: #eef2ff; color: var(--primary); }
    form .btn { width: 100%; margin-top: 4px; padding: 11px; font-size: 15px; }
    footer { padding: 22px 0 12px; text-align: center; color: rgba(255, 255, 255, 0.7); font-size: 13px; }
    #bar {
      position: fixed;
      top: 0;
      left: 0;
      height: 4px;
      width: 0;
      background: linear-gradient(90deg, var(--accent), var(--primary-light));
      z-index: 99;
    }
    @media (max-width: 900px) {
      #plans { min-height: auto; padding: 40px 0; }
      .plans { grid-template-columns: 1fr; max-width: 460px; margin: 16px auto 0; }
      .plan .subtext { min-height: auto; }
    }
    @media (max-width: 760px) {
      html, body { overflow-x: hidden !important; width: 100vw !important; max-width: 100% !important; }
      .wrap { padding: 0 16px !important; }
      section { padding: 36px 0 !important; }
      .hero { min-height: auto !important; }
      .hero > .wrap { justify-content: flex-start !important; }
      .hero-grid { text-align: center !important; margin: 0 !important; }
      .hero h1 { font-size: clamp(26px, 7vw, 34px) !important; }
      .hero p.lead { font-size: 14.5px !important; margin: 0 auto 18px !important; }
      .hero-cta { justify-content: center !important; }
      .stats { justify-content: center !important; gap: 16px !important; margin-top: 16px !important; }
      .mq { padding: 9px 0 !important; }
      .mq-in { font-size: 13.5px !important; }
      .mq-in span { margin: 0 16px !important; }
      #plans { min-height: auto !important; padding: 36px 0 !important; }
      .plans { grid-template-columns: 1fr !important; max-width: 100% !important; gap: 14px !important; }
      .plan .subtext { min-height: auto !important; }
      .box { grid-template-columns: 1fr !important; text-align: center !important; gap: 20px !important; width: 100% !important; max-width: 100% !important; }
      .box > * { width: 100% !important; max-width: 100% !important; min-width: 0 !important; }
      form { text-align: left !important; padding: 16px !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; overflow: visible !important; position: relative !important; }
      .rev-track { gap: 14px !important; animation-duration: 35s !important; }
      .rev-card { flex: 0 0 280px !important; max-width: 280px !important; padding: 18px !important; }
    }
  </style>
</head>
<body>
  <div id="bar"></div>
  <!-- Hero Section -->
  <header class="hero">
    <div class="wrap">
      <nav>
        <a href="{{ url('/') }}" class="logo-link">
          <img src="data:image/png;base64,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" alt="Overseas Education Lane" class="logo-img">
        </a>
        <a class="btn" href="#join">Enroll Now</a>
      </nav>
      <div class="hero-grid">
        <div>
          <span class="tag">KOREAN LANGUAGE CLASSES</span>
          <h1>Learn Korean. <span>Build Your Future.</span></h1>
          <p class="lead">Live Korean language classes designed to help you build your speaking, listening, reading and writing skills. Choose the Korean class plan that fits your schedule and learning goals.</p>
          <div class="hero-cta">
            <a class="btn" href="#plans">See the 3 plans</a>
          </div>
          <div class="stats">
            <div><b>3</b><small>flexible plans</small></div>
            <div><b>5</b><small>classes a week, max</small></div>
            <div><b>&#8377;4,000</b><small>starting per month (20% off)</small></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Ticker Marquee inside Hero -->
    <div class="mq" aria-hidden="true">
      <div class="mq-in">
        <span>안녕하세요</span><span><b>Live Classes</b></span>
        <span>화이팅</span><span><b>Expert Trainers</b></span>
        <span>한국어</span><span><b>Certificate</b></span>
        <span>감사합니다</span><span><b>Learn Korean</b></span>
        <span>안녕하세요</span><span><b>Live Classes</b></span>
        <span>화이팅</span><span><b>Expert Trainers</b></span>
        <span>한국어</span><span><b>Certificate</b></span>
        <span>감사합니다</span><span><b>Learn Korean</b></span>
      </div>
    </div>
  </header>
  <!-- Plans Section -->
  <section id="plans">
    <div class="wrap">
      <h2 style="text-align:center;font-size:clamp(26px,3.8vw,36px);margin-bottom:6px;color:var(--primary-dark);">Choose the Korean Class That Fits You Best</h2>
      <p style="text-align:center;color:var(--mut);font-size:15px;max-width:580px;margin:0 auto 18px;">Select the schedule that matches your learning pace and fluency targets.</p>
      <div class="plans">
        <!-- Plan 1 -->
        <article class="plan">
          <div class="plan-tag">FOUNDATION PLAN</div>
          <h3>2 Classes Per Week</h3>
          <p class="subtext">For learners building strong foundations in Korean.</p>
          <div class="dur">Course Duration: 6 Months</div>
          <ul>
            <li>Expert trainers</li>
            <li>Interactive classes</li>
            <li>Certificate of completion</li>
            <li>Steady learning and a strong foundation</li>
          </ul>
          <div class="price">&#8377;4,000 <small>/ Month</small></div>
          <a class="btn" href="#join" data-plan="FOUNDATION PLAN (2 Classes Per Week - ₹4,000/Month)">Enroll Now</a>
        </article>
        <!-- Plan 2 -->
        <article class="plan active default-plan">
          <div class="plan-tag">PROGRESS PLAN</div>
          <h3>3 Classes Per Week</h3>
          <p class="subtext">Ideal for learners developing their Korean language skills.</p>
          <div class="dur">Course Duration: 5 Months</div>
          <ul>
            <li>Expert trainers</li>
            <li>Interactive classes</li>
            <li>Certificate of completion</li>
            <li>Balanced learning and greater progress</li>
          </ul>
          <div class="price">&#8377;5,000 <small>/ Month</small></div>
          <a class="btn" href="#join" data-plan="PROGRESS PLAN (3 Classes Per Week - ₹5,000/Month)">Enroll Now</a>
        </article>
        <!-- Plan 3 -->
        <article class="plan">
          <div class="plan-tag">INTENSIVE PLAN</div>
          <h3>5 Classes Per Week</h3>
          <p class="subtext">For learners looking for intensive and faster-paced Korean language learning.</p>
          <div class="dur">Course Duration: 3&ndash;4 Months</div>
          <ul>
            <li>Expert trainers</li>
            <li>Interactive classes</li>
            <li>Certificate of completion</li>
            <li>Fast-track learning</li>
            <li>Quick progress through regular practice</li>
          </ul>
          <div class="price">&#8377;9,000 <small>/ Month</small></div>
          <a class="btn" href="#join" data-plan="INTENSIVE PLAN (5 Classes Per Week - ₹9,000/Month)">Enroll Now</a>
        </article>
      </div>
    </div>
  </section>
  <!-- What You'll Learn Section -->
  <section class="learn-sec" id="learn">
    <div class="wrap">
      <h2 style="text-align:center;font-size:clamp(28px,4vw,38px);margin-bottom:8px;color:var(--primary-dark);">What You&rsquo;ll Learn</h2>
      <p style="text-align:center;color:var(--mut);margin-bottom:24px;font-size:16px;font-weight:600;">Build Your Korean Language Skills</p>
      <div class="feat">
        <div class="f">
          <span class="num">MODULE 01</span>
          <h3>Speaking</h3>
          <p>Practise everyday conversations and pronunciation.</p>
        </div>
        <div class="f">
          <span class="num">MODULE 02</span>
          <h3>Listening</h3>
          <p>Improve your understanding of spoken Korean.</p>
        </div>
        <div class="f">
          <span class="num">MODULE 03</span>
          <h3>Reading</h3>
          <p>Learn to read Hangul and understand written Korean.</p>
        </div>
        <div class="f">
          <span class="num">MODULE 04</span>
          <h3>Writing</h3>
          <p>Build your ability to write Korean words and sentences.</p>
        </div>
        <div class="f">
          <span class="num">MODULE 05</span>
          <h3>Interactive Practice</h3>
          <p>Reinforce learning through guided activities.</p>
        </div>
        <div class="f">
          <span class="num">MODULE 06</span>
          <h3>Expert Guidance</h3>
          <p>Receive structured support throughout your learning journey.</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Student Reviews -->
  <section id="reviews">
    <div class="wrap">
      <div class="rev-head">
        <h2 style="font-size:clamp(28px,4vw,38px);color:var(--primary-dark);margin-bottom:6px;">What Our Students Say</h2>
        <p style="color:var(--mut);font-size:16px;">Real experiences from 9 students learning Korean with OEL.</p>
      </div>
    </div>
    <!-- Continuous Auto-Scrolling Slider -->
    <div class="rev-marquee">
      <div class="rev-track">
        <!-- Set 1 -->
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;I started from zero with the Hangul alphabet. The trainer was so patient with pronunciation and grammar. Now I can hold basic conversations easily!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar">A</div>
            <div class="rev-meta"><b>Ananya Sharma</b><small>Foundation Plan &middot; Beginner Learner</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The 3-day per week schedule was perfect with my college timetable. The speaking drills really helped build my confidence to speak without hesitation.&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:var(--accent);">K</div>
            <div class="rev-meta"><b>Karan Mehta</b><small>Progress Plan &middot; College Student</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The fast-track 5-day batch helped me prepare for my South Korea student visa interview and build solid conversational skills in just 3 months. Fantastic trainers!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:var(--primary-light);">N</div>
            <div class="rev-meta"><b>Neha Rawat</b><small>Intensive Plan &middot; Study Abroad Aspirant</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Joined out of curiosity for Korean culture, but the structured lessons and interactive speaking sessions made me fall in love with the language. Highly recommended!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#10b981;">R</div>
            <div class="rev-meta"><b>Rohit Verma</b><small>Progress Plan &middot; Working Professional</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The guided activities and patient trainers made reading and writing Hangul super easy. I can read Korean menus and store boards comfortably now!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#8b5cf6;">P</div>
            <div class="rev-meta"><b>Pooja Deshmukh</b><small>Foundation Plan &middot; First-time Learner</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Daily live practice and speaking drills made a huge difference. Trainers provide instant personal corrections, and the certificate of completion added great value.&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#f97316;">A</div>
            <div class="rev-meta"><b>Aakash Nair</b><small>Intensive Plan &middot; Fast-track Learner</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Practicing everyday conversations and listening to native audio clips every week helped my ear adapt to Korean cadence. Truly supportive instructors!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#06b6d4;">S</div>
            <div class="rev-meta"><b>Simran Kaur</b><small>Progress Plan &middot; Language Enthusiast</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The 2 classes per week schedule gave me enough time to revise notes and practice writing without clashing with my university studies. Very balanced plan.&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#ec4899;">V</div>
            <div class="rev-meta"><b>Vivek Joshi</b><small>Foundation Plan &middot; College Student</small></div>
          </div>
        </div>
        <div class="rev-card">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Learning Korean with OEL gave me a tremendous head start for my South Korea admissions. The structured syllabus covers speaking, reading, and writing thoroughly!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#3b82f6;">R</div>
            <div class="rev-meta"><b>Riya Sen</b><small>Intensive Plan &middot; Study in Korea Aspirant</small></div>
          </div>
        </div>
        <!-- Set 2 (Duplicates for seamless loop) -->
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;I started from zero with the Hangul alphabet. The trainer was so patient with pronunciation and grammar. Now I can hold basic conversations easily!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar">A</div>
            <div class="rev-meta"><b>Ananya Sharma</b><small>Foundation Plan &middot; Beginner Learner</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The 3-day per week schedule was perfect with my college timetable. The speaking drills really helped build my confidence to speak without hesitation.&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:var(--accent);">K</div>
            <div class="rev-meta"><b>Karan Mehta</b><small>Progress Plan &middot; College Student</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The fast-track 5-day batch helped me prepare for my South Korea student visa interview and build solid conversational skills in just 3 months. Fantastic trainers!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:var(--primary-light);">N</div>
            <div class="rev-meta"><b>Neha Rawat</b><small>Intensive Plan &middot; Study Abroad Aspirant</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Joined out of curiosity for Korean culture, but the structured lessons and interactive speaking sessions made me fall in love with the language. Highly recommended!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#10b981;">R</div>
            <div class="rev-meta"><b>Rohit Verma</b><small>Progress Plan &middot; Working Professional</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The guided activities and patient trainers made reading and writing Hangul super easy. I can read Korean menus and store boards comfortably now!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#8b5cf6;">P</div>
            <div class="rev-meta"><b>Pooja Deshmukh</b><small>Foundation Plan &middot; First-time Learner</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Daily live practice and speaking drills made a huge difference. Trainers provide instant personal corrections, and the certificate of completion added great value.&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#f97316;">A</div>
            <div class="rev-meta"><b>Aakash Nair</b><small>Intensive Plan &middot; Fast-track Learner</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Practicing everyday conversations and listening to native audio clips every week helped my ear adapt to Korean cadence. Truly supportive instructors!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#06b6d4;">S</div>
            <div class="rev-meta"><b>Simran Kaur</b><small>Progress Plan &middot; Language Enthusiast</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;The 2 classes per week schedule gave me enough time to revise notes and practice writing without clashing with my university studies. Very balanced plan.&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#ec4899;">V</div>
            <div class="rev-meta"><b>Vivek Joshi</b><small>Foundation Plan &middot; College Student</small></div>
          </div>
        </div>
        <div class="rev-card" aria-hidden="true">
          <div>
            <div class="rev-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <q>&ldquo;Learning Korean with OEL gave me a tremendous head start for my South Korea admissions. The structured syllabus covers speaking, reading, and writing thoroughly!&rdquo;</q>
          </div>
          <div class="rev-author">
            <div class="avatar" style="background:#3b82f6;">R</div>
            <div class="rev-meta"><b>Riya Sen</b><small>Intensive Plan &middot; Study in Korea Aspirant</small></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Enquiry Form & Footer -->
  <section class="formsec" id="join">
    <div class="wrap box">
      <div class="formsec-left">
        <h2>Ready to Start Learning Korean?</h2>
        <p>Choose your preferred class plan and submit your details. Our team will contact you with the next steps.</p>
      </div>
      <form id="enrolForm" novalidate>
        <h3 style="font-size:19px;color:var(--primary-dark);margin-bottom:2px;">Enquiry Form</h3>
        <p style="font-size:13px;color:var(--mut);margin-bottom:4px;">Fill in your details below and we&rsquo;ll get in touch with you.</p>
        <label>Full Name
          <input type="text" id="formName" name="name" placeholder="Enter your full name" autocomplete="name">
          <small class="field-err" id="errName"></small>
        </label>
        <label>Email Address
          <input type="email" id="formEmail" name="email" placeholder="Enter your email address" autocomplete="email">
          <small class="field-err" id="errEmail"></small>
        </label>
        <label>Phone Number
          <input type="tel" id="formPhone" name="phone" placeholder="Enter your 10-digit WhatsApp number" autocomplete="tel" maxlength="10">
          <small class="field-err" id="errPhone"></small>
        </label>
        <label>City
          <input type="text" id="formCity" name="city" placeholder="Enter your city">
          <small class="field-err" id="errCity"></small>
        </label>
        <div class="field-wrap">
          <span>Class Plan</span>
          <input type="hidden" id="planSelect" name="plan" value="progress">
          <div class="custom-select" id="customPlanDropdown">
            <button type="button" class="select-btn" id="customPlanBtn">
              <span id="customPlanText">PROGRESS PLAN &ndash; 3 Classes/Wk (&#8377;5,000/mo)</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <ul class="select-menu" id="customPlanMenu">
              <li data-val="foundation">FOUNDATION PLAN &ndash; 2 Classes/Wk (&#8377;4000/mo)</li>
              <li data-val="progress" class="selected">PROGRESS PLAN &ndash; 3 Classes/Wk (&#8377;5,000/mo)</li>
            
              <li data-val="intensive">INTENSIVE PLAN &ndash; 5 Classes/Wk (&#8377;9,000/mo)</li>
            </ul>
          </div>
          <small class="field-err" id="errPlan"></small>
        </div>
        @csrf
        <input type="hidden" id="submissionKey" name="submission_key" value="">
        <button class="btn" id="buyNowButton" type="submit">Buy Now</button>
        <p id="paymentStatus" role="status" aria-live="polite" style="display:none;margin:10px 0 0;"></p>
        <button class="btn" id="retryPaymentButton" type="button" style="display:none;margin-top:8px;">Retry payment</button>
      </form>
    </div>
    <footer>
      &copy; Overseas Education Lane. All rights reserved.
    </footer>
  </section>
  <!-- Interactive JavaScript -->
  <script>
    // Reading Progress Bar
    var bar = document.getElementById('bar');
    window.addEventListener('scroll', function() {
      var d = document.documentElement;
      var p = window.scrollY / (d.scrollHeight - window.innerHeight);
      if (bar) bar.style.width = (p * 100) + '%';
    }, { passive: true });
    // Interactive Plan Cards Hover
    var planCards = document.querySelectorAll('.plan');
    var plansWrap = document.querySelector('.plans');
    var defaultCard = document.querySelector('.plan.default-plan');
    planCards.forEach(function(card) {
      card.addEventListener('mouseenter', function() {
        planCards.forEach(function(c) { c.classList.remove('active'); });
        card.classList.add('active');
      });
    });
    if (plansWrap) {
      plansWrap.addEventListener('mouseleave', function() {
        planCards.forEach(function(c) { c.classList.remove('active'); });
        if (defaultCard) defaultCard.classList.add('active');
      });
    }
    // Custom Plan Dropdown
    var cpBtn = document.getElementById('customPlanBtn'),
        cpMenu = document.getElementById('customPlanMenu'),
        cpTxt = document.getElementById('customPlanText'),
        cpHidden = document.getElementById('planSelect');
    function closePlanMenu() {
      if (cpMenu) cpMenu.classList.remove('open');
      if (cpBtn) cpBtn.classList.remove('open');
    }
    function setPlanVal(v, t) {
      if (cpHidden) cpHidden.value = v;
      if (cpTxt) cpTxt.textContent = t;
      if (cpMenu) {
        cpMenu.querySelectorAll('li').forEach(function(li) {
          li.classList.toggle('selected', li.getAttribute('data-val') === v);
        });
      }
      closePlanMenu();
    }
    if (cpBtn && cpMenu) {
      cpBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var isOpen = cpMenu.classList.contains('open');
        if (isOpen) {
          closePlanMenu();
        } else {
          cpMenu.classList.add('open');
          cpBtn.classList.add('open');
        }
      });
      cpMenu.querySelectorAll('li').forEach(function(li) {
        li.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          setPlanVal(li.getAttribute('data-val'), li.textContent);
        });
      });
      document.addEventListener('click', function(e) {
        if (!e.target.closest('#customPlanDropdown')) {
          closePlanMenu();
        }
      });
    }
    document.querySelectorAll('[data-plan]').forEach(function(b) {
      b.addEventListener('click', function() {
        var p = b.getAttribute('data-plan');
        if (cpMenu && p) {
          cpMenu.querySelectorAll('li').forEach(function(li) {
            if (li.getAttribute('data-val') === p.split(' ')[0].toLowerCase()) {
              setPlanVal(li.getAttribute('data-val'), li.textContent);
            }
          });
        }
      });
    });
    // Form Validation & Submission
    var enrolForm = document.getElementById('enrolForm'),
        inputName = document.getElementById('formName'),
        inputEmail = document.getElementById('formEmail'),
        inputPhone = document.getElementById('formPhone'),
        inputCity = document.getElementById('formCity'),
        inputPlan = document.getElementById('planSelect'),
        errName = document.getElementById('errName'),
        errEmail = document.getElementById('errEmail'),
        errPhone = document.getElementById('errPhone'),
        errCity = document.getElementById('errCity'),
        errPlan = document.getElementById('errPlan');
    function showError(inputEl, errEl, msg) {
      if (inputEl) inputEl.classList.add('is-invalid');
      if (errEl) { errEl.textContent = msg; errEl.classList.add('show'); }
    }
    function clearError(inputEl, errEl) {
      if (inputEl) inputEl.classList.remove('is-invalid');
      if (errEl) { errEl.textContent = ''; errEl.classList.remove('show'); }
    }
    function validateName() {
      var v = inputName.value.trim();
      if (!v) { showError(inputName, errName, 'Please enter your full name.'); return false; }
      if (!/^[a-zA-Z\s]{3,50}$/.test(v)) { showError(inputName, errName, 'Name must contain letters only (min 3 characters).'); return false; }
      clearError(inputName, errName);
      return true;
    }
    function validateEmail() {
      var v = inputEmail.value.trim();
      if (!v) { showError(inputEmail, errEmail, 'Please enter your email address.'); return false; }
      if (!/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(v)) { showError(inputEmail, errEmail, 'Please enter a valid email address.'); return false; }
      clearError(inputEmail, errEmail);
      return true;
    }
    function validatePhone() {
      var v = inputPhone.value.trim();
      if (!v) { showError(inputPhone, errPhone, 'Please enter your WhatsApp number.'); return false; }
      if (!/^[6-9]\d{9}$/.test(v)) { showError(inputPhone, errPhone, 'Please enter a valid 10-digit mobile number.'); return false; }
      clearError(inputPhone, errPhone);
      return true;
    }
    function validateCity() {
      var v = inputCity.value.trim();
      if (!v) { showError(inputCity, errCity, 'Please enter your city.'); return false; }
      if (!/^[a-zA-Z\s]{2,50}$/.test(v)) { showError(inputCity, errCity, 'City must contain letters only (min 2 characters).'); return false; }
      clearError(inputCity, errCity);
      return true;
    }
    function validatePlan() {
      var v = inputPlan ? inputPlan.value.trim() : '';
      if (!v) { showError(cpBtn, errPlan, 'Please choose a class plan.'); return false; }
      clearError(cpBtn, errPlan);
      return true;
    }
    inputPhone.addEventListener('input', function() {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
      if (inputPhone.classList.contains('is-invalid')) validatePhone();
    });
    inputName.addEventListener('input', function() { if (inputName.classList.contains('is-invalid')) validateName(); });
    inputName.addEventListener('blur', function() { if (inputName.value.trim()) validateName(); });
    inputEmail.addEventListener('input', function() { if (inputEmail.classList.contains('is-invalid')) validateEmail(); });
    inputEmail.addEventListener('blur', function() { if (inputEmail.value.trim()) validateEmail(); });
    inputPhone.addEventListener('blur', function() { if (inputPhone.value.trim()) validatePhone(); });
    inputCity.addEventListener('input', function() { if (inputCity.classList.contains('is-invalid')) validateCity(); });
    inputCity.addEventListener('blur', function() { if (inputCity.value.trim()) validateCity(); });
    var buyNowButton = document.getElementById('buyNowButton'),
        retryButton = document.getElementById('retryPaymentButton'),
        paymentStatus = document.getElementById('paymentStatus'),
        submissionKey = document.getElementById('submissionKey'),
        retryToken = localStorage.getItem('ieltsRetryToken'),
        enquiryReference = localStorage.getItem('ieltsEnquiryReference'),
        pendingPaymentId = localStorage.getItem('ieltsPendingPaymentId'),
        paidReference = localStorage.getItem('ieltsPaidReference'),
        paidAt = Number(localStorage.getItem('ieltsPaidAt') || 0),
        hasSavedSubmission = !!localStorage.getItem('ieltsSubmissionKey'),
        processing = false,
        statusNeedsCheck = false,
        checkoutScriptPromise = null,
        checkoutScriptStartedAt = performance.now(),
        buyPointerDownAt = 0;
    function newSubmissionKey() {
      if (window.crypto && window.crypto.randomUUID) return window.crypto.randomUUID();
      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0;
        return (c === 'x' ? r : (r & 3 | 8)).toString(16);
      });
    }
    submissionKey.value = localStorage.getItem('ieltsSubmissionKey') || newSubmissionKey();
    localStorage.setItem('ieltsSubmissionKey', submissionKey.value);
    if (paidReference && (!paidAt || Date.now() - paidAt > 86400000)) {
      paidReference = null;
      localStorage.removeItem('ieltsPaidReference');
      localStorage.removeItem('ieltsPaidAt');
    }
    function setStatus(message, state) {
      paymentStatus.textContent = message;
      paymentStatus.style.display = 'block';
      paymentStatus.setAttribute('data-state', state || 'info');
    }
    function showOnly(button) {
      buyNowButton.style.display = button === 'buy' ? 'inline-block' : 'none';
      retryButton.style.display = button === 'retry' || button === 'check' ? 'inline-block' : 'none';
      retryButton.textContent = button === 'check' ? 'Check payment status' : 'Retry Payment';
    }
    function setBuyProcessing(active) {
      buyNowButton.disabled = active;
      buyNowButton.setAttribute('aria-busy', active ? 'true' : 'false');
      buyNowButton.innerHTML = active
        ? '<span class="payment-spinner" aria-hidden="true"></span>Processing...'
        : 'Buy Now';
    }
    function markPaid(reference) {
      setStatus('Payment Successful. Your reference is ' + reference + '.', 'success');
      processing = false;
      showOnly('none');
      buyNowButton.disabled = false;
      localStorage.removeItem('ieltsRetryToken');
      localStorage.removeItem('ieltsEnquiryReference');
      localStorage.removeItem('ieltsSubmissionKey');
      localStorage.removeItem('ieltsPendingPaymentId');
      localStorage.setItem('ieltsPaidReference', reference);
      localStorage.setItem('ieltsPaidAt', String(Date.now()));
    }
    function loadRazorpay() {
      if (window.Razorpay) return Promise.resolve();
      if (!checkoutScriptPromise) {
        checkoutScriptPromise = new Promise(function(resolve, reject) {
          var script = document.createElement('script');
          script.src = 'https://checkout.razorpay.com/v1/checkout.js';
          script.async = true;
          script.onload = function() {
            console.info('[IELTS payment timing]', {
              correlation_id: submissionKey.value,
              stage: 'checkout_sdk_load_ms',
              duration_ms: Math.round((performance.now() - checkoutScriptStartedAt) * 100) / 100
            });
            resolve();
          };
          script.onerror = function() { reject(new Error('Razorpay Checkout could not be loaded.')); };
          document.head.appendChild(script);
        }).catch(function(error) {
          checkoutScriptPromise = null;
          throw error;
        });
      }
      return checkoutScriptPromise;
    }
    loadRazorpay().catch(function() {});
    function sendJson(url, payload, timeoutMs) {
      var controller = new AbortController();
      var startedAt = performance.now();
      var correlationId = submissionKey.value || (payload && payload.submission_key) || retryToken || newSubmissionKey();
      var timeoutHandle = window.setTimeout(function() { controller.abort(); }, timeoutMs || 30000);
      return fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': enrolForm.querySelector('input[name="_token"]').value,
          'X-Correlation-ID': correlationId
        },
        signal: controller.signal,
        body: JSON.stringify(payload)
      }).then(function(response) {
        return response.json().catch(function() { return {}; }).then(function(data) {
          var elapsed = Math.round((performance.now() - startedAt) * 100) / 100;
          console.info('[IELTS payment timing]', {
            correlation_id: response.headers.get('X-Correlation-ID') || correlationId,
            stage: 'http_request',
            duration_ms: elapsed,
            status: response.status
          });
          if (!response.ok) {
            var error = new Error(data.message || 'The request could not be completed.');
            error.data = data;
            error.status = response.status;
            error.paymentStateUncertain = !!data.payment_state_uncertain;
            throw error;
          }
          return data;
        });
      }).catch(function(error) {
        if (error.name === 'AbortError') {
          var timeoutError = new Error('The request is taking longer than expected. Checking payment status before retrying.');
          timeoutError.timedOut = true;
          throw timeoutError;
        }
        throw error;
      }).finally(function() {
        window.clearTimeout(timeoutHandle);
      });
    }
    function recoverableState(message, checkFirst) {
      processing = false;
      setBuyProcessing(false);
      statusNeedsCheck = !!checkFirst;
      showOnly(checkFirst ? 'check' : 'retry');
      setStatus(message, checkFirst ? 'info' : 'error');
    }
    function openCheckout(data) {
      return loadRazorpay().then(function() {
        showOnly('none');
        setStatus('Opening secure payment checkout...', 'info');
        var callbackStarted = false;
        var checkoutStartedAt = performance.now();
        var checkout = new Razorpay({
          key: data.key_id,
          amount: data.amount,
          currency: data.currency,
          name: 'Overseas Education Lane',
          description: data.plan_name,
          order_id: data.order_id,
          prefill: { name: data.name, email: data.email, contact: data.phone },
          notes: { enquiry_reference: data.enquiry_reference },
          handler: function(response) {
            callbackStarted = true;
            pendingPaymentId = response.razorpay_payment_id;
            localStorage.setItem('ieltsPendingPaymentId', pendingPaymentId);
            processing = true;
            showOnly('none');
            setStatus('Verifying Payment...', 'info');
            sendJson('{{ route("ielts-courses.payment.verify") }}', response, 30000).then(function(result) {
              markPaid(result.enquiry_reference);
            }).catch(function(error) {
              checkPaymentStatus(true, error.message);
            });
          },
          modal: {
            ondismiss: function() {
              if (!callbackStarted) {
                checkPaymentStatus(true, 'Checkout was closed. Checking payment status before allowing another attempt.');
              }
            }
          }
        });
        checkout.on('payment.failed', function(response) {
          callbackStarted = true;
          pendingPaymentId = response.error && response.error.metadata
            ? response.error.metadata.payment_id
            : null;
          if (pendingPaymentId) localStorage.setItem('ieltsPendingPaymentId', pendingPaymentId);
          checkPaymentStatus(true, 'Payment was not confirmed. Checking the order before offering another attempt.');
        });
        checkout.open();
        console.info('[IELTS payment timing]', {
          correlation_id: submissionKey.value,
          stage: 'checkout_open_called',
          duration_ms: Math.round((performance.now() - checkoutStartedAt) * 100) / 100
        });
        processing = false;
      }).catch(function(error) {
        recoverableState(error.message + ' Your enquiry is saved.', true);
      });
    }
    function checkPaymentStatus(silent, reason) {
      processing = true;
      showOnly('none');
      setBuyProcessing(true);
      setStatus('Checking payment status...', 'info');
      return sendJson('{{ route("ielts-courses.payment.status") }}', {
        submission_key: submissionKey.value || retryToken,
        enquiry_reference: enquiryReference,
        retry_token: retryToken,
        razorpay_payment_id: pendingPaymentId
      }, 20000).then(function(data) {
        if (data.payment_status === 'paid') {
          markPaid(data.enquiry_reference || enquiryReference);
          return;
        }
        if (data.enquiry_found === false) {
          statusNeedsCheck = false;
          showOnly('buy');
          setBuyProcessing(false);
          setStatus('No saved payment order was found. You can safely submit the enquiry again.', 'error');
          return;
        }
        retryToken = data.retry_token || retryToken;
        enquiryReference = data.enquiry_reference || enquiryReference;
        if (retryToken) localStorage.setItem('ieltsRetryToken', retryToken);
        if (enquiryReference) localStorage.setItem('ieltsEnquiryReference', enquiryReference);
        if (data.payment_state_uncertain) {
          recoverableState('Payment status is still being confirmed. Check again before retrying.', true);
          return;
        }
        statusNeedsCheck = false;
        if (data.can_retry) {
          if (data.payment_status === 'failed') {
            pendingPaymentId = null;
            localStorage.removeItem('ieltsPendingPaymentId');
          }
          showOnly(enquiryReference ? 'retry' : 'buy');
          setBuyProcessing(false);
          setStatus(data.payment_status === 'failed'
            ? 'Payment failed. You can retry using the saved enquiry.'
            : 'No successful payment was found. You can retry using the saved enquiry.', 'error');
          return;
        }
        recoverableState('Payment status is still being confirmed. Check again before retrying.', true);
      }).catch(function(error) {
        recoverableState(reason || error.message + ' Do not start another payment until status is confirmed.', true);
      }).finally(function() {
        processing = false;
        retryButton.disabled = false;
        if (buyNowButton.style.display !== 'none') setBuyProcessing(false);
      });
    }
    function beginPayment(payload) {
      processing = true;
      statusNeedsCheck = false;
      showOnly('buy');
      setBuyProcessing(true);
      setStatus('Preparing your payment, please wait...', 'info');
      return sendJson('{{ route("ielts-courses.enquiry.store") }}', payload, 30000).then(function(data) {
        if (data.payment_status === 'paid') {
          markPaid(data.enquiry_reference);
          return;
        }
        retryToken = data.retry_token || retryToken;
        enquiryReference = data.enquiry_reference;
        localStorage.setItem('ieltsRetryToken', retryToken);
        localStorage.setItem('ieltsEnquiryReference', enquiryReference);
        return openCheckout(data);
      }).catch(function(error) {
        if (error.data && error.data.enquiry_reference && error.data.retry_token) {
          enquiryReference = error.data.enquiry_reference;
          retryToken = error.data.retry_token;
          localStorage.setItem('ieltsRetryToken', retryToken);
          localStorage.setItem('ieltsEnquiryReference', enquiryReference);
        }
        processing = false;
        setBuyProcessing(false);
        if (error.status === 422) {
          showOnly('buy');
          setStatus(error.message, 'error');
          return;
        }
        recoverableState(error.message, true);
        checkPaymentStatus(true, error.message);
      });
    }
    function retryPayment() {
      processing = true;
      showOnly('none');
      retryButton.disabled = true;
      setStatus('Preparing your payment, please wait...', 'info');
      return sendJson('{{ route("ielts-courses.payment.retry") }}', {
        enquiry_reference: enquiryReference,
        retry_token: retryToken
      }, 30000).then(function(data) {
        if (data.payment_status === 'paid') {
          markPaid(data.enquiry_reference);
          return;
        }
        return openCheckout(data);
      }).catch(function(error) {
        recoverableState(error.message, true);
        checkPaymentStatus(true, error.message);
      }).finally(function() {
        retryButton.disabled = false;
      });
    }
    retryButton.addEventListener('click', function() {
      if (processing) return;
      if (statusNeedsCheck) {
        checkPaymentStatus(false);
      } else if (retryToken && enquiryReference) {
        retryPayment();
      }
    });
    buyNowButton.addEventListener('pointerdown', function() {
      buyPointerDownAt = performance.now();
    });
    enrolForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (processing) return;
      var handlerStartedAt = performance.now();
      console.info('[IELTS payment timing]', {
        correlation_id: submissionKey.value,
        stage: 'click_to_submit_handler_ms',
        duration_ms: buyPointerDownAt
          ? Math.round((handlerStartedAt - buyPointerDownAt) * 100) / 100
          : 0
      });
      var validationStartedAt = performance.now();
      var okN = validateName(), okE = validateEmail(), okP = validatePhone(), okC = validateCity(), okPl = validatePlan();
      console.info('[IELTS payment timing]', {
        correlation_id: submissionKey.value,
        stage: 'frontend_validation_ms',
        duration_ms: Math.round((performance.now() - validationStartedAt) * 100) / 100
      });
      if (!okN || !okE || !okP || !okC || !okPl) {
        if (!okN) inputName.focus();
        else if (!okE) inputEmail.focus();
        else if (!okP) inputPhone.focus();
        else if (!okC) inputCity.focus();
        return;
      }
      beginPayment({
        name: inputName.value.trim(),
        email: inputEmail.value.trim(),
        phone: inputPhone.value.trim(),
        city: inputCity.value.trim(),
        plan: inputPlan.value,
        submission_key: submissionKey.value
      });
    });
    if (paidReference) {
      markPaid(paidReference);
    } else if (hasSavedSubmission || (retryToken && enquiryReference)) {
      statusNeedsCheck = true;
      showOnly('check');
      checkPaymentStatus(true, 'Checking your saved enquiry payment...');
    } else {
      showOnly('buy');
    }
  </script>
  @include('frontend.partials.chatbot')
</body>
</html>