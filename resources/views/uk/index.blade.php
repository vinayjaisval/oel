<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="description" content="Explore UK universities, courses, scholarships, admission requirements and student visa guidance. Get free personalised counselling from Overseas Education Lane." />
    <meta name="keywords" content="Study in UK, Study in UK for Indian students, UK universities, UK student visa, UK scholarships, Study abroad UK, UK university admission, Masters in UK, Bachelor's in UK" />
    <meta name="author" content="Overseas Education Lane" />

    <!-- SITE TITLE -->
    <title>Study in UK for Indian Students | Free Counselling | Overseas Education Lane</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" href="{{ asset('southkorea/images/logo.png') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('southkorea/images/logo.png') }}" type="image/x-icon" />

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- INTL TEL INPUT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />

    <!-- CUSTOM CSS -->
    <style>
        :root {
            --uk-navy: #0b2545;
            --uk-navy-dark: #071a33;
            --uk-blue: #0066cc;
            --uk-blue-light: #e8f2f7;
            --uk-accent: #ffb020;
            --uk-accent-dark: #e6960a;
            --uk-success: #10b981;
            --uk-text-dark: #1f2937;
            --uk-text-light: #6b7280;
            --uk-bg-light: #f7f9fc;
            --uk-border: #e5e7eb;
            --uk-outer-bg: #11151d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--uk-text-dark);
            line-height: 1.6;
            background-color: var(--uk-outer-bg);
        }

        /* ============ LANDING PAGE WRAPPER ============ */
        .uk-landing-page {
            width: 100%;
            background: var(--uk-outer-bg);
            padding: 24px 0;
            overflow-wrap: break-word;
        }

        .uk-landing-page img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .uk-landing-page .uk-page-container {
            max-width: 1250px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            overflow: hidden;
        }

        .uk-landing-page .uk-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .uk-landing-page a {
            text-decoration: none;
        }

        .uk-landing-page .uk-section {
            padding: 64px 0;
        }

        .uk-landing-page .uk-section-tight {
            padding: 44px 0;
        }

        .uk-landing-page .uk-bg-light {
            background: var(--uk-bg-light);
        }

        .uk-landing-page .uk-section-header {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 2.5rem;
        }

        .uk-landing-page .uk-section-header h2 {
            font-size: 2rem;
            color: var(--uk-navy);
            font-weight: 800;
            margin-bottom: 0.6rem;
            font-family: 'Poppins', sans-serif;
        }

        .uk-landing-page .uk-section-header p {
            font-size: 1.02rem;
            color: var(--uk-text-light);
        }

        /* ============ HEADER ============ */
        .uk-landing-page .uk-header {
            background: #fff;
            border-bottom: 1px solid var(--uk-border);
        }

        .uk-landing-page .uk-header-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem 1rem;
        }

        .uk-landing-page .uk-logo img {
            height: 36px;
            width: auto;
            display: block;
        }

        .uk-landing-page .uk-header-right {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem 1.25rem;
            min-width: 0;
        }

        .uk-landing-page .uk-header-phone {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--uk-navy);
            white-space: nowrap;
        }

        .uk-landing-page .uk-header-phone i {
            color: var(--uk-blue);
        }

        /* ============ BUTTONS ============ */
        .uk-landing-page .uk-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.92rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .uk-landing-page .uk-btn-primary {
            background: var(--uk-accent);
            color: var(--uk-navy-dark);
        }

        .uk-landing-page .uk-btn-primary:hover {
            background: var(--uk-accent-dark);
            transform: translateY(-2px);
            color: var(--uk-navy-dark);
        }

        .uk-landing-page .uk-btn-secondary {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, 0.6);
        }

        .uk-landing-page .uk-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .uk-landing-page .uk-btn-navy {
            background: var(--uk-navy);
            color: #fff;
        }

        .uk-landing-page .uk-btn-navy:hover {
            background: var(--uk-navy-dark);
            color: #fff;
        }

        .uk-landing-page .uk-btn-block {
            width: 100%;
        }

        .uk-landing-page .uk-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ============ HERO ============ */
        .uk-landing-page .uk-hero {
            background: linear-gradient(135deg, var(--uk-navy) 0%, var(--uk-navy-dark) 100%);
            color: #fff;
            padding: 48px 0;
            position: relative;
            overflow: hidden;
        }

        .uk-landing-page .uk-hero::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -8%;
            width: 420px;
            height: 420px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .uk-landing-page .uk-hero-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 2.5rem;
            align-items: start;
        }

        .uk-landing-page .uk-hero-grid > * {
            min-width: 0;
        }

        .uk-landing-page .uk-badge {
            display: inline-block;
            background: rgba(255, 176, 32, 0.15);
            color: var(--uk-accent);
            border: 1px solid rgba(255, 176, 32, 0.4);
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            margin-bottom: 1rem;
        }

        .uk-landing-page .uk-hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            word-break: normal;
            overflow-wrap: break-word;
        }

        .uk-landing-page .uk-hero-title .uk-highlight {
            color: var(--uk-accent);
        }

        .uk-landing-page .uk-hero-desc {
            font-size: 1.05rem;
            opacity: 0.92;
            max-width: 520px;
            margin-bottom: 1.5rem;
        }

        .uk-landing-page .uk-chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
        }

        .uk-landing-page .uk-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .uk-landing-page .uk-chip i {
            color: var(--uk-accent);
        }

        .uk-landing-page .uk-hero-ctas {
            display: flex;
            gap: 0.85rem;
            flex-wrap: wrap;
        }

        /* ============ HERO FORM CARD ============ */
        .uk-landing-page .uk-form-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.75rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
            color: var(--uk-text-dark);
        }

        .uk-landing-page .uk-form-card h3 {
            font-size: 1.3rem;
            color: var(--uk-navy);
            font-weight: 700;
            margin-bottom: 0.35rem;
            font-family: 'Poppins', sans-serif;
        }

        .uk-landing-page .uk-form-sub {
            font-size: 0.88rem;
            color: var(--uk-text-light);
            margin-bottom: 1.25rem;
        }

        .uk-landing-page .uk-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.9rem;
        }

        .uk-landing-page .uk-form-grid > * {
            min-width: 0;
        }

        .uk-landing-page .uk-form-grid .uk-form-full {
            grid-column: 1 / -1;
        }

        .uk-landing-page .uk-form-group {
            margin-bottom: 0.9rem;
        }

        .uk-landing-page .uk-label {
            display: block;
            font-weight: 600;
            color: var(--uk-text-dark);
            margin-bottom: 0.35rem;
            font-size: 0.82rem;
        }

        .uk-landing-page .uk-input {
            width: 100%;
            border: 1px solid var(--uk-border);
            border-radius: 7px;
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
            transition: all 0.25s ease;
        }

        .uk-landing-page .uk-input:focus {
            outline: none;
            border-color: var(--uk-blue);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.12);
        }

        .uk-landing-page .invalid-feedback,
        .uk-landing-page .uk-field-error {
            width: 100%;
            margin-top: 0.35rem;
            font-size: 0.8rem;
            color: #dc3545;
        }

        .uk-landing-page .uk-form-text-small {
            font-size: 0.75rem;
            color: var(--uk-text-light);
            margin-top: 0.75rem;
            line-height: 1.4;
        }

        .uk-landing-page .uk-form-submit {
            margin-top: 0.35rem;
        }

        .uk-landing-page .alert {
            border-radius: 7px;
            border: none;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .uk-landing-page .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .uk-landing-page .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .uk-landing-page .alert-info {
            background: var(--uk-blue-light);
            border: 1px solid var(--uk-blue);
            color: var(--uk-navy);
        }

        /* ============ STATS STRIP ============ */
        .uk-landing-page .uk-stats-strip {
            background: var(--uk-bg-light);
            border-bottom: 1px solid var(--uk-border);
            padding: 28px 0;
        }

        .uk-landing-page .uk-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            text-align: center;
        }

        .uk-landing-page .uk-stat {
            min-width: 0;
        }

        .uk-landing-page .uk-stat i {
            color: var(--uk-blue);
            font-size: 1.4rem;
            margin-bottom: 0.4rem;
        }

        .uk-landing-page .uk-stat strong {
            display: block;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--uk-navy);
            font-family: 'Poppins', sans-serif;
        }

        .uk-landing-page .uk-stat span {
            font-size: 0.8rem;
            color: var(--uk-text-light);
            font-weight: 500;
        }

        /* ============ GENERIC CARD ============ */
        .uk-landing-page .uk-card {
            background: #fff;
            border: 1px solid var(--uk-border);
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.25s ease;
            height: 100%;
            min-width: 0;
        }

        .uk-landing-page .uk-card:hover {
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.07);
            border-color: var(--uk-blue);
            transform: translateY(-4px);
        }

        .uk-landing-page .uk-card-icon {
            font-size: 1.6rem;
            color: var(--uk-blue);
            margin-bottom: 0.75rem;
        }

        .uk-landing-page .uk-card h4 {
            color: var(--uk-navy);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.05rem;
        }

        .uk-landing-page .uk-card p {
            color: var(--uk-text-light);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .uk-landing-page .uk-mini-link {
            display: inline-block;
            margin-top: 0.35rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--uk-blue);
        }

        .uk-landing-page .uk-mini-link:hover {
            color: var(--uk-navy);
        }

        /* ============ UNIVERSITY GRID ============ */
        .uk-landing-page .uk-uni-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .uk-landing-page .uk-uni-card {
            text-align: center;
            padding: 1.1rem 0.8rem;
        }

        .uk-landing-page .uk-uni-logo {
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.6rem;
        }

        .uk-landing-page .uk-uni-logo img {
            max-height: 56px;
            max-width: 100%;
            width: auto;
            object-fit: contain;
        }

        .uk-landing-page .uk-uni-card h4 {
            font-size: 0.92rem;
            margin-bottom: 0.3rem;
        }

        .uk-landing-page .uk-uni-card p {
            font-size: 0.78rem;
            margin-bottom: 0.3rem;
        }

        /* ============ COURSE GRID ============ */
        .uk-landing-page .uk-course-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.1rem;
        }

        /* ============ WHY GRID ============ */
        .uk-landing-page .uk-why-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.1rem;
        }

        /* ============ PROCESS ============ */
        .uk-landing-page .uk-process-step {
            position: relative;
            padding-left: 68px;
            margin-bottom: 1.6rem;
        }

        .uk-landing-page .uk-process-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 48px;
            height: 48px;
            background: var(--uk-navy);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            font-family: 'Poppins', sans-serif;
        }

        .uk-landing-page .uk-process-step h4 {
            color: var(--uk-navy);
            font-weight: 700;
            margin-bottom: 0.35rem;
            font-size: 1.02rem;
        }

        .uk-landing-page .uk-process-step p {
            color: var(--uk-text-light);
            font-size: 0.92rem;
        }

        /* ============ ELIGIBILITY ============ */
        .uk-landing-page .uk-eligibility-item {
            padding: 1.1rem 1.3rem;
            margin-bottom: 0.8rem;
        }

        .uk-landing-page .uk-eligibility-item h4 {
            font-size: 0.98rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .uk-landing-page .uk-eligibility-item h4 i {
            color: var(--uk-success);
        }

        .uk-landing-page .uk-eligibility-item p {
            font-size: 0.9rem;
            margin: 0;
        }

        /* ============ SCHOLARSHIP GRID ============ */
        .uk-landing-page .uk-scholarship-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.1rem;
        }

        /* ============ TESTIMONIALS ============ */
        .uk-landing-page .uk-testimonial-section {
            background: linear-gradient(135deg, var(--uk-navy) 0%, var(--uk-navy-dark) 100%);
            color: #fff;
        }

        .uk-landing-page .uk-testimonial-section .uk-section-header h2,
        .uk-landing-page .uk-testimonial-section .uk-section-header p {
            color: #fff;
        }

        .uk-landing-page .uk-testimonial-section .uk-section-header p {
            opacity: 0.8;
        }

        .uk-landing-page .uk-testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.1rem;
        }

        .uk-landing-page .uk-testimonial-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            min-width: 0;
        }

        .uk-landing-page .uk-testimonial-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            margin: 0 auto 0.8rem;
            object-fit: cover;
            border: 2px solid var(--uk-accent);
        }

        .uk-landing-page .uk-stars {
            color: var(--uk-accent);
            margin-bottom: 0.6rem;
            font-size: 0.85rem;
        }

        .uk-landing-page .uk-testimonial-text {
            font-style: italic;
            margin-bottom: 0.9rem;
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .uk-landing-page .uk-testimonial-author {
            font-weight: 700;
            color: var(--uk-accent);
            font-size: 0.92rem;
        }

        .uk-landing-page .uk-testimonial-role {
            font-size: 0.8rem;
            opacity: 0.75;
        }

        .uk-landing-page .uk-testimonial-university {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
            opacity: 0.9;
        }

        .uk-landing-page .uk-testimonial-university i {
            color: var(--uk-accent);
        }

        /* ============ FAQ ============ */
        .uk-landing-page .uk-faq-list {
            max-width: 820px;
            margin: 0 auto;
        }

        .uk-landing-page .uk-faq-item {
            background: #fff;
            border: 1px solid var(--uk-border);
            border-radius: 8px;
            margin-bottom: 0.75rem;
        }

        .uk-landing-page .uk-faq-header {
            padding: 1.1rem 1.3rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .uk-landing-page .uk-faq-header:hover {
            background: var(--uk-blue-light);
        }

        .uk-landing-page .uk-faq-title {
            font-weight: 600;
            color: var(--uk-navy);
            font-size: 0.98rem;
            margin: 0;
        }

        .uk-landing-page .uk-faq-toggle {
            color: var(--uk-blue);
            font-size: 1.1rem;
            transition: transform 0.25s ease;
            flex-shrink: 0;
            margin-left: 0.75rem;
        }

        .uk-landing-page .uk-faq-item.active .uk-faq-toggle {
            transform: rotate(180deg);
        }

        .uk-landing-page .uk-faq-content {
            display: none;
            padding: 0 1.3rem 1.1rem;
            color: var(--uk-text-light);
            font-size: 0.9rem;
        }

        .uk-landing-page .uk-faq-item.active .uk-faq-content {
            display: block;
        }

        /* ============ FINAL CTA ============ */
        .uk-landing-page .uk-final-cta {
            background: linear-gradient(135deg, var(--uk-navy) 0%, var(--uk-navy-dark) 100%);
            color: #fff;
            text-align: center;
            padding: 52px 0;
            position: relative;
            overflow: hidden;
        }

        .uk-landing-page .uk-final-cta h2 {
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        .uk-landing-page .uk-final-cta p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }

        .uk-landing-page .uk-final-cta-buttons {
            display: flex;
            gap: 0.85rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ============ FOOTER ============ */
        .uk-landing-page .uk-footer {
            background: var(--uk-navy-dark);
            color: #fff;
            padding: 2.5rem 0 1rem;
        }

        .uk-landing-page .uk-footer-grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr) minmax(0, 1.3fr) minmax(0, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .uk-landing-page .uk-footer-grid > div {
            min-width: 0;
        }

        .uk-landing-page .uk-footer h5 {
            font-weight: 700;
            margin-bottom: 0.9rem;
            font-size: 1rem;
        }

        .uk-landing-page .uk-footer p,
        .uk-landing-page .uk-footer a {
            font-size: 0.88rem;
            opacity: 0.85;
            color: #fff;
        }

        .uk-landing-page .uk-footer a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .uk-landing-page .uk-footer ul {
            list-style: none;
        }

        .uk-landing-page .uk-footer ul li {
            margin-bottom: 0.5rem;
        }

        .uk-landing-page .uk-footer-socials {
            display: flex;
            gap: 0.9rem;
            font-size: 1.2rem;
        }

        .uk-landing-page .uk-footer-bottom {
            text-align: center;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.65;
            font-size: 0.8rem;
        }

        /* ============ STICKY MOBILE CTA ============ */
        .uk-landing-page .uk-mobile-sticky {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid var(--uk-border);
            padding: 0.7rem;
            z-index: 999;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.12);
        }

        .uk-landing-page .uk-mobile-sticky-buttons {
            display: flex;
            gap: 0.5rem;
            max-width: 1140px;
            margin: 0 auto;
        }

        .uk-landing-page .uk-mobile-sticky-btn {
            flex: 1;
            padding: 0.7rem;
            border: none;
            border-radius: 7px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.88rem;
        }

        .uk-landing-page .uk-mobile-sticky-btn.primary {
            background: var(--uk-blue);
            color: #fff;
        }

        .uk-landing-page .uk-mobile-sticky-btn.secondary {
            background: var(--uk-blue-light);
            color: var(--uk-blue);
        }

        /* ============ FLOATING CONTACT ============ */
        .uk-landing-page .uk-floating-contact {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 998;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .uk-landing-page .uk-floating-btn {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        }

        .uk-landing-page .uk-floating-whatsapp {
            background: #25d366;
            color: #fff;
        }

        .uk-landing-page .uk-floating-whatsapp:hover {
            transform: scale(1.08);
        }

        .uk-landing-page .uk-floating-phone {
            background: var(--uk-blue);
            color: #fff;
        }

        .uk-landing-page .uk-floating-phone:hover {
            transform: scale(1.08);
        }

        /* ============ LOADING STATE ============ */
        .uk-landing-page .uk-btn-loading {
            position: relative;
            color: transparent !important;
        }

        .uk-landing-page .uk-btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid rgba(0, 0, 0, 0.25);
            border-radius: 50%;
            border-top-color: var(--uk-navy);
            animation: uk-spinner 0.8s linear infinite;
        }

        @keyframes uk-spinner {
            to { transform: rotate(360deg); }
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1024px) {
            .uk-landing-page .uk-hero-title {
                font-size: 40px;
            }

            .uk-landing-page .uk-uni-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .uk-landing-page .uk-hero-grid {
                grid-template-columns: 1fr;
            }

            .uk-landing-page .uk-form-card {
                margin-top: 1.5rem;
            }

            .uk-landing-page .uk-course-grid,
            .uk-landing-page .uk-why-grid,
            .uk-landing-page .uk-scholarship-grid,
            .uk-landing-page .uk-testimonial-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .uk-landing-page .uk-footer-grid {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            }
        }

        @media (max-width: 768px) {
            .uk-landing-page {
                padding: 0;
            }

            .uk-landing-page .uk-page-container {
                border-radius: 0;
                box-shadow: none;
            }

            .uk-landing-page .uk-inner {
                padding: 0 18px;
            }

            .uk-landing-page .uk-header-inner {
                padding: 10px 18px;
            }

            .uk-landing-page .uk-hero-title {
                font-size: 34px;
            }

            .uk-landing-page .uk-hero-desc {
                font-size: 0.98rem;
            }

            .uk-landing-page .uk-hero-ctas {
                flex-direction: column;
            }

            .uk-landing-page .uk-hero-ctas .uk-btn {
                width: 100%;
            }

            .uk-landing-page .uk-form-grid {
                grid-template-columns: 1fr;
            }

            .uk-landing-page .uk-section {
                padding: 44px 0;
            }

            .uk-landing-page .uk-section-tight {
                padding: 32px 0;
            }

            .uk-landing-page .uk-section-header h2 {
                font-size: 1.5rem;
            }

            .uk-landing-page .uk-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1.25rem;
            }

            .uk-landing-page .uk-uni-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .uk-landing-page .uk-course-grid,
            .uk-landing-page .uk-why-grid,
            .uk-landing-page .uk-scholarship-grid,
            .uk-landing-page .uk-testimonial-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .uk-landing-page .uk-process-step {
                padding-left: 56px;
            }

            .uk-landing-page .uk-process-number {
                width: 42px;
                height: 42px;
                font-size: 1.05rem;
            }

            .uk-landing-page .uk-footer-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .uk-landing-page .uk-mobile-sticky {
                display: flex;
                padding-bottom: calc(0.7rem + env(safe-area-inset-bottom));
            }

            body {
                padding-bottom: calc(58px + env(safe-area-inset-bottom));
            }

            .uk-landing-page .uk-floating-contact {
                bottom: calc(76px + 1rem);
                right: 1rem;
            }

            .uk-landing-page .uk-floating-btn {
                width: 46px;
                height: 46px;
                font-size: 1.15rem;
            }

            .uk-landing-page .uk-final-cta h2 {
                font-size: 1.4rem;
            }

            .uk-landing-page .uk-final-cta-buttons {
                flex-direction: column;
            }

            .uk-landing-page .uk-final-cta-buttons .uk-btn {
                width: 100%;
            }

            .uk-landing-page .uk-header-phone span {
                display: none;
            }
        }

        @media (max-width: 430px) {
            .uk-landing-page .uk-hero-title {
                font-size: 30px;
            }

            .uk-landing-page .uk-badge {
                font-size: 0.7rem;
            }

            .uk-landing-page .uk-stats-grid {
                gap: 1rem;
            }

            .uk-landing-page .uk-stat strong {
                font-size: 1.15rem;
            }

            .uk-landing-page .uk-header-inner .uk-btn {
                padding: 0.5rem 0.9rem;
                font-size: 0.8rem;
            }

            .uk-landing-page .uk-logo img {
                height: 30px;
            }
        }
    </style>
</head>

<body>
    <!-- GOOGLE TAG MANAGER (NOSCRIPT) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLHRGHLP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- END GOOGLE TAG MANAGER (NOSCRIPT) -->

    <!-- FACEBOOK PIXEL NOSCRIPT -->
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1184569629588476&ev=PageView&noscript=1" />
    </noscript>

    <div class="uk-landing-page">
        <div class="uk-page-container">

            <!-- HEADER -->
            <header class="uk-header">
                <div class="uk-header-inner">
                    <a class="uk-logo" href="/">
                        <img src="{{ asset('southkorea/images/logo.png') }}" alt="Overseas Education Lane">
                    </a>
                    <div class="uk-header-right">
                        <a href="tel:+918929922525" class="uk-header-phone">
                            <i class="fas fa-phone"></i> <span>+91 89299 22525</span>
                        </a>
                        <a href="#register-form" class="uk-btn uk-btn-navy uk-counselling-cta">Get Free Counselling</a>
                    </div>
                </div>
            </header>

            <!-- HERO SECTION -->
            <section class="uk-hero">
                <div class="uk-inner">
                    <div class="uk-hero-grid">
                        <div class="uk-hero-content">
                            <span class="uk-badge">STUDY IN UK &middot; 2026 INTAKE</span>
                            <h1 class="uk-hero-title">Get Admission in Top UK Universities with <span class="uk-highlight">Scholarships up to &pound;10,000</span></h1>
                            <p class="uk-hero-desc">Explore top UK universities, courses, scholarships and student visa guidance with personalised support from experienced education counsellors.</p>

                            <div class="uk-chip-row">
                                <span class="uk-chip"><i class="fas fa-check-circle"></i> Free Profile Evaluation</span>
                                <span class="uk-chip"><i class="fas fa-check-circle"></i> No IELTS Options Available</span>
                                <span class="uk-chip"><i class="fas fa-check-circle"></i> 2-Year PSW Visa</span>
                                <span class="uk-chip"><i class="fas fa-check-circle"></i> Expert Visa Assistance</span>
                            </div>

                            <div class="uk-hero-ctas">
                                <a href="#register-form" class="uk-btn uk-btn-primary uk-counselling-cta">Book Free Counselling</a>
                                <a href="#eligibility" class="uk-btn uk-btn-secondary uk-eligibility-cta">Check Eligibility</a>
                            </div>
                        </div>

                        <div class="uk-hero-form">
                            <div class="uk-form-card" id="register-form">
                                @if(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Error!</strong> {{ session('error') }}
                                    </div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success" role="alert">
                                        <strong>Success!</strong> {{ session('success') }}
                                    </div>
                                @endif

                                <h3>Get Free UK Eligibility Assessment</h3>
                                <p class="uk-form-sub">Check your profile and get personalised guidance.</p>

                                <form id="uk-lead-form" action="{{ route('send-mail-uk') }}" method="POST" novalidate>
                                    @csrf

                                    <div class="uk-form-grid">
                                        <div class="uk-form-group">
                                            <label for="name" class="uk-label">Full Name *</label>
                                            <input type="text" id="name" name="name" class="uk-input form-control @error('name') is-invalid @enderror"
                                                   placeholder="Enter your full name" required>
                                            <div class="invalid-feedback">
                                                @if($errors->has('name'))
                                                    {{ $errors->first('name') }}
                                                @else
                                                    Please enter your full name.
                                                @endif
                                            </div>
                                        </div>

                                      <div class="uk-form-group">
    <label for="phone" class="uk-label">Mobile Number *</label>

    <input
        type="tel"
        id="phone"
        name="phone"
        class="uk-input form-control @error('phone') is-invalid @enderror"
        placeholder="Enter phone number"
        required
        maxlength="10"
        inputmode="numeric"
        pattern="[0-9]{10}"
        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
    >

    <div class="uk-field-error" id="phone-error"
         style="display: {{ $errors->has('phone') ? 'block' : 'none' }};">
        @if($errors->has('phone'))
            {{ $errors->first('phone') }}
        @else
            Please enter a valid mobile number.
        @endif
    </div>
</div>

                                        <div class="uk-form-group">
                                            <label for="email" class="uk-label">Email Address *</label>
                                            <input type="email" id="email" name="email" class="uk-input form-control @error('email') is-invalid @enderror"
                                                   placeholder="your.email@example.com" required>
                                            <div class="invalid-feedback">
                                                @if($errors->has('email'))
                                                    {{ $errors->first('email') }}
                                                @else
                                                    Please enter a valid email address.
                                                @endif
                                            </div>
                                        </div>

                                        <div class="uk-form-group">
                                            <label for="study-level" class="uk-label">Study Level</label>
                                            <select id="study-level" name="study_level" class="uk-input">
                                                <option value="">Select an option</option>
                                                <option value="Bachelor's">Bachelor's Degree</option>
                                                <option value="Master's">Master's Degree</option>
                                                <option value="MBA">MBA</option>
                                                <option value="PhD">PhD</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="uk-form-group">
                                            <label for="course" class="uk-label">Preferred Course</label>
                                            <input type="text" id="course" name="course" class="uk-input"
                                                   placeholder="e.g., Business, Computer Science">
                                        </div>

                                        <div class="uk-form-group">
                                            <label for="qualification" class="uk-label">Current Qualification</label>
                                            <input type="text" id="qualification" name="qualification" class="uk-input"
                                                   placeholder="e.g., 12th Pass, Bachelor's">
                                        </div>

                                        <div class="uk-form-group">
                                            <label for="intake" class="uk-label">Preferred Intake</label>
                                            <select id="intake" name="intake" class="uk-input">
                                                <option value="">Select an option</option>
                                                <option value="January">January</option>
                                                <option value="May">May</option>
                                                <option value="September">September</option>
                                                <option value="Not Sure">Not Sure</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="uk-form-submit">
                                        <button type="submit" class="uk-btn uk-btn-primary uk-btn-block uk-submit-lead" id="uk-submit-btn">
                                            Get Free Counselling
                                        </button>
                                    </div>

                                    <p class="uk-form-text-small">
                                        Your information is safe and will only be used to contact you regarding your UK study options.
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STATISTICS STRIP -->
            <section class="uk-stats-strip">
                <div class="uk-inner">
                    <div class="uk-stats-grid">
                        <div class="uk-stat">
                            <i class="fas fa-graduation-cap"></i>
                            <strong>15,000+</strong>
                            <span>Students Guided</span>
                        </div>
                        <div class="uk-stat">
                            <i class="fas fa-user-tie"></i>
                            <strong>50+</strong>
                            <span>Expert Counsellors</span>
                        </div>
                        <div class="uk-stat">
                            <i class="fas fa-calendar-alt"></i>
                            <strong>13+</strong>
                            <span>Years of Experience</span>
                        </div>
                        <div class="uk-stat">
                            <i class="fas fa-handshake"></i>
                            <strong>End-to-End</strong>
                            <span>Application Support</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- UNIVERSITIES SECTION -->
            <section class="uk-section" id="universities">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>Top UK Universities</h2>
                        <p>Explore universities that match your academic goals.</p>
                    </div>

                    <div class="uk-uni-grid">
                        <div class="uk-card uk-uni-card">
                            <div class="uk-uni-logo"><img src="{{ asset('imagesapi/1717504808_leed.png') }}" alt="University of Leeds logo" loading="lazy"></div>
                            <h4>University of Leeds</h4>
                            <p>Leeds, England</p>
                            <a href="#register-form" class="uk-mini-link">Explore &rarr;</a>
                        </div>
                        <div class="uk-card uk-uni-card">
                            <div class="uk-uni-logo"><img src="{{ asset('imagesapi/1717573641_university-of-nottingham-logo.jpg') }}" alt="University of Nottingham logo" loading="lazy"></div>
                            <h4>University of Nottingham</h4>
                            <p>Nottingham, England</p>
                            <a href="#register-form" class="uk-mini-link">Explore &rarr;</a>
                        </div>
                        <div class="uk-card uk-uni-card">
                            <div class="uk-uni-logo"><img src="{{ asset('imagesapi/1717736527_1631598055_512x512-pixels_logo-002.png') }}" alt="University of Liverpool logo" loading="lazy"></div>
                            <h4>University of Liverpool</h4>
                            <p>Liverpool, England</p>
                            <a href="#register-form" class="uk-mini-link">Explore &rarr;</a>
                        </div>
                        <div class="uk-card uk-uni-card">
                            <div class="uk-uni-logo"><img src="{{ asset('imagesapi/1717581592_BRISTOL.jpeg') }}" alt="University of Bristol logo" loading="lazy"></div>
                            <h4>University of Bristol</h4>
                            <p>Bristol, England</p>
                            <a href="#register-form" class="uk-mini-link">Explore &rarr;</a>
                        </div>
                        <div class="uk-card uk-uni-card">
                            <div class="uk-uni-logo"><img src="{{ asset('imagesapi/1717666306_glasgow logo.jpeg') }}" alt="University of Glasgow logo" loading="lazy"></div>
                            <h4>University of Glasgow</h4>
                            <p>Glasgow, Scotland</p>
                            <a href="#register-form" class="uk-mini-link">Explore &rarr;</a>
                        </div>
                        <div class="uk-card uk-uni-card">
                            <div class="uk-uni-logo"><img src="{{ asset('imagesapi/1718695222_birm logo.png') }}" alt="University of Birmingham logo" loading="lazy"></div>
                            <h4>University of Birmingham</h4>
                            <p>Birmingham, England</p>
                            <a href="#register-form" class="uk-mini-link">Explore &rarr;</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- POPULAR COURSES SECTION -->
            <section class="uk-section uk-bg-light" id="courses">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>Popular Courses for International Students</h2>
                        <p>Choose from a wide range of programmes at UK universities.</p>
                    </div>

                    <div class="uk-course-grid">
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-laptop-code"></i></div>
                            <h4>Computer Science & IT</h4>
                            <p>Software Engineering, AI, Data Science, Cybersecurity and Cloud Computing.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-chart-line"></i></div>
                            <h4>Business & Management</h4>
                            <p>MBA, Business Administration, Marketing, HR and Entrepreneurship.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-cogs"></i></div>
                            <h4>Engineering</h4>
                            <p>Civil, Mechanical, Electrical, Aerospace and Chemical Engineering.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-brain"></i></div>
                            <h4>Data Science & AI</h4>
                            <p>Machine Learning, Big Data Analytics and Business Intelligence.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-heartbeat"></i></div>
                            <h4>Healthcare & Nursing</h4>
                            <p>Nursing, Medicine, Pharmacy and Public Health programmes.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-landmark"></i></div>
                            <h4>Law & Social Sciences</h4>
                            <p>LLB, LLM, International Law, Economics and Psychology.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- WHY STUDY IN UK SECTION -->
            <section class="uk-section" id="why-uk">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>Why Study in the UK?</h2>
                        <p>Discover the benefits of studying at UK universities.</p>
                    </div>

                    <div class="uk-why-grid">
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-star"></i></div>
                            <h4>Globally Recognised Universities</h4>
                            <p>Study at internationally recognised institutions known for academic excellence.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-briefcase"></i></div>
                            <h4>Work & Career Opportunities</h4>
                            <p>Develop skills and experience for your future career with industry-focused programmes.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-book"></i></div>
                            <h4>Affordable & Flexible</h4>
                            <p>Explore a range of universities, courses and study options to suit your budget.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-globe"></i></div>
                            <h4>Global Exposure</h4>
                            <p>Experience an international academic environment with students from 190+ countries.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-medal"></i></div>
                            <h4>Scholarship Opportunities</h4>
                            <p>Get guidance on merit-based and need-based scholarships and funding options.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-headset"></i></div>
                            <h4>Expert Support</h4>
                            <p>Get assistance throughout your application and visa journey at every step.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ADMISSION PROCESS SECTION -->
            <section class="uk-section uk-bg-light">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>Your UK Study Journey</h2>
                        <p>Follow these simple steps to start your UK education.</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="uk-process-step">
                                <div class="uk-process-number">01</div>
                                <h4>Profile Evaluation</h4>
                                <p>We assess your academic background, goals and eligibility for UK universities.</p>
                            </div>
                            <div class="uk-process-step">
                                <div class="uk-process-number">02</div>
                                <h4>University & Course Selection</h4>
                                <p>Shortlist suitable universities and courses aligned with your goals and budget.</p>
                            </div>
                            <div class="uk-process-step">
                                <div class="uk-process-number">03</div>
                                <h4>Application & Documentation</h4>
                                <p>Get guidance with applications, SOP, LOR and all required documents.</p>
                            </div>
                            <div class="uk-process-step">
                                <div class="uk-process-number">04</div>
                                <h4>Offer & Financial Guidance</h4>
                                <p>Understand your offer, fees and scholarships, and plan your finances.</p>
                            </div>
                            <div class="uk-process-step">
                                <div class="uk-process-number">05</div>
                                <h4>Visa & Pre-Departure Support</h4>
                                <p>Get comprehensive guidance for your UK Student Visa and pre-departure orientation.</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="#register-form" class="uk-btn uk-btn-navy uk-process-cta">Start My UK Application</a>
                    </div>
                </div>
            </section>

           
            <!-- SCHOLARSHIP SECTION -->
            <section class="uk-section uk-bg-light">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>Explore UK Scholarship Opportunities</h2>
                        <p>Various funding options available to help with your UK education.</p>
                    </div>

                    <div class="uk-scholarship-grid">
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-university"></i></div>
                            <h4>University Scholarships</h4>
                            <p>Merit-based, need-based and subject-specific scholarships across institutions.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-medal"></i></div>
                            <h4>Merit-Based Scholarships</h4>
                            <p>Awarded for academic excellence, often covering partial to full tuition fees.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-book"></i></div>
                            <h4>Course-Specific Funding</h4>
                            <p>Additional funding for STEM, healthcare and engineering disciplines.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-globe"></i></div>
                            <h4>Government Scholarships</h4>
                            <p>Government-funded programmes offered by UK agencies or home country governments.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-building"></i></div>
                            <h4>External Organisations</h4>
                            <p>Scholarships from NGOs, foundations, trusts and corporate organisations.</p>
                        </div>
                        <div class="uk-card">
                            <div class="uk-card-icon"><i class="fas fa-piggy-bank"></i></div>
                            <h4>Loans & Financial Aid</h4>
                            <p>Education loans and financial assistance with favourable terms for students.</p>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="#register-form" class="uk-btn uk-btn-navy uk-scholarship-cta">Check Scholarship Options</a>
                    </div>
                </div>
            </section>

            <!-- TESTIMONIALS SECTION -->
            <section class="uk-section uk-testimonial-section">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>What Our Students Say</h2>
                        <p>Real experiences from students we have guided.</p>
                    </div>

                    <div class="uk-testimonial-grid">
                        <div class="uk-testimonial-card">
                            <img src="{{ asset('southkorea/images/img/t2.png') }}" alt="Student" class="uk-testimonial-avatar">
                            <div class="uk-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="uk-testimonial-text">"Got admitted to Manchester University for MSc Computer Science with partial scholarship. The counselling team was very supportive throughout the process!"</p>
                            <p class="uk-testimonial-author">Priya Sharma</p>
                            <p class="uk-testimonial-role">MSc Computer Science</p>
                            <p class="uk-testimonial-university"><i class="fas fa-graduation-cap"></i> University of Manchester</p>
                        </div>
                        <div class="uk-testimonial-card">
                            <img src="{{ asset('southkorea/images/img/t4.png') }}" alt="Student" class="uk-testimonial-avatar">
                            <div class="uk-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="uk-testimonial-text">"Exceptional guidance for my visa application and university selection. The team helped me choose the best fit for my career goals."</p>
                            <p class="uk-testimonial-author">Sakshi Patel</p>
                            <p class="uk-testimonial-role">BA Business Administration</p>
                            <p class="uk-testimonial-university"><i class="fas fa-graduation-cap"></i> University of Edinburgh</p>
                        </div>
                        <div class="uk-testimonial-card">
                            <img src="{{ asset('southkorea/images/img/t3.png') }}" alt="Student" class="uk-testimonial-avatar">
                            <div class="uk-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="uk-testimonial-text">"From profile evaluation to visa approval, every step was smooth. The team's expertise made my UK journey stress-free!"</p>
                            <p class="uk-testimonial-author">Anjali Desai</p>
                            <p class="uk-testimonial-role">LLM Law</p>
                            <p class="uk-testimonial-university"><i class="fas fa-graduation-cap"></i> London School of Economics</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ SECTION -->
            <section class="uk-section uk-bg-light" id="faq">
                <div class="uk-inner">
                    <div class="uk-section-header">
                        <h2>Frequently Asked Questions</h2>
                        <p>Get answers to common questions about studying in the UK.</p>
                    </div>

                    <div class="uk-faq-list">
                        <div class="uk-faq-item active">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">Can Indian students study in the UK?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                Yes, Indian students can absolutely study in the UK. UK universities welcome international students including Indian nationals. You'll need a valid passport, academic qualifications, and proof of financial capability. UK student visa requirements apply for international students.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">What are the requirements to study in the UK?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                Main requirements include a valid passport, academic qualifications matching the course level, English language proficiency (IELTS/TOEFL), proof of financial capability, letters of recommendation and statement of purpose for postgraduate programmes, and sometimes entrance exams or interviews depending on the course.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">Is IELTS required to study in the UK?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                Most UK universities require IELTS or TOEFL scores to prove English proficiency. However, some universities accept alternative qualifications like CAE or equivalents, and some offer pre-sessional English programmes for students who don't meet the requirement initially.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">How much does it cost to study in the UK?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                Costs vary by university and course. Undergraduate tuition fees generally range from £10,000-£35,000 per year, while postgraduate fees range from £12,000-£40,000+ per year. Living expenses range from £12,000-£20,000 per year depending on location. We provide personalised cost estimates based on your choice.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">Can I get a scholarship to study in the UK?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                Yes, there are various scholarship opportunities available for Indian students, including university scholarships, merit-based awards, subject-specific funding, government scholarships, and external organisation grants. Our counsellors help you identify and apply for scholarships matching your profile.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">Which UK universities can I apply to?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                You can apply to any UK university that accepts international applicants, including Oxford, Cambridge, Imperial College London, LSE, Edinburgh, Manchester, Bristol, Warwick, Durham and many more. We help you identify universities best suited to your academic profile and goals.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">When should I apply?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                Most UK universities follow academic years starting in September/October, with applications typically open from September to January. Some universities have rolling admissions. It's best to apply 6-12 months before your intended intake to allow time for processing and your visa application.
                            </div>
                        </div>

                        <div class="uk-faq-item">
                            <div class="uk-faq-header">
                                <h5 class="uk-faq-title">How does the UK student visa process work?</h5>
                                <span class="uk-faq-toggle"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="uk-faq-content">
                                After receiving a university offer, you'll get a Confirmation of Acceptance for Studies (CAS). With the CAS and required documents, you apply for a Student Visa through UK Visas and Immigration. Processing typically takes about 3 weeks. Our counsellors guide you through each step.
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FINAL CTA SECTION -->
            <section class="uk-final-cta">
                <div class="uk-inner">
                    <h2>Ready to Start Your UK Study Journey?</h2>
                    <p>Get personalised guidance from our experienced UK education counsellors and take the first step toward your UK dream.</p>
                    <div class="uk-final-cta-buttons">
                        <a href="#register-form" class="uk-btn uk-btn-primary uk-final-cta-counsel">Get Free Counselling</a>
                        <a href="#eligibility" class="uk-btn uk-btn-secondary uk-final-cta-eligibility">Check Eligibility</a>
                    </div>
                </div>
            </section>

            <!-- FOOTER -->
            <footer class="uk-footer">
                <div class="uk-inner">
                    <div class="uk-footer-grid">
                        <div>
                            <h5>Overseas Education Lane</h5>
                            <p>Helping Indian students achieve their dreams of studying abroad since 2013. We provide end-to-end guidance for university selection, applications, visa assistance, and more.</p>
                        </div>
                        <div>
                            <h5>Quick Links</h5>
                            <ul>
                                <li><a href="#why-uk">Why UK</a></li>
                                <li><a href="#universities">Universities</a></li>
                                <li><a href="#courses">Courses</a></li>
                                <li><a href="#faq">FAQ</a></li>
                            </ul>
                        </div>
                        <div>
                            <h5>Contact Us</h5>
                            <p>
                                <strong>Phone:</strong> +91 8929922525<br>
                                <strong>Email:</strong> info@overseaseducationlane.com<br>
                                <strong>Hours:</strong> Mon-Sat, 9 AM - 6 PM IST
                            </p>
                        </div>
                        <div>
                            <h5>Follow Us</h5>
                            <div class="uk-footer-socials">
                                <a href="https://facebook.com/overseaseducationlane.oel/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://instagram.com/overseaseducation_lane/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://linkedin.com/company/75765761/" target="_blank"><i class="fab fa-linkedin"></i></a>
                                <a href="https://youtube.com/@OverseasEducationLane1" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-footer-bottom">
                        <p>&copy; 2025 Overseas Education Lane. All rights reserved. | Privacy Policy | Terms of Service</p>
                    </div>
                </div>
            </footer>

        </div>

        <!-- MOBILE STICKY CTA -->
        <div class="uk-mobile-sticky">
            <div class="uk-mobile-sticky-buttons">
                <button class="uk-mobile-sticky-btn secondary uk-mobile-whatsapp" onclick="window.open('https://wa.me/8929922525', '_blank')">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </button>
                <button class="uk-mobile-sticky-btn primary uk-mobile-call" onclick="window.location.href='tel:+918929922525'">
                    <i class="fas fa-phone"></i> Call
                </button>
            </div>
        </div>

        <!-- FLOATING CONTACT BUTTONS (DESKTOP) -->
        <div class="uk-floating-contact">
            <a href="https://wa.me/8929922525" target="_blank" class="uk-floating-btn uk-floating-whatsapp uk-whatsapp-cta" title="Chat on WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="tel:+918929922525" class="uk-floating-btn uk-floating-phone uk-phone-cta" title="Call Us">
                <i class="fas fa-phone"></i>
            </a>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        // INTL TEL INPUT SETUP
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "in",
            preferredCountries: ["in", "gb", "us"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js"
        });

        // FORM SUBMISSION TRACKING
        document.getElementById('uk-lead-form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('uk-submit-btn');
            submitBtn.disabled = true;
            submitBtn.classList.add('uk-btn-loading');
            submitBtn.textContent = 'Submitting...';

            // Trigger conversion tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'uk_form_submit', {
                    'event_category': 'engagement',
                    'event_label': 'UK Lead Form Submission'
                });
            }

            // Facebook Pixel
            if (typeof fbq !== 'undefined') {
                fbq('track', 'Lead', {
                    content_name: 'UK Study Enquiry'
                });
            }
        });

        // FAQ ACCORDION
        document.querySelectorAll('.uk-faq-header').forEach(header => {
            header.addEventListener('click', function() {
                const faqItem = this.parentElement;

                // Close all other FAQs
                document.querySelectorAll('.uk-faq-item').forEach(item => {
                    if (item !== faqItem) {
                        item.classList.remove('active');
                    }
                });

                // Toggle current FAQ
                faqItem.classList.toggle('active');
            });
        });

        // CTA BUTTON TRACKING
        document.querySelectorAll('[class*="uk-"][class*="-cta"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const btnClass = this.className;
                let eventLabel = 'CTA Click';

                if (btnClass.includes('counselling') || btnClass.includes('counsel')) eventLabel = 'UK Counselling CTA';
                else if (btnClass.includes('eligibility')) eventLabel = 'Eligibility Check CTA';
                else if (btnClass.includes('whatsapp')) eventLabel = 'WhatsApp Click';
                else if (btnClass.includes('phone')) eventLabel = 'Phone Click';

                if (typeof gtag !== 'undefined') {
                    gtag('event', 'page_click', {
                        'event_category': 'engagement',
                        'event_label': eventLabel
                    });
                }
            });
        });

        // FLOATING CONTACT VISIBILITY ON SCROLL
        window.addEventListener('scroll', function() {
            const floatingContact = document.querySelector('.uk-floating-contact');
            if (window.scrollY > 200) {
                floatingContact.style.display = 'flex';
            } else {
                floatingContact.style.display = 'none';
            }
        });

        // NAVBAR SMOOTH SCROLL
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // FORM VALIDATION
        const form = document.getElementById('uk-lead-form');
        const phoneErrorEl = document.getElementById('phone-error');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }

            // intl-tel-input wraps #phone in its own container, which breaks the
            // CSS sibling selector Bootstrap relies on to auto-show .invalid-feedback,
            // so its message visibility is toggled manually here instead.
            if (phoneInputField && !phoneInputField.checkValidity()) {
                phoneInputField.classList.add('is-invalid');
                phoneErrorEl.style.display = 'block';
            } else if (phoneInputField) {
                phoneInputField.classList.remove('is-invalid');
                phoneErrorEl.style.display = 'none';
            }

            form.classList.add('was-validated');
        }, false);
    </script>

    <!-- GOOGLE TAG MANAGER -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KLHRGHLP');
    </script>

    <!-- GOOGLE ANALYTICS -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T9PKC9W1V2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-T9PKC9W1V2');
    </script>

    <!-- FACEBOOK PIXEL -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1184569629588476');
        fbq('track', 'PageView');
    </script>
</body>

</html>
