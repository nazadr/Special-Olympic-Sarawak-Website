<?php
// Placeholder for future database integration
$song26Data = [];

// Check if page is in standalone mode (opened from index as special event page)
$isStandalone = isset($_GET['standalone']) && $_GET['standalone'] == '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Malaysia — 6th National Games | SONG 26</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Local style within this HTML */
        :root {
            --so-red: #FF0000;
            --so-white: #ffffff;
            --so-dark: #1a1a1a;
            --so-gray: #666;
            --so-light-gray: #f5f5f5;
            --shadow-sm: 0 2px 10px rgba(255, 0, 0, 0.08);
            --shadow-md: 0 4px 20px rgba(255, 0, 0, 0.12);
            --shadow-lg: 0 8px 30px rgba(255, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header-space {
            height: 70px;
            background: transparent;
        }

        .body {
            background-color: var(--so-white);
            overflow-y: auto;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }

        /* Hero Section - SEA Games Inspired */
        .song26-hero {
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            padding: 10px 20px 80px;
        }

        .song26-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.06) 0%, transparent 50%);
            pointer-events: none;
        }

        .song26-hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .song26-hero-logo {
            width: 280px;
            height: 280px;
            margin-bottom: 15px;
            filter: brightness(0) invert(1) drop-shadow(0 4px 20px rgba(0,0,0,0.2));
            animation: floatLogo 3s ease-in-out infinite;
        }

        /* Countdown Clock Styles (inverted colors: white card, red text) */
        .song26-countdown {
            display: flex;
            gap: 18px;
            justify-content: center;
            align-items: center;
            margin: 8px 0 22px;
            z-index: 3;
        }
        .song26-countdown-part {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.98);
            border-radius: 10px;
            padding: 8px 14px;
            min-width: 72px;
            border: 1px solid rgba(255,0,0,0.10);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            color: var(--so-red);
        }
        .song26-countdown-part span {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--so-red);
            line-height: 1;
            letter-spacing: 0.5px;
            transition: transform 220ms ease, color 200ms ease;
        }
        .song26-countdown-label {
            font-size: 0.82rem;
            color: var(--so-red);
            opacity: 0.95;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        @media (max-width: 640px) {
            .song26-countdown { gap: 8px; }
            .song26-countdown-part { padding: 6px 8px; min-width: 48px; }
            .song26-countdown-part span { font-size: 1.1rem; }
            .song26-countdown-label { font-size: 0.65rem; }
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .song26-hero-location {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
            opacity: 0.9;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.95);
        }

        /* Both titles with prominent headline style */
        .song26-hero h1 {
            font-size: 3.2rem;
            font-weight: 900;
            margin-bottom: 6px;
            line-height: 1.05;
            letter-spacing: -1px;
            text-transform: uppercase;
            opacity: 1;
        }

        .song26-hero-subtitle {
            font-size: 3.2rem;
            font-weight: 900;
            margin-bottom: 18px;
            opacity: 1;
            letter-spacing: -1px;
            text-transform: uppercase;
            line-height: 1.05;
        }

        .song26-hero-date {
            font-size: 2rem;
            font-weight: 600;
            margin-top: 10px;
            padding: 15px 40px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            display: inline-block;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .song26-hero-logo-inline {
            display: none;
        }

        /* Hero Sponsor Showcase - Desktop Only */
        .song26-hero-sponsors {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 25px 20px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 16px;
            border: 2px solid rgba(255, 0, 0, 0.15);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 0, 0, 0.08);
            width: 240px;
            max-height: 60vh;
            overflow-y: auto;
            overflow-x: hidden;
            animation: fadeInRight 1s ease 0.3s backwards;
            scrollbar-width: thin;
            scrollbar-color: var(--so-red) rgba(255, 0, 0, 0.05);
            scroll-behavior: smooth;
        }
        
        .song26-hero-sponsors::-webkit-scrollbar {
            width: 8px;
        }
        
        .song26-hero-sponsors::-webkit-scrollbar-track {
            background: rgba(255, 0, 0, 0.05);
            border-radius: 4px;
            margin: 8px 0;
        }
        
        .song26-hero-sponsors::-webkit-scrollbar-thumb {
            background: var(--so-red);
            border-radius: 4px;
            transition: background 0.2s ease;
        }
        
        .song26-hero-sponsors::-webkit-scrollbar-thumb:hover {
            background: #cc0000;
        }

        /* Gradient fade effect at top and bottom */
        .song26-hero-sponsors::before {
            content: '';
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.98) 0%, transparent 100%);
            z-index: 1;
            pointer-events: none;
        }

        .song26-hero-sponsors::after {
            content: '';
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.98) 0%, transparent 100%);
            z-index: 1;
            pointer-events: none;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .song26-hero-sponsors-title {
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            color: var(--so-red);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(255, 0, 0, 0.15);
        }

        .song26-hero-sponsor-tier {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .song26-hero-sponsor-tier-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--so-red);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-left: 4px;
            margin-bottom: 4px;
        }

        /* Color-code each tier inside the hero sponsors card */
        .song26-hero-sponsors > .song26-hero-sponsor-tier:nth-child(2) .song26-hero-sponsor-tier-label {
            /* Platinum - light metallic */
            color: #666161c4;
        }
        .song26-hero-sponsors > .song26-hero-sponsor-tier:nth-child(3) .song26-hero-sponsor-tier-label {
            /* Gold */
            color: #D4AF37;
        }
        .song26-hero-sponsors > .song26-hero-sponsor-tier:nth-child(4) .song26-hero-sponsor-tier-label {
            /* Silver */
            color: #B0B0B0;
        }

        .song26-hero-sponsor-logos {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .song26-hero-sponsor-item {
            background: var(--so-light-gray);
            border-radius: 8px;
            padding: 12px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 0, 0, 0.1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .song26-hero-sponsor-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.15);
            border-color: var(--so-red);
            background: var(--so-white);
        }

        .song26-hero-sponsor-item-small {
            padding: 10px 8px;
        }

        .song26-hero-sponsor-placeholder {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--so-red);
            text-align: center;
        }

        /* Hide sponsors on mobile/tablet */
        @media (max-width: 1200px) {
            .song26-hero-sponsors {
                display: none;
            }
        }

        /* Main Content Container - Full Width Sections */
        .song26-main-content {
            background: var(--so-white);
        }

        /* Full Width Section Wrapper */
        .song26-full-section {
            width: 100%;
            padding: 80px 0;
        }

        .song26-full-section.gray-bg {
            background: var(--so-light-gray);
        }

        .song26-full-section.white-bg {
            background: var(--so-white);
        }

        .song26-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Section Title - SEA Games Style */
        .song26-section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .song26-section-title h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--so-dark);
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }

        .song26-section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--so-red);
            border-radius: 2px;
        }

        .song26-section-title p {
            font-size: 1.2rem;
            color: var(--so-gray);
            max-width: 700px;
            margin: 25px auto 0;
            line-height: 1.8;
        }

        /* Info Cards - Enhanced Grid */
        .song26-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .song26-info-card {
            background: var(--so-white);
            border-radius: 20px;
            padding: 50px 35px;
            text-align: center;
            transition: var(--transition);
            border: 2px solid transparent;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .song26-info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--so-red) 0%, #ff4d6d 100%);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .song26-info-card:hover::before {
            transform: scaleX(1);
        }

        .song26-info-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--so-red);
        }

        .song26-icon-wrapper {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.3);
            transition: var(--transition);
        }

        .song26-info-card:hover .song26-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .song26-info-card i {
            font-size: 2.5rem;
            color: var(--so-white);
        }

        .song26-info-card h3 {
            font-size: 1.5rem;
            color: var(--so-dark);
            margin-bottom: 15px;
            font-weight: 700;
        }

        .song26-info-card p {
            font-size: 1.05rem;
            color: var(--so-gray);
            line-height: 1.7;
        }

        /* Content Sections - Full Width Alternating */
        .song26-content-section {
            padding: 70px 0;
            text-align: center;
        }

        .song26-content-box {
            max-width: 900px;
            margin: 0 auto;
            padding: 50px;
            background: var(--so-white);
            border-radius: 25px;
            box-shadow: var(--shadow-md);
            border-left: 5px solid var(--so-red);
        }

        .song26-content-box h3 {
            font-size: 2rem;
            color: var(--so-red);
            margin-bottom: 25px;
            font-weight: 700;
        }

        .song26-content-box p {
            font-size: 1.15rem;
            color: var(--so-dark);
            line-height: 1.9;
        }

        /* Motto Section - Special Highlight */
        .song26-motto-section {
            padding: 100px 40px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 60px;
        }

        .song26-motto-section::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 15rem;
            color: rgba(255,255,255,0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .song26-motto-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 0 auto;
        }

        .song26-motto-content h3 {
            font-size: 1.5rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 300;
        }

        .song26-motto-content p {
            font-size: 2.2rem;
            color: var(--so-white);
            font-weight: 300;
            line-height: 1.6;
            font-style: italic;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* Participation Grid */
        .song26-participation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .song26-sport-card {
            background: var(--so-white);
            padding: 30px 25px;
            border-radius: 15px;
            border-left: 4px solid var(--so-red);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            text-align: left;
        }

        .song26-sport-card:hover {
            transform: translateX(5px);
            box-shadow: var(--shadow-md);
        }

        .song26-sport-card::before {
            content: '◆';
            color: var(--so-red);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Get Involved Section */
        .song26-involvement-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .song26-involvement-card {
            background: var(--so-white);
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-top: 5px solid var(--so-red);
            text-align: left;
        }

        .song26-involvement-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .song26-involvement-card h4 {
            font-size: 1.4rem;
            color: var(--so-red);
            margin-bottom: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .song26-involvement-card h4::before {
            content: '►';
            font-size: 1rem;
        }

        .song26-involvement-card p {
            font-size: 1.05rem;
            color: var(--so-dark);
            line-height: 1.7;
        }

        /* Organizing Committee - Enhanced Layout */
        .song26-committee-section {
            padding: 80px 0;
            background: var(--so-light-gray);
        }

        .song26-committee-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--so-dark);
            text-align: center;
            margin-bottom: 60px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .song26-committee-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--so-red);
            border-radius: 2px;
        }

        .song26-committee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 35px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .song26-committee-card {
            background: var(--so-white);
            border-radius: 20px;
            padding: 45px 30px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-top: 4px solid var(--so-red);
            position: relative;
        }

        .song26-committee-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .song26-committee-photo {
            width: 160px;
            height: 160px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255, 0, 0, 0.1);
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.2);
        }

        .song26-committee-card:hover .song26-committee-photo {
            transform: scale(1.08);
            box-shadow: 0 12px 35px rgba(255, 0, 0, 0.3);
        }

        .song26-committee-photo i {
            font-size: 2.8rem;
            color: var(--so-white);
        }

        .song26-committee-photo img {
            width: 82%;
            height: 82%;
            object-fit: contain;
            border-radius: 6px;
            background: white;
            padding: 6px;
            display: block;
        }

        /* When there's no uploaded logo, remove the red bubble and heavy shadow */
        .song26-committee-photo.no-logo {
            background: transparent !important;
            box-shadow: none !important;
            border: 0 !important;
        }

        .song26-committee-photo.no-logo i {
            font-size: 1.6rem;
            color: var(--so-dark);
            background: transparent;
            box-shadow: none;
        }

        .song26-committee-role {
            font-size: 0.95rem;
            color: var(--so-red);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .song26-committee-name {
            font-size: 1.25rem;
            color: var(--so-dark);
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .song26-committee-position {
            font-size: 0.95rem;
            color: var(--so-gray);
            font-style: italic;
        }

        .song26-committee-hierarchy,
        .song26-committee-level,
        .song26-committee-member {
            display: none;
        }

        /* Sponsors Section */
        .song26-sponsors-section {
            padding: 80px 0;
            background: var(--so-white);
        }

        .song26-sponsors-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--so-dark);
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .song26-sponsors-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--so-red);
            border-radius: 2px;
        }

        .song26-sponsors-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--so-gray);
            margin-bottom: 60px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .song26-sponsor-tier {
            margin-bottom: 60px;
        }

        .song26-sponsor-tier-title {
            text-align: center;
            font-size: 1.5rem;
            color: var(--so-red);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        .song26-sponsors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .song26-sponsor-card {
            background: var(--so-white);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 180px;
        }

        .song26-sponsor-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--so-red);
        }

        .song26-sponsor-logo {
            max-width: 100%;
            max-height: 100px;
            object-fit: contain;
            filter: grayscale(100%);
            transition: var(--transition);
        }

        .song26-sponsor-card:hover .song26-sponsor-logo {
            fliter:grayscale(0%);
        }

        .song26-sponsor-placeholder {
            width: 100%;
            height: 100px;
            background: var(--so-light-gray);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--so-gray);
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Sport Tabs - Bookmark Style */
        .song26-sport-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
            border-bottom: 3px solid var(--so-light-gray);
            padding-bottom: 0;
        }

        .song26-sport-tab {
            padding: 15px 25px;
            background: var(--so-light-gray);
            border: none;
            border-radius: 12px 12px 0 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--so-gray);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            border-bottom: 3px solid transparent;
        }

        .song26-sport-tab:hover {
            background: rgba(255, 0, 0, 0.1);
            color: var(--so-red);
        }

        .song26-sport-tab.active {
            background: var(--so-white);
            color: var(--so-red);
            border-bottom: 3px solid var(--so-red);
            box-shadow: 0 -3px 10px rgba(255, 0, 0, 0.1);
        }

        /* Standings Container */
        .song26-standings-container {
            margin-bottom: 40px;
        }

        .song26-standings-table {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .song26-standings-table.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Table Wrapper */
        .song26-table-wrapper {
            background: var(--so-white);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 2px solid var(--so-light-gray);
        }

        /* Table Styles */
        .song26-table {
            width: 100%;
            border-collapse: collapse;
        }

        .song26-table thead {
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            color: var(--so-white);
        }

        .song26-table thead th {
            padding: 20px 15px;
            text-align: left;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .song26-table thead th.text-center {
            text-align: center;
        }

        .song26-table tbody tr {
            border-bottom: 1px solid var(--so-light-gray);
            transition: var(--transition);
        }

        .song26-table tbody tr:hover {
            background: rgba(255, 0, 0, 0.05);
        }

        .song26-table tbody tr:last-child {
            border-bottom: none;
        }

        .song26-table tbody td {
            padding: 18px 15px;
            font-size: 1.05rem;
            color: var(--so-dark);
        }

        /* Ensure state names in tables are fully capitalized */
        .song26-table .state-cell,
        .song26-table tbody td:nth-child(2) {
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .song26-table tbody td:first-child {
            font-weight: 700;
            color: var(--so-red);
            font-size: 1.1rem;
            text-align: center;
        }

        .song26-table .text-center {
            text-align: center;
        }

        /* Rank Badges */
        .song26-table .rank-1,
        .song26-table .rank-2,
        .song26-table .rank-3 {
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 25px;
            display: inline-block;
            color: var(--so-white);
            font-size: 1rem;
        }

        .song26-table .rank-1 {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        .song26-table .rank-2 {
            background: linear-gradient(135deg, #C0C0C0 0%, #808080 100%);
            box-shadow: 0 4px 12px rgba(192, 192, 192, 0.3);
        }

        .song26-table .rank-3 {
            background: linear-gradient(135deg, #CD7F32 0%, #8B4513 100%);
            box-shadow: 0 4px 12px rgba(205, 127, 50, 0.3);
        }

        /* Medal Table Specific Styles */
        .song26-medal-standings {
            margin-top: 40px;
        }

        .song26-medal-table thead th {
            padding: 20px 12px;
        }

        .song26-medal-table .medal-col i {
            margin-right: 5px;
            font-size: 1rem;
        }

        .song26-medal-table .gold-col {
            color: rgba(255, 255, 255, 0.95);
        }

        .song26-medal-table .silver-col {
            color: rgba(255, 255, 255, 0.95);
        }

        .song26-medal-table .bronze-col {
            color: rgba(255, 255, 255, 0.95);
        }

        .song26-medal-table .total-col {
            color: rgba(255, 255, 255, 1);
            font-weight: 800;
        }

        .song26-medal-table tbody .medal-count,
        .song26-medal-table tbody .total-count {
            font-size: 1.15rem;
            font-weight: 600;
        }

        .song26-medal-table tbody .gold-count {
            color: #B8860B;
            font-weight: 700;
        }

        .song26-medal-table tbody .silver-count {
            color: #6B7280;
            font-weight: 700;
        }

        .song26-medal-table tbody .bronze-count {
            color: #92400E;
            font-weight: 700;
        }

        .song26-medal-table tbody .total-count {
            color: var(--so-red);
            font-size: 1.25rem;
        }

        .song26-medal-table tbody .state-cell {
            font-weight: 600;
        }

        .song26-medal-table tbody .rank-1-row {
            background: linear-gradient(90deg, rgba(255, 215, 0, 0.1) 0%, transparent 100%);
        }

        .song26-medal-table tbody .rank-2-row {
            background: linear-gradient(90deg, rgba(192, 192, 192, 0.1) 0%, transparent 100%);
        }

        .song26-medal-table tbody .rank-3-row {
            background: linear-gradient(90deg, rgba(205, 127, 50, 0.1) 0%, transparent 100%);
        }

        .song26-medal-table tbody .rank-cell {
            font-size: 1.2rem;
        }

        /* Logo Section */
        .song26-logo-section {
            text-align: center;
            margin: 60px 0;
        }

        .song26-logo-card {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 36px 0 48px;
        }

        .song26-logo-placeholder {
            display: none;
        }

        /* Side Navigation Bar - Dynamic Animated Desktop Only */
        .song26-side-nav {
            position: fixed;
            left: 30px;
            top: 270px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 25px 22px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(249, 249, 255, 0.94));
            border-radius: 14px;
            border: 1px solid rgba(226, 27, 35, 0.12);
            backdrop-filter: blur(12px);
            box-shadow: 
                0 8px 32px rgba(226, 27, 35, 0.08),
                0 0 0 1px rgba(226, 27, 35, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            animation: navSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
        }

        @keyframes navSlideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes navFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        .song26-side-nav::before {
            display: none;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .song26-side-nav:hover {
            box-shadow: 
                0 16px 48px rgba(226, 27, 35, 0.15),
                0 0 0 1px rgba(226, 27, 35, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border-color: rgba(226, 27, 35, 0.2);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(255, 248, 248, 0.96));
            animation: navFloat 4s ease-in-out infinite;
        }

        .song26-side-nav:hover::before {
            display: none;
        }

        .song26-nav-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .song26-nav-item {
            position: relative;
            animation: itemFadeIn 0.5s ease backwards;
        }

        .song26-nav-item:nth-child(1) { animation-delay: 0.1s; }
        .song26-nav-item:nth-child(2) { animation-delay: 0.15s; }
        .song26-nav-item:nth-child(3) { animation-delay: 0.2s; }
        .song26-nav-item:nth-child(4) { animation-delay: 0.25s; }
        .song26-nav-item:nth-child(5) { animation-delay: 0.3s; }
        .song26-nav-item:nth-child(6) { animation-delay: 0.35s; }
        .song26-nav-item:nth-child(7) { animation-delay: 0.4s; }

        @keyframes itemFadeIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .song26-nav-link {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-decoration: none;
            color: #666;
            font-family: 'Ubuntu', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            letter-spacing: 0.35px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 8px 10px;
            margin: 0 -10px;
            position: relative;
            gap: 11px;
            border-radius: 8px;
            overflow: hidden;
        }

        .song26-nav-link::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(226, 27, 35, 0.03), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .song26-nav-link::before {
            content: '•';
            color: var(--so-red);
            font-size: 1.4rem;
            line-height: 1;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-weight: 700;
            text-shadow: 0 0 0 rgba(226, 27, 35, 0);
        }

        .song26-nav-link:hover {
            color: var(--so-red);
            transform: translateX(6px);
            background: linear-gradient(135deg, rgba(226, 27, 35, 0.06), rgba(226, 27, 35, 0.02));
        }

        .song26-nav-link:hover::after {
            opacity: 1;
        }

        .song26-nav-link:hover::before {
            transform: scale(1.25) rotate(15deg);
            text-shadow: 0 0 12px rgba(226, 27, 35, 0.4);
        }

        .song26-nav-link.active {
            color: var(--so-red);
            font-weight: 600;
            background: linear-gradient(135deg, rgba(226, 27, 35, 0.08), rgba(226, 27, 35, 0.04));
            box-shadow: inset 0 0 12px rgba(226, 27, 35, 0.08);
        }

        .song26-nav-link.active::before {
            transform: scale(1.3);
            text-shadow: 0 0 16px rgba(226, 27, 35, 0.5);
            animation: bulletPulse 2s ease-in-out infinite;
        }

        @keyframes bulletPulse {
            0%, 100% { transform: scale(1.3); }
            50% { transform: scale(1.45); }
        }

        .song26-nav-dot {
            display: none;
        }

        .song26-nav-dot::before {
            display: none;
        }

        .song26-nav-dot::after {
            display: none;
        }

        .song26-nav-link:hover .song26-nav-dot {
            display: none;
        }

        .song26-nav-link:hover .song26-nav-dot::before {
            display: none;
        }

        .song26-nav-link.active .song26-nav-dot {
            display: none;
        }

        @keyframes dotPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 1; }
        }

        .song26-nav-link.active .song26-nav-dot::before {
            display: none;
        }

        .song26-nav-link.active .song26-nav-dot::after {
            display: none;
        }

        @keyframes dotRing {
            0% { opacity: 0; }
            100% { opacity: 0; }
        }

        .song26-nav-label {
            opacity: 1;
            visibility: visible;
            position: static;
            background: transparent;
            color: inherit;
            padding: 0;
            border-radius: 0;
            font-family: 'Ubuntu', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: auto;
            box-shadow: none;
            letter-spacing: 0.35px;
            text-transform: none;
            transform: none;
        }

        .song26-nav-label::before {
            display: none;
        }

        .song26-nav-label::after {
            display: none;
        }

        .song26-nav-link:hover .song26-nav-label,
        .song26-nav-link.active .song26-nav-label {
            opacity: 1;
            visibility: visible;
            position: static;
            transform: none;
        }

        .song26-nav-link:hover .song26-nav-label::before {
            display: none;
        }

        .song26-nav-link.active .song26-nav-label {
            background: transparent;
            box-shadow: none;
            color: var(--so-red);
            font-weight: 600;
            letter-spacing: 0.4px;
        }

        /* Mobile Navigation Toggle - Futuristic Button */
        .song26-nav-toggle {
            display: none;
            position: fixed;
            left: 20px;
            bottom: 30px;
            z-index: 1001;
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            border-radius: 50%;
            border: none;
            color: var(--so-white);
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 
                0 10px 35px rgba(255, 0, 0, 0.5),
                0 0 0 4px rgba(255, 0, 0, 0.1),
                inset 0 2px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .song26-nav-toggle::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent);
            border-radius: 50%;
            transition: all 0.6s ease;
        }

        .song26-nav-toggle:hover::before {
            width: 100%;
            height: 100%;
        }

        .song26-nav-toggle::after {
            content: '';
            position: absolute;
            inset: -3px;
            background: linear-gradient(45deg, var(--so-red), #ff4d6d, var(--so-red));
            background-size: 200% 200%;
            border-radius: 50%;
            z-index: -1;
            opacity: 0;
            animation: gradientShift 3s ease infinite;
            transition: opacity 0.4s ease;
        }

        .song26-nav-toggle:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 
                0 15px 45px rgba(255, 0, 0, 0.6),
                0 0 0 6px rgba(255, 0, 0, 0.2),
                inset 0 2px 0 rgba(255, 255, 255, 0.3);
        }

        .song26-nav-toggle:hover::after {
            opacity: 1;
        }

        .song26-nav-toggle:active {
            transform: scale(1.05) rotate(5deg);
        }

        .song26-nav-toggle i {
            position: relative;
            z-index: 1;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .song26-nav-toggle.active {
            transform: rotate(90deg);
            background: linear-gradient(135deg, #ff4d6d 0%, var(--so-red) 100%);
        }

        .song26-nav-toggle.active i {
            transform: rotate(90deg);
        }

        /* Desktop Only - Hide navigation on all mobile/tablet views */
        @media (max-width: 1200px) {
            .song26-side-nav {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .song26-side-nav,
            .song26-nav-toggle {
                display: none !important;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .song26-hero {
                min-height: 60vh;
                padding: 60px 20px;
            }

            .song26-hero h1 {
                font-size: 2.2rem;
            }

            .song26-hero-location {
                font-size: 1.1rem;
            }

            .song26-hero-subtitle {
                font-size: 1.1rem;
            }

            .song26-hero-date {
                font-size: 1.5rem;
                padding: 12px 30px;
            }

            .song26-hero-logo {
                width: 100px;
                height: 100px;
                margin-bottom: 20px;
            }

            .song26-container {
                padding: 0 20px;
            }

            .song26-full-section {
                padding: 50px 0;
            }

            .song26-section-title h2 {
                font-size: 2rem;
            }

            .song26-section-title p {
                font-size: 1.05rem;
            }

            .song26-info-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .song26-info-card {
                padding: 35px 25px;
            }

            .song26-content-box {
                padding: 35px 25px;
            }

            .song26-content-box h3 {
                font-size: 1.6rem;
            }

            .song26-motto-section {
                padding: 70px 20px;
            }

            .song26-motto-content p {
                font-size: 1.6rem;
            }

            .song26-participation-grid,
            .song26-involvement-grid {
                grid-template-columns: 1fr;
            }

            .song26-sport-tabs {
                gap: 5px;
            }

            .song26-sport-tab {
                padding: 12px 18px;
                font-size: 0.9rem;
            }

            .song26-table-wrapper {
                overflow-x: auto;
            }

            .song26-table {
                min-width: 600px;
            }

            .song26-table thead th {
                padding: 15px 10px;
                font-size: 0.95rem;
            }

            .song26-table tbody td {
                padding: 15px 10px;
                font-size: 0.95rem;
            }

            .song26-medal-table .medal-col i {
                display: none;
            }

            /* Mobile Navigation - Left Side */
            .song26-side-nav {
                left: -320px;
                top: auto;
                bottom: 110px;
                transform: none;
                border-radius: 0 25px 25px 0;
                padding: 35px 30px;
                transition: left 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                animation: none;
                width: 280px;
                max-width: 85vw;
            }

            .song26-side-nav.active {
                left: 0;
                box-shadow: 
                    5px 0 40px rgba(255, 0, 0, 0.25),
                    0 0 0 1px rgba(255, 0, 0, 0.15);
            }

            .song26-nav-items {
                gap: 22px;
            }

            .song26-nav-link {
                flex-direction: row;
                justify-content: flex-start;
                font-size: 1.05rem;
                padding: 12px 0;
            }

            .song26-nav-link::before {
                left: -20px;
            }

            .song26-nav-dot {
                margin-right: 18px;
                margin-left: 0;
                width: 16px;
                height: 16px;
            }

            .song26-nav-label {
                opacity: 1;
                visibility: visible;
                position: relative;
                left: auto;
                background: transparent;
                color: var(--so-gray);
                padding: 0;
                box-shadow: none;
                pointer-events: auto;
                transform: none;
                font-size: 1rem;
                text-transform: none;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .song26-nav-label::before,
            .song26-nav-label::after {
                display: none;
            }

            .song26-nav-link:hover .song26-nav-label,
            .song26-nav-link.active .song26-nav-label {
                color: var(--so-red);
                left: auto;
                transform: none;
            }

            .song26-nav-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .song26-committee-section {
                padding: 50px 0;
            }

            .song26-committee-title {
                font-size: 2rem;
                margin-bottom: 40px;
            }

            .song26-committee-grid {
                grid-template-columns: 1fr;
                gap: 25px;
                padding: 0 20px;
            }

            .song26-sponsors-section {
                padding: 50px 0;
            }

            .song26-sponsors-title {
                font-size: 2rem;
            }

            .song26-sponsors-grid {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 20px;
            }
        }

        /* Sport Venue Details Styles */
        .song26-sport-card-wrapper {
            grid-column: span 1;
        }

        .song26-sport-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: visible;
        }

        .song26-sport-card.active {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(231, 76, 60, 0.4);
        }

        /* Desktop: Hide inline venue details */
        .song26-venue-details {
            display: none;
        }

        /* Desktop: Shared Bubble Card */
        .song26-shared-venue-bubble {
            max-height: 0;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 0;
            opacity: 0;
            transform: translateY(-20px);
        }

        .song26-shared-venue-bubble.active {
            max-height: 2000px;
            margin-top: 50px;
            opacity: 1;
            transform: translateY(0);
        }

        .song26-venue-bubble-card {
            background: #ffffff;
            border-radius: 40px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.15),
                0 10px 30px rgba(231, 76, 60, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            padding: 50px 60px;
            position: relative;
            overflow: hidden;
        }

        .song26-venue-bubble-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #e74c3c, #c0392b, #e74c3c);
            border-radius: 40px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .song26-venue-bubble-card:hover::before {
            opacity: 0.1;
        }

        .song26-venue-content {
            padding: 30px;
        }

        .song26-venue-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #e74c3c;
        }

        .song26-venue-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
        }

        .song26-venue-title h3 {
            margin: 0;
            color: #2c3e50;
            font-size: 26px;
            font-weight: 700;
        }

        .song26-venue-title p {
            margin: 5px 0 0 0;
            color: #7f8c8d;
            font-size: 15px;
        }

        .song26-venue-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-top: 25px;
        }

        .song26-venue-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
        }

        .song26-venue-section h4 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .song26-venue-section h4 i {
            color: #e74c3c;
        }

        .song26-venue-map {
            width: 100%;
            height: 350px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* Carousel Container */
        .song26-venue-photo-carousel {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            background: #f8f9fa;
            padding: 15px;
            height: 260px;
        }

        .song26-venue-photos {
            display: flex;
            gap: 0;
            height: 100%;
            transition: transform 0.5s ease;
            position: relative;
        }

        .song26-venue-photo {
            min-width: 100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ecf0f1, #bdc3c7);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            flex-shrink: 0;
        }

        /* Carousel Navigation Buttons */
        .song26-carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(231, 76, 60, 0.9);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .song26-carousel-nav:hover {
            background: rgba(192, 57, 43, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .song26-carousel-nav:active {
            transform: translateY(-50%) scale(0.95);
        }

        .song26-carousel-prev {
            left: 10px;
        }

        .song26-carousel-next {
            right: 10px;
        }

        .song26-venue-info {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #e74c3c;
            margin-bottom: 20px;
        }

        .song26-venue-info p {
            margin: 8px 0;
            color: #555;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .song26-venue-info i {
            color: #e74c3c;
            width: 20px;
        }

        @media (max-width: 768px) {
            /* Mobile: Hide shared bubble, show inline details */
            .song26-shared-venue-bubble {
                display: none !important;
            }

            .song26-venue-details {
                display: block;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s ease-out;
                background: #ffffff;
                margin-top: 0;
            }

            .song26-venue-details.active {
                max-height: 1500px;
                margin-top: 20px;
                border-radius: 15px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            }

            .song26-venue-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .song26-venue-section {
                padding: 15px;
            }

            .song26-venue-photo-carousel {
                height: 200px;
                padding: 10px;
            }

            .song26-venue-photo {
                font-size: 13px;
                padding: 10px;
            }

            .song26-carousel-nav {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .song26-carousel-prev {
                left: 5px;
            }

            .song26-carousel-next {
                right: 5px;
            }

            .song26-venue-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                padding-bottom: 15px;
            }

            .song26-venue-icon {
                width: 50px;
                height: 50px;
                font-size: 24px;
            }

            .song26-venue-title h3 {
                font-size: 22px;
            }

            .song26-venue-title p {
                font-size: 14px;
            }

            .song26-venue-info {
                padding: 15px;
                margin-bottom: 15px;
            }

            .song26-venue-info p {
                font-size: 14px;
            }

            .song26-venue-map {
                height: 250px;
                border-radius: 8px;
            }

            .song26-venue-section h4 {
                font-size: 16px;
                margin-bottom: 12px;
            }

            .song26-venue-content {
                padding: 20px;
            }

            /* Mobile: Show arrows on sport cards */
            .song26-sport-card::after {
                content: '\f078';
                font-family: 'Font Awesome 5 Free';
                font-weight: 900;
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                opacity: 0.6;
                transition: all 0.3s ease;
                font-size: 14px;
            }

            .song26-sport-card.active::after {
                transform: translateY(-50%) rotate(180deg);
            }

            .song26-sport-card.active {
                transform: none;
            }
        }
    </style>
</head>
<body class="body">
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Header Space for Navigation Bar -->
    <div class="header-space"></div>

    <!-- Side Navigation -->
    <nav class="song26-side-nav" id="sideNav">
        <ul class="song26-nav-items">
            <li class="song26-nav-item">
                <a href="#home" class="song26-nav-link active" data-section="home">
                    <span class="song26-nav-label">Home</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#about" class="song26-nav-link" data-section="about">
                    <span class="song26-nav-label">About</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#sports" class="song26-nav-link" data-section="sports">
                    <span class="song26-nav-label">Sports</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#medal-standings" class="song26-nav-link" data-section="medal-standings">
                    <span class="song26-nav-label">Medal Standings</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#games-standings" class="song26-nav-link" data-section="games-standings">
                    <span class="song26-nav-label">Games Standings</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#partners" class="song26-nav-link" data-section="partners">
                    <span class="song26-nav-label">Partners</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#sponsors" class="song26-nav-link" data-section="sponsors">
                    <span class="song26-nav-label">Sponsors</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
            <li class="song26-nav-item">
                <a href="#oath" class="song26-nav-link" data-section="oath">
                    <span class="song26-nav-label">SO Oath</span>
                    <span class="song26-nav-dot"></span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Mobile Navigation Toggle -->
    <button class="song26-nav-toggle" id="navToggle" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Hero Section -->
    <section class="song26-hero" id="home">
        <div class="song26-hero-content">
            <img src="../assets/images/SONG26_Logo.png" alt="SONG 26 Logo" class="song26-hero-logo">
                    <!-- Countdown Clock -->
                    <div class="song26-countdown" id="song26-countdown">
                        <div class="song26-countdown-part">
                            <span id="countdown-days">00</span>
                            <div class="song26-countdown-label">Days</div>
                        </div>
                        <div class="song26-countdown-part">
                            <span id="countdown-hours">00</span>
                            <div class="song26-countdown-label">Hours</div>
                        </div>
                        <div class="song26-countdown-part">
                            <span id="countdown-minutes">00</span>
                            <div class="song26-countdown-label">Minutes</div>
                        </div>
                        <div class="song26-countdown-part">
                            <span id="countdown-seconds">00</span>
                            <div class="song26-countdown-label">Seconds</div>
                        </div>
                    </div>
            <h1>Special Olympics Malaysia</h1>
            <div class="song26-hero-subtitle">6th National Games</div>
            <div class="song26-hero-location">Bintulu</div>
            <div class="song26-hero-location">Sarawak</div>
            <div class="song26-hero-date">24 - 26 April 2026</div>
        </div>
        
        <!-- Sponsor Showcase - Desktop Only -->
        <div class="song26-hero-sponsors">
            <div class="song26-hero-sponsors-title">Proudly Supported By</div>
            
            <div class="song26-hero-sponsor-tier">
                <div class="song26-hero-sponsor-tier-label">Platinum</div>
                <div class="song26-hero-sponsor-logos">
                    <div class="song26-hero-sponsor-item">
                        <div class="song26-hero-sponsor-placeholder">Platinum 1</div>
                    </div>
                    <div class="song26-hero-sponsor-item">
                        <div class="song26-hero-sponsor-placeholder">Platinum 2</div>
                    </div>
                    <div class="song26-hero-sponsor-item">
                        <div class="song26-hero-sponsor-placeholder">Platinum 3</div>
                    </div>
                    <div class="song26-hero-sponsor-item">
                        <div class="song26-hero-sponsor-placeholder">Platinum 4</div>
                    </div>
                    <div class="song26-hero-sponsor-item">
                        <div class="song26-hero-sponsor-placeholder">Platinum 5</div>
                    </div>
                </div>
            </div>
            
            <div class="song26-hero-sponsor-tier">
                <div class="song26-hero-sponsor-tier-label">Gold</div>
                <div class="song26-hero-sponsor-logos">
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Gold 1</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Gold 2</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Gold 3</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Gold 4</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Gold 5</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Gold 6</div>
                    </div>
                </div>
            </div>
            
            <div class="song26-hero-sponsor-tier">
                <div class="song26-hero-sponsor-tier-label">Silver</div>
                <div class="song26-hero-sponsor-logos">
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 1</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 2</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 3</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 4</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 5</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 6</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 7</div>
                    </div>
                    <div class="song26-hero-sponsor-item song26-hero-sponsor-item-small">
                        <div class="song26-hero-sponsor-placeholder">Silver 8</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="song26-main-content">
        <!-- About Section -->
        <section class="song26-full-section white-bg" id="about">
            <div class="song26-container">
                <div class="song26-section-title">
                    <h2>SONG 2026</h2>
                    <p>A celebration of athletic achievement, inclusion, and community for athletes with intellectual disabilities across Sarawak.</p>
                </div>

                <!-- Logo Display -->
                <div class="song26-logo-section">
                    <div class="song26-logo-card">
                        <div aria-hidden="false" role="img" aria-label="Special Olympics Sarawak logo" style="width:110px;height:110px;background:#FFFFFF;border-radius:50%;box-shadow:0 4px 16px rgba(255, 0, 0,0.12);display:flex;align-items:center;justify-content:center;">
                            <img src="../assets/images/SONG26_Logo.png" alt="SONG 26 Logo" style="width:90px;height:auto;display:block;object-fit:contain;" aria-hidden="false">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Info Cards -->
        <section class="song26-full-section gray-bg">
            <div class="song26-container"> 
                <div class="song26-info-grid">
                    <div class="song26-info-card">
                        <div class="song26-icon-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Venue</h3> 
                        <p>Bintulu, Sarawak<br>Clean Green Energy Hub Of Malaysia</p>
                    </div>
                    <div class="song26-info-card">
                        <div class="song26-icon-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Date</h3>
                        <p>24 - 26 April 2026<br>Three Days of Competition & Unity</p>
                    </div>
                    <div class="song26-info-card">
                        <div class="song26-icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Participants</h3>
                        <p>Athletes, unified partners, coaches and delegations from all across Malaysia</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sports Competitions Section -->
        <section class="song26-full-section gray-bg" id="sports">
            <div class="song26-container">
                <div class="song26-section-title">
                    <h2>Sports Competitions</h2>
                    <p>Click on any sport to view venue details and location</p>
                </div>
                <div class="song26-participation-grid">
                    <!-- Athletics -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="athletics">Athletics</div>
                        <div class="song26-venue-details" id="venue-athletics">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-running"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Athletics</h3>
                                        <p>Stadium Bintulu</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Stadium Bintulu, Jalan Kidurong, 97000 Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Main athletic stadium with track and field facilities</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.558537844736!2d113.05260097567584!3d3.2099442527744677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc170ce21d4fd%3A0x1c1fdd6349140015!2sStadium%20Bintulu%20(Athletic%2C%20Soccer)!5e0!3m2!1sen!2smy!4v1770103108574!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">
                                                    <img src="../assets/images/Stadium_BTU1.jpg" alt="Stadium Bintulu Front View" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                                                </div>
                                                <div class="song26-venue-photo">
                                                    <img src="../assets/images/Stadium_BTU2.jpg" alt="Stadium Bintulu Aerial View" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                                                </div>
                                                <div class="song26-venue-photo">
                                                    <img src="../assets/images/Stadium_BTU3.jpg" alt="Stadium Bintulu Track" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                                                </div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aquatics -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="aquatics">Aquatics</div>
                        <div class="song26-venue-details" id="venue-aquatics">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-swimmer"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Aquatics</h3>
                                        <p>Kolam Renang Awam BDA</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Kolam Renang Awam BDA, Bintulu Development Authority, 97000 Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Public swimming pool with Olympic-standard facilities</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.0638867764335!2d113.04647537496553!3d3.176395996864427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d570f51e4a4a5%3A0x5c6d7e8f9a0b1c2d!2sBintulu%20Development%20Authority%20Swimming%20Complex!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Badminton -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="badminton">Badminton</div>
                        <div class="song26-venue-details" id="venue-badminton">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-baseball-ball"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Badminton</h3>
                                        <p>B&G Badminton Centre</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> B&G Badminton Centre, Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Professional badminton facility with multiple courts</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.1238568456784!2d113.04014567496546!3d3.1643936968650577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d571234567890%3A0x1a2b3c4d5e6f7a8b!2sB%26G%20Badminton%20Centre!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basketball -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="basketball">Basketball</div>
                        <div class="song26-venue-details" id="venue-basketball">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-basketball-ball"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Basketball</h3>
                                        <p>Dewan Bola Kerajang Bintulu</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Dewan Bola Kerajang Bintulu, 97000 Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Basketball hall with standard competition courts</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.0956789456784!2d113.05458967496546!3d3.1678936968650577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d57123456789a%3A0x2b3c4d5e6f7a8b9c!2sBintulu%20Basketball%20Court!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bocce -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="bocce">Bocce</div>
                        <div class="song26-venue-details" id="venue-bocce">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Bocce</h3>
                                        <p>Stadium Muhibah</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Stadium Muhibah, 97000 Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Multi-purpose stadium with bocce facilities</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.0456789456784!2d113.03778767496546!3d3.1798936968650577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d570abcdefabc%3A0x3c4d5e6f7a8b9c0d!2sStadium%20Muhibah!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bowling -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="bowling">Bowling</div>
                        <div class="song26-venue-details" id="venue-bowling">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-bowling-ball"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Ten-Pin Bowling</h3>
                                        <p>Megaland Bowling Centre Bintulu</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Megaland Bowling Centre, Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Modern bowling alley with professional lanes</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.1123456789014!2d113.04236787496546!3d3.1656936968650577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d571fedcba987%3A0x4d5e6f7a8b9c0d1e!2sMegalanes%20Bowling%20Centre!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Football 5-a-Side -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="football">Football 5-a-Side</div>
                        <div class="song26-venue-details" id="venue-football">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-futbol"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Unified Football 5-A-Side</h3>
                                        <p>Kelab Kidurong Bintulu</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Kelab Kidurong, Kidurong, 97000 Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Sports club with futsal and football facilities</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.2345678901234!2d113.06903457496546!3d3.1512936968650577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d5623456789ab%3A0x5e6f7a8b9c0d1e2f!2sKelab%20Sukan%20Kidurong!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Tennis -->
                    <div class="song26-sport-card-wrapper">
                        <div class="song26-sport-card" data-sport="tabletennis">Table Tennis</div>
                        <div class="song26-venue-details" id="venue-tabletennis">
                            <div class="song26-venue-content">
                                <div class="song26-venue-header">
                                    <div class="song26-venue-icon">
                                        <i class="fas fa-table-tennis"></i>
                                    </div>
                                    <div class="song26-venue-title">
                                        <h3>Table Tennis</h3>
                                        <p>Dinner World Restaurant (Ground Floor)</p>
                                    </div>
                                </div>
                                <div class="song26-venue-info">
                                    <p><i class="fas fa-map-marker-alt"></i> Dinner World Restaurant, Ground Floor, Bintulu, Sarawak</p>
                                    <p><i class="fas fa-info-circle"></i> Indoor venue with table tennis facilities</p>
                                </div>
                                <div class="song26-venue-grid">
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-map"></i> Location Map</h4>
                                        <iframe 
                                            class="song26-venue-map"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.0876543210984!2d113.04347897496546!3d3.1734936968650577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321d571abcd12345%3A0x6f7a8b9c0d1e2f3a!2sDinner%20World%20Restaurant!5e0!3m2!1sen!2smy!4v1738605100000!5m2!1sen!2smy"
                                            allowfullscreen="" 
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                    <div class="song26-venue-section">
                                        <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                        <div class="song26-venue-photo-carousel">
                                            <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="song26-venue-photos">
                                                <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                                <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                            </div>
                                            <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shared Venue Bubble (Desktop Only) -->
                <div class="song26-shared-venue-bubble" id="sharedVenueBubble">
                    <div class="song26-venue-bubble-card">
                        <div class="song26-venue-content">
                            <div class="song26-venue-header">
                                <div class="song26-venue-icon" id="bubbleIcon">
                                    <i class="fas fa-running"></i>
                                </div>
                                <div class="song26-venue-title">
                                    <h3 id="bubbleSportName">Athletics</h3>
                                    <p id="bubbleVenueName">Stadium Bintulu</p>
                                </div>
                            </div>
                            <div class="song26-venue-info" id="bubbleVenueInfo">
                                <p><i class="fas fa-map-marker-alt"></i> <span id="bubbleAddress">Stadium Bintulu, Jalan Kidurong, 97000 Bintulu, Sarawak</span></p>
                                <p><i class="fas fa-info-circle"></i> <span id="bubbleDescription">Main athletic stadium with track and field facilities</span></p>
                            </div>
                            <div class="song26-venue-grid">
                                <div class="song26-venue-section">
                                    <h4><i class="fas fa-map"></i> Location Map</h4>
                                    <iframe 
                                        id="bubbleMap"
                                        class="song26-venue-map"
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.558537844736!2d113.05260097567584!3d3.2099442527744677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc170ce21d4fd%3A0x1c1fdd6349140015!2sStadium%20Bintulu%20(Athletic%2C%20Soccer)!5e0!3m2!1sen!2smy!4v1770103108574!5m2!1sen!2smy"
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                </div>
                                <div class="song26-venue-section">
                                    <h4><i class="fas fa-camera"></i> Venue Photos</h4>
                                    <div class="song26-venue-photo-carousel">
                                        <button class="song26-carousel-nav song26-carousel-prev" aria-label="Previous photo">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <div class="song26-venue-photos">
                                            <div class="song26-venue-photo">Photo 1<br>Coming Soon</div>
                                            <div class="song26-venue-photo">Photo 2<br>Coming Soon</div>
                                            <div class="song26-venue-photo">Photo 3<br>Coming Soon</div>
                                            <div class="song26-venue-photo">Photo 4<br>Coming Soon</div>
                                        </div>
                                        <button class="song26-carousel-nav song26-carousel-next" aria-label="Next photo">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Standings Section -->
        <section class="song26-full-section white-bg" id="medal-standings">
            <div class="song26-container">
                <div class="song26-section-title">
                    <h2>Overall Medal Standings</h2>
                    <p>Combined medal count across all sports competitions</p>
                </div>

                <div class="song26-medal-standings">
                    <div class="song26-table-wrapper">
                        <table class="song26-table song26-medal-table">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>State</th>
                                    <th class="text-center medal-col gold-col"><i class="fas fa-medal"></i> Gold</th>
                                    <th class="text-center medal-col silver-col"><i class="fas fa-medal"></i> Silver</th>
                                    <th class="text-center medal-col bronze-col"><i class="fas fa-medal"></i> Bronze</th>
                                    <th class="text-center total-col"><i class="fas fa-trophy"></i> Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="rank-1-row">
                                    <td class="rank-cell">1</td>
                                    <td class="state-cell"><strong>Sarawak</strong></td>
                                    <td class="text-center medal-count gold-count">15</td>
                                    <td class="text-center medal-count silver-count">12</td>
                                    <td class="text-center medal-count bronze-count">10</td>
                                    <td class="text-center total-count"><strong>37</strong></td>
                                </tr>
                                <tr class="rank-2-row">
                                    <td class="rank-cell">2</td>
                                    <td class="state-cell"><strong>Selangor</strong></td>
                                    <td class="text-center medal-count gold-count">14</td>
                                    <td class="text-center medal-count silver-count">11</td>
                                    <td class="text-center medal-count bronze-count">9</td>
                                    <td class="text-center total-count"><strong>34</strong></td>
                                </tr>
                                <tr class="rank-3-row">
                                    <td class="rank-cell">3</td>
                                    <td class="state-cell"><strong>Johor</strong></td>
                                    <td class="text-center medal-count gold-count">12</td>
                                    <td class="text-center medal-count silver-count">10</td>
                                    <td class="text-center medal-count bronze-count">11</td>
                                    <td class="text-center total-count"><strong>33</strong></td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">4</td>
                                    <td class="state-cell">Penang</td>
                                    <td class="text-center medal-count gold-count">11</td>
                                    <td class="text-center medal-count silver-count">9</td>
                                    <td class="text-center medal-count bronze-count">8</td>
                                    <td class="text-center total-count">28</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">5</td>
                                    <td class="state-cell">Sabah</td>
                                    <td class="text-center medal-count gold-count">9</td>
                                    <td class="text-center medal-count silver-count">10</td>
                                    <td class="text-center medal-count bronze-count">7</td>
                                    <td class="text-center total-count">26</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">6</td>
                                    <td class="state-cell">Perak</td>
                                    <td class="text-center medal-count gold-count">8</td>
                                    <td class="text-center medal-count silver-count">7</td>
                                    <td class="text-center medal-count bronze-count">9</td>
                                    <td class="text-center total-count">24</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">7</td>
                                    <td class="state-cell">Kedah</td>
                                    <td class="text-center medal-count gold-count">6</td>
                                    <td class="text-center medal-count silver-count">8</td>
                                    <td class="text-center medal-count bronze-count">6</td>
                                    <td class="text-center total-count">20</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">8</td>
                                    <td class="state-cell">Kelantan</td>
                                    <td class="text-center medal-count gold-count">5</td>
                                    <td class="text-center medal-count silver-count">6</td>
                                    <td class="text-center medal-count bronze-count">7</td>
                                    <td class="text-center total-count">18</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">9</td>
                                    <td class="state-cell">Terengganu</td>
                                    <td class="text-center medal-count gold-count">4</td>
                                    <td class="text-center medal-count silver-count">5</td>
                                    <td class="text-center medal-count bronze-count">6</td>
                                    <td class="text-center total-count">15</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">10</td>
                                    <td class="state-cell">Pahang</td>
                                    <td class="text-center medal-count gold-count">3</td>
                                    <td class="text-center medal-count silver-count">4</td>
                                    <td class="text-center medal-count bronze-count">5</td>
                                    <td class="text-center total-count">12</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">11</td>
                                    <td class="state-cell">Melaka</td>
                                    <td class="text-center medal-count gold-count">2</td>
                                    <td class="text-center medal-count silver-count">3</td>
                                    <td class="text-center medal-count bronze-count">4</td>
                                    <td class="text-center total-count">9</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">12</td>
                                    <td class="state-cell">Negeri Sembilan</td>
                                    <td class="text-center medal-count gold-count">2</td>
                                    <td class="text-center medal-count silver-count">2</td>
                                    <td class="text-center medal-count bronze-count">3</td>
                                    <td class="text-center total-count">7</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">13</td>
                                    <td class="state-cell">Perlis</td>
                                    <td class="text-center medal-count gold-count">1</td>
                                    <td class="text-center medal-count silver-count">2</td>
                                    <td class="text-center medal-count bronze-count">2</td>
                                    <td class="text-center total-count">5</td>
                                </tr>
                                <tr>
                                    <td class="rank-cell">14</td>
                                    <td class="state-cell">Kuala Lumpur</td>
                                    <td class="text-center medal-count gold-count">1</td>
                                    <td class="text-center medal-count silver-count">1</td>
                                    <td class="text-center medal-count bronze-count">1</td>
                                    <td class="text-center total-count">3</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Competition Standings -->
                <div class="song26-section-title" id="games-standings" style="margin-top: 80px;">
                    <h2>Games Standings</h2>
                    <p>Live rankings and medal standings for all participating SO states</p>
                </div>

                <!-- Sport Tabs (Bookmark Style) -->
                <div class="song26-sport-tabs">
                    <button class="song26-sport-tab active" data-sport="aquatics">Aquatics</button>
                    <button class="song26-sport-tab" data-sport="athletics">Athletics</button>
                    <button class="song26-sport-tab" data-sport="badminton">Badminton</button>
                    <button class="song26-sport-tab" data-sport="basketball">Basketball</button>
                    <button class="song26-sport-tab" data-sport="bocce">Bocce</button>
                    <button class="song26-sport-tab" data-sport="bowling">Bowling</button>
                    <button class="song26-sport-tab" data-sport="football">Football 5-a-Side</button>
                    <button class="song26-sport-tab" data-sport="tabletennis">Table Tennis</button>
                </div>

                <!-- State Standings Table Container -->
                <div class="song26-standings-container">
                    <!-- Aquatics -->
                    <div class="song26-standings-table active" id="standings-aquatics">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Sarawak</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Selangor</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Johor</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Penang</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Sabah</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Athletics -->
                    <div class="song26-standings-table" id="standings-athletics">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Selangor</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Sarawak</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Sabah</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Johor</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Penang</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Badminton -->
                    <div class="song26-standings-table" id="standings-badminton">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Penang</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Selangor</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Sarawak</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Johor</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Sabah</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Basketball -->
                    <div class="song26-standings-table" id="standings-basketball">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Johor</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Sarawak</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Selangor</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Penang</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Sabah</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bocce -->
                    <div class="song26-standings-table" id="standings-bocce">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Sabah</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Sarawak</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Penang</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Selangor</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Johor</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bowling -->
                    <div class="song26-standings-table" id="standings-bowling">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Selangor</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Johor</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Sarawak</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Penang</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Sabah</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Football -->
                    <div class="song26-standings-table" id="standings-football">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Sarawak</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Sabah</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Johor</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Selangor</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Penang</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Table Tennis -->
                    <div class="song26-standings-table" id="standings-tabletennis">
                        <div class="song26-table-wrapper">
                            <table class="song26-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th class="text-center">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Penang</td><td class="text-center rank-1">1st</td></tr>
                                    <tr><td>2</td><td>Selangor</td><td class="text-center rank-2">2nd</td></tr>
                                    <tr><td>3</td><td>Sarawak</td><td class="text-center rank-3">3rd</td></tr>
                                    <tr><td>4</td><td>Johor</td><td class="text-center">4th</td></tr>
                                    <tr><td>5</td><td>Sabah</td><td class="text-center">5th</td></tr>
                                    <tr><td>6</td><td>Perak</td><td class="text-center">6th</td></tr>
                                    <tr><td>7</td><td>Kedah</td><td class="text-center">7th</td></tr>
                                    <tr><td>8</td><td>Kelantan</td><td class="text-center">8th</td></tr>
                                    <tr><td>9</td><td>Terengganu</td><td class="text-center">9th</td></tr>
                                    <tr><td>10</td><td>Pahang</td><td class="text-center">10th</td></tr>
                                    <tr><td>11</td><td>Melaka</td><td class="text-center">11th</td></tr>
                                    <tr><td>12</td><td>Negeri Sembilan</td><td class="text-center">12th</td></tr>
                                    <tr><td>13</td><td>Perlis</td><td class="text-center">13th</td></tr>
                                    <tr><td>14</td><td>Kuala Lumpur</td><td class="text-center">14th</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organizing Companies Section -->
        <section class="song26-committee-section" id="partners">
            <div class="song26-container">
                <h2 class="song26-committee-title">Organizing Partners</h2>
                <div class="song26-committee-grid">
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo no-logo">
                            <img src="../assets/images/kpwk.png" alt="Kementerian Pembangunan Wanita">
                        </div>
                        <div class="song26-committee-name ">Kementerian Pembangunan Wanita, Kanak-Kanak dan Kesejahteraan Komuniti</div>
                    </div>
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo no-logo">
                            <img src="../assets/images/jkms.png" alt="Jabatan Kebajikan Masyarakat">
                        </div>
                        <div class="song26-committee-name">Jabatan Kebajikan Masyarakat</div>
                    </div>
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="song26-committee-name">Organization Logo</div>
                    </div>
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo no-logo">
                            <img src="../assets/images/bintuluport_logo.png" alt="Bintulu Port">
                        </div>
                        <div class="song26-committee-name">Bintulu Port</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sponsors Section -->
        <section class="song26-sponsors-section" id="sponsors">
            <div class="song26-container">
                <h2 class="song26-sponsors-title">Our Sponsors</h2>
                <p class="song26-sponsors-subtitle">We extend our gratitude to our valued sponsors who make SONG 2026 possible</p>
                
                <!-- Platinum Sponsors -->
                <div class="song26-sponsor-tier">
                    <h3 class="song26-sponsor-tier-title">Platinum Sponsors</h3>
                    <div class="song26-sponsors-grid">
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                    </div>
                </div>

                <!-- Gold Sponsors -->
                <div class="song26-sponsor-tier">
                    <h3 class="song26-sponsor-tier-title">Gold Sponsors</h3>
                    <div class="song26-sponsors-grid">
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                    </div>
                </div>

                <!-- Silver Sponsors -->
                <div class="song26-sponsor-tier">
                    <h3 class="song26-sponsor-tier-title">Silver Sponsors</h3>
                    <div class="song26-sponsors-grid">
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Special Olympic Oath Section -->
        <section class="song26-motto-section" id="oath">
            <div class="song26-motto-content">
                <h3>Special Olympics Oath</h3>
                <p>"Let me win.<br>But if I cannot win,<br>let me be brave in the attempt."</p>
            </div>
        </section>
    </div>

    <!-- Section Divider -->
    <div class="section-divider"></div>
    
    <?php if (!$isStandalone): ?>
    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>
    <?php endif; ?>

    <script src="../scripts/script.js"></script>

    <!-- Countdown Clock Script -->
    <script>
    // Countdown target: 24 April 2026, 12:00 a.m. (midnight)
    const countdownTarget = new Date(2026, 3, 24, 0, 0, 0).getTime(); // Month is 0-indexed
    function updateCountdown() {
        const now = new Date().getTime();
        const diff = countdownTarget - now;
        const daysEl = document.getElementById('countdown-days');
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const secondsEl = document.getElementById('countdown-seconds');
        if (diff <= 0) {
            daysEl.textContent = '00';
            hoursEl.textContent = '00';
            minutesEl.textContent = '00';
            secondsEl.textContent = '00';
            return;
        }
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        daysEl.textContent = String(days).padStart(2, '0');
        hoursEl.textContent = String(hours).padStart(2, '0');
        minutesEl.textContent = String(minutes).padStart(2, '0');
        secondsEl.textContent = String(seconds).padStart(2, '0');
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
    </script>

    <!-- Sport Tabs Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sportTabs = document.querySelectorAll('.song26-sport-tab');
            const standingsTables = document.querySelectorAll('.song26-standings-table');

            sportTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Get the sport data attribute
                    const sport = this.getAttribute('data-sport');

                    // Remove active class from all tabs and tables
                    sportTabs.forEach(t => t.classList.remove('active'));
                    standingsTables.forEach(table => table.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Show corresponding table
                    const targetTable = document.getElementById('standings-' + sport);
                    if (targetTable) {
                        targetTable.classList.add('active');
                    }
                });
            });
        });
    </script>

    <!-- Sport Venue Details Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sportCards = document.querySelectorAll('.song26-sport-card');
            const sharedBubble = document.getElementById('sharedVenueBubble');
            const isMobile = window.innerWidth <= 768;
            
            // Venue data object
            const venueData = {
                athletics: {
                    name: 'Athletics',
                    venue: 'Stadium Bintulu',
                    icon: 'fa-running',
                    address: 'Stadium Bintulu, Jalan Kidurong, 97000 Bintulu, Sarawak',
                    description: 'Main athletic stadium with track and field facilities',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.558537844736!2d113.05260097567584!3d3.2099442527744677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc170ce21d4fd%3A0x1c1fdd6349140015!2sStadium%20Bintulu%20(Athletic%2C%20Soccer)!5e0!3m2!1sen!2smy!4v1770103108574!5m2!1sen!2smy'
                },
                aquatics: {
                    name: 'Aquatics',
                    venue: 'Kolam Renang Awam BDA',
                    icon: 'fa-swimmer',
                    address: 'Kolam Renang Awam BDA, Bintulu Development Authority, 97000 Bintulu, Sarawak',
                    description: 'Public swimming pool with Olympic-standard facilities',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.674603832099!2d113.04201477567604!3d3.180038652960533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc0541f25afa5%3A0xa24e1c63fc7e736b!2sPublic%20Swimming%20Pool%20Bintulu!5e0!3m2!1sen!2smy!4v1770103133657!5m2!1sen!2smy'
                },
                badminton: {
                    name: 'Badminton',
                    venue: 'B&G Badminton Centre',
                    icon: 'fa-baseball-ball',
                    address: 'B&G Badminton Centre, Bintulu, Sarawak',
                    description: 'Professional badminton facility with multiple courts',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.6795732643714!2d113.03932307567591!3d3.178751952968484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc051476ca661%3A0x6345af03f5c41354!2sB%20%26%20G%20Sport%20Centre!5e0!3m2!1sen!2smy!4v1770103153963!5m2!1sen!2smy'
                },
                basketball: {
                    name: 'Basketball',
                    venue: 'Dewan Bola Kerajang Bintulu',
                    icon: 'fa-basketball-ball',
                    address: 'Dewan Bola Kerajang Bintulu, 97000 Bintulu, Sarawak',
                    description: 'Basketball hall with standard competition courts',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31869.43510340652!2d113.02129839942762!3d3.178799950712159!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc1d635010f99%3A0xf7a19303993dfe6a!2sBasketball%20Association%20Bintulu%20Stadium!5e0!3m2!1sen!2smy!4v1770103193043!5m2!1sen!2smy'
                },
                bocce: {
                    name: 'Bocce',
                    venue: 'Kelab Kidurong Bintulu',
                    icon: 'fa-circle',
                    address: 'Kelab Kidurong, Kidurong, 97000 Bintulu, Sarawak',
                    description: 'Sports club with bocce facilities',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.5110367035927!2d113.05786167567597!3d3.222103452698371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc12e7c119201%3A0x4d236df68bfa9d58!2sKelab%20Kidurong%20Bintulu!5e0!3m2!1sen!2smy!4v1770103213555!5m2!1sen!2smy'
                },
                bowling: {
                    name: 'Ten-Pin Bowling',
                    venue: 'Megaland Bowling Centre Bintulu',
                    icon: 'fa-bowling-ball',
                    address: 'Megaland Bowling Centre, Bintulu, Sarawak',
                    description: 'Modern bowling alley with professional lanes',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2040073.110922797!2d110.82716738036058!3d2.953715278091896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc1965be6bea7%3A0xda08bfaa12acd132!2sMegalanes%20Bintulu!5e0!3m2!1sen!2smy!4v1770103265303!5m2!1sen!2smy'
                },
                football: {
                    name: 'Unified Football 5-A-Side',
                    venue: 'Stadium Muhibbah',
                    icon: 'fa-futbol',
                    address: 'Stadium Muhibbah, 97000 Bintulu, Sarawak',
                    description: 'Indoor stadium with futsal and football facilities',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.5483282507394!2d113.05480387567599!3d3.2125615527581304!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc17a7c7ffeb9%3A0xf7ce3c468f0e60d!2sStadium%20Muhibah(Indoor)!5e0!3m2!1sen!2smy!4v1770103238486!5m2!1sen!2smy'
                },
                tabletennis: {
                    name: 'Table Tennis',
                    venue: 'Dinner World Restaurant (Ground Floor)',
                    icon: 'fa-table-tennis',
                    address: 'Dinner World Restaurant, Ground Floor, Bintulu, Sarawak',
                    description: 'Indoor venue with table tennis facilities',
                    mapUrl: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.5841482317765!2d113.05852547567581!3d3.2033694528155046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x321dc172aa8304ab%3A0xf6614b9214f516d9!2sDinner%20World%20Restaurant%20By%20Highlands%20Seafood!5e0!3m2!1sen!2smy!4v1770103301292!5m2!1sen!2smy'
                }
            };
            
            sportCards.forEach(card => {
                card.addEventListener('click', function() {
                    const sport = this.getAttribute('data-sport');
                    const venueDetails = document.getElementById('venue-' + sport);
                    const isActive = this.classList.contains('active');
                    
                    if (window.innerWidth > 768) {
                        // Desktop: Use shared bubble
                        if (isActive) {
                            // Close if clicking the same sport
                            this.classList.remove('active');
                            sharedBubble.classList.remove('active');
                        } else {
                            // Close all other cards
                            document.querySelectorAll('.song26-sport-card').forEach(c => {
                                c.classList.remove('active');
                            });
                            
                            // Activate clicked card
                            this.classList.add('active');
                            
                            // Update bubble content
                            const data = venueData[sport];
                            document.getElementById('bubbleIcon').innerHTML = '<i class="fas ' + data.icon + '"></i>';
                            document.getElementById('bubbleSportName').textContent = data.name;
                            document.getElementById('bubbleVenueName').textContent = data.venue;
                            document.getElementById('bubbleAddress').textContent = data.address;
                            document.getElementById('bubbleDescription').textContent = data.description;
                            document.getElementById('bubbleMap').src = data.mapUrl;
                            
                            // Show bubble
                            sharedBubble.classList.add('active');
                            
                            // Smooth scroll to bubble after animation
                            setTimeout(() => {
                                sharedBubble.scrollIntoView({ 
                                    behavior: 'smooth', 
                                    block: 'nearest'
                                });
                            }, 300);
                        }
                    } else {
                        // Mobile: Use inline details (original behavior)
                        // Close all other venue details
                        document.querySelectorAll('.song26-venue-details').forEach(detail => {
                            detail.classList.remove('active');
                        });
                        document.querySelectorAll('.song26-sport-card').forEach(c => {
                            c.classList.remove('active');
                        });
                        
                        // Toggle the clicked venue
                        if (!isActive) {
                            venueDetails.classList.add('active');
                            this.classList.add('active');
                            
                            // Smooth scroll to the venue details
                            setTimeout(() => {
                                const cardRect = this.getBoundingClientRect();
                                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                                const targetPosition = cardRect.top + scrollTop - 100;
                                
                                window.scrollTo({
                                    top: targetPosition,
                                    behavior: 'smooth'
                                });
                            }, 300);
                        }
                    }
                });
            });
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Close all active states on resize
                    document.querySelectorAll('.song26-sport-card').forEach(c => {
                        c.classList.remove('active');
                    });
                    document.querySelectorAll('.song26-venue-details').forEach(d => {
                        d.classList.remove('active');
                    });
                    if (sharedBubble) {
                        sharedBubble.classList.remove('active');
                    }
                }, 250);
            });
        });
    </script>

    <!-- Carousel Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all carousels
            const carousels = document.querySelectorAll('.song26-venue-photo-carousel');
            
            carousels.forEach(carousel => {
                const prevBtn = carousel.querySelector('.song26-carousel-prev');
                const nextBtn = carousel.querySelector('.song26-carousel-next');
                const photosContainer = carousel.querySelector('.song26-venue-photos');
                const photos = carousel.querySelectorAll('.song26-venue-photo');
                
                if (!prevBtn || !nextBtn || !photosContainer || photos.length === 0) return;
                
                let currentIndex = 0;
                const totalPhotos = photos.length;
                
                function updateCarousel() {
                    const offset = -currentIndex * 100;
                    photosContainer.style.transform = `translateX(${offset}%)`;
                }
                
                // Next button - loop to start
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    currentIndex = (currentIndex + 1) % totalPhotos;
                    updateCarousel();
                });
                
                // Previous button - loop to end
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    currentIndex = (currentIndex - 1 + totalPhotos) % totalPhotos;
                    updateCarousel();
                });
                
                // Initial position
                updateCarousel();
            });
        });
    </script>

    <!-- Side Navigation Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.song26-nav-link');
            const navToggle = document.getElementById('navToggle');
            const sideNav = document.getElementById('sideNav');
            const sections = document.querySelectorAll('section[id]');
            
            // Debug: Log found sections
            console.log('Found sections:', sections.length);
            sections.forEach(s => console.log('Section:', s.id, 'offsetTop:', s.offsetTop));
            
            // Configuration: Set to false to disable auto-highlighting on scroll
            const AUTO_HIGHLIGHT_ENABLED = true;
            let isScrolling = false;
            let scrollEndTimer;

            // Smooth scrolling for navigation links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);

                    if (targetSection) {
                        // Mark as user-initiated scroll
                        isScrolling = true;
                        
                        // Immediately update active state
                        updateActiveNav(targetId);
                        
                        const offsetTop = targetSection.offsetTop - 70;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                        
                        // Reset after scroll completes
                        setTimeout(() => {
                            isScrolling = false;
                        }, 1000);

                        // Close mobile nav after clicking (landscape only)
                        if (window.innerWidth <= 768 && window.innerHeight < window.innerWidth) {
                            sideNav.classList.remove('active');
                            navToggle.classList.remove('active');
                            const icon = navToggle.querySelector('i');
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
            });

            // Mobile navigation toggle
            navToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sideNav.classList.toggle('active');
                this.classList.toggle('active');
                
                // Change icon
                const icon = this.querySelector('i');
                if (this.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });

            // Highlight active section on scroll - Fixed accurate detection
            let currentActiveSection = 'home';
            
            function highlightNavOnScroll() {
                const scrollY = window.scrollY || window.pageYOffset;
                const windowHeight = window.innerHeight;
                const docHeight = document.documentElement.scrollHeight;
                
                // Debug
                // console.log('Scroll Y:', scrollY);
                
                // At very top - always home
                if (scrollY < 100) {
                    updateActiveNav('home');
                    return;
                }
                
                // At bottom of page - activate last section
                if (scrollY + windowHeight >= docHeight - 100) {
                    const lastSection = sections[sections.length - 1];
                    if (lastSection) {
                        updateActiveNav(lastSection.getAttribute('id'));
                    }
                    return;
                }
                
                // Find which section is currently in view
                const triggerPoint = scrollY + (windowHeight * 0.35);
                let activeSection = null;
                
                // Loop through sections to find active one
                for (let i = 0; i < sections.length; i++) {
                    const section = sections[i];
                    const sectionTop = section.offsetTop;
                    const sectionBottom = sectionTop + section.offsetHeight;
                    
                    if (triggerPoint >= sectionTop && triggerPoint < sectionBottom) {
                        activeSection = section.getAttribute('id');
                        break;
                    }
                }
                
                // Fallback: find the section we've scrolled past
                if (!activeSection) {
                    for (let i = sections.length - 1; i >= 0; i--) {
                        const section = sections[i];
                        if (scrollY >= section.offsetTop - 150) {
                            activeSection = section.getAttribute('id');
                            break;
                        }
                    }
                }
                
                if (activeSection) {
                    updateActiveNav(activeSection);
                }
            }
            
            function updateActiveNav(sectionId) {
                if (sectionId === currentActiveSection) return;
                
                // console.log('Updating active to:', sectionId);
                currentActiveSection = sectionId;
                navLinks.forEach(link => {
                    if (link.getAttribute('data-section') === sectionId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            // Scroll event - direct, no debounce for responsiveness
            window.addEventListener('scroll', function() {
                if (!isScrolling && AUTO_HIGHLIGHT_ENABLED) {
                    highlightNavOnScroll();
                }
            }, { passive: true });

            // Initial check
            highlightNavOnScroll();
            
            // Also check after a short delay (in case sections load late)
            setTimeout(highlightNavOnScroll, 500);

            // Auto-hide mobile nav button when scrolling down, show when scrolling up (landscape only)
            let lastScrollTop = 0;
            window.addEventListener('scroll', function() {
                // Only work in landscape mobile view
                if (window.innerWidth <= 768 && window.innerHeight < window.innerWidth) {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    if (scrollTop > lastScrollTop && scrollTop > 200) {
                        // Scrolling down
                        navToggle.style.transform = 'translateY(150%)';
                    } else {
                        // Scrolling up
                        navToggle.style.transform = 'translateY(0)';
                    }
                    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
                }
            });

            // Prevent nav from closing when clicking inside
            sideNav.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Close mobile nav when clicking outside (landscape only)
            document.addEventListener('click', function(e) {
                // Only work in landscape mobile view
                if (window.innerWidth <= 768 && window.innerHeight < window.innerWidth) {
                    if (!sideNav.contains(e.target) && !navToggle.contains(e.target)) {
                        sideNav.classList.remove('active');
                        navToggle.classList.remove('active');
                        const icon = navToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = Array.from(document.querySelectorAll('.song26-nav-link'));
            if (!navLinks.length) return;

            // Map links to sections by data-section -> element id
            const linkToSection = navLinks.reduce((acc, link) => {
                const id = link.dataset.section;
                if (id) {
                    const el = document.getElementById(id);
                    if (el) acc[id] = { link, el };
                }
                return acc;
            }, {});

            let activeLink = document.querySelector('.song26-nav-link.active') || null;

            // IntersectionObserver to detect section entering viewport
            // rootMargin tuned to trigger when section top reaches ~40% of viewport
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -50% 0px',
                threshold: [0, 0.15, 0.3, 0.6]
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (!entry.target.id) return;
                    const id = entry.target.id;
                    const mapping = linkToSection[id];
                    if (!mapping) return;

                    // Mark link active when intersecting enough
                    if (entry.isIntersecting && entry.intersectionRatio > 0.12) {
                        const newLink = mapping.link;
                        if (newLink !== activeLink) {
                            if (activeLink) activeLink.classList.remove('active');
                            newLink.classList.add('active');
                            activeLink = newLink;
                        }
                    }
                });
            }, observerOptions);

            Object.values(linkToSection).forEach(({ el }) => observer.observe(el));

            // Smooth scrolling for clicks (offset adjusts for header height)
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = link.dataset.section;
                    const target = document.getElementById(id);
                    if (!target) return;
                    const headerOffset = 80; // adjust if your header height differs
                    const elementPosition = target.getBoundingClientRect().top + window.scrollY;
                    const offsetPosition = Math.max(elementPosition - headerOffset, 0);
                    window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                });
            });

            // Optional: Update active class on load if section already in view
            window.setTimeout(() => {
                // If we're at the very top, ensure Home is active
                if (window.scrollY <= 60 && linkToSection.home && linkToSection.home.link) {
                    if (activeLink) activeLink.classList.remove('active');
                    linkToSection.home.link.classList.add('active');
                    activeLink = linkToSection.home.link;
                    return;
                }

                // Fallback: pick a section roughly in view
                const inView = Object.values(linkToSection).find(({ el }) => {
                    const rect = el.getBoundingClientRect();
                    return rect.top <= window.innerHeight * 0.6 && rect.bottom >= window.innerHeight * 0.1;
                });
                if (inView && inView.link) {
                    if (activeLink) activeLink.classList.remove('active');
                    inView.link.classList.add('active');
                    activeLink = inView.link;
                }
            }, 120);

            // Ensure Home becomes active when scrolled to very top (works during fast scrolls)
            window.addEventListener('scroll', () => {
                if (window.scrollY <= 60 && linkToSection.home && linkToSection.home.link) {
                    if (activeLink !== linkToSection.home.link) {
                        if (activeLink) activeLink.classList.remove('active');
                        linkToSection.home.link.classList.add('active');
                        activeLink = linkToSection.home.link;
                    }
                }
            }, { passive: true });
        });
    </script>

</body>
</html>