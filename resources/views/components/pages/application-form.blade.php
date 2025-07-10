@extends('components.layout.app')

@section('content')
<style>
.wizard,
.wizard .nav-tabs,
.wizard .nav-tabs .nav-item {
	position: relative;
}
.wizard .nav-tabs:after {
	content: "";
	width: 80%;
	border-bottom: solid 2px #ccc;
	position: absolute;
	margin-left: auto;
	margin-right: auto;
	top: 38%;
	z-index: -1;
}
.wizard .nav-tabs .nav-item .nav-link {
	width: 70px;
	height: 70px;
	margin-bottom: 6%;
	background: white;
	border: 2px solid #ccc;
	color: #ccc;
	z-index: 10;
}
.wizard .nav-tabs .nav-item .nav-link:hover {
	color: #333;
	border: 2px solid #333;
}
.wizard .nav-tabs .nav-item .nav-link.active {
	background: #fff;
	border: 2px solid #0dcaf0;
	color: #0dcaf0;
}
.wizard .nav-tabs .nav-item .nav-link:after {
	content: " ";
	position: absolute;
	left: 50%;
	transform: translate(-50%);
	opacity: 0;
	margin: 0 auto;
	bottom: 0px;
	border: 5px solid transparent;
	border-bottom-color: #0dcaf0;
	transition: 0.1s ease-in-out;
}

.nav-tabs .nav-item .nav-link.active:after {
	content: " ";
	position: absolute;
	left: 50%;
	transform: translate(-50%);
	opacity: 1;
	margin: 0 auto;
	bottom: 0px;
	border: 10px solid transparent;
	border-bottom-color: #0dcaf0;
}
.wizard .nav-tabs .nav-item .nav-link svg {
	font-size: 25px;
}
</style>

<main>
    <div class="container">
        <div class="card mt-20 mb-50" >
            <div class="card-header">
                Send Us Your Information
            </div>
            <div class="card-body">
                <form action="{{ route('client.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="wizard my-5">
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Personal Information">
                                <a class="nav-link active rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step1" id="step1-tab" data-bs-toggle="tab" role="tab" aria-controls="step1" aria-selected="true">
                                    <i class="fas fa-folder-open"></i>
                                </a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Document Uploads">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step2" id="step2-tab" data-bs-toggle="tab" role="tab" aria-controls="step2" aria-selected="false" title="Step 2">
                                    <i class="fas fa-briefcase"></i>
                                </a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Job Selection">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step3" id="step3-tab" data-bs-toggle="tab" role="tab" aria-controls="step3" aria-selected="false" title="Step 3">
                                    <i class="fas fa-star"></i>
                                </a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmation And Submit">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step4" id="step4-tab" data-bs-toggle="tab" role="tab" aria-controls="step4" aria-selected="false" title="Step 4">
                                    <i class="fas fa-flag-checkered"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- Step 1: User Form -->
                            <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">
                                <h3>User Information</h3>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="surname">Surname</label>
                                        <input type="text" class="form-control" name="surname"  id="surname" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email"  id="email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-info next">Continue <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>

                            <!-- Step 2: Upload Documents -->
                            <div class="tab-pane fade" role="tabpanel" id="step2" aria-labelledby="step2-tab">
                                <h3>Document Upload</h3>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="id_number">ID Number</label>
                                        <input type="text" class="form-control" name="id_number" id="id_number" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="passport_number">Passport Number</label>
                                        <input type="text" class="form-control" name="passport_number"  id="passport_number"  required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>National ID - (Back And Front)</label>
                                        <input type="file" class="form-control" name="id_card" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Passport Copy (6 Months Valid)</label>
                                        <input type="file" class="form-control" name="passport_copy">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Passport Expiry Date</label>
                                        <input type="date" class="form-control" name="passport_expiry">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Good Conduct Certificate</label>
                                        <input type="file" class="form-control" name="good_conduct">
                                    </div>

                                </div>
                                <div class="d-flex justify-content-between">
                                    <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                                    <a class="btn btn-info next">Continue <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>

                            <!-- Step 3: Job Categorization -->
                            <div class="tab-pane fade" role="tabpanel" id="step3" aria-labelledby="step3-tab">
                                <h3>Job Categorization</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="job_category">Job Category</label>
                                        <select class="form-select" name="job_category" id="job_category" required>
                                            <option value="">-- Select Job Category --</option>
                                            @foreach($jobCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="job_title">Job Title</label>
                                        <select class="form-select" name="job_title" id="job_title" required>
                                            <option value="">-- Select Job Title --</option>
                                            @foreach($careers as $career)
                                                <option value="{{ $career->id }}">{{ $career->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="experience_brief" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Curriculum Vitae (CV)</label>
                                        <input type="file" class="form-control" name="cv" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                                    <a class="btn btn-info next">Continue <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>

                            <!-- Step 4: Confirmation -->
                            <div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
                                <h3 class="mb-4">Confirmation</h3>
                                <p class="text-muted">Please confirm your information before submitting the form.</p>

                                <div class="row gy-4">
                                    <!-- Personal Details Card -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-header bg-info text-white fw-bold">Personal Information</div>
                                            <div class="card-body">
                                                <p><strong>Surname:</strong> <span id="confirm_surname"></span></p>
                                                <p><strong>First Name:</strong> <span id="confirm_first_name"></span></p>
                                                <p><strong>Middle Name:</strong> <span id="confirm_middle_name"></span></p>
                                                <p><strong>Email:</strong> <span id="confirm_email"></span></p>
                                                <p><strong>Phone Number:</strong> <span id="confirm_phone_number"></span></p>
                                                <p><strong>ID Number:</strong> <span id="confirm_id_number"></span></p>
                                                <p><strong>Passport Number:</strong> <span id="confirm_passport_number"></span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Job Details Card -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-header bg-success text-white fw-bold">Job Information</div>
                                            <div class="card-body">
                                                <p><strong>Job Category:</strong> <span id="confirm_job_category"></span></p>
                                                <p><strong>Job Title:</strong> <span id="confirm_job_title"></span></p>
                                                <p><strong>Short Summary:</strong><br>
                                                    <small class="text-muted" id="confirm_experience_brief"></small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                                    <button type="submit" class="btn btn-success btn-lg">Submit <i class="fas fa-check-circle ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        $(".next").click(function () {
            const nextTabLinkEl = $(".nav-tabs .active").closest("li").next("li").find("a")[0];
            const nextTab = new bootstrap.Tab(nextTabLinkEl);
            nextTab.show();

            if ($(nextTabLinkEl).attr('href') === '#step4') {
                $("#confirm_surname").text($("#surname").val());
                $("#confirm_first_name").text($("#first_name").val());
                $("#confirm_middle_name").text($("#middle_name").val());
                $("#confirm_email").text($("#email").val());
                $("#confirm_phone_number").text($("#phone_number").val());
                $("#confirm_id_number").text($("#id_number").val());
                $("#confirm_passport_number").text($("#confirm_passport_number").val());
                $("#confirm_job_category").text($("[name='job_category']").val());
                $("#confirm_job_title").text($("[name='job_title']").val());
                $("#confirm_experience_brief").text($("[name='experience_brief']").val());
            }
        });

        $(".previous").click(function () {
            const prevTabLinkEl = $(".nav-tabs .active").closest("li").prev("li").find("a")[0];
            const prevTab = new bootstrap.Tab(prevTabLinkEl);
            prevTab.show();
        });
    });
</script>

@endsection
