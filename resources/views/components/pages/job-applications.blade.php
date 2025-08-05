@extends('components.layout.app')

@section('content')
<div class="container" style="padding-top: 20px;">
  <div class="row">
    <!-- Sidebar -->
    <aside class="col-md-3">
      <!-- Filter -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">Filters</h4>
        </div>
        <div class="panel-body">
          <div class="form-group">
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
              <button class="btn btn-default btn-xs apply-btn" data-job-id="{{ $job->id }}">Apply</button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="col-md-9">
      <h3 class="page-header">Job Listings</h3>

      {{-- <!-- Search -->
      <div class="form-group" style="margin: 20px 0;">
        <input id="jobSearch" type="text" placeholder="Search for jobs" class="form-control">
      </div> --}}

      <!-- Job List -->
      <div id="jobList">
        @foreach($jobs as $job)
        <div class="job-item media" style="border-bottom: 1px solid #eee; padding: 15px 0;"
             data-job-id="{{ $job->id }}"
             data-job-category="{{ $job->job_category_id }}"
             data-job-name="{{ strtolower($job->title) }}">
          <div class="media-body">
            <strong>{{ $job->title }}</strong><br>
            <small class="text-muted">{{ $job->jobCategory->name ?? 'N/A' }}</small>
          </div>
          <div class="media-right">
            <button class="btn btn-link btn-xs view-details-btn" data-job-id="{{ $job->id }}">View</button>
          </div>
        </div>
        @endforeach
      </div>
    </main>
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

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('categoryFilter');
    const jobSearch = document.getElementById('jobSearch');
    const jobList = document.getElementById('jobList');
    const jobItems = Array.from(document.querySelectorAll('.job-item'));
    const applyButtons = document.querySelectorAll('.apply-btn');
    const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
    const jobDetailsModal = $('#jobDetailsModal');
    const jobDetailsContent = document.getElementById('jobDetailsContent');
    const closeModal = document.getElementById('closeModal');

    function filterJobs() {
        const selectedCategory = categoryFilter.value;
        const searchTerm = jobSearch.value.toLowerCase();

        jobItems.forEach(item => {
            const matchesCategory = selectedCategory === '' || item.dataset.jobCategory === selectedCategory;
            const matchesSearch = item.dataset.jobName.includes(searchTerm);

            if (matchesCategory && matchesSearch) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    categoryFilter.addEventListener('change', filterJobs);
    jobSearch.addEventListener('input', filterJobs);

    applyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const jobId = this.dataset.jobId;
            alert('Apply clicked for job ID: ' + jobId);
        });
    });

    viewDetailsButtons.forEach(button => {
        button.addEventListener('click', function () {
            const jobId = this.dataset.jobId;
            fetch(`/jobs/${jobId}/details`)
                .then(response => response.json())
                .then(data => {
                    jobDetailsContent.innerHTML = `
                        <h4>${data.title}</h4>
                        <p><strong>Category:</strong> ${data.jobCategory?.name || 'N/A'}</p>
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>Available Slots:</strong> ${data.slots}</p>
                    `;
                    jobDetailsModal.modal('show');
                })
                .catch(error => {
                    jobDetailsContent.innerHTML = '<p>Error loading job details</p>';
                    jobDetailsModal.modal('show');
                });
        });
    });

    closeModal.addEventListener('click', function () {
        jobDetailsModal.modal('hide');
        jobDetailsContent.innerHTML = '';
    });
});
</script>
@endsection