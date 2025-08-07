@extends('components.layout.app')

@section('content')
    <style>
        .job-application-wrapper {
            padding-top: 20px;
            width: 100%;
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

        .job-application-wrapper #categoryFilter {
            width: 100% !important;
            max-width: 80% !important;
            box-sizing: border-box !important;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #fff;
        }

        @media screen and (max-width: 768px) {
            .job-application-wrapper #categoryFilter {
                font-size: 16px !important;
                padding: 12px 10px !important;
                border-radius: 6px !important;
            }

            .job-application-wrapper .panel-heading h4 {
                font-size: 18px !important;
            }

            .job-application-wrapper .form-group label {
                font-size: 14px !important;
                display: block !important;
                margin-bottom: 8px !important;
            }

            /* Ensure panel does not shrink */
            .job-application-wrapper .panel-body {
                padding: 10px !important;
            }
            .job-application-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                padding: 10px 5px !important;
            }

            .job-application-wrapper .row {
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
            }

            .job-application-wrapper aside.col-md-3,
            .job-application-wrapper main.col-md-9 {
                display: block !important;
                width: 100% !important;
                float: none !important;
                clear: both !important;
                padding: 0 10px !important;
                margin-bottom: 20px !important;
            }

            .job-application-wrapper .panel {
                width: 100% !important;
                margin-bottom: 15px !important;
            }

            .job-application-wrapper .media {
                display: block !important;
                width: 100% !important;
                padding: 15px 0 !important;
            }

            .job-application-wrapper .media-body,
            .job-application-wrapper .media-right {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
                padding: 5px 0 !important;
            }

            .job-application-wrapper .media-right {
                text-align: center !important;
                margin-top: 10px !important;
            }

            .job-application-wrapper .apply-btn,
            .job-application-wrapper .btn {
                display: block !important;
                width: 100% !important;
                padding: 15px !important;
                font-size: 16px !important;
                margin: 10px 0 !important;
            }

            .form-control {
                flex: 1 1 250px;
                padding: 15px 20px;
                border: 1px solid #ced4da;
                border-radius: 8px;
                font-size: 14px; /* Increased font size */
                box-sizing: border-box;
                transition: all 0.3s ease;
                background-color: #fff;
            }

            .job-application-wrapper .text-center .btn {
                display: inline-block !important;
                margin: 5px !important;
                min-width: 44px !important;
            }
        }

        @media screen and (max-width: 480px) {
            .job-application-wrapper {
                padding: 5px !important;
            }

            .job-application-wrapper aside.col-md-3,
            .job-application-wrapper main.col-md-9 {
                padding: 0 5px !important;
            }

            .job-application-wrapper .apply-btn,
            .job-application-wrapper .btn {
                padding: 12px !important;
                font-size: 14px !important;
            }
        }

        /* Responsive images inside job section - exclude header logo */
        .job-application-wrapper img:not(header img):not(.navbar img):not(.logo img) {
            max-width: 100% !important;
            height: auto !important;
        }
    </style>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="job-application-wrapper container" style="padding-top: 20px;">
                    <div class="row">
                        <!-- Sidebar -->
                        <aside class="col-md-3">
                            <!-- Filter -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Filters</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="job-selection-row">
                                        <label for="categoryFilter">Categories</label>
                                        <select id="categoryFilter" class="form-control">
                                            <option value="">Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Trending Jobs -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Trending Jobs</h4>
                                </div>
                                <div class="panel-body">
                                    @foreach($trendingJobs as $job)
                                        <div class="media" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                                            <div class="media-body">
                                                <strong>{{ $job->title }}</strong><br>
                                                <small class="text-muted">{{ $job->jobCategory->name ?? 'N/A' }}</small>
                                            </div>
                                            <div class="media-right">
                                                <a href="/application-form" class="btn btn-default btn-xs apply-btn" style="transition: all 0.3s ease; background-color: #2D78C9; color: white; border: 1px solid #007bff;">Apply</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </aside>

                        <!-- Main Content -->
                        <main class="col-md-9">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h1 class="panel-title" style=" font-weight: bold; font-size: 24px">Job-Listings</h1>
                                </div>
                                <div id="jobList">
                                    <div class="panel-body">
                                        @if($jobs->count())
                                            @foreach($jobs as $job)
                                                <div class="media" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                                                    <div class="media-body">
                                                        <strong>{{ $job->title ?? $job->name }}</strong>
                                                        <span class="badge badge-primary" style="margin-left: 10px; background-color: #a4b2c0;">
                                                            {{ $job->slots ?? 0 }} slots
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $job->jobCategory->name ?? 'Category not available' }}
                                                        </small>
                                                    </div>
                                                    <div class="media-right">
                                                        <a href="/application-form" class="btn btn-default btn-xs apply-btn" style="transition: all 0.3s ease; background-color: #2D78C9; color: white; border: 1px solid #007bff; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px;" onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">Apply</a>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Pagination links --}}
                                            {{-- <div class="mt-3">
                                                {{ $jobs->links() }}
                                            </div> --}}
                                            <div class="text-center mt-4">
                                                @if ($jobs->onFirstPage())
                                                    <button class="btn bg-blue btn-default" disabled>&lt;</button>
                                                @else
                                                    <a href="{{ $jobs->previousPageUrl() }}" class="btn btn-default">&lt;</a>
                                                @endif

                                                @if ($jobs->hasMorePages())
                                                    <a href="{{ $jobs->nextPageUrl() }}" class="btn btn-default">&gt;</a>
                                                @else
                                                    <button class="btn  bg-bluebtn-default" disabled>&gt;</button>
                                                @endif
                                            </div>

                                        @else
                                            <p>No jobs found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Job Details Modal -->
                            <div id="jobDetailsModal" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" id="closeModal" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Job Details</h4>
                                        </div>
                                        <div id="jobDetailsContent" class="modal-body">
                                            <!-- Content gets injected here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryFilter = document.getElementById('categoryFilter');
            const jobList = document.getElementById('jobList');
            const jobDetailsModal = $('#jobDetailsModal');
            const jobDetailsContent = document.getElementById('jobDetailsContent');
            const closeModal = document.getElementById('closeModal');

            let selectedCategoryName = '';

            function renderJobs(jobs) {
                if (jobs.length === 0) {
                    return '<p>No jobs found for this category.</p>';
                }

                return jobs.map(job => {
                    const categoryName = job.jobCategory ? job.jobCategory.name : selectedCategoryName || 'Uncategorized';
                    return `
                <div class="media" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                    <div class="media-body">
                        <strong>${job.title || job.name}</strong><br>
                        <small class="text-muted">${categoryName}</small>
                    </div>
                    <div class="media-right">
                        <a href="/application-form" class="btn btn-default btn-xs apply-btn"
                            style="transition: all 0.3s ease; background-color: #007bff; color: white; border: 1px solid #007bff; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px;"
                            onmouseover="this.style.backgroundColor='#0056b3'"
                            onmouseout="this.style.backgroundColor='#007bff'">Apply</a>
                    </div>
                </div>
            `;
                }).join('');
            }

            categoryFilter.addEventListener('change', function () {
                const categoryId = this.value;
                selectedCategoryName = this.options[this.selectedIndex].text;

                fetch(`/jobs/filter?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        const html = renderJobs(data.jobs);
                        jobList.querySelector('.panel-body').innerHTML = html;
                    })
                    .catch(() => {
                        jobList.querySelector('.panel-body').innerHTML = '<p>Error loading jobs.</p>';
                    });
            });
        });

    </script>
@endsection
