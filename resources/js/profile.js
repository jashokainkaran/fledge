document.addEventListener("DOMContentLoaded", () => {
  const editButton           = document.getElementById("editButton");
  const saveButton           = document.getElementById("saveButton");
  const profileForm          = document.getElementById("profileForm");
  const inputs               = document.querySelectorAll("input:not([type='file'])");
  const fileInputs           = document.querySelectorAll("input[type='file']");
  const profilePictureLabel  = document.getElementById("profilePictureLabel");
  const profilePictureInput  = document.getElementById("profilePicture");
  const progressBar          = document.getElementById("progressBar");
  const completionText       = document.getElementById("completionText");
  const progressTooltip      = document.getElementById("progressTooltip");
  const suggestionProfilePic = document.getElementById("suggestion-profile-picture");
  const suggestionCV         = document.getElementById("suggestion-cv");
  const suggestionPersonal   = document.getElementById("suggestion-personal");
  const cvInput              = document.getElementById("cv");
  const cvFileName           = document.getElementById("cvFileName");
  let isEditing              = false;

  function updateProgress() {
    let progress = 0;

    // Personal info (40%)
    const first = document.getElementById("firstName").value.trim();
    const last  = document.getElementById("lastName").value.trim();
    const email = document.getElementById("email").value.trim();
    if (first && last && email) {
      progress += 40;
      suggestionPersonal.innerHTML = '<i class="fas fa-check-circle mr-2"></i><span>Personal info completed (40%)</span>';
      suggestionPersonal.classList.add("text-green-600");
    } else {
      suggestionPersonal.innerHTML = '<i class="fas fa-circle-notch mr-2"></i><span>Add your personal information (40%)</span>';
      suggestionPersonal.classList.remove("text-green-600");
    }

    // Profile picture (25%)
    if (suggestionProfilePic.classList.contains("text-green-600") || profilePictureInput.files.length > 0) {
      progress += 25;
      suggestionProfilePic.innerHTML = '<i class="fas fa-check-circle mr-2"></i><span>Profile picture added (25%)</span>';
      suggestionProfilePic.classList.add("text-green-600");
    } else {
      suggestionProfilePic.innerHTML = '<i class="fas fa-circle-notch mr-2"></i><span>Add a profile picture (25%)</span>';
      suggestionProfilePic.classList.remove("text-green-600");
    }

    // CV (35%)
    if (suggestionCV.classList.contains("text-green-600") || cvInput.files.length > 0) {
      progress += 35;
      suggestionCV.innerHTML = '<i class="fas fa-check-circle mr-2"></i><span>CV uploaded (35%)</span>';
      suggestionCV.classList.add("text-green-600");
    } else {
      suggestionCV.innerHTML = '<i class="fas fa-circle-notch mr-2"></i><span>Upload your CV (35%)</span>';
      suggestionCV.classList.remove("text-green-600");
    }

    progressBar.style.width     = `${progress}%`;
    completionText.textContent  = `${progress}% Complete`;
    progressTooltip.textContent = `${progress}%`;
  }

  // initial
  updateProgress();

  // toggle edit mode
  editButton.addEventListener("click", () => {
    isEditing = true;
    inputs.forEach(i => {
      i.disabled = false;
      i.classList.replace("bg-gray-100", "bg-white");
      i.classList.replace("text-gray-500", "text-gray-800");
    });
    fileInputs.forEach(i => i.removeAttribute("disabled"));
    profilePictureLabel.classList.remove("opacity-0");
    editButton.classList.add("hidden");
    saveButton.classList.remove("hidden");
  });

  // prevent file dialog when not editing
  [profilePictureInput, cvInput].forEach(el => {
    el.addEventListener("click", e => { if (!isEditing) e.preventDefault(); });
  });

  // profile picture preview
  profilePictureInput.addEventListener("change", e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => {
      document.getElementById("preview").src = reader.result;
      updateProgress();
    };
    reader.readAsDataURL(file);
  });

  // CV change
  cvInput.addEventListener("change", function() {
    if (!this.files.length) {
      cvFileName.textContent = "No file chosen";
      return updateProgress();
    }
    const file = this.files[0];
    if (file.type !== "application/pdf") {
      alert("Please upload a PDF file only.");
      this.value = "";
      cvFileName.textContent = "No file chosen";
      return;
    }
    cvFileName.textContent = file.name;
    updateProgress();
  });

  // live-update personal fields
  ["firstName","lastName","email"].forEach(id => {
    document.getElementById(id).addEventListener("input", updateProgress);
  });

  // Save → scan CV via AJAX, then submit
  saveButton.addEventListener("click", async e => {
    e.preventDefault();

    // if CV changed, scan it first
    if (cvInput.files.length) {
      const form = new FormData();
      form.append("cv", cvInput.files[0]);
      try {
        const res = await fetch("/api/profile/cv-scan", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
          },
          body: form
        });
        const json = await res.json();
        if (json.status === "error") {
          alert(json.message);
          return;
        }
      } catch (err) {
        console.error(err);
        alert("Something went wrong. Please try again.");
        return;
      }
    }

    // if no CV or clean, submit form
    profileForm.submit();
  });
});
