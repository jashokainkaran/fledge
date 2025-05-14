document.addEventListener('DOMContentLoaded', function () {
    // Get the apply button
    const applyButton = document.getElementById('apply-now-button');

    if (applyButton) {
        applyButton.addEventListener('click', function (event) {
            event.preventDefault();  // Prevent any default behavior (like navigating)

            // For example, show an alert or submit a form
            alert('Application submitted successfully!');
            // If you are submitting a form:
            // document.getElementById('application-form').submit();
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const applyButton = document.getElementById('apply-now-button');
    const applicationForm = document.getElementById('application-form'); // Assuming you have a form with this ID

    if (applyButton && applicationForm) {
        applyButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(applicationForm);

            fetch('/submit-application', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF protection
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Your application has been successfully submitted!');
                    // Optionally, redirect or clear the form
                } else {
                    alert('There was an error submitting your application.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            });
        });
    }
});

