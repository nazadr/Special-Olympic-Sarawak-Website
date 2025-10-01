<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Registration | Special Olympics Sarawak</title>
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
        <h2>Coach Registration</h2>
        <p style="text-align: center; margin-bottom: 30px;">Thank you for your interest in becoming a coach for Special Olympics Sarawak!</p>
        <p style="text-align: center;">Your commitment to guiding and inspiring athletes is essential to the success of our program. As a coach, you will play a key role in helping athletes reach their full potential, both on and off the field. Please take a moment to provide us with some details about yourself so that we can match you with the right team and ensure that you have the support and resources needed for a rewarding coaching experience. Together, we can make a lasting impact on the lives of those we serve.</p>

        <!-- When a user click Submit, the page will redirect to the process_coach_registration.php (not created) -->
        <form action="ja-coach-submit-initial.html" method="POST">
            <div class="form-section-title">YOUR PERSONAL INFORMATION</div>
            <div class="form-group">
                <label for="coach_full_name">Full Name: <span style="color: #e53935">*</span></label>
                <input type="text" id="coach_full_name" name="coach_full_name" placeholder="John Mason" required>
            </div>
            <div class="form-group">
                <label>Gender: <span style="color: #e53935">*</span></label>
                <div class="radio-group">
                    <input type="radio" id="coach_gender_m" name="coach_gender" value="M" required>
                    <label for="coach_gender_m">M</label>
                    <input type="radio" id="coach_gender_f" name="coach_gender" value="F">
                    <label for="coach_gender_f">F</label>
                </div>
            </div>
            <div class="form-group">
                <label for="coach_nric_passport">NRIC/Passport No.: <span style="color: #e53935">*</span></label>
                <input type="text" id="coach_nric_passport" name="coach_nric_passport" required>
            </div>
            <div class="form-group">
                <label for="coach_dob">Date of Birth: <span style="color: #e53935">*</span></label>
                <input type="date" id="coach_dob" name="coach_dob" placeholder="DD/MM/YYYY">
            </div>
            <div class="form-group">
                <label for="coach_age">Age: <span style="color: #e53935">*</span></label>
                <input type="text" id="coach_age" name="coach_age" readonly>
            </div>
            <div class="form-group">
                <label for="coach_email">Email Address: <span style="color: #e53935">*</span></label>
                <input type="email" id="coach_email" name="coach_email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label for="coach_phone">Phone Number: <span style="color: #e53935">*</span></label>
                <input type="tel" id="coach_phone" name="coach_phone" placeholder="+60 12-345 6789" required>
            </div>
            <div class="form-group">
                <label for="coach_mailing_address">Mailing Address: <span style="color: #e53935">*</span></label>
                <textarea style="resize: none;" id="coach_mailing_address" name="coach_mailing_address" placeholder="No. 123, Taman Lorem Ipsum, Jalan Dolor Sit Amet, 96000 Sibu, Sarawak." required></textarea>
            </div>

            <div class="form-section-title">EXPERIENCE AND CERTIFICATION</div>
            <div class="form-group">
                <label for="sport_coached">Sport Coached: <span style="color: #e53935">*</span></label>
                <input type="text" id="sport_coached" name="sport_coached">
            </div>
            <div class="form-group">
                <label for="years_experience">Years of Experience: <span style="color: #e53935">*</span></label>
                <input type="text" id="years_experience" name="years_experience">
            </div>
            <div class="form-group">
                <label for="type_certification">Type of Certification: <span style="color: #e53935">*</span></label>
                <input type="text" id="type_certification" name="type_certification">
            </div>
            <div class="form-group">
                <label for="date_certification">Date of Certification: <span style="color: #e53935">*</span></label>
                <input type="date" id="date_certification" name="date_certification" placeholder="DD/MM/YYYY">
            </div>

            <div class="form-section-title">EMERGENCY CONTACT INFORMATION</div>
            <div class="form-group">
                <label for="emergency_full_name">Full Name: <span style="color: #e53935">*</span></label>
                <input type="text" id="emergency_full_name" name="emergency_full_name" placeholder="Jane Doe" required>
            </div>
            <div class="form-group">
                <label for="emergency_relationship">Relationship with the Coach: <span style="color: #e53935">*</span></label>
                <input type="text" id="emergency_relationship" name="emergency_relationship" placeholder="Mother" required>
            </div>
            <div class="form-group">
                <label for="emergency_phone">Phone Number: <span style="color: #e53935">*</span></label>
                <input type="tel" id="emergency_phone" name="emergency_phone" placeholder="+60 12-345 6789" required>
            </div>
            <div class="form-group">
                <label for="emergency_email">Email Address: <span style="color: #e53935">*</span></label>
                <input type="email" id="emergency_email" name="emergency_email" placeholder="jane@example.com" required>
            </div>

            <div class="form-section-title">ACKNOWLEDGEMENT</div>
            <div class="acknowledgement">
                <p style="margin-bottom: 30px;">I, the undersigned, acknowledge and agree to the following terms and conditions as a Coach with Special Olympics Sarawak:</p>
                <ol>
                    <li><strong>Eligibility to Participate:</strong> I confirm that I am physically and mentally able to perform the duties required of me as a Coach and will provide a safe, supportive, and positive environment for all athletes.</li>
                    <li><strong>Likeness Release:</strong> I grant Special Olympics Sarawak, the event organizing committees, and Special Olympics accredited State Programs (collectively “Special Olympics”) the right to use my likeness, photo, video, name, voice, words, and biographical information to promote Special Olympics activities, events, and fundraising campaigns.</li>
                    <li><strong>Risk and Safety Awareness:</strong> I acknowledge that my role as a Coach may involve potential risks. I will take all necessary precautions to ensure the safety and well-being of the athletes under my care, following all safety protocols. I will report any injuries, medical concerns, or incidents to the appropriate event organizers or medical professionals promptly.</li>
                    <li><strong>Compliance with Rules and Regulations:</strong> I agree to abide by all Special Olympics Sarawak rules, policies, and regulations and will conduct myself in a manner that aligns with the values and mission of Special Olympics, fostering an inclusive and respectful environment for all participants.</li>
                    <li><strong>Indemnity and Liability:</strong> I hereby release, discharge, and covenant not to sue Special Olympics Sarawak, the event organizers, its administrators, officers, volunteers, employees, sponsors, and other participants (the "Releasees") from any liability, claims, demands, or losses, including those related to negligence, arising out of my participation as a Coach. I also agree to indemnify and hold harmless the Releasees from any claims made by third parties as a result of my actions or omissions.</li>
                    <li><strong>Health and Medical Information:</strong> I understand that my personal information, including health-related details, may be collected and used for the purpose of event management and safety. This information may be shared with medical professionals in the event of an emergency, and I consent to this usage.</li>
                    <li><strong>Personal Information and Privacy:</strong> Special Olympics Sarawak may collect and use my personal information, including contact details and other identifying information, to facilitate my role as a Coach. This information may be used for communications, safety, and promotional purposes, including marketing via email, text message, or social media. I understand I have the right to access, correct, or delete my personal information.</li>
                    <li><strong>Voluntary Participation:</strong> I confirm that my participation as a Coach is voluntary and that I have read and understood the risks involved. I agree to perform my duties with care, respect, and responsibility to ensure a positive experience for the athletes.</li>
                </ol>
                <p style="margin-bottom: 30px;">I acknowledge that I have read and understood this Acknowledgement and Waiver, and I agree to the terms and conditions outlined above.</p>
                <p>(This is a placeholder and is subject to change.)</p>
                <div class="checkbox-container">
                    <input type="checkbox" id="coach_agree" name="coach_agree" required>
                    <label for="coach_agree">I AGREE <span style="color: #e53935">*</span></label>
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
        flatpickr("#coach_dob", {
            dateFormat: "d/m/Y", // This is the format that will be submitted
            altInput: true,      // Enables a user-friendly input field
            altFormat: "d/m/Y",  // This is the format displayed to the user
            onClose: function(selectedDates, dateStr, instance) {
                calculateAge('coach_dob', 'coach_age'); // Recalculate age when date is selected
            }
        });

        flatpickr("#date_certification", {
            dateFormat: "d/m/Y", // This is the format that will be submitted
            altInput: true,      // Enables a user-friendly input field
            altFormat: "d/m/Y"   // This is the format displayed to the user
        });

        function calculateAge(dobId, ageId) {
            const dobInput = document.getElementById(dobId);
            // Flatpickr stores the actual date in the input's value in the specified dateFormat (d/m/Y)
            const dobParts = dobInput.value.split('/');
            if (dobParts.length === 3) {
                // Note: Month is 0-indexed in JavaScript Date object (January is 0, December is 11)
                const dob = new Date(dobParts[2], dobParts[1] - 1, dobParts[0]); // YYYY, MM-1, DD
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                document.getElementById(ageId).value = age;
            } else {
                document.getElementById(ageId).value = ''; // Clear if date format is incorrect or not yet selected
            }
        }
    </script>
    <script src="../scripts/script.js"></script>
</body>
</html>