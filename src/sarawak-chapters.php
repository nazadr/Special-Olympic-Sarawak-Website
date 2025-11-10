<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarawak Chapters | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Space reserved for existing header */
        .header-space {
            height: 80px;
            background-color: transparent;
        }
        
        /* Space reserved for existing footer */
        .footer-space {
            height: 150px;
            background-color: transparent;
        }

        /* Main Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            overflow-y: auto;
        }
        
        .container {
            max-width: 2000px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .title-section {
            text-align: center;
            padding: 80px 0;
            background: url('https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/8c98b565-bfe0-46a0-b7d9-318b15044a47.png') center/cover no-repeat;
            margin-bottom: 30px;
            position: relative;
            color: white;
            border-bottom: 3px solid #e30613;

        }
              
        .title-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(112, 112, 112, 0.7);
        }
        
        .title-section h1,
        .title-section p {
            position: relative;
            z-index: 1;
        }
        
        .title-section h1 {
            color: white;
            font-size: 3rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
        
        .title-section h1:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background-color: white;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .title-section p {
            color: rgba(255,255,255,0.9);
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        
        .affiliates-grid {
            display: grid;
            grid-template-columns: repeat(5, 250px);
            gap: 30px;
            padding: 20px 0;
            justify-content: center;
        }
        
        .affiliate-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
            width: 250px;
        }
        
        .affiliate-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(227, 6, 19, 0.2);
        }
        
        .affiliate-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: #e30613;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }
        
        .affiliate-card:hover:before {
            transform: scaleX(1);
        }
        
        .affiliate-image {
            height: 150px;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        .affiliate-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .affiliate-details {
            padding: 20px;
            text-align: center;
        }
        
        .affiliate-details h3 {
            color: #e30613;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }
        
        .affiliate-card:hover .affiliate-details h3 {
            color: #333;
        }
        
        .affiliate-details p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .affiliate-link {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #e30613;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .affiliate-link:hover {
            background-color: #c00511;
            transform: scale(1.05);
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .affiliates-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
            }
            
            .title-section {
                padding: 50px 20px;
            }
            
            .title-section h1 {
                font-size: 2rem;
            }
            
            .title-section p {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 850px) {
            .affiliates-grid {
                grid-template-columns: 1fr;
                max-width: 250px;
                margin: 0 auto;
            }
            
            .title-section h1 {
                font-size: 1.8rem;
            }
        }

        /* Map Section */
        .map-section {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
            margin-top: 30px;
            border-top: 1px solid #eee;
        }

        .map-section h2 {
            color: #e30613;
            font-size: 2.5rem;
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }

        .map-section h2:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background-color: #e30613;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .map-container {
            position: relative;
            max-width: 1000px;
            height: 1100px; /* Adjust as needed, depent on the pinpoint hover */
            margin: 0 auto;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden; /* Ensure pinpoints don't overflow */
        }

        .sarawak-map {
            position: absolute;
            left: 0;
            bottom: 1%;
            width: 100%;
            height: auto;
            display: block;
        }

        .pinpoint {
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: #e30613;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: white;
            box-shadow: 0 0 0 5px rgba(227, 6, 19, 0.3);
            transition: all 0.2s ease-in-out;
            z-index: 2; /* Ensure pinpoints are above the map */
        }

        .pinpoint:hover {
            transform: scale(1.2);
            box-shadow: 0 0 0 8px rgba(227, 6, 19, 0.5);
        }

        .pinpoint-info {
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            /* Reduced padding */
            padding: 10px; /* Was 15px */
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 20;
            /* Reduced min-width */
            min-width: 200px; /* Was 250px */
            /* Optional: Add max-width if you want to cap its size */
            max-width: 220px; /* New: Added max-width */
            text-align: left;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            pointer-events: none;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
        }
        

        .pinpoint:hover .pinpoint-info {
            opacity: 1;
            visibility: visible;
            pointer-events: auto; /* Enable clicks when visible */
            transform: translateX(-50%); /* Recently added */
        }

        /* Custom pinpoint-info bottom for Miri */
        #pinpoint-miri {
            z-index: 22;
        }
        
        /* .miri-info.bottom {
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(110%) !important;
        } */

        /* Specific hover effect for Miri */
        #pinpoint-miri:hover .pinpoint-info { /* Target Miri's pinpoint specifically */
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateX(-50%); /* Apply translateY only for Miri on hover */
        }

        .pinpoint-info h4 {
            color: #e30613;
            margin-top: 0;
            /* Reduced margin-bottom */
            margin-bottom: 8px; /* Was 10px */
            /* Reduced font-size */
            font-size: 1.1rem; /* Was 1.2rem */
        }
        .pinpoint-info img {
            /* Reduced max-width */
            max-width: 80px; /* Was 80px */
            height: auto;
            /* Reduced margin-bottom */
            margin-bottom: 8px; /* Was 10px */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .pinpoint-info p {
            color: #555;
            /* Reduced font-size */
            font-size: 0.85rem; /* Was 0.9rem */
            line-height: 1.4; /* Slightly reduced line-height for compactness */
            margin-bottom: 0;
        }

        .pinpoint-stats {
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 8px;
            font-size: 0.8rem;
            color: #777;
        }

        .pinpoint-stats div {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .pinpoint-stats i {
            margin-right: 5px;
            color: #e30613;
        }

        /* Draggable pinpoint styles */
        .pinpoint.draggable {
            cursor: grab;
        }

        .pinpoint.draggable:active {
            cursor: grabbing;
        }

        /* Color Roots for Analytics */
        :root {
            --maincategory-color: #dddddd; /* for Category, Male and Female column */
            --subcategory-color: #f2f2f2; /* for subcategory rows */
            --data-color: #ffffff; /* for all body rows */
            --lightblue-color: #e0f2f7; /* Light blue for Male */
            --lightpink-color: #fce4ec; /* Light pink for Female */
            --total-color: #e6e6e6; /* Newly added: Light grey for Total columns */
        }

        /* Chapter Overview Section */
        .chapter-overview-section {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
            margin: 30px 0 80px 0;
            border-top: 1px solid #eee;
        }

        .chapter-overview-section h2 {
            color: #e30613;
            font-size: 2.5rem;
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }

        .chapter-overview-section h2:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background-color: #e30613;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .chapter-overall-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .chapter-overall-grid {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: stretch;
            gap: 24px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
        }
        .chapter-overall-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 24px 18px;
            min-width: 160px;
            max-width: 220px;
            flex: 1 1 160px;
            text-align: center;
            font-size: 1.1rem;
            color: #333;
            transition: box-shadow 0.2s, transform 0.2s;
            margin: 0
        }
        .chapter-overall-card h3 {
            color: #e30613;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .chapter-overall-card p {
            margin: 0 0 8px 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .chapter-overall-card p.coc-num {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .chapter-overview-container {
            max-width: 1200px; /* Adjust as needed */
            margin: 0 auto;
        }

        .chapter-table-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(600px, 1fr)); /* Responsive grid for chapter cards */
            gap: 30px;
            justify-content: center;
            padding: 20px 0;
        }

        .chapter-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex; /* for logo on the left, and table on the right*/
            align-items: flex-start;
            gap: 15px;
            transition: all 0.3s ease;
            border-top: 5px solid #e30613;
            min-height: 120px;
        }

        .chapter-card h3 {
            display: none; /* block for mobile */
            color: #e30613;
            margin: 0 0 10px 0;
            font-size: 1.6rem;
        }

        .chapter-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .chapter-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .chapter-logo {
            width: 200px;
            height: 200px;
            object-fit: contain;
            /* border: 1px solid #eee; */
            flex-shrink: 0; /* Prevent logo from shrinking */
            margin-top: 5px; /* Align logo vertically with text */
        }

        .chapter-summary-table {
            width: 100%; /* Take remaining space */
            border-collapse: collapse;
            margin: auto 0 auto 0; /* Center vertically */
            flex-grow: 1; /* Grow to fill space */
        }

        .chapter-summary-table th,
        .chapter-summary-table td {
            border: 1px solid #eee;
            padding: 8px 5px;
            text-align: center;
            font-size: 0.9rem;
        }

        .chapter-summary-table thead th {
            font-weight: bold;
            color: #333;
            background-color: var(--maincategory-color); /* Light grey for all header cells, but colspan overrides to ensure consistency */
        }

        .chapter-summary-table thead th:not([colspan]) {
            background-color: transparent; /* No background for M, F, Total sub-headers */
        }

        .chapter-summary-table tbody td {
            background-color: transparent; /* No background for data cells */
        }

        .chapter-summary-table tbody td:first-child {
            background-color: transparent; /* Empty alignment cell */
        }

        /* Responsive Adjustments */
        @media (max-width: 1040px) {
            .map-container {
                height: auto; /* Reset to pre-changes */
            }
            .sarawak-map {
                position: static;
            }
            .pinpoint {
                opacity: 1;
                transition: opacity 0.3s;
            }
            .pinpoint.inactive-pinpoint {
                opacity: 0.2;
                pointer-events: none;
                transition: opacity 0.3s;
            }
            .mobile-pinpoint-bar {
                width: 100%;
                overflow-x: auto;
                margin: 24px 0 12px 0;
                padding-bottom: 8px;
            }
            .mobile-pinpoint-buttons {
                display: flex;
                flex-direction: row;
                gap: 12px;
                width: max-content;
                min-width: 100%;
                /* padding: 0 12px; */
                justify-content: center;
            }
            .mobile-pinpoint-buttons button {
                flex: 0 0 auto;
                padding: 10px 22px;
                border-radius: 999px;
                border: none;
                background: #fff;
                color: #333;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: ease 0.2 all;
                outline: none;
                box-shadow: 0 2px 8px rgba(227, 6, 19, 0.08);
            }
            .mobile-pinpoint-buttons button.active,
            .mobile-pinpoint-buttons button:focus {
                background: #e53935;
                color: #fff;
            }
            .mobile-pinpoint-card {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                margin: 0 auto 24px auto;
                padding: 24px 18px;
                min-height: 120px;
                max-width: 500px; /* Should be 1000px and shrinkable */
                width: auto;
                font-size: 1rem;
                color: #333;
            }
        }

        @media (max-width: 600px) {
            .chapter-overall-grid {
                flex-direction: column;
                align-items: center;
                gap: 18px;
            }
            .chapter-overall-card {
                max-width: 350px;
                width: 100%;
                min-width: 0;
            }
        }

        @media (max-width: 768px) {
            .chapter-card {
                flex-direction: column; /* Stack logo above table on medium screens */
                align-items: center;
                text-align: center;
                gap: 10px;
            }

            .chapter-card h3 {
                display: block;
            }
            
            .chapter-summary-table th,
            .chapter-summary-table td {
                font-size: 0.8rem;
                padding: 6px 3px;
            }
            
            .chapter-logo {
                width: 100px;
                height: 100px;
            }
            
            .chapter-table-wrapper {
                grid-template-columns: 1fr; /* Single column on mobile */
            }
        }

        @media (max-width: 480px) {
            .chapter-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Chatbot (Loaded via JS) -->
    <!-- <div id="chatbot-container"></div> -->
    
    <!-- Header Space -->
    <div class="header-space"></div>
    
    <div class="container">
        <!-- Title Section with Description -->
        <div class="title-section">
            <h1>Sarawak Chapters</h1>
            <p>The Special Olympics Sarawak affiliates program brings together organizations and institutions that share our vision of creating inclusive opportunities for athletes with intellectual disabilities. These partnerships strengthen our ability to deliver transformative sports programs that foster acceptance, inclusion, and well-being throughout Sarawak.</p>
        </div>
        
        <!-- Affiliates Grid -->
        <div class="affiliates-grid">
            <!-- Placeholder card for adding affiliates -->
            <div class="affiliate-card">
                <div class="affiliate-image">
                    <img src="../assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png" alt="SO Miri Chapter" />
                </div>
                <div class="affiliate-details">
                    <h3>SO Miri Chapter</h3>
                    <p>Newest chapter; growing fast and set to host the next state games in 2027.</p>
                    <a href="#" class="affiliate-link">Learn More</a>
                </div>
            </div>
            
            <div class="affiliate-card">
                <div class="affiliate-image">
                    <img src="../assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png" alt="SO Bintulu Chapter" />
                </div>
                <div class="affiliate-details">
                    <h3>SO Bintulu Chapter</h3>
                    <p>Main chapter and 2025 state games champion; very active with many athletes and programs.</p>
                    <a href="#" class="affiliate-link">Learn More</a>
                </div>
            </div>
            
            <div class="affiliate-card">
                <div class="affiliate-image">
                    <img src="../assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png" alt="SO Samarahan Chapter" />
                </div>
                <div class="affiliate-details">
                    <h3>SO Samarahan Chapter</h3>
                    <p>An upcoming chapter; strong participation and hosts regular activities.</p>
                    <a href="#" class="affiliate-link">Learn More</a>
                </div>
            </div>

            <div class="affiliate-card">
                <div class="affiliate-image">
                    <img src="../assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png" alt="SO Sibu Chapter" />
                </div>
                <div class="affiliate-details">
                    <h3>SO Sibu Chapter</h3>
                    <p>First branch, leads unified sports and coach training.</p>
                    <a href="#" class="affiliate-link">Learn More</a>
                </div>
            </div>

             <div class="affiliate-card">
                <div class="affiliate-image">
                    <img src="../assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png" alt="SO Kuching Chapter" />
                </div>
                <div class="affiliate-details">
                    <h3>SO Kuching Chapter</h3>
                    <p>Runs training, health screenings, and inclusive sports with 100+ volunteers.</p>
                    <a href="#" class="affiliate-link">Learn More</a>
                </div>
            </div>



        </div>
    </div>

    <div class="map-section">
        <h2>Our Chapters Across Sarawak</h2>
        <div class="map-container">
            <img src="../assets/images/sarawak_map_undefined2.png" alt="Sarawak Map" class="sarawak-map">
            <!-- Pinpoints will be added here by JavaScript -->
        </div>
        <div class="mobile-pinpoint-bar" id="mobilePinpointBar" style="display: none;">
            <div class="mobile-pinpoint-buttons">
                <button data-id="kuching">Kuching</button>
                <button data-id="samarahan">Samarahan</button>
                <button data-id="sibu">Sibu</button>
                <button data-id="bintulu">Bintulu</button>
                <button data-id="miri">Miri</button>
            </div>
        </div>
        <div class="mobile-pinpoint-card" id="mobilePinpointCard" style="display: none;"></div>
    </div>

    <!-- Initial version of Overview — may need to be redesigned to look simple and modern without using the table format -->
    <div class="chapter-overview-section">
        <h2>Participants Overview</h2>
        <!-- Displays the whole participants based on the total of (Athletes/UP + Coaches + Volunteers)-->
        <div class="chapter-overall-container">
            <div class="chapter-overall-grid">
                <!-- SO Kuching Chapter -->
                <div class="chapter-overall-card">
                    <h3>Kuching Chapter</h3>
                    <p>Total participants:</p>
                    <p class="coc-num">470</p>
                </div>
                <!-- SO Samarahan Chapter -->
                <div class="chapter-overall-card">
                    <h3>Samarahan Chapter</h3>
                    <p>Total participants:</p>
                    <p class="coc-num">90</p>
                </div>
                <!-- SO Sibu Chapter-->
                <div class="chapter-overall-card">
                    <h3>Sibu Chapter</h3>
                    <p>Total participants:</p>
                    <p class="coc-num">290</p>
                </div>
                <!-- SO Bintulu Chapter -->
                <div class="chapter-overall-card">
                    <h3>Bintulu Chapter</h3>
                    <p>Total participants:</p>
                    <p class="coc-num">314</p>
                </div>
                <!-- SO Miri Chapter -->
                <div class="chapter-overall-card">
                    <h3>Miri Chapter</h3>
                    <p>Total participants:</p>
                    <p class="coc-num">205</p>
                </div>
            </div>
        </div>
        <div class="chapter-overview-container">
            <div class="chapter-table-wrapper">
                
                <!-- SO Kuching Chapter Card -->
                <div class="chapter-card">
                    <img src="../assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png" alt="SO Kuching Chapter Logo" class="chapter-logo">
                    <h3>SO Kuching Chapter</h3>
                    <table class="analytics-table chapter-summary-table">
                        <thead>
                            <tr>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Athletes / Unified Partners</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Coaches</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Volunteers</th>
                            </tr>
                            <tr>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>160</td>
                                <td>140</td>
                                <td style="font-weight: bold;">300</td>
                                <td>27</td>
                                <td>23</td>
                                <td style="font-weight: bold;">50</td>
                                <td>72</td>
                                <td>48</td>
                                <td style="font-weight: bold;">120</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SO Samarahan Chapter Card -->
                <div class="chapter-card">
                    <img src="../assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png" alt="SO Samarahan Chapter Logo" class="chapter-logo">
                    <h3>SO Samarahan Chapter (Upcoming)</h3>
                    <table class="analytics-table chapter-summary-table">
                        <thead>
                            <tr>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Athletes / Unified Partners</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Coaches</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Volunteers</th>
                            </tr>
                            <tr>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>28</td>
                                <td>22</td>
                                <td style="font-weight: bold;">50</td>
                                <td>6</td>
                                <td>4</td>
                                <td style="font-weight: bold;">10</td>
                                <td>18</td>
                                <td>12</td>
                                <td style="font-weight: bold;">30</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SO Sibu Chapter -->
                <div class="chapter-card">
                    <img src="../assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png" alt="SO Sibu Chapter Logo" class="chapter-logo">
                    <h3>SO Sibu Chapter</h3>
                    <table class="analytics-table chapter-summary-table">
                        <thead>
                            <tr>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Athletes / Unified Partners</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Coaches</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Volunteers</th>
                            </tr>
                            <tr>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>74</td>
                                <td>106</td>
                                <td style="font-weight: bold;">180</td>
                                <td>13</td>
                                <td>17</td>
                                <td style="font-weight: bold;">30</td>
                                <td>43</td>
                                <td>37</td>
                                <td style="font-weight: bold;">80</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SO Bintulu Chapter -->
                <div class="chapter-card">
                    <img src="../assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png" alt="SO Bintulu Chapter Logo" class="chapter-logo">
                    <h3>SO Bintulu Chapter</h3>
                    <table class="analytics-table chapter-summary-table">
                        <thead>
                            <tr>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Athletes / Unified Partners </th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Coaches</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Volunteers</th>
                            </tr>
                            <tr>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>93</td>
                                <td>81</td>
                                <td style="font-weight: bold;">174</td>
                                <td>22</td>
                                <td>18</td>
                                <td style="font-weight: bold;">40</td>
                                <td>55</td>
                                <td>45</td>
                                <td style="font-weight: bold;">100</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SO Miri Chapter -->
                <div class="chapter-card">
                    <img src="../assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png" alt="SO Miri Chapter Logo" class="chapter-logo">
                    <h3>SO Miri Chapter</h3>
                    <table class="analytics-table chapter-summary-table">
                        <thead>
                            <tr>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Athletes / Unified Partners</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Coaches</th>
                                <th colspan="3" style="background-color: var(--maincategory-color);">Volunteers</th>
                            </tr>
                            <tr>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                                <th>M</th>
                                <th>F</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>59</td>
                                <td>61</td>
                                <td style="font-weight: bold;">120</td>
                                <td>12</td>
                                <td>13</td>
                                <td style="font-weight: bold;">25</td>
                                <td>33</td>
                                <td>27</td>
                                <td style="font-weight: bold;">60</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        <p><span style="color: #e53935;">* </span><strong>M</strong> = Male | <strong>F</strong> = Female</p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapContainer = document.querySelector('.map-container');
            const sarawakMap = document.querySelector('.sarawak-map');

            // Pinpoint data with initial positions (adjust these values)
            const pinpointsData = [
                {
                    id: 'miri',
                    name: 'SO Miri Chapter',
                    logo: '../assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png',
                    description: 'Chairman: <p style="margin: 0 0 10px 0; font-weight: 600;">Madam Liza Chai</p><p style="margin: 0;">Vice Chairman:</p><p style="margin-top: 0; font-weight: 600;">Lorem Ipsum Dolor Sit Amet Consectetuer Adipiscing Elit</p><p style="margin: 10px 0 0 0;">Secretary:</p><p style="margin-top: 0; font-weight: 600;">Lorem Ipsum Dolor Sit Amet Consectetuer Adipiscing Elit</p><p style="margin: 10px 0 0 0;">Treasurer:</p><p style="margin-top: 0; font-weight: 600;">Lorem Ipsum Dolor Sit Amet Consectetuer Adipiscing Elit</p>',
                    top: '59%', // Original: 37%
                    left: '67%',
                    athletes: 120,
                    coaches: 25,
                    volunteers: 60
                },
                {
                    id: 'bintulu',
                    name: 'SO Bintulu Chapter',
                    logo: '../assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png',
                    description: 'Chairman: <p style="margin: 0 0 10px 0; font-weight: 600;">Dato Haji Ruslan Bin Abdul Ghani</p><p style="margin: 0;">Vice Chairman:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Secretary:</p><p style="margin-top: 0; font-weight: 600;">Sabrina Cheong Oi Lin binti Abdullah</p><p style="margin: 10px 0 0 0;">Treasurer:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p>',
                    top: '70%', // Original: 55%
                    left: '56%',
                    athletes: 250,
                    coaches: 40,
                    volunteers: 100
                },
                {
                    id: 'sarawak-sibu',
                    name: 'SO Sarawak/Sibu Chapter',
                    logo: '../assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png',
                    description: 'Chairman: <p style="margin: 0 0 10px 0; font-weight: 600;">Pemanca Datuk Jason Tai Hee</p><p style="margin: 0;">Vice Chairman:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Secretary:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Treasurer:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p>',
                    top: '79%', // Original: 68%
                    left: '39%',
                    athletes: 180,
                    coaches: 30,
                    volunteers: 80
                },
                {
                    id: 'kuching',
                    name: 'SO Kuching Chapter',
                    logo: '../assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png',
                    description: 'Chairman: <p style="margin: 0 0 10px 0; font-weight: 600;">Datin Dayang Mariani Abang Zain</p><p style="margin: 0;">Vice Chairman:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Secretary:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Treasurer:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p>',
                    top: '86%', // Original: 80%
                    left: '20%',
                    athletes: 300,
                    coaches: 50,
                    volunteers: 120
                },
                {
                    id: 'samarahan',
                    name: 'SO Samarahan Chapter (Upcoming)',
                    logo: '../assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png',
                    description: 'Chairman: <p style="margin: 0 0 10px 0; font-weight: 600;">Mr. Sarahandi Api Abdullah</p><p style="margin: 0;">Vice Chairman:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Secretary:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p><p style="margin: 10px 0 0 0;">Treasurer:</p><p style="margin-top: 0; font-weight: 600;">(Unknown)</p>',
                    top: '87%', // Original: 81%
                    left: '24%',
                    athletes: 50,
                    coaches: 10,
                    volunteers: 30
                }
            ];

            // Pre-changes version of pinpoint position when width viewport is below than 1041px
            const mobilePinpointPositions = {
                miri: {top: '37%', left: '67%'},
                bintulu:{top: '55%', left: '56%'},
                'sarawak-sibu': {top: '68%', left: '39%'},
                kuching:{top: '80%', left: '20%'},
                samarahan:{top: '81%', left: '24%'}
            }

            const desktopPinpointPositions = {
                miri: {top: '59%', left: '67%'},
                bintulu:{top: '70%', left: '56%'},
                'sarawak-sibu': {top: '79%', left: '39%'},
                kuching:{top: '86%', left: '20%'},
                samarahan:{top: '87%', left: '24%'}
            }

            if (window.matchMedia('(min-width: 1041px)').matches) {
                pinpointsData.forEach(data => {
                    if(desktopPinpointPositions[data.id]) {
                        data.top = desktopPinpointPositions[data.id].top;
                        data.left = desktopPinpointPositions[data.id].left;
                    }
                })
            }

            if (window.matchMedia('(max-width: 1040px)').matches) {
                pinpointsData.forEach(data => {
                    if(mobilePinpointPositions[data.id]) {
                        data.top = mobilePinpointPositions[data.id].top;
                        data.left = mobilePinpointPositions[data.id].left;
                    }
                })
            }

            function updatePinpointPositions() {
                const isDesktop = window.matchMedia('(min-width: 1041px)').matches;
                pinpointsData.forEach(data => {
                    const pos = isDesktop ? desktopPinpointPositions[data.id] : mobilePinpointPositions[data.id];
                    if(pos) {
                        data.top = pos.top;
                        data.left = pos.left;
                        const el = document.getElementById(`pinpoint-${data.id}`);
                        if (el) {
                            el.style.top = pos.top;
                            el.style.left = pos.left;
                        }
                    }
                })
            }

            window.addEventListener('resize', updatePinpointPositions);
            window.addEventListener('orientationchange', updatePinpointPositions);

            // Create pinpoint
            function createPinpoint(data) {
                const pinpoint = document.createElement('div');
                pinpoint.classList.add('pinpoint');
                // pinpoint.classList.add('draggable'); // Make it draggable - removed as per instruction
                pinpoint.id = `pinpoint-${data.id}`;
                pinpoint.style.top = data.top;
                pinpoint.style.left = data.left;

                const infoBox = document.createElement('div');
                infoBox.classList.add('pinpoint-info');
                infoBox.classList.add('bottom'); // Default position, can be adjusted dynamically
                // Add specific class for Miri's info box
                if (data.id === 'miri') {
                    infoBox.classList.add('miri-info');
                }

                infoBox.innerHTML = `
                    <h4>${data.name}</h4>
                    <img src="${data.logo}" alt="${data.name} Logo">
                    <p>${data.description}</p>
                    <div class="pinpoint-stats">
                        <div><i class="fa-solid fa-person-running" style="margin: 0 6px 0 2px;"></i> Athletes: ${data.athletes}</div>
                        <div><i class="fa-solid fa-user-tie" style="margin: 0 6px 0 2px;"></i> Coaches: ${data.coaches}</div>
                        <div><i class="fa-solid fa-handshake-angle"></i> Volunteers: ${data.volunteers}</div>
                    </div>
                `;

                pinpoint.appendChild(infoBox);
                mapContainer.appendChild(pinpoint);
            }

            // Pinpoint hover as card for mobile
            function showMobilePinpointBar(show, selectedId = 'kuching') {
                const bar = document.getElementById('mobilePinpointBar');
                const card = document.getElementById('mobilePinpointCard');
                bar.style.display = show ? 'block' : 'none';
                card.style.display = show ? 'block' : 'none';
                if (show) {
                    // Render the card for the selected chapter
                    const data = pinpointsData.find(p => p.id === selectedId || (selectedId === 'sibu' && p.id === 'sarawak-sibu'));
                    if (data) renderMobilePinpointCard(data);
                    bar.querySelectorAll('button').forEach(btn => {
                        btn.classList.toggle('active', btn.dataset.id === selectedId);
                    });
                    // Set pinpoint opacity (on mobile)
                    pinpointsData.forEach(p => {
                        const el = document.getElementById(`pinpoint-${p.id}`);
                        if (el) {
                            if (p.id === selectedId || (selectedId === 'sibu' && p.id === 'sarawak-sibu')) {
                                el.classList.remove('inactive-pinpoint');
                            } else {
                                el.classList.add('inactive-pinpoint')
                            }
                        }
                    });
                } else {
                    // On desktop, all pinpoints are fully visible
                    pinpointsData.forEach(p => {
                        const el = document.getElementById(`pinpoint-${p.id}`);
                        if (el) el.classList.remove('inactive-pinpoint');
                    });
                }
            }

            function renderMobilePinpointCard(data) {
                const card = document.getElementById('mobilePinpointCard');
                card.innerHTML = `
                <div style="text-align:center;">
                    <img src="${data.logo}" alt="${data.name} Logo" style="max-width:160px; margin-bottom:10px;">
                </div>
                <h4 style="color:#e30613; margin-top:0; font-size: 1.2rem;">${data.name}</h4>
                <div style="margin-bottom:10px;">${data.description}</div>
                <div class="pinpoint-stats" style="font-size: 1rem; font-weight: 600;">
                    <div><i class="fa-solid fa-person-running" style="margin: 0 6px 0 3px;"></i> Athletes: ${data.athletes}</div>
                    <div><i class="fa-solid fa-user-tie" style="margin: 0 6px 0 3px;"></i> Coaches: ${data.coaches}</div>
                    <div><i class="fa-solid fa-handshake-angle"></i> Volunteers: ${data.volunteers}</div>
                </div>
                `;
            }

            const bar = document.getElementById('mobilePinpointBar');
            if (bar) {
                bar.querySelectorAll('button').forEach(btn => {
                    btn.addEventListener('click', function() {
                        showMobilePinpointBar(true, btn.dataset.id);
                    });
                })
            }

            function setupMobilePinpointBar() {
                if (window.innerWidth <= 1040) {
                    document.querySelectorAll('.pinpoint-info').forEach(el => {
                        el.style.display = 'none';
                    });
                } else {
                    document.querySelectorAll('.pinpoint-info').forEach(el => {
                        el.style.display = '';
                    });
                }
            }

            function handleResponsivePinpoints() {
                if (window.innerWidth <= 1040) {
                    showMobilePinpointBar(true);
                    setupMobilePinpointBar();
                } else {
                    showMobilePinpointBar(false);
                    setupMobilePinpointBar();
                }
            }

            window.addEventListener('resize', handleResponsivePinpoints);
            window.addEventListener('orientationchange', handleResponsivePinpoints);

            document.addEventListener('DOMContentLoaded', function() {
                setupMobilePinpointBar();
                handleResponsivePinpoints();
            });

            // Create all pinpoints
            pinpointsData.forEach(data => createPinpoint(data));

            // Initial run
            setupMobilePinpointBar();
            handleResponsivePinpoints();
            updatePinpointPositions();
        });
    </script>

    <!-- Section Divider -->
    <div class="section-divider"></div>
    
    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
</body>
</html>