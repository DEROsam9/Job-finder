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
              <a href="/application-form" class="btn btn-default btn-xs apply-btn" style="transition: all 0.3s ease; background-color: #007bff; color: white; border: 1px solid #007bff;">Apply</a>
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

      {{-- <!-- Search -->
      <div class="form-group" style="margin: 20px 0;">
        <input id="jobSearch" type="text" placeholder="Search for jobs" class="form-control">
      </div> --}}

      <!-- Job List -->
      <div id="jobList">
    <div class="panel-body">
        @if($jobs->count())
            @foreach($jobs as $job)
                <div class="media" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                    <div class="media-body">
                        <strong>{{ $job->title ?? $job->name }}</strong><br>
                        <small class="text-muted">
                            {{ $job->jobCategory->name ?? 'Category not available' }}
                        </small>
                    </div>
                    <div class="media-right">
                        <a href="/application-form" class="btn btn-default btn-xs apply-btn" style="transition: all 0.3s ease; background-color: #007bff; color: white; border: 1px solid #007bff; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px;" onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">Apply</a>
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



<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('categoryFilter');
    const jobList = document.getElementById('jobList');
    const jobDetailsModal = $('#jobDetailsModal');
    const jobDetailsContent = document.getElementById('jobDetailsContent');
    const closeModal = document.getElementById('closeModal');

    function renderJobs(jobs, categoryName = null) {
        if (jobs.length === 0) {
            const message = categoryName 
                ? `No jobs found for ${categoryName}.` 
                : 'No jobs found.';
            return `<p>${message}</p>`;
        }

        return jobs.map(job => `
            <div class="media" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <div class="media-body">
                    <strong>${job.title || job.name}</strong><br>
                    <small class="text-muted">${job.jobCategory ? job.jobCategory.name : (categoryName || '${categoryName}')}</small>
                </div>
                <div class="media-right">
                    <a href="/application-form" class="btn btn-default btn-xs apply-btn" style="transition: all 0.3s ease; background-color: #007bff; color: white; border: 1px solid #007bff; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px;"
                        onmouseover="this.style.backgroundColor='#0056b3'"
                        onmouseout="this.style.backgroundColor='#007bff'">Apply</a>
                </div>
            </div>
        `).join('');
    }

    function attachApplyHandlers() {
        const applyButtons = document.querySelectorAll('.apply-btn');
        applyButtons.forEach(button => {
            button.addEventListener('click', function () {
                alert('Apply clicked for job');
            });
        });
    }

    function attachViewDetailsHandlers() {
        const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
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
                    .catch(() => {
                        jobDetailsContent.innerHTML = '<p>Error loading job details</p>';
                        jobDetailsModal.modal('show');
                    });
            });
        });
    }

    categoryFilter.addEventListener('change', function () {
        const categoryId = this.value;

        fetch(`/jobs/filter?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const html = renderJobs(data.jobs);
                jobList.querySelector('.panel-body').innerHTML = html;
                attachApplyHandlers();
                attachViewDetailsHandlers();
            })
            .catch(() => {
                jobList.querySelector('.panel-body').innerHTML = '<p>Error loading jobs.</p>';
            });
    });

    closeModal.addEventListener('click', function () {
        jobDetailsModal.modal('hide');
        jobDetailsContent.innerHTML = '';
    });
});
</script>

@endsection