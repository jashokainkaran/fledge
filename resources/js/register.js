document.addEventListener('DOMContentLoaded', () => {
  const form            = document.getElementById('register-form');
  const firstName       = document.getElementById('first_name');
  const lastName        = document.getElementById('last_name');
  const email           = document.getElementById('email');
  const studentId       = document.getElementById('student_id');
  const password        = document.getElementById('password');
  const confirmPwd      = document.getElementById('password_confirmation');
  const strengthBar     = document.getElementById('password-strength-bar');
  const strengthText    = document.getElementById('password-strength-text');
  const errorsContainer = document.getElementById('validation-errors');
  const errorList       = document.getElementById('error-list');
  const csrfToken       = document.querySelector('meta[name="csrf-token"]').content;

  // Show or clear a single field error
  const showFieldError = (id, msg) => {
    const errEl = document.getElementById(`${id}-error`);
    if (errEl) errEl.textContent = msg;
    document.getElementById(id)?.classList.add('border-red-500');
  };
  const clearFieldError = id => {
    const errEl = document.getElementById(`${id}-error`);
    if (errEl) errEl.textContent = '';
    document.getElementById(id)?.classList.remove('border-red-500');
  };

  // Password strength meter
  const updatePasswordStrength = () => {
    const val = password.value;
    let score = 0, feedback = [];

    if (val.length >= 8)       score += 25; else feedback.push('8+ chars');
    if (/[a-z]/.test(val))     score += 25; else feedback.push('lowercase');
    if (/[A-Z]/.test(val))     score += 25; else feedback.push('uppercase');
    if (/\d/.test(val))        score += 12.5; else feedback.push('number');
    if (/[@$!%*#?&]/.test(val)) score += 12.5; else feedback.push('symbol');

    strengthBar.style.width = `${score}%`;
    if (score < 50) {
      strengthBar.className = 'bg-red-500 h-1.5 rounded-full';
      strengthText.textContent = 'Weak';
    } else if (score < 75) {
      strengthBar.className = 'bg-yellow-500 h-1.5 rounded-full';
      strengthText.textContent = 'Medium';
    } else {
      strengthBar.className = 'bg-green-500 h-1.5 rounded-full';
      strengthText.textContent = 'Strong';
    }

    if (feedback.length && val) {
      showFieldError('password', `Missing: ${feedback.join(', ')}`);
    } else {
      clearFieldError('password');
    }
  };

  // Password confirmation
  const validatePasswordMatch = () => {
    clearFieldError('password_confirmation');
    if (confirmPwd.value && password.value !== confirmPwd.value) {
      showFieldError('password_confirmation', 'Passwords do not match.');
      return false;
    }
    return true;
  };

  // Event bindings
  password.addEventListener('input', updatePasswordStrength);
  confirmPwd.addEventListener('input', validatePasswordMatch);

  form.addEventListener('submit', e => {
    e.preventDefault();
    errorsContainer.classList.add('hidden');
    errorList.innerHTML = '';

    // Client‑side checks
    if (!validatePasswordMatch()) return;

    // Build payload
    const payload = {
      first_name:           firstName.value.trim(),
      last_name:            lastName.value.trim(),
      email:                email.value.trim(),
      student_id:           studentId.value.trim(),
      password:             password.value,
      password_confirmation: confirmPwd.value
    };

    fetch(form.action, {
      method: 'POST',
      headers: {
        'Accept':       'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(payload)
    })
      .then(async response => {
        const body = await response.json();
        if (response.ok && body.status === 'success') {
          // On success, go to dashboard
          window.location.href = body.redirect;
        } else {
          // Show validation errors
          errorsContainer.classList.remove('hidden');
          const errors = body.errors || {};
          Object.entries(errors).forEach(([field, msgs]) => {
            msgs.forEach(msg => {
              const li = document.createElement('li');
              li.textContent = msg;
              errorList.appendChild(li);
            });
            showFieldError(field, msgs[0]);
          });
        }
      })
      .catch(() => {
        alert('Server error, please try again.');
      });
  });
});
