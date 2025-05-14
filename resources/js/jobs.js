// resources/js/jobs.js

document.addEventListener('DOMContentLoaded', () => {
  console.log('✅ jobs.js loaded');

  const keywordInput       = document.getElementById("keyword");
  const categorySelect     = document.getElementById("category");
  const jobTypeSelect      = document.getElementById("jobType");
  const workingHoursSelect = document.getElementById("workingHours");
  const locationSelect     = document.getElementById("location");
  const searchButton       = document.getElementById("searchButton");
  const jobListingsContainer = document.getElementById("job-listings");

  function buildQueryString() {
    const params = new URLSearchParams();
    if (keywordInput.value.trim())    params.append('keyword', keywordInput.value.trim());
    if (categorySelect.value)         params.append('category', categorySelect.value);
    if (jobTypeSelect.value)          params.append('jobType', jobTypeSelect.value);
    if (workingHoursSelect.value)     params.append('workingHours', workingHoursSelect.value);
    if (locationSelect.value)         params.append('location', locationSelect.value);
    const qs = params.toString();
    console.log("🔍 filters →", qs || "[no filters]");
    return qs;
  }

  function fetchJobs() {
    const qs = buildQueryString();
    // use the blade-generated URL, not a hardcoded "/jobs"
    const url = window.jobsIndexUrl + (qs ? `?${qs}` : '');
    console.log('🚀 fetch:', url);

    fetch(url, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
    .then(r => {
      console.log('👀 response status', r.status);
      if (!r.ok) throw new Error("Network response was not ok");
      return r.text();
    })
    .then(html => {
      jobListingsContainer.innerHTML = html;
      console.log('✅ job list updated');
    })
    .catch(err => {
      console.error("Fetch error:", err);
    });
  }

  // wire up events
  searchButton.addEventListener("click", fetchJobs);
  categorySelect.addEventListener("change", fetchJobs);
  jobTypeSelect.addEventListener("change", fetchJobs);
  workingHoursSelect.addEventListener("change", fetchJobs);
  locationSelect.addEventListener("change", fetchJobs);
  // optional: only search on enter in keyword, not every keystroke
  keywordInput.addEventListener("keyup", (e) => {
    if (e.key === 'Enter') fetchJobs();
  });
});
