@extends('components.layout.app')
@section('content')
    <style>
        .form-step { display: none; }
        .form-step.active { display: block; }
        .step-indicator.active { background: #2D78C9; color: white; }
        .step-indicator { cursor: pointer; }
        .progress-line { background: #B3B3B3; height: 3px; position: absolute; top: 30px; width: 100%; z-index: -1; }
        .progress-line.active { background: #2D78C9; }
        .form-section { margin-top: 40px; }
        .form-section input { margin: 10px 0; width: 48%; }
        .form-section p { display: flex; justify-content: space-between; }
        .form-section button { margin: 20px 0; padding: 10px 20px; background: #2D78C9; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .form-section button:disabled { background: #CCCCCC; cursor: not-allowed; }
    </style>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h1>Apply For a Job</h1>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: flex">
                    <div style="width: 700px; position: relative; justify-content: space-between; align-items: flex-start; display: inline-flex">
                        <div class="progress-line" id="progress-line"></div>
                        <div style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
                            <div class="step-indicator active" data-step="1" style="width: 60px; height: 60px; padding: 18px 1px; background: #E5E5E5; border-radius: 100px; outline: 1px #2D78C9 solid; outline-offset: -1px; display: flex; justify-content: center; align-items: center;">
                                <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 800;">1</div>
                            </div>
                            <div style="text-align: center; font-weight: 700">Step 1</div>
                            <div style="text-align: center; color: #2D78C9; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Personal Details</div>
                        </div>
                        <div style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
                            <div class="step-indicator" data-step="2" style="width: 60px; height: 60px; padding: 18px 1px; background: #E5E5E5; border-radius: 100px; outline: 1px #CCCCCC solid; outline-offset: -1px; display: flex; justify-content: center; align-items: center;">
                                <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 700;">2</div>
                            </div>
                            <div style="text-align: center; font-weight: 700">Step 2</div>
                            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Upload Document</div>
                        </div>
                        <div style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
                            <div class="step-indicator" data-step="3" style="width: 60px; height: 60px; padding: 18px 1px; background: #E5E5E5; border-radius: 100px; outline: 1px #CCCCCC solid; outline-offset: -1px; display: flex; justify-content: center; align-items: center;">
                                <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 700;">3</div>
                            </div>
                            <div style="text-align: center; font-weight: 700">Step 3</div>
                            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Job Categorization</div>
                        </div>
                        <div style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
                            <div class="step-indicator" data-step="4" style="width: 60px; height: 60px; padding: 18px 1px; background: #E5E5E5; border-radius: 100px; outline: 1px #CCCCCC solid; outline-offset: -1px; display: flex; justify-content: center; align-items: center;">
                                <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 700;">4</div>
                            </div>
                            <div style="text-align: center; font-weight: 700">Step 4</div>
                            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: 'Montserrat', sans-serif; font-weight: 400;">Confirm Details</div>
                        </div>
                    </div>
                    <div class="form-section">
                        <form id="application-form">
                            <div class="form-step active" data-step="1">
                                <p>
                                    <input type="text" name="First Name" placeholder="First Name" required>
                                    <input type="text" name="Last Name" placeholder="Last Name" required>
                                </p>
                                <p>
                                    <input type="email" name="Email Address" placeholder="Email Address" required>
                                    <input type="tel" name="Phone Number" placeholder="Phone Number" required>
                                </p>
                                <p>
                                    <input type="text" name="Passport Number" placeholder="Passport Number" required>
                                    <input type="text" name="ID Number" placeholder="ID Number" required>
                                </p>
                                <button type="button" onclick="nextStep(2)">Next</button>
                            </div>
                            <div class="form-step" data-step="2">

                                <div class="upload-section">
                                    <div class="upload-box">
                                        <div class="upload-content">
                                            <i class="fa fa-upload"></i>
                                            <p>Appload Passport</p>
                                            <input type="file" name="resume" accept=".pdf,.doc,.docx" id="resumeFile">
                                            <label for="resumeFile" class="upload-btn">Choose File</label>
                                            <div class="file-info" id="resumeInfo"></div>
                                        </div>
                                    </div>
                                    <div class="upload-box">
                                        <div class="upload-content">
                                            <i class="fa fa-upload"></i>
                                            <p>Upload Resume/CV</p>
                                            <input type="file" name="resume" accept=".pdf,.doc,.docx" id="resumeFile">
                                            <label for="resumeFile" class="upload-btn">Choose File</label>
                                            <div class="file-info" id="resumeInfo"></div>
                                        </div>
                                    </div>
                                    <div class="upload-box">
                                        <div class="upload-content">
                                            <i class="fa fa-file-text"></i>
                                            <p>Upload Cover Letter (Optional)</p>
                                            <input type="file" name="coverLetter" accept=".pdf,.doc,.docx" id="coverFile">
                                            <label for="coverFile" class="upload-btn">Choose File</label>
                                            <div class="file-info" id="coverInfo"></div>
                                        </div>
                                    </div>
                                </div>

{{--                                <p>--}}
{{--                                    <input type="file" name="Resume" accept=".pdf,.doc,.docx" required>--}}
{{--                                    <input type="file" name="Cover Letter" accept=".pdf,.doc,.docx">--}}
{{--                                </p>--}}
                                <p>
                                    <button type="button" onclick="prevStep(1)">Previous</button>
                                    <button type="button" onclick="nextStep(3)">Next</button>
                                </p>
                            </div>
                            <div class="form-step" data-step="3">
                                <p>
                                    <select name="Job Category" required>
                                        <option value="">Select Job Category</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <input type="text" name="Job Title" placeholder="Desired Job Title" required>
                                </p>
                                <p>
                                    <button type="button" onclick="prevStep(2)">Previous</button>
                                    <button type="button" onclick="nextStep(4)">Next</button>
                                </p>
                            </div>
                            <div class="form-step" data-step="4">
                                <p><div id="form-summary"></div></p>
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
            currentStep = step;
        }

        function nextStep(step) {
            const currentInputs = document.querySelectorAll(`.form-step[data-step="${currentStep}"] input[required], .form-step[data-step="${currentStep}"] select[required]`);
            let valid = true;
            currentInputs.forEach(input => {
                if (!input.value) {
                    valid = false;
                    input.style.border = '1px solid red';
                } else {
                    input.style.border = '';
                }
            });
            if (valid) {
                if (step === 4) {
                    displaySummary();
                }
                showStep(step);
            } else {
                alert('Please fill in all required fields.');
            }
        }

        function prevStep(step) {
            showStep(step);
        }

        function displaySummary() {
            const formData = new FormData(document.getElementById('application-form'));
            let summary = '<h3>Application Summary</h3>';
            for (let [key, value] of formData.entries()) {
                if (key !== 'Resume' && key !== 'Cover Letter') {
                    summary += `<p><strong>${key}:</strong> ${value}</p>`;
                } else {
                    summary += `<p><strong>${key}:</strong> ${value.name || 'Not uploaded'}</p>`;
                }
            }
            document.getElementById('form-summary').innerHTML = summary;
        }

        document.getElementById('application-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Application submitted successfully!');
        });
    </script>
@endsection
