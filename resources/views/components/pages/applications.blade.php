@extends('components.layout.app')
@section('content')
<style>
    .form-step { display: none; }
    .form-step.active { display: block; }
    .step-indicator.active { background: #2D78C9; color: white; }
    .step-indicator { cursor: pointer; }
    .progress-line { background: #B3B3B3; height: 3px; position: absolute; top: 2rem; width: 100%; z-index: 1; }
    .progress-line.active { background: #2D78C9; }
    .form-section { margin-top: 40px; position: relative; z-index: 1; }
    .form-section input, .form-section select { margin: 10px 0; width: 48%; }
    .form-section p { display: flex; justify-content: space-between; flex-wrap: wrap; }
    .form-section button {
        margin: 25px 0;
        padding: 14px 32px;
        font-size: 16px;
        font-weight: 600;
        background: #2D78C9;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .form-section button:disabled { background: #CCCCCC; cursor: not-allowed; }
    .progress-container {
        width: 100%;
        max-width: 800px;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin: 20px auto 10px;
        padding: 0 20px;
        z-index: 2;
    }

    .progress-line {
        position: absolute;
        top: 24px;
        left: 10px;
        right: 10px;
        height: 4px;
        background-color: #E0E0E0;
        z-index: 1;
        border-radius: 2px;
    }

    .progress-line.active {
        background-color: #2D78C9;
        transition: width 0.3s ease-in-out;
    }

    .step-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        min-width: 100px;
        z-index: 2;
        position: relative;
    }

    .step-indicator {
        width: 45px;
        height: 45px;
        background: #E5E5E5;
        border-radius: 50%;
        outline: 2px solid #CCCCCC;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 8px;
        transition: background 0.3s ease;
    }

    .step-indicator.active {
        background: #2D78C9;
        color: white;
        outline: 2px solid #2D78C9;
    }

    .step-container div:nth-child(2) {
        font-weight: 700;
        font-size: 14px;
        color: #2D78C9;
        text-align: center;
    }

    .step-container div:nth-child(3) {
        font-size: 12px;
        color: #555;
        font-weight: 400;
        text-align: center;
        max-width: 120px;
    }
    .step-indicator[data-step="4"].active {
        background: #1E40AF;
        outline-color: #1E40AF;
        box-shadow: 0 0 10px rgba(30, 64, 175, 0.4);
        transition: all 0.3s ease-in-out;
    }

    /* Job selection styles */
    .job-selection-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .job-selection-row select {
        flex: 1;
        min-width: 150px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .job-selection-row .delete-job-btn {
        background: #dc2626;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s ease;
        flex-shrink: 0;
    }

    .job-selection-row .delete-job-btn:hover {
        background: #b91c1c;
    }

    .add-job-btn {
        background: #2D78C9;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .add-job-btn i {
        font-size: 14px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .progress-container {
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            white-space: nowrap;
            gap: 10px;
            padding: 10px;
            margin: 20px auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .progress-line {
            display: none;
        }

        .step-container {
            flex: 0 0 auto;
            justify-content: flex-start;
            align-items: center;
            width: 100%;
            min-width: 150px;
            gap: 10px;
        }

        .step-indicator {
            width: 35px;
            height: 35px;
            font-size: 14px;
            margin-bottom: 0;
        }

        .step-container div:nth-child(2),
        .step-container div:nth-child(3) {
            font-size: 12px;
            text-align: left;
        }

        .summary-grid {
            display: block !important;
        }

        .summary-grid > div {
            width: 100% !important;
            margin-bottom: 10px;
        }

        .form-section input,
        .form-section select {
            width: 100%;
        }

        .job-selection-row {
            gap: 8px;
        }

        .job-selection-row select {
            min-width: calc(50% - 15px);
        }
    }

    @media (max-width: 480px) {
        .form-section button {
            width: 100%;
        }

        .form-step[data-step="4"] button[type="submit"] {
            width: 100%;
        }

        .step-indicator {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }

        .step-container div:nth-child(2) {
            font-size: 10px;
        }

        .step-container div:nth-child(3) {
            font-size: 9px;
        }

        .job-selection-row select {
            min-width: 100%;
        }

        .job-selection-row .delete-job-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Fix for menu z-index */
    .navbar {
        position: relative;
        z-index: 1000;
    }

    .form-step[data-step="4"] button[type="submit"] {
        background: #10B981;
        font-weight: 600;
        font-size: 16px;
        padding: 14px 32px;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .form-step[data-step="4"] button[type="submit"]:hover {
        background: #059669;
    }

    .upload-section {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
        width: 100%;
    }

    .upload-section > div {
        flex: 0 0 calc(50% - 10px);
    }

    @media (max-width: 768px) {
        .upload-section > div {
            flex: 0 0 100%;
        }
    }

    .upload-box {
        background: #F1F5F9;
        padding: 20px;
        border-radius: 8px;
        flex: 1 1 45%;
        min-width: 280px;
        border: 2px dashed #ddd;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color 0.3s ease;
    }

    .upload-box.full-width {
        flex: 1 1 100%;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }

    input.shake, select.shake {
        animation: shake 0.3s ease;
        border: 1px solid red !important;
    }

    input[type="file"].shake {
        box-shadow: 0 0 0 2px #f87171;
    }
</style>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1050; margin: 0; border-radius: 0;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
     @if(session('error'))
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            </div>
                        @endif

    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h1>Apply For a Job</h1>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: flex">
                    <div class="progress-container">
                        <div class="progress-line" id="progress-line"></div>
                        <div class="step-container">
                            <div class="step-indicator active" data-step="1">
                                <div style="text-align: center; font-weight: 700; color: #1A1A1A;">1</div>
                            </div>
                            <div>Step 1</div>
                            <div style="text-align: center; color: #2D78C9; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Personal Details</div>
                        </div>
                        <div class="step-container">
                            <div class="step-indicator" data-step="2">
                                <div style="text-align: center; color: #1A1A1A;">2</div>
                            </div>
                            <div>Step 2</div>
                            <div style="text-align: center; color: #2D78C9; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Upload Document</div>
                        </div>
                        <div class="step-container">
                            <div class="step-indicator" data-step="3">
                                <div style="text-align: center; color: #1A1A1A;">3</div>
                            </div>
                            <div>Step 3</div>
                            <div style="text-align: center; color: #2D78C9; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Job Categorization</div>
                        </div>
                        <div class="step-container">
                            <div class="step-indicator" data-step="4">
                                <div style="text-align: center; color: #1A1A1A;">4</div>
                            </div>
                            <div>Step 4</div>
                            <div style="text-align: center; color: #2D78C9; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Confirm Details</div>
                        </div>
                    </div>
                    <div class="form-section">
                        <div id="form-error-message" style="color: #dc2626; font-weight: 500; margin-bottom: 10px; display: none;"></div>

                        <form id="application-form" action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-step active" data-step="1">
                                <h3 style="color: black;">User Information</h3>
                                <p>
                                    <input type="text" name="first_name" placeholder="First Name" required>
                                    <input type="text" name="surname" placeholder="Last Name" required>
                                </p>
                                <p>
                                    <input type="email" name="email" placeholder="Email Address" required>
                                    <input type="tel" name="phone_number" placeholder="Phone Number" required>
                                </p>
                                <p>
                                    <input type="text" name="id_number" id="id_number" placeholder="ID Number" required>
                                    <input type="text" name="passport_number" id="passport_number" placeholder="Passport Number(optional)">
                                </p>
                                <div id="passport_expiry_wrapper" style="display: none; width: 100%; margin-top: 20px;">
                                    <label for="passport_expiry" style="color: #2d2c2c; float: left; margin-bottom: 5px; display: block;">
                                        Passport Expiry Date
                                    </label>
                                    <input type="date" class="form-control" id="passport_expiry" name="passport_expiry" placeholder="Passport Expiry Date" style="width: 100%; height: 50px; padding: 10px; border: 1px solid #ccc; border-radius: 10px;">
                                </div>
                                <button type="button" onclick="nextStep(2)">Next</button>
                            </div>

                            <div class="form-step" data-step="2">
                                <h3 style="color: black;">Upload Documents</h3>
                                <div class="upload-section">
                                    <div class="upload-box full-width">
                                        <div class="upload-content">
                                            <i class="fa fa-id-card"></i>
                                            <p>Passport Photo</p>
                                            <input type="file" name="passport_photo" accept=".pdf,.doc,.docx" id="passportPhotoFile">
                                            <label for="passportPhotoFile" class="upload-btn">Choose File</label>
                                            <div class="file-info" id="passportPhotoInfo"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 style="color: black;">Upload ID Front</h4>
                                        <div class="upload-box">
                                            <div class="upload-content">
                                                <i class="fa fa-id-card"></i>
                                                <p>Upload ID Front</p>
                                                <input type="file" name="client_id_front" accept=".pdf,.doc,.docx" id="idCardFile">
                                                <label for="idCardFile" class="upload-btn">Choose File</label>
                                                <div class="file-info" id="idCardInfo"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 style="color: black;">Upload ID Back</h4>
                                        <div class="upload-box">
                                            <div class="upload-content">
                                                <i class="fa fa-id-card"></i>
                                                <p>Upload ID Back</p>
                                                <input type="file" name="client_id_back" accept=".pdf,.doc,.docx" id="idCardBackFile">
                                                <label for="idCardBackFile" class="upload-btn">Choose File</label>
                                                <div class="file-info" id="idCardBackInfo"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 style="color: black;">Upload Passport</h4>
                                        <div class="upload-box">
                                            <div class="upload-content">
                                                <i class="fa fa-upload"></i>
                                                <p>Upload Passport</p>
                                                <input type="file" name="passport_copy" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" id="passportFile">
                                                <label for="passportFile" class="upload-btn">Choose File(optional)</label>
                                                <div class="file-info" id="passportInfo"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 style="color: black;">Upload Good Conduct Certificate</h4>
                                        <div class="upload-box">
                                            <div class="upload-content">
                                                <i class="fa fa-upload"></i>
                                                <p>Good Conduct Certificate</p>
                                                <input type="file" name="good_conduct" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" id="goodConductFile">
                                                <label for="goodConductFile" class="upload-btn">Choose File(optional)</label>
                                                <div class="file-info" id="goodConductInfo"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p>
                                    <button type="button" style="background-color: orange;" onclick="prevStep(1)">Previous</button>
                                    <button type="button" onclick="nextStep(3)">Next</button>
                                </p>
                            </div>

                            <div class="form-step" data-step="3">
                                <h3 style="color: black;">Job Selection</h3>
                                <div class="upload-section">
                                    <div class="upload-box full-width">
                                        <div class="upload-content">
                                            <i class="fa fa-file-text"></i>
                                            <p>Upload CV</p>
                                            <input type="file" name="cv" accept=".pdf,.doc,.docx" id="cvFile">
                                            <label for="cvFile" class="upload-btn">Choose File</label>
                                            <div class="file-info" id="cvInfo"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-selection-container">
                                    <h4 style="margin-bottom: 15px; color: #333;">Select Your Job Preferences</h4>
                                    <div id="jobSelections">
                                        <div class="job-selection-row">
                                            <select name="job_category[]" class="job-category-select">
                                                <option value="">Select Job Category</option>
                                            </select>
                                            <select name="job_title[]" class="job-title-select">
                                                <option value="">Select Job Title</option>
                                            </select>
                                            <button type="button" class="delete-job-btn" style="display: none;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" onclick="addJobSelection()" class="add-job-btn">
                                        <i class="fa fa-plus"></i> Add Another Job Preference
                                    </button>
                                </div>
                                <p>
                                    <button type="button" style="background-color: orange;" onclick="prevStep(2)">Previous</button>
                                    <button type="button" onclick="nextStep(4)">Next</button>
                                </p>
                            </div>

                            <div class="form-step" data-step="4">
                                <div style="background: #F9FAFB; color: black; padding: 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                                    <div id="form-summary"></div>
                                </div>

                                <p>
                                    <button type="button" style="background-color: orange;" onclick="prevStep(3)">Previous</button>
                                    <button type="submit">Submit</button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let currentStep = 1;
    let jobCategoriesCache = [];

    // Basic step navigation functions
    function scrollToStep(stepNumber) {
        const step = document.querySelector(`.step-indicator[data-step="${stepNumber}"]`);
        if (step) {
            step.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    }

    function updateProgressLine(step) {
        const progressLine = document.getElementById('progress-line');
        const widthPercentage = ((step - 1) / 3) * 100;
        progressLine.style.width = `${widthPercentage}%`;
        progressLine.classList.add('active');
    }

    function updateStepIndicators(step) {
        document.querySelectorAll('.step-indicator').forEach(indicator => {
            indicator.classList.remove('active');
            indicator.style.outlineColor = '#CCCCCC';
            if (parseInt(indicator.dataset.step) <= step) {
                indicator.classList.add('active');
                indicator.style.outlineColor = '#2D78C9';
            }
        });
    }

    function showStep(step) {
        document.querySelectorAll('.form-step').forEach(stepElement => {
            stepElement.classList.remove('active');
        });
        document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
        updateStepIndicators(step);
        updateProgressLine(step);
        scrollToStep(step);
        currentStep = step;
    }

    function nextStep(step) {
        const currentInputs = document.querySelectorAll(`.form-step[data-step="${currentStep}"] input[required], .form-step[data-step="${currentStep}"] select[required]`);
        let valid = true;

        currentInputs.forEach(input => {
            if (!input.value) {
                valid = false;
                input.classList.add('shake');
            } else {
                input.classList.remove('shake');
            }
        });

        setTimeout(() => {
            currentInputs.forEach(input => input.classList.remove('shake'));
        }, 500);

        if (valid) {
            document.getElementById('form-error-message').style.display = 'none';
            if (step === 4) {
                displaySummary();
            }
            showStep(step);
        } else {
            document.getElementById('form-error-message').innerText = 'Please fill in all required fields.';
            document.getElementById('form-error-message').style.display = 'block';
        }
    }

    function prevStep(step) {
        showStep(step);
    }

    function displaySummary() {
        const form = document.getElementById('application-form');
        const formData = new FormData(form);

        const personalFields = ['first_name', 'surname', 'email', 'phone_number', 'passport_number', 'id_number', 'passport_expiry'];
        const documentFields = ['client_id_front', 'client_id_back', 'passport_copy', 'passport_photo' , 'good_conduct', 'cv'];

        const fieldLabels = {
            first_name: "First Name",
            surname: "Surname",
            email: "Email",
            phone_number: "Phone Number",
            passport_number: "Passport Number",
            id_number: "ID Number",
            passport_expiry: "Passport Expiry",
            client_id_front: "ID Front",
            client_id_back: "ID Back",
            passport_copy: "Passport Copy",
            passport_photo: "Passport Photo",
            good_conduct: "Good Conduct",
            cv: "Curriculum Vitae (CV)",
            job_category: "Job Category",
            job_title: "Job Title",
        };

        const summary = {
            personal: [],
            documents: [],
            jobs: []
        };

        // Process personal and document fields
        for (let [key, value] of formData.entries()) {
            if (key === '_token') continue;

            let label = fieldLabels[key] || key;
            let displayValue = value;

            if (value instanceof File) {
                displayValue = value.name || 'Not uploaded';
            }

            if (personalFields.includes(key)) {
                summary.personal.push({ label, displayValue });
            } else if (documentFields.includes(key)) {
                summary.documents.push({ label, displayValue });
            }
        }

        // Process job selections
        const jobCategories = formData.getAll('job_category[]');
        const jobTitles = formData.getAll('job_title[]');

        for (let i = 0; i < jobCategories.length; i++) {
            if (jobCategories[i] && jobTitles[i]) {
                const categorySelect = document.querySelectorAll('.job-category-select')[i];
                const titleSelect = document.querySelectorAll('.job-title-select')[i];

                const categoryText = categorySelect ? categorySelect.options[categorySelect.selectedIndex].text : jobCategories[i];
                const titleText = titleSelect ? titleSelect.options[titleSelect.selectedIndex].text : jobTitles[i];

                summary.jobs.push({
                    number: i + 1,
                    category: categoryText,
                    title: titleText
                });
            }
        }

        // Generate HTML for jobs table
        let jobsTableHtml = `
            <div style="width: 100%;">
                <table class="summary-table" style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                    <thead>
                        <tr style="background-color: #f3f4f6; text-align: left;">
                            <th style="padding: 10px; border-bottom: 1px solid #ccc;">Job Category</th>
                            <th style="padding: 10px; border-bottom: 1px solid #ccc;">Job Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${summary.jobs.map(job => `
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">${job.category}</td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">${job.title}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;

        let html = `
            <h3 style="font-size: 20px; margin-bottom: 15px; color: #2D78C9;">Application Summary</h3>

            <div style="margin-bottom: 20px;">
                <h4 style="color: #1E3A8A; margin-bottom: 10px;">Personal Details</h4>
                <div class="summary-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                    ${summary.personal.map(item => `
                        <div style="background: #fff; padding: 10px 16px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <strong>${item.label}:</strong> ${item.displayValue}
                        </div>`).join('')}
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <h4 style="color: #1E3A8A; margin-bottom: 10px;">Uploaded Documents</h4>
                <div class="summary-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                    ${summary.documents.map(item => `
                        <div style="background: #fff; padding: 10px 16px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <strong>${item.label}:</strong> ${item.displayValue}
                        </div>`).join('')}
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <h4 style="color: #1E3A8A; margin-bottom: 10px;">Job Details</h4>
                ${jobsTableHtml}
            </div>
        `;

        document.getElementById('form-summary').innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize passport expiry field
        const passportInput = document.getElementById('passport_number');
        const expiryWrapper = document.getElementById('passport_expiry_wrapper');

        passportInput.addEventListener('input', function() {
            expiryWrapper.style.display = this.value.trim() ? 'block' : 'none';
        });

        // Initialize job categories
        fetch('/api/v1/job-categories')
            .then(response => response.json())
            .then(data => {

                jobCategoriesCache = data.data || data;

                console.log(jobCategoriesCache)

                // Initialize ALL existing job category selects (including the first one)
                document.querySelectorAll('.job-category-select').forEach(select => {
                    // Clear existing options
                    select.innerHTML = '<option value="">Select Job Category</option>';

                    // Add new options
                    jobCategoriesCache.forEach(category => {
                        select.add(new Option(category.name, category.id));
                    });

                    // Add change handler to load job titles
                    select.addEventListener('change', function() {
                        const categoryId = this.value;
                        const titleSelect = this.closest('.job-selection-row').querySelector('.job-title-select');

                        titleSelect.innerHTML = '<option value="">Loading...</option>';

                        if (!categoryId) {
                            titleSelect.innerHTML = '<option value="">Select Job Title</option>';
                            return;
                        }

                        fetch(`/api/v1/careers/by-category/${categoryId}`)
                            .then(response => response.json())
                            .then(data => {
                                titleSelect.innerHTML = '<option value="">Select Job Title</option>';
                                data.forEach(job => {
                                    titleSelect.add(new Option(job.name, job.id));
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                titleSelect.innerHTML = '<option value="">Error loading</option>';
                            });
                    });
                });
            });

        // Make addJobSelection available globally
        window.addJobSelection = function() {
            const container = document.getElementById('jobSelections');

            const row = document.createElement('div');
            row.className = 'job-selection-row';

            const categorySelect = document.createElement('select');
            categorySelect.name = 'job_category[]';
            categorySelect.className = 'job-category-select';
            categorySelect.style.flex = '1';
            categorySelect.innerHTML = '<option value="">Select Job Category</option>';

            const titleSelect = document.createElement('select');
            titleSelect.name = 'job_title[]';
            titleSelect.className = 'job-title-select';
            titleSelect.style.flex = '1';
            titleSelect.innerHTML = '<option value="">Select Job Title</option>';

            // Create delete button
            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = '<i class="fa fa-trash"></i>';
            deleteBtn.type = 'button';
            deleteBtn.className = 'delete-job-btn';
            deleteBtn.onclick = function() {
                row.remove();
                // Don't allow deleting the first row
                const rows = document.querySelectorAll('.job-selection-row');
                if (rows.length === 1) {
                    rows[0].querySelector('.delete-job-btn').style.display = 'none';
                }
            };

            row.appendChild(categorySelect);
            row.appendChild(titleSelect);
            row.appendChild(deleteBtn);
            container.appendChild(row);

            // Show delete button for all rows except the first one
            const rows = document.querySelectorAll('.job-selection-row');
            if (rows.length > 1) {
                rows.forEach((row, index) => {
                    if (index > 0) {
                        row.querySelector('.delete-job-btn').style.display = 'block';
                    }
                });
            }

            // Populate categories for the new select
            jobCategoriesCache.forEach(category => {
                categorySelect.add(new Option(category.name, category.id));
            });

            // Add change handler for the new select
            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                titleSelect.innerHTML = '<option value="">Loading...</option>';

                if (!categoryId) {
                    titleSelect.innerHTML = '<option value="">Select Job Title</option>';
                    return;
                }

                fetch(`/api/v1/careers/by-category/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        titleSelect.innerHTML = '<option value="">Select Job Title</option>';
                        data.forEach(job => {
                            titleSelect.add(new Option(job.name, job.id));
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        titleSelect.innerHTML = '<option value="">Error loading</option>';
                    });
            });
        };

        // Auto-close alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 4000);
        });

        // Form submission
        document.getElementById('application-form').addEventListener('submit', function(e) {
            displaySummary();
        });
    });
    </script>
@endsection
