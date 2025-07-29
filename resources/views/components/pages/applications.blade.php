@extends('components.layout.app')
@section('content')
<style>
    .form-step { display: none; }
    .form-step.active { display: block; }
    .step-indicator.active { background: #2D78C9; color: white; }
    .step-indicator { cursor: pointer; }
    .progress-line { background: #B3B3B3; height: 3px; position: absolute; top: 2rem; width: 100%; z-index: -1; }
    .progress-line.active { background: #2D78C9; }
    .form-section { margin-top: 40px; }
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
    }

    .progress-line {
        position: absolute;
        top: 24px;
        left: 10px;
        right: 10px;
        height: 4px;
        background-color: #E0E0E0;
        z-index: 0;
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
        z-index: 1;
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
        background: #1E40AF; /* A deeper blue for final step */
        outline-color: #1E40AF;
        box-shadow: 0 0 10px rgba(30, 64, 175, 0.4);
        transition: all 0.3s ease-in-out;
    }


    /* Mobile Responsive */
    @media (max-width: 768px) {
        .progress-container {
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            white-space: nowrap;
            gap: 10px; /* Reduced from 25px */
            padding: 10px;
            margin: 20px auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .progress-line {
            display: none;
        }

        .step-container {
            flex: 0 0 auto; /* Prevent shrinking */
            justify-content: flex-start;
            align-items: center;
            width: 100%;
            min-width: 150px; /* Adjust as needed for readability */
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
        justify-content: space-between; /* Spread evenly across two columns */
        width: 100%;
    }

    .upload-section > div {
        flex: 0 0 calc(50% - 10px); /* Two columns with gap accounted for */
    }

    @media (max-width: 768px) {
        .upload-section > div {
            flex: 0 0 100%; /* Stack on smaller screens */
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

    @media (max-width: 480px) {
        .form-section button {
            width: 100%;
        }

        .form-step[data-step="4"] button[type="submit"] {
            width: 100%;
        }
    }



    @media (max-width: 480px) {
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
    }

</style>
@if (session('success'))
    <div style="background: #D1FAE5; color: #065F46; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background: #FECACA; color: #991B1B; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">
        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
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

                                    <input type="text" name="passport_number" id="passport_number" placeholder="Passport Number(optional)" >
                                <div id="passport_expiry_wrapper"
                                     style="display: none; width: 100%; margin-top: 20px; position: relative; z-index: 10;">

                                    <label for="passport_expiry" style="color: #2d2c2c; float: left; margin-bottom: 5px; display: block;">
                                        Passport Expiry Date
                                    </label>

                                    <input type="date"
                                           class="form-control"
                                           id="passport_expiry"
                                           name="passport_expiry"
                                           placeholder="Passport Expiry Date"
                                           style="width: 100%; height: 50px; padding: 10px; border: 1px solid #ccc; border-radius: 10px;">
                                </div>

                                </p>
                                <button type="button" onclick="nextStep(2)">Next</button>
                            </div>
                            <!-- Docs Upload -->
                            <div class="form-step" data-step="2">
                                <h3 style="color: black;">Upload Documents</h3>
                                <div class="upload-section">
                                    <div>
                                        <h4 style="color: black;">Upload ID Front</h4>
                                        <div class="upload-box">
                                            <div class="upload-content">
                                                <i class="fa fa-id-card"></i>
                                                <p>Upload ID Front</p>
                                                <input type="file" name="client_id_front" accept=".pdf,.doc,.docx" id="idCardFile" >
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
                                        <div class="upload-box ">
                                            <div class="upload-content">
                                                <i class="fa fa-upload"></i>
                                                <p>Upload Passport</p>
                                                <input type="file" name="passport_copy" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" id="passportFile" >
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
                                                <input type="file" name="good_conduct" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" id="goodConductFile" >
                                                <label for="goodConductFile" class="upload-btn">Choose File(optional)</label>
                                                <div class="file-info" id="goodConductInfo"></div>
                                            </div>
                                    </div>
                                    </div>


                                </div>

                                <p>
                                    <button type="button" onclick="prevStep(1)">Previous</button>
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
                                                <input type="file" name="cv" accept=".pdf,.doc,.docx" id="cvFile" >
                                                <label for="cvFile" class="upload-btn">Choose File</label>
                                                <div class="file-info" id="cvInfo"></div>
                                            </div>
                                        </div>

                                </div>
                                <p>
                                    <select id="jobCategorySelect" name="job_category" class="form-control">
                                        <option value="">Select Job Category</option>
                                    </select>

                                    <select id="jobTitleSelect" name="job_title" class="form-control">
                                        <option value="">Select Job Title</option>
                                    </select>

                                </p>
                                <p>
                                    <button type="button" onclick="prevStep(2)">Previous</button>
                                    <button type="button" onclick="nextStep(4)">Next</button>
                                </p>
                            </div>
                            <div class="form-step" data-step="4">
                                <div style="background: #F9FAFB; color: black; padding: 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                                    <div id="form-summary"></div>
                                </div>

                                <p>
                                    <button type="button" onclick="prevStep(3)">Previous</button>
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

        // Remove shake class after animation ends so it can re-trigger next time
        setTimeout(() => {
            currentInputs.forEach(input => input.classList.remove('shake'));
        }, 500);

        if (valid) {
            // Check passport expiry is at least 6 months away if a passport is entered
            // const passportNumber = document.getElementById('passport_number').value.trim();
            // const passportExpiryInput = document.getElementById('passport_expiry');
            //
            // if (passportNumber !== '') {
            //     const expiryDate = new Date(passportExpiryInput.value);
            //     const today = new Date();
            //     const sixMonthsFromNow = new Date();
            //     sixMonthsFromNow.setMonth(today.getMonth() + 6);
            //
            //     if (expiryDate < sixMonthsFromNow) {
            //         passportExpiryInput.classList.add('shake');
            //         document.getElementById('form-error-message').innerText = 'Passport expiry date must be at least 6 months from today.';
            //         document.getElementById('form-error-message').style.display = 'block';
            //         return; // stop the step change
            //     }
            // }
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
        const documentFields = ['client_id_front', 'client_id_back', 'passport_copy', 'good_conduct', 'cv'];
        const jobFields = ['job_category', 'job_title'];

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
            good_conduct: "Good Conduct",
            cv: "Curriculum Vitae (CV)",
            job_category: "Job Category",
            job_title: "Job Title",
        };

        const seen = new Set();
        const summary = {
            personal: [],
            documents: [],
            job: [],
        };

        for (let [key, value] of formData.entries()) {
            if (key === '_token') continue; // skip token

            if (seen.has(key)) continue;
            seen.add(key);

            let label = fieldLabels[key] || key;
            let displayValue = value;

            // Replace job_category and job_title IDs with their text
            if (key === 'job_category') {
                const selectedOption = document.querySelector(`#jobCategorySelect option[value="${value}"]`);
                if (selectedOption) {
                    displayValue = selectedOption.textContent;
                }
            } else if (key === 'job_title') {
                const selectedOption = document.querySelector(`#jobTitleSelect option[value="${value}"]`);
                if (selectedOption) {
                    displayValue = selectedOption.textContent;
                }
            } else if (value instanceof File) {
                displayValue = value.name || 'Not uploaded';
            }

            if (personalFields.includes(key)) {
                summary.personal.push({ label, displayValue });
            } else if (documentFields.includes(key)) {
                summary.documents.push({ label, displayValue });
            } else if (jobFields.includes(key)) {
                summary.job.push({ label, displayValue });
            }
        }

        let html = `
    <h3 style="font-size: 20px; margin-bottom: 15px; color: #2D78C9;">Application Summary</h3>

    <div style="margin-bottom: 20px;">
        <h4 style="color: #1E3A8A; margin-bottom: 10px;">Personal Details</h4>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            ${summary.personal.map(item => `
                <div style="background: #fff; padding: 10px 16px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <strong>${item.label}:</strong> ${item.displayValue}
                </div>`).join('')}
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <h4 style="color: #1E3A8A; margin-bottom: 10px;">Uploaded Documents</h4>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            ${summary.documents.map(item => `
                <div style="background: #fff; padding: 10px 16px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <strong>${item.label}:</strong> ${item.displayValue}
                </div>`).join('')}
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <h4 style="color: #1E3A8A; margin-bottom: 10px;">Job Details</h4>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            ${summary.job.map(item => `
                <div style="background: #fff; padding: 10px 16px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <strong>${item.label}:</strong> ${item.displayValue}
                </div>`).join('')}
        </div>
    </div>
`;


        document.getElementById('form-summary').innerHTML = html;

    }





            // Optional: keep summary display before submission
    document.getElementById('application-form').addEventListener('submit', function(e) {
        displaySummary(); // Optional
        // Do NOT preventDefault — allow Laravel to handle it
    });


        document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('jobCategorySelect');
        const titleSelect = document.getElementById('jobTitleSelect');
        const passportInput = document.getElementById('passport_number');
        const expiryWrapper = document.getElementById('passport_expiry_wrapper');

        passportInput.addEventListener('input', function () {
            if (passportInput.value.trim() !== '') {
                expiryWrapper.style.display = 'block';
            } else {
                expiryWrapper.style.display = 'none';
            }
        });
        // Fetch job categories
        fetch('/api/v1/job-categories')
            .then(response => response.json())
            .then(response => {
                const data = response.data || response; // Support for both paginated and non-paginated
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching job categories:', error);
            });

    // On category change, fetch job titles
    categorySelect.addEventListener('change', function () {
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
                    const option = document.createElement('option');
                    option.value = job.id;
                    option.textContent = job.name;
                    titleSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching job titles:', error);
                titleSelect.innerHTML = '<option value="">Failed to load titles</option>';
            });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('[style*="padding: 15px 20px"]');
    setTimeout(() => {
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 4000);
});

    </script>
@endsection
