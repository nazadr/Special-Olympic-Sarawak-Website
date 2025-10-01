<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Registration | Special Olympics Sarawak</title>
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
        .form-group .radio-group label {
            display: inline-block;
            margin-right: 15px;
        }
        .form-group textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            resize: vertical;
            min-height: 80px;
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

        /* Dropdown Checkbox Styling */
        .dropdown-checkbox-container {
            position: relative;
            width: 100%;
        }
        .dropdown-checkbox-button {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fff;
            cursor: pointer;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dropdown-checkbox-button::after {
            content: '\25BC'; /* Down arrow */
            font-size: 0.8em;
            margin-left: 5px;
        }
        .dropdown-checkbox-options {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
        }
        .dropdown-checkbox-options label {
            display: block;
            padding: 8px 10px;
            cursor: pointer;
            font-weight: normal; /* Override form-group label style */
            margin-bottom: 0;
        }
        .dropdown-checkbox-options label:hover {
            background-color: #f1f1f1;
        }
        .dropdown-checkbox-options input[type="checkbox"] {
            margin-right: 8px;
        }
        .dropdown-checkbox-options.show {
            display: block;
        }
    </style>
</head>
<body>
    <script src="../scripts/components/header.js"></script>
    <script src="../scripts/components/socmed-bar.js"></script>

    <div class="header-space"></div>

    <div class="form-container">
        <h2>Athlete Registration</h2>
        <p style="text-align: center; margin-bottom: 30px;">Thank you for choosing to be a part of Special Olympics Sarawak!</p>
        <p style="text-align: center;">We are excited to welcome you into our vibrant community of athletes. As an athlete, you will have the opportunity to participate in a wide range of sports, develop new skills, and experience the joy of competition. Our goal is to provide a supportive environment where you can thrive, build confidence, and achieve your personal best. Please take a moment to share some information about yourself so we can better understand your needs and match you with the right team. We are committed to supporting you every step of the way as you embark on this incredible journey of growth and achievement.</p>

        <!-- When a user click Submit, the page will redirect to the process_athlete_registration.php (not created) -->
        <form action="ja-athlete-submit-initial.html" method="POST">
            <div class="form-section-title">YOUR PERSONAL INFORMATION</div>
            <div class="form-group">
                <label for="athlete_full_name">Full Name: <span style="color: #e53935">*</span></label>
                <input type="text" id="athlete_full_name" name="athlete_full_name" placeholder="John Mason" required>
            </div>
            <div class="form-group">
                <label>Gender: <span style="color: #e53935">*</span></label>
                <div class="radio-group">
                    <input type="radio" id="athlete_gender_m" name="athlete_gender" value="M" required>
                    <label for="athlete_gender_m">M</label>
                    <input type="radio" id="athlete_gender_f" name="athlete_gender" value="F">
                    <label for="athlete_gender_f">F</label>
                </div>
            </div>
            <div class="form-group">
                <label for="athlete_nric_passport">NRIC/Passport No.: <span style="color: #e53935">*</span></label>
                <input type="text" id="athlete_nric_passport" name="athlete_nric_passport" required>
            </div>
            <div class="form-group">
                <label for="athlete_oku_card">OKU/PWD Card No.: <span style="color: #e53935">*</span></label>
                <input type="text" id="athlete_oku_card" name="athlete_oku_card">
            </div>
            <div class="form-group">
                <label for="athlete_dob">Date of Birth: <span style="color: #e53935">*</span></label>
                <input type="text" id="athlete_dob" name="athlete_dob" placeholder="DD/MM/YYYY" required>
            </div>
            <div class="form-group">
                <label for="athlete_age">Age: <span style="color: #e53935">*</span></label>
                <input type="text" id="athlete_age" name="athlete_age" readonly>
            </div>
            <div class="form-group">
                <label for="athlete_email">Email Address: <span style="color: #e53935">*</span></label>
                <input type="email" id="athlete_email" name="athlete_email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label for="athlete_phone">Phone Number: <span style="color: #e53935">*</span></label>
                <input type="tel" id="athlete_phone" name="athlete_phone" placeholder="+60 12-345 6789" required>
            </div>
            <div class="form-group">
                <label for="athlete_mailing_address">Mailing Address: <span style="color: #e53935">*</span></label>
                <textarea style="resize: none;" id="athlete_mailing_address" name="athlete_mailing_address" placeholder="No. 123, Taman Lorem Ipsum, Jalan Dolor Sit Amet, 96000 Sibu, Sarawak." required></textarea>
            </div>
            <!-- Active Sports Checkbox -->
            <div class="form-group">
                <label>Preferred Sports <span style="color: #e53935">*</span></label>
                <div class="checkbox-group">
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Aquatics"><label for="aquatics">Aquatics</label></div>
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Athletes"><label for="athletes">Athletics</label></div>
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Badminton"><label for="badminton">Badminton</label></div>
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Bocce"><label for="bocce">Bocce</label></div>
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Bowling"><label for="bowling">Bowling</label></div>
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Floorball"><label for="floorball">Floorball</label></div>
                    <div><input type="checkbox" id="athleteActiveSports" name="athlete_active_sports[]" value="Football"><label for="football">Football</label></div>
                </div>
            </div>
            <!-- <div class="form-group">
                <label>Active Sports:</label>
                <div class="dropdown-checkbox-container" id="activeSportsDropdown">
                    <button type="button" class="dropdown-checkbox-button">Select Sports</button>
                    <div class="dropdown-checkbox-options">
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Aquatics"> Aquatics</label>
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Athletics"> Athletics</label>
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Badminton"> Badminton</label>
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Bocce"> Bocce</label>
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Bowling"> Bowling</label>
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Floorball"> Floorball</label>
                        <label><input type="checkbox" name="athlete_active_sports[]" value="Football"> Football</label>
                    </div>
                </div>
            </div> -->
            <div class="form-group">
                <label>Athlete with Intellectual Disabilities: <span style="color: #e53935">*</span></label>
                <div class="radio-group">
                    <input type="radio" id="athlete_id_yes" name="athlete_intellectual_disabilities" value="Yes" required>
                    <label for="athlete_id_yes">Yes</label>
                    <input type="radio" id="athlete_id_no" name="athlete_intellectual_disabilities" value="No">
                    <label for="athlete_id_no">No</label>
                </div>
            </div>
            <!-- Event Interested Checkbox -->
            <div class="form-group">
                <label>Event Interested in: <span style="color: #e53935">*</span></label>
                <div class="checkbox-group">
                    <div><input type="checkbox" id="athleteEventInterested" name="athlete_event_interested[]" value="SOHAP"><label for="sohap">Healthy Athletes Program (SOHAP)</label></div>
                    <div><input type="checkbox" id="athleteEventInterested" name="athlete_event_interested[]" value="ALPs"><label for="alp">Athletes Leadership Program (ALPs)</label></div>
                    <div><input type="checkbox" id="athleteEventInterested" name="athlete_event_interested[]" value="YAP"><label for="yap">Young Athletes Program (YAP)</label></div>
                </div>
            </div>
            <!-- <div class="form-group">
                <label>Event Interests:</label>
                <div class="dropdown-checkbox-container" id="eventInterestedDropdown">
                    <button type="button" class="dropdown-checkbox-button">Select Events</button>
                    <div class="dropdown-checkbox-options">
                        <label><input type="checkbox" name="athlete_event_interested[]" value="Healthy Athletes Program"> Healthy Athletes Program</label>
                        <label><input type="checkbox" name="athlete_event_interested[]" value="Athletes Leadership Program"> Athletes Leadership Program</label>
                        <label><input type="checkbox" name="athlete_event_interested[]" value="Young Athletes Program"> Young Athletes Program</label>
                    </div>
                </div>
            </div> -->
            <div class="form-group">
                <label for="athlete_registered_in">Athlete registered in: <span style="color: #e53935">*</span></label>
                <select id="athlete_registered_in" name="athlete_registered_in" required>
                    <option value="">Select Location</option>
                    <option value="Bintulu">Bintulu</option>
                    <option value="Kuching">Kuching</option>
                    <option value="Miri">Miri</option>
                    <option value="Sibu">Sibu</option>
                </select>
            </div>

            <div class="form-section-title">PARENT / GUARDIAN INFORMATION</div>
            <div class="form-group">
                <label for="parent_guardian_name">Parent/Guardian's Full Name: <span style="color: #e53935">*</span></label>
                <input type="text" id="parent_guardian_name" name="parent_guardian_name" required>
            </div>
            <div class="form-group">
                <label for="parent_guardian_relation">Relation with Athlete: <span style="color: #e53935">*</span></label>
                <select id="parent_guardian_relation" name="parent_guardian_relation" required>
                    <option value="">Select Relation</option>
                    <option value="Aunt">Aunt</option>
                    <option value="Brother">Brother</option>
                    <option value="Caregiver">Caregiver</option>
                    <option value="Father">Father</option>
                    <option value="Mother">Mother</option>
                    <option value="Sister">Sister</option>
                    <option value="Uncle">Uncle</option>
                </select>
            </div>
            <div class="form-group">
                <label for="parent_guardian_phone">Parent/Guardian's Phone Number: <span style="color: #e53935">*</span></label>
                <div style="display: flex;">
                    <input type="tel" id="parent_guardian_phone" name="parent_guardian_phone" placeholder="+60 12-345 6789" required>
                </div>
            </div>
            <div class="form-group">
                <label for="parent_guardian_email">Parent/Guardian's Email: <span style="color: #e53935">*</span></label>
                <input type="email" id="parent_guardian_email" name="parent_guardian_email" required>
            </div>

            <div class="form-section-title">ACKNOWLEDGEMENT</div>
            <div class="acknowledgement">
                <p style="margin-bottom: 30px;">I am the Parent or Guardian of the Young Athletes participant named below and the particulars as provided in "ATHLETE INFORMATION" section and I agree to the following:</p>
                <ol>
                    <li><strong>Able to Participate:</strong> The Athlete is physically able to take part in Special Olympics activities.</li>
                    <li><strong>Likeness Release:</strong> I give permission to Special Olympics Sarawak, Special Olympics Sarawak games organizing committees, and Special Olympics accredited State Programs (collectively “Special Olympics”) to use the Athlete’s likeness, photo, video, name, voice, words, and biographical information to promote Special Olympics and raise funds for Special Olympics.</li>
                    <li><strong>Risk of Concussion and Other Injury:</strong> I know there is a risk of injury. I understand the risk of continuing to participate with or after a concussion or other injury. The Athlete may have to get medical care if there is a suspected concussion or other injury. The Athlete also may have to wait 7 days or more and get permission from a doctor before playing sports again.</li>
                    <li><strong>Health Programs:</strong> If the Athlete takes part in a Special Olympics health program, I consent to health activities, exams, and treatment for the Athlete. This should not replace regular health care. I can say no to treatment or anything else any time for the Young Athlete.</li>
                    <li><strong>Indemnity:</strong> I hereby release, discharge, and covenant not to sue Special Olympics Sarawak (“Special Olympics”), the Special Olympics event organiser, its administrators, directors, agents, officers, volunteers, and employees, other participants, any sponsors, advertisers, and, if applicable, owners and lessors of premises on which the event takes place (each considered one of the "Releasees” herein) from all liability, claims, demands, losses, or damages on my account caused or alleged to be caused in whole or in part by the negligence of the Releasees or otherwise, including negligent rescue operations; and I further agree that if, despite this release, waiver of liability, and assumption of risk I, or anyone on my and/or my minor child's behalf, makes a claim against any of the Releasees, I will indemnify, save, and hold harmless each of the Releasees from any loss, liability, damage, or cost that any may incur as the result of such claim.</li>
                    <li><strong>Personal Information:</strong> I understand that Special Olympics Sarawak will be collecting the Athlete’s personal information as part of participation, including name, image, address, telephone number, health information, and other personally identifying and health related information provided to Special Olympics (“personal information”).
                        <ul>
                            <li>using the personal information in order to: confirm eligibility and safe participation; run trainings and events; share competition results (including on the Web and in news media); provide health treatment if the Athlete participates in a health program; analyze data for the purposes of improving programming and identifying and responding to the needs of Special Olympics participants; perform computer operations, quality assurance, testing, and other related activities; and provide event-related services.</li>
                            <li>using the personal information for communications and marketing purposes, including direct digital marketing through email, text message, and social media.</li>
                            <li>sharing personal information with (i) researchers, such as universities and public health agencies, that are studying intellectual disabilities and the impact of Special Olympics activities, (ii) medical professionals in an emergency, and (iii) government authorities for the purpose of assisting with any visas required for international travel to Special Olympics events and for any other purpose necessary to protect public safety, respond to government requests, and report information as required by law.</li>
                            <li>I have the right to ask to see the personal information or to be informed about the personal information that is processed. I have the right to ask to correct and delete the personal information, and to restrict the processing of personal information if it is inconsistent with this consent.</li>
                        </ul>
                    </li>
                </ol>
                <p style="margin-bottom: 30px;">I have read this RELEASE AND WAIVER OF LIABILITY AND INDEMNITY AGREEMENT, AND PARENTAL CONSENT AGREEMENT, understand that I have given up substantial rights by signing it and have signed it freely and without any inducement or assurance of any nature and intend it be a complete and unconditional release of all liability to the greatest extent allowed by law and agree that if any portion of this Agreement is held to be invalid the balance, notwithstanding, shall continue in full force and effect.</p>
                <p>(This is a placeholder and is subject to change.)</p>
                <div class="checkbox-container">
                    <input type="checkbox" id="athlete_agree" name="athlete_agree" required>
                    <label for="athlete_agree">I AGREE <span style="color: #e53935">*</span></label>
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
        flatpickr("#athlete_dob", {
            dateFormat: "d/m/Y", // This is the format that will be submitted
            altInput: true,      // Enables a user-friendly input field
            altFormat: "d/m/Y",  // This is the format displayed to the user
            onClose: function(selectedDates, dateStr, instance) {
                calculateAge('athlete_dob', 'athlete_age'); // Recalculate age when date is selected
            }
        });

        // Dropdown Checkbox Functionality
        var checkList = document.getElementById('activeSportsDropdown');
        checkList.getElementsByClassName('dropdown-checkbox-button')[0].onclick = function(evt) {
          if (checkList.classList.contains('dropdown-checkbox-options'))
            checkList.classList.add('dropdown-checkbox-options');
          else
            checkList.classList.remove('dropdown-checkbox-options');
        }
        
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
    <script src="../scripts/script-prerelease.js"></script>
</body>
</html>