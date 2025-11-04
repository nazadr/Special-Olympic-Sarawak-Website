<!-- This pre-release version is made to be identical to the printed form of SO Sarawak Volunteer Registration Form -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(Pre-release) Volunteer Registration | Special Olympics Sarawak</title>
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
            color: #e53935;
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
            border-bottom: 2px solid #e53935;
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
            background-color: #e53935;
            color: white;
        }
        .form-actions button[type="submit"]:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>
    <script src="../scripts/components/header.js"></script>
    <script src="../scripts/components/socmed-bar.js"></script>

    <div class="header-space"></div>

    <div class="form-container">
        <h2>Volunteer Registration</h2>
        <p style="text-align: center; margin-bottom: 30px;">Thank you for your interest in volunteering with Special Olympics Sarawak!</p>
        <p style="text-align: center;">Volunteers are the heart of our program, and your support is crucial in creating an environment where athletes can excel. Whether you're helping at events, supporting athletes during training, or assisting with administrative tasks, your contribution will make a lasting impact. Please provide us with some basic information about yourself so we can match you with volunteer opportunities that best align with your interests and skills. Your dedication will help us continue to provide life-changing opportunities for our athletes. Together, we can create an inclusive and empowering community.</p>

        <!-- When a user click Submit, the page will redirect to the process_volunteer_registration.php (not created) -->
        <form action="ja-volunteer-submit-initial.html" method="POST">
            <div class="form-section-title">PERSONAL PARTICULARS</div>
            <div class="form-group">
                <label for="volunteer_full_name">Full Name: <span style="color: #e53935">*</span></label>
                <input type="text" id="volunteer_full_name" name="volunteer_full_name" placeholder="John Mason" required>
            </div>
            <div class="form-group">
                <label>Gender: <span style="color: #e53935">*</span></label>
                <div class="radio-group">
                    <input type="radio" id="volunteer_gender_m" name="volunteer_gender" value="M" required>
                    <label for="volunteer_gender_m">M</label>
                    <input type="radio" id="volunteer_gender_f" name="volunteer_gender" value="F">
                    <label for="volunteer_gender_f">F</label>
                </div>
            </div>
            <div class="form-group">
                <label for="volunteer_dob">Date of Birth: <span style="color: #e53935">*</label>
                <input type="date" id="volunteer_dob" name="volunteer_dob" placeholder="DD/MM/YYYY">
            </div>
            <div class="form-group">
                <label for="volunteer_age">Age: <span style="color: #e53935">*</span></label>
                <input type="text" id="volunteer_age" name="volunteer_age" readonly>
            </div>
            <div class="form-group">
                <label for="volunteer_nric_passport">NRIC/Passport Number: <span style="color: #e53935">*</span></label>
                <input type="text" id="volunteer_nric_passport" name="volunteer_nric_passport" required>
            </div>
            <div class="form-group">
                <label for="volunteer_welfare_card">Welfare Card No.: <span style="color: #e53935;">*</span></label>
                <input type="text" id="volunteer_welfare_card" name="volunteer_welfare_card" required>
            </div>
            <div class="form-group">
                <label for="volunteer_school">School: <span style="color: #e53935">*</span></label>
                <input type="text" id="volunteer_school" name="volunteer_school" placeholder="SMK Lorem Ipsum" required>
            </div>
            <div class="form-group">
                <label for="volunteer_email">Email Address: <span style="color: #e53935">*</span></label>
                <input type="email" id="volunteer_email" name="volunteer_email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label for="volunteer_phone">Phone Number: <span style="color: #e53935">*</span></label>
                <input type="tel" id="volunteer_phone" name="volunteer_phone" placeholder="+60 12-345 6789" required>
            </div>
            <div class="form-group">
                <label for="volunteer_mailing_address">Mailing Address: <span style="color: #e53935">*</span></label>
                <textarea style="resize: none;" id="volunteer_mailing_address" name="volunteer_mailing_address" placeholder="No. 123, Taman Lorem Ipsum, Jalan Dolor Sit Amet, 96000 Sibu, Sarawak." required></textarea>
            </div>
            <div class="form-group">
                <label for="volunteer_attached_org">Attached Organization (compulsory): <span style="color: #e53935;">*</span></label>
                <input type="text" id="volunteer_attached_org" name="volunteer_attached_org" placeholder="" required>
            </div>

            <div class="form-section-title">QUALIFICATION AND EXPERIENCE</div>
            <div class="form-group">
                <label for="volunteer_academic">Academic: <span style="color: #e53935;">*</span></label>
                <input type="text" id="volunteer_academic" name="volunteer_academic" required>
            </div>
            <!-- Continue from here -->
            <div class="form-group">
                <label>Sports: <span style="color: #e53935">*</span></label>
                <input type="text" id="volunteer_sports" name="volunteer_sports" required>
                <div style="margin-top: 12px;" class="checkbox-group">
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Corporate/NGO/Govt"><label for="v_qne-corporate">Corporate/NGO/Government</label></div>
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Family"><label for="v_qne-family">Family</label></div>
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Leader"><label for="v_qne-leader">Leader</label></div>
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Official"><label for="v_qne-official">Official</label></div>
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Volunteer"><label for="v_qne-volunteer">Volunteer</label></div>
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Coach"><label for="v_qne-coach">Coach <span style="color: #e53935;">*</span></label></div>
                    <div><input type="checkbox" id="volunteer_qne" name="volunteer_qne[]" value="Unified Parner"><label for="v_qne-unified">Unified Partner <span style="color: #e53935;">*</span></label></div>
                </div>
            </div>

            <div class="form-section-title">SPORTS (FOR COACH AND UNIFIED PARTNER ONLY)</div>
            <div class="form-group">
                <div class="checkbox-group">
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="ALPs"><label for="v_alps">ALPs</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Aquatics"><label for="v_aquatics">Aquatics</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Athletics"><label for="v_athletics">Athletics</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Badminton"><label for="v_badminton">Badminton</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Basketball"><label for="v_basketball">Basketball</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Bocce"><label for="v_bocce">Bocce</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Bowling"><label for="v_bowling">Bowling</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Cycling"><label for="v_cycling">Cycling</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Floorball"><label for="v_floorball">Floorball</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Floor Hockey"><label for="v_floorhockey">Floor Hockey</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Football"><label for="v_football">Football</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="MATP"><label for="v_matp">MATP</label></div>
                    <div><input type="checkbox" id="volunteer_sport" name="volunteer_sport[]" value="Other Sports"><label for="v_othersports">Other Sports*</label></div>
                </div>
                <div style="margin-top: 12px;" class="form-group">
                    <label>Other Sports (if selected): <span style="color: #e53935;">*</span></label>
                    <input type="text" id="volunteer_other_sports" name="volunteer_other_sports" placeholder="Please specify if 'Other Sports' is selected above.">
                </div>
            </div>

            <div class="form-section-title">ACKNOWLEDGEMENT</div>
            <div class="acknowledgement">
                <p style="margin-bottom: 30px;">I, the undersigned, acknowledge and agree to the following terms and conditions as a Volunteer with Special Olympics Sarawak:</p>
                <ol>
                    <li><strong>Eligibility to Participate:</strong> I confirm that I am physically and mentally able to fulfill the responsibilities required of me as a Volunteer and will contribute to a safe and welcoming environment for all athletes and event participants.</li>
                    <li><strong>Likeness Release:</strong> I grant Special Olympics Sarawak, the event organizing committees, and Special Olympics accredited State Programs (collectively “Special Olympics”) the right to use my likeness, photo, video, name, voice, words, and biographical information to promote Special Olympics activities, events, and fundraising campaigns.</li>
                    <li><strong>Risk and Safety Awareness:</strong> I acknowledge that my role as a Volunteer may involve potential risks. I will follow all safety procedures to minimize these risks, report any safety concerns or injuries to the relevant authorities, and act in a way that prioritizes the well-being of the athletes and other participants.</li>
                    <li><strong>Compliance with Rules and Regulations:</strong> I agree to adhere to all Special Olympics Sarawak rules, policies, and guidelines. I will ensure my conduct is professional, respectful, and aligned with the values of Special Olympics, helping create an inclusive and supportive atmosphere.</li>
                    <li><strong>Indemnity and Liability:</strong> I hereby release, discharge, and covenant not to sue Special Olympics Sarawak, the event organizers, its administrators, officers, volunteers, employees, sponsors, and other participants (the "Releasees") from any liability, claims, demands, or losses, including those related to negligence, arising out of my participation as a Volunteer. I also agree to indemnify and hold harmless the Releasees from any claims made by third parties as a result of my actions or omissions.</li>
                    <li><strong>Health and Medical Information:</strong> I understand that my personal information, including health details, may be collected and used for event management, safety, and medical emergency purposes. I consent to the use and sharing of my personal information with medical professionals if necessary in case of an emergency.</li>
                    <li><strong>Personal Information and Privacy:</strong> Special Olympics Sarawak may collect and use my personal information for communication, event planning, and promotional purposes. I understand that my information may be used in digital marketing, including email, text messages, and social media. I acknowledge my right to request access, correction, or deletion of my personal information.</li>
                    <li><strong>Voluntary Participation:</strong> I confirm that my participation as a Volunteer is voluntary. I have read and understood the risks involved, and I agree to perform my duties with respect, care, and responsibility to help create a positive and enjoyable experience for the athletes and participants.</li>
                </ol>
                <p style="margin-bottom: 30px;">I acknowledge that I have read and understood this Acknowledgement and Waiver, and I agree to the terms and conditions outlined above.</p>
                <p>(This is a placeholder and is subject to change.)</p>
                <div class="checkbox-container">
                    <input type="checkbox" id="volunteer_agree" name="volunteer_agree" required>
                    <label for="volunteer_agree">I AGREE <span style="color: #e53935">*</span></label>
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
        flatpickr("#volunteer_dob", {
            dateFormat: "d/m/Y", // This is the format that will be submitted
            altInput: true,      // Enables a user-friendly input field
            altFormat: "d/m/Y",  // This is the format displayed to the user
            onClose: function(selectedDates, dateStr, instance) {
                calculateAge('volunteer_dob', 'volunteer_age'); // Recalculate age when date is selected
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