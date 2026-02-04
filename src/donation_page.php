<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Local HTML style -->
    <style>
        /* Space for existing header/footer */
        .header-space {
            height: 70px;
        }
        
        /* Main Styles */
        body {
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            overflow-y: auto;
        }

        /* Chapter QR Donation Section */
        .chapter-qr-section {
            padding: 60px 20px;
            background-color: #f9f9f9;
        }

        .chapter-qr-section h2 {
            text-align: center;
            color: #FF0000;
            font-size: 2rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .chapter-qr-section h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background-color: #FF0000;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .chapter-qr-section > p {
            text-align: center;
            color: #666;
            max-width: 700px;
            margin: 30px auto 40px auto;
            font-size: 1.1rem;
        }

        .chapter-qr-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .chapter-qr-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            text-align: center;
            padding: 20px 15px;
            border-top: 4px solid #FF0000;
        }

        .chapter-qr-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(227, 6, 19, 0.15);
        }

        .chapter-qr-card .chapter-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin: 0 auto 12px auto;
            display: block;
        }

        .chapter-qr-card h3 {
            color: #FF0000;
            font-size: 1.1rem;
            margin: 0 0 15px 0;
            font-weight: 600;
        }

        .chapter-qr-card .qr-code {
            width: 180px;
            height: 180px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            padding: 12px;
            background: #fff;
        }

        .chapter-qr-card .chapter-location {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            color: #888;
            font-size: 0.9rem;
            margin-top: 12px;
        }

        .chapter-qr-card .chapter-location i {
            color: #FF0000;
            font-size: 0.85rem;
        }

        /* Responsive Styles for Chapter QR Grid */
        @media (max-width: 1100px) {
            .chapter-qr-grid {
                grid-template-columns: repeat(3, 1fr);
                max-width: 900px;
                gap: 25px;
            }
        }

        @media (max-width: 700px) {
            .chapter-qr-grid {
                grid-template-columns: repeat(2, 1fr);
                max-width: 450px;
            }
            
            .chapter-qr-card .qr-code {
                width: 140px;
                height: 140px;
            }
            
            .chapter-qr-card .chapter-logo {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 480px) {
            .chapter-qr-grid {
                grid-template-columns: 1fr;
                max-width: 280px;
            }
            
            .chapter-qr-section h2 {
                font-size: 1.6rem;
            }
        }

        /* Account Information Alignment */
        .account-info {
            text-align: left;
            max-width: 450px;
            margin: 0 auto;
        }

        .account-info p {
            display: flex;
            margin: 8px 0;
            font-size: 1rem;
        }

        .account-info p strong {
            width: 160px;
            flex-shrink: 0;
            text-align: left;
            position: relative;
            padding-right: 20px;
        }

        .account-info p strong::after {
            content: ':';
            position: absolute;
            right: 8px;
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
    
    <section class="donate-page">
        <div class="donate-container">
            <h1>Empower Athletes with Intellectual Disabilities</h1>
            <p>Your donation to Special Olympics helps provide year-round sports training and athletic competition in a variety of Olympic-type sports for children and adults with intellectual disabilities.</p>
        </div>
    </section>
    
    <div class="donate-container">
        <h2>Donate via QR Code</h2>
        <!-- Both QR codes is just a sample, not an actual SO Sarawak QR -->
        <div class="donation-options">
            <div class="donation-card-qr-horizontal">
                <div class="qr-section">
                    <div class="qr-code-wrapper">
                        <img src="../assets/images/malaysia-national-qr.png" alt="SO Sarawak DuitNow QR">
                        <p class="qr-recipient">Special Olympics Sarawak</p>
                    </div>
                </div>
                <div class="bank-info-section">
                    <h3>You can fund transfer donation to our account as follow:</h3>
                    <div class="account-info">
                        <p><span class="label">Bank</span>RHB Bank Berhad</p>
                        <p><span class="label">Account Number</span>1234-5678-901234</p>
                        <p><span class="label">Account Name</span>Special Olympics Sarawak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter QR Donation Section -->
    <section class="chapter-qr-section">
        <h2>Donate to Our Chapters</h2>
        <p>Support your local Special Olympics chapter directly. Scan the QR code of your preferred chapter to make a donation.</p>
        
        <div class="chapter-qr-grid">
            <!-- Kuching Chapter -->
            <div class="chapter-qr-card">
                <img src="../assets/images/SO_Kuching_chapter.png" alt="SO Kuching Chapter" class="chapter-logo">
                <h3>SO Kuching Chapter</h3>
                <img src="../assets/images/malaysia-national-qr.png" alt="Kuching Chapter QR" class="qr-code">
                <div class="chapter-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Kuching, Sarawak</span>
                </div>
            </div>

            <!-- Samarahan Chapter -->
            <div class="chapter-qr-card">
                <img src="../assets/images/SO_Samarahan_chapter.png" alt="SO Samarahan Chapter" class="chapter-logo">
                <h3>SO Samarahan Chapter</h3>
                <img src="../assets/images/malaysia-national-qr.png" alt="Samarahan Chapter QR" class="qr-code">
                <div class="chapter-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Samarahan, Sarawak</span>
                </div>
            </div>

            <!-- Sibu Chapter -->
            <div class="chapter-qr-card">
                <img src="../assets/images/SO_Sibu_Chapter.png" alt="SO Sibu Chapter" class="chapter-logo">
                <h3>SO Sibu Chapter</h3>
                <img src="../assets/images/malaysia-national-qr.png" alt="Sibu Chapter QR" class="qr-code">
                <div class="chapter-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Sibu, Sarawak</span>
                </div>
            </div>

            <!-- Bintulu Chapter -->
            <div class="chapter-qr-card">
                <img src="../assets/images/SO_Bintulu_chapter.png" alt="SO Bintulu Chapter" class="chapter-logo">
                <h3>SO Bintulu Chapter</h3>
                <img src="../assets/images/malaysia-national-qr.png" alt="Bintulu Chapter QR" class="qr-code">
                <div class="chapter-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Bintulu, Sarawak</span>
                </div>
            </div>

            <!-- Miri Chapter -->
            <div class="chapter-qr-card">
                <img src="../assets/images/SO_Miri_chapter.png" alt="SO Miri Chapter" class="chapter-logo">
                <h3>SO Miri Chapter</h3>
                <img src="../assets/images/malaysia-national-qr.png" alt="Miri Chapter QR" class="qr-code">
                <div class="chapter-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Miri, Sarawak</span>
                </div>
            </div>
        </div>
    </section>
    
    <section class="donate-impact-section">
        <h2>Your Impact</h2>
        <div class="donate-impact-grid">
            <div class="donate-impact-item">
                <h3>5.7M+</h3>
                <p>Athletes empowered worldwide through Special Olympics programs</p>
            </div>
            <div class="donate-impact-item">
                <h3>100+</h3>
                <p>Countries with active Special Olympics programs</p>
            </div>
            <div class="donate-impact-item">
                <h3>30+</h3>
                <p>Olympic-type sports offered to athletes</p>
            </div>
            <div class="donate-impact-item">
                <h3>1M+</h3>
                <p>Coaches and volunteers trained annually</p>
            </div>
        </div>
    </section>
    
    <section class="donate-testimonials">
        <h2>Why Donors Support Special Olympics</h2>
        <div class="donate-testimonial-grid">
            <div class="donate-testimonial-card">
                <p>"Seeing the joy and confidence these athletes gain through sports is priceless. My donation is an investment in human potential."</p>
                <div class="author">- Michael T., Monthly Donor</div>
            </div>
            <div class="donate-testimonial-card">
                <p>"Our company proudly supports Special Olympics because we believe in inclusion and the transformative power of sports."</p>
                <div class="author">- Sarah K., Corporate Partner</div>
            </div>
            <div class="donate-testimonial-card">
                <p>"As a parent of an athlete, I've witnessed firsthand how Special Olympics changes lives. I give so others can experience this too."</p>
                <div class="author">- David R., Legacy Donor</div>
            </div>
        </div>
    </section>
    
    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <!-- Section Divider -->
    <div class="section-divider"></div>
    <script src="../scripts/script.js"></script>
</body>
</html>