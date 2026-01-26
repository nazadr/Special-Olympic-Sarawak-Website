<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unified Partner Registration | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Flatpickr CSS for Date Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px 0;
            overflow-y: auto;
        }
        .header-space {
            height: 70px;
        }
        .form-container {
            max-width: 800px;
            margin: 64px auto 80px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .form-container h2 {
            color: #FF0000;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.2rem;
        }
        .form-container p {
            text-align: left;
            margin-bottom: 70px;
            color: #4b5563;
            line-height: 1.6;
        }
        .form-section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-top: 30px;
            margin-bottom: 20px;
            border-bottom: 2px solid #FF0000;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group select,
        .form-group textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .form-group input[type="radio"] {
            margin-right: 5px;
        }
        .form-group textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            resize: vertical;
            min-height: 80px;
        }
        .form-group .radio-group label {
            display: inline-block;
            margin-right: 15px;
        }
        .checkbox-group label {
            display: inline;
            margin-left: 5px;
        }
        .checkbox-group div {
            margin-bottom: 5px;
        }
        .acknowledgement {
            background-color: #f9fafb;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            color: #4b5563;
        }
        .acknowledgement h3 {
            font-size: 1.2rem;
            color: #111827;
            margin-bottom: 15px;
        }
        .acknowledgement ol {
            list-style-type: decimal;
            margin-left: 20px;
            margin-bottom: 20px;
        }
        .acknowledgement li {
            margin-bottom: 10px;
        }
        .acknowledgement ul {
            list-style-type: disc;
            margin-left: 20px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .acknowledgement .checkbox-container {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        .acknowledgement .checkbox-container input[type="checkbox"] {
            margin-right: 10px;
        }
        .form-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .form-actions button {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-actions button[type="reset"] {
            background-color: #6c757d;
            color: white;
        }
        .form-actions button[type="reset"]:hover {
            background-color: #5a6268;
        }
        .form-actions button[type="submit"] {
            background-color: #FF0000;
            color: white;
        }
        .form-actions button[type="submit"]:hover {
            background-color: #CC0000;
        }
    </style>
</head>
<body>
    <script src="../scripts/components/header.js"></script>
    <script src="../scripts/components/socmed-bar.js"></script>

    <div class="header-space"></div>

    <div class="form-container">
        <h2>Unified Partner Registration</h2>
        <p style="text-align: center; margin-bottom: 30px;">Thank you for your interest in becoming a Unified Partner with Special Olympics Sarawak!</p>
        <p style="text-align: center;">As a Unified Partner, you will play a vital role in promoting inclusion by training and competing alongside athletes with intellectual disabilities. Through shared experiences on and off the field, you’ll build meaningful friendships, foster mutual respect, and help break down barriers. Whether you’re new to sports or a seasoned athlete, your participation helps create a more unified and accepting community.</p>

        <!-- When a user click Submit, the page will redirect to the process_unified_registration.php (not created) -->
        <form action="ja-unified-submit-initial.html" method="POST">
            <div class="form-section-title">PERSONAL PARTICULARS</div>
            <div class="form-group">
                <label for="unified_full_name">Full Name: <span style="color: #FF0000">*</span></label>
                <input type="text" id="unified_full_name" name="unified_full_name" required>
            </div>
            <div class="form-group">
                <label for="unified_nick_name">Nick Name: <span style="color: #FF0000">*</span></label>
                <input type="text" id="unified_nick_name" name="unified_nick_name" required>
            </div>
            <div class="form-group">
                <label>Gender: <span style="color: #FF0000;">*</span></label>
                <div class="radio-group">
                    <input type="radio" id="unified_gender_m" name="unified_gender" value="M" required>
                    <label for="unified_gender_m">M</label>
                    <input type="radio" id="unified_gender_f" name="unified_gender" value="F">
                    <label for="unified_gender_f">F</label>
                </div>
            </div>
            <div class="form-group">
                <label for="unified_dob">Date of Birth: <span style="color: #FF0000">*</label>
                <input type="date" id="unified_dob" name="unified_dob" placeholder="DD/MM/YYYY">
            </div>
            <div class="form-group">
                <label for="volunteer_age">Age: <span style="color: #FF0000">*</span></label>
                <input type="text" id="volunteer_age" name="volunteer_age" readonly>
            </div>
            <div class="form-group">
                <label for="unified_nric_passport">NRIC/Birth Number/Passport Number: <span style="color: #FF0000">*</span></label>
                <input type="text" id="unified_nric_passport" name="unified_nric_passport" required>
            </div>
            <div class="form-group">
                <label for="unified_school">School: <span style="color: #FF0000">*</span></label>
                <input type="text" id="unified_school" name="unified_school" required>
            </div>
            <div class="form-group">
                <label for="unified_email">Email Address: <span style="color: #FF0000">*</span></label>
                <input type="email" id="unified_email" name="unified_email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label for="unified_phone">Phone Number: <span style="color: #FF0000">*</span></label>
                <input type="tel" id="unified_phone" name="unified_phone" placeholder="+60 12-345 6789" required>
            </div>
            <div class="form-group">
                <label for="unified_mailing_address">Mailing Address: <span style="color: #FF0000">*</span></label>
                <textarea style="resize: none;" id="unified_mailing_address" name="unified_mailing_address" placeholder="No. 123, Taman Lorem Ipsum, Jalan Dolor Sit Amet, 96000 Sibu, Sarawak." required></textarea>
            </div>

            <div class="form-section-title">UNIFIED SPORTS</div>
            <div class="form-group">
                <label>Unified Sports: <span style="color: #FF0000;">*</span></label>
                <div style="margin-top: 12px;" class="checkbox-group">
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Badminton"><label for="unified_usports-badmintion">Unified Badminton</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Basketball"><label for="unified_usports-basketball">Unified Basketball</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Bocce"><label for="unified_usports-bocce">Unified Bocce</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Bowling"><label for="unified_usports-bowling">Unified Bowling</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Floor Hockey"><label for="unified_usports-floor-hockey">Unified Floor Hockey</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Football"><label for="unified_usports-football">Unified Football</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Unified Ping Pong"><label for="unified_usports-pingpong">Unified Ping Pong</label></div>
                    <div><input type="checkbox" id="unified_usports" name="unified_usports[]" value="Other Sports"><label for="unified_usports-others">Other Sports</label></div>
                </div>
                <input type="text" id="unified_sports" name="unified_sports" placeholder="(Other sports, if any)">
            </div>

            <div class="form-section-title">UNIFIED PARTNER, PARENTS OR GUARDIANS RELEASE</div>
            <div class="form-group">
                <label>Parent's/Guardian's Full Name: <span style="color: #FF0000;">*</span></label>
                <input type="text" id="unified_pgfn" name="unified_pgfn" required>
            </div>
            <div class="form-group">
                <label>Parent's/Guardian's NRIC/Birth Number/Passport Number: <span style="color: #FF0000;">*</span></label>
                <input type="text" id="unified_pgic" name="unified_pgic" required>
            </div>
            <div class="acknowledgement">
                <p style="margin-bottom: 30px;">I, the undersigned of the above-named Unified Partner, hereby request permission for him/her to participate in the Special Olympics Sarawak program. I represent and warrant that he/she is physically and mentally able to participate in Special Olympics Sarawak.</p>
                <p style="margin-bottom: 30px;">On behalf of the Unified Partner and myself, I acknowledge that he/she will be using facilities at his/her own risk and I, on my own behalf, hereby release, discharge and indemnify Special Olympics Sarawak from all liability for injury to person or damage to property of myself or entrant. In permitting the Unified Partner to participate, I am granting permission to you to use the likeness, voice and words of the Unified Partner in television, radio, films, newspaper, magazine and other media for the purpose of advertising and communicating the purpose and activities of Special Olympics Sarawak and in appealing for funds to support such activities. If I am not personally at the Special Olympics activities in which Unified Partner is to compete, so as to be consulted in case of necessity, you are authorised on my behalf and at my account to take such measures and arrange for such medical and hospital treatment that you may deem advisable for health and well-being of the Unified Partner.</p>
                <div class="checkbox-container">
                    <input type="checkbox" id="unified_agree" name="unified_agree" required>
                    <label for="unified_agree">I AGREE <span style="color: #FF0000">*</span></label>
                </div>
                <p>By submitting this form, I confirm that the information provided is accurate and true, read and AGREED to the terms.</p>
            </div>

            <div class="form-actions">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script src="../scripts/components/bottom-nav.js"></script>
    <script src="../scripts/components/site-footer.js"></script>

    <script>
        flatpickr("#unified_dob", {
            dateFormat: "d/m/Y", // This is the format that will be submitted
            altInput: true,      // Enables a user-friendly input field
            altFormat: "d/m/Y",  // This is the format displayed to the user
            onClose: function(selectedDates, dateStr, instance) {
                calculateAge('unified_dob', 'unified_age'); // Recalculate age when date is selected
            }
        });
        
        function calculateAge(dobId, ageId) {
            const dobInput = document.getElementById(dobId);
            const ageInput = document.getElementById(ageId);
            const dob = new Date(dobInput.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            ageInput.value = age;
        }
    </script>
    <script src="../scripts/script.js"></script>
</body>
</html>