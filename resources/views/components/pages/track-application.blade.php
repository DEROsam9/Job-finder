@extends('components.layout.app')

@section('content')
<style>
    /* Form Section */
    .form-track {
        background: #f8f9fa;
        padding: 2rem;
    }

    .form-track h3 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-weight: 500;
       font-size: 14px;
    }

    .form-track form {
        margin-top: 20px;
    }

    .form-track .input-group {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .form-track input[type="text"] {
        flex: 1 1 250px;
        padding: 15px 20px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 14px; /* Increased font size */
        min-height: 55px; /* Increased height */
        box-sizing: border-box;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-track input[type="text"]:focus {
        border-color: #2D78C9;
        outline: none;
        box-shadow: 0 0 0 4px rgba(45, 120, 201, 0.2);
    }

    .form-track input[type="text"]::placeholder {
        color: #6c757d;
        opacity: 0.7;
        font-size: 14px; /* Larger placeholder text */
    }

    .form-track .btn {
        padding: 15px 25px;
        font-size: 14px !important; /* Larger button text */
        font-weight: 500;
        border-radius: 8px;
        white-space: nowrap;
        transition: all 0.3s ease;
        background-color: #2D78C9;
        border: none;
        min-height: 55px; /* Match input height */
    }

    .form-track .btn:hover {
        background-color: #1a5a9c;
        transform: translateY(-2px);
    }

    /* Error message */
    .form-track .text-danger {
        font-size: 14px; /* Larger error text */
        color: #dc3545;
        margin-top: 10px;
        display: inline-block;
        padding: 8px 12px;
        background-color: rgba(220, 53, 69, 0.1);
        border-radius: 6px;
    }

    /* Results Section */
    .result-card {
        background: #fff;
        border-radius: 10px;
        padding: 1.8rem;
        height: 100%;
        transition: all 0.3s ease;
        border-left: 5px solid #2D78C9;
        margin-bottom: 1.5rem;
    }

    .result-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .result-card h5 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
        font-weight: 600;
        font-size: 14px;
    }

    .result-card p {
        margin-bottom: 1rem;
        color: #495057;
        font-size: 14px; /* Larger card text */
        line-height: 1.5;
    }

    .result-card strong {
        color: #343a40;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    /* Page Header */
    .pg-title h1 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .pg-title .lead {
        font-size: 1.2rem;
        color: #495057;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .form-track input[type="text"],
        .form-track .btn {
            font-size: 1.05rem ;
            padding: 14px 18px;
        }
    }
@media (max-width: 768px) {
   .form-track input[type="text"] {
        flex: 1 1 auto;
        font-size: 14px;
        padding: 10px 14px;
        min-height: 40px;
    }
    .form-track {
        padding: 1.2rem;
    }

    .form-track h3 {
        font-size: 14px;
    }

    .form-track .input-group {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }

    .form-track input[type="text"],
    .form-track .btn {
        width: 100%;
        font-size: 14px;
        padding: 10px 14px;
        min-height: 42px;
    }

    .pg-title h1 {
        font-size: 14px;
    }

    .pg-title .lead {
        font-size: 14px;
    }

    .result-card {
        padding: 1.2rem;
    }

    .result-card h5 {
        font-size: 14px;
    }

    .result-card p {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .form-track {
        padding: 1rem;
        border-radius: 6px;
    }

    .form-track h3 {
        font-size: 14px;
        margin-bottom: 1rem;
    }

    .pg-title h1 {
       font-size: 24px;
    }

    .pg-title .lead {
        font-size: 14px;
    }

    .result-card {
        padding: 1rem;
        border-radius: 8px;
    }

    .result-card h5 {
        font-size: 14px;
        margin-bottom: 1rem;
    }
}


    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

<div class="row">
    <div class="container">
        <div class="col-md-12">
            <div class="pg-title mb-4">
                <h1>Track Your Application</h1>
                <p class="lead">Check the status of your job application in real-time</p>
            </div>

            <div class="pg-content">
                <div class="form-track shadow-sm">
                    <h3>Enter your details to track your application</h3>

                    <form action="{{ route('track.search') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="id_number" placeholder="National ID / Passport Number" required>
                            <input type="text" name="reference_number" placeholder="Job Reference Number" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search mr-2"></i> Track Application
                            </button>
                        </div>

                        @if(session('error'))
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>

                {{-- Results Section --}}
                @isset($application)
                    <div class="row mt-4 fade-in">
                        <div class="col-md-4 mb-4">
                            <div class="result-card shadow-sm">
                                <h5><i class="fas fa-briefcase mr-2 text-primary"></i><strong>Job Details</strong></h5>
                                <p><strong>Job Category:</strong> {{ $application->career->jobCategory->name ?? 'N/A' }}</p>
                                <p><strong>Job Title:</strong> {{ $application->career->name ?? 'N/A' }}</p>
                                <p><strong>Job Description:</strong> {{ Str::limit($application->career->description ?? 'N/A', 100) }}</p>
                                <a href="{{ route('careers.show', $application->career->id) }}" class="btn btn-sm btn-outline-primary mt-2">View Job</a>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="result-card shadow-sm">
                                <h5><i class="fas fa-user mr-2 text-primary"></i><strong>Applicant Info</strong></h5>
                                <p><strong>Name:</strong> {{ $application->client->surname }} {{ $application->client->first_name }} {{ $application->client->middle_name }}</p>
                                <p><strong>Email:</strong> {{ $application->client->email }}</p>
                                <p><strong>Phone:</strong> {{ $application->client->phone_number }}</p>
                                @if($application->client->id_number)
                                    <p><strong>ID Number:</strong> {{ $application->client->id_number }}</p>
                                @endif
                                @if($application->client->passport_number)
                                    <p><strong>Passport Number:</strong> {{ $application->client->passport_number }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="result-card shadow-sm">
                                <h5><i class="fas fa-tasks mr-2 text-primary"></i><strong>Application Status</strong></h5>
                                <p><i class="far fa-calendar-alt text-muted mr-2"></i> <strong>Submitted:</strong> {{ \Carbon\Carbon::parse($application->created_at)->format('d M Y') }}</p>
                                <p>
                                    <i class="fas fa-info-circle text-muted mr-2"></i>
                                    <strong>Status:</strong>
                                    <span class="status-badge status-{{ strtolower($application->status->name ?? 'pending') }}">
                                {{ $application->status->name ?? 'Pending' }}
                            </span>
                                </p>
                                @if($application->updated_at->gt($application->created_at))
                                    <p><i class="far fa-clock text-muted mr-2"></i> <strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($application->updated_at)->format('d M Y') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
@endsection
