document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('registerForm');
    if (!form) return;

    const registerBtn = document.getElementById('registerBtn');
    const successAlert = document.getElementById('successAlert');
    const successMessage = document.getElementById('successMessage');
    let isRedirecting = false;

    function showPageLoader() {
        const preloader = document.getElementById('preloader-active');
        if (!preloader) return;
        preloader.style.display = 'block';
        preloader.style.opacity = '1';
        document.body.style.overflow = 'hidden';
    }

    function hidePageLoader() {
        const preloader = document.getElementById('preloader-active');
        if (!preloader) return;
        preloader.style.display = 'none';
        preloader.style.opacity = '0';
        document.body.style.overflow = 'visible';
    }

    /* ------------------------------
       Utility: Clear Errors
    ------------------------------ */
    function clearErrors() {
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.classList.add('d-none');
            el.textContent = '';
        });

        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        const termsContainer = document.getElementById('terms-container');
        if (termsContainer) {
            termsContainer.style.border = '';
            termsContainer.style.borderRadius = '';
            termsContainer.style.padding = '';
            termsContainer.style.backgroundColor = '';
        }
    }

    /* ------------------------------
       Utility: Display Errors
    ------------------------------ */
    function displayErrors(errors) {
        clearErrors();
        let firstErrorField = null;

        for (let field in errors) {

            const errorElement = document.getElementById(`error-${field}`);
            const inputField = document.getElementById(field);

            if (errorElement) {
                errorElement.textContent = errors[field][0];
                errorElement.classList.remove('d-none');
            }

            if (inputField) {
                inputField.classList.add('is-invalid');
                if (!firstErrorField) {
                    firstErrorField = inputField;
                }
            }

            // Special styling for terms checkbox
            if (field === 'terms') {
                const termsContainer = document.getElementById('terms-container');
                if (termsContainer) {
                    termsContainer.style.border = '2px solid #dc3545';
                    termsContainer.style.borderRadius = '4px';
                    termsContainer.style.padding = '8px';
                    termsContainer.style.backgroundColor = '#fff5f5';
                }
            }
        }

        if (firstErrorField) {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErrorField.focus();
        }
    }

    /* ------------------------------
       Email Validator
    ------------------------------ */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /* ------------------------------
       Phone Validator stop wheeling on number input
    ------------------------------ */
    function isValidPhone(phone) {
        const phoneRegex = /^\d{10,15}$/;
        return phoneRegex.test(phone);
    }
 
   

    /* ------------------------------
       Form Submit
    ------------------------------ */
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        clearErrors();
        successAlert.style.display = 'none';

        let clientErrors = {};

        const first_name = document.getElementById('first_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;
        const terms = document.getElementById('terms').checked;

        // Required checks
        if (!first_name) {
            clientErrors['first_name'] = ['First name is required'];
        }

        if (!email) {
            clientErrors['email'] = ['Email is required'];
        } else if (!isValidEmail(email)) {
            clientErrors['email'] = ['Please enter a valid email address'];
        }

        if(!phone) {
            clientErrors['phone'] = ['Mobile number is required'];
        } else if (!/^\d{10,15}$/.test(phone)) {
            clientErrors['phone'] = ['Please enter a valid mobile number (10-15 digits)'];
        }

        if (!password) {
            clientErrors['password'] = ['Password is required'];
        }

        if (!password_confirmation) {
            clientErrors['password_confirmation'] = ['Password confirmation is required'];
        }

        // Password match validation (NEW)
        if (password && password_confirmation && password !== password_confirmation) {
            clientErrors['password_confirmation'] = ['Passwords do not match'];
        }

        if (!terms) {
            clientErrors['terms'] = ['You must agree to the terms and policy'];
        }

        if (Object.keys(clientErrors).length > 0) {
            displayErrors(clientErrors);
            return;
        }

        registerBtn.disabled = true;
        registerBtn.textContent = 'Registering...';
        showPageLoader();

        // If button was type=button we may get click -> dispatch submit; ensure default prevented

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {

            if (response.status === 200) {
                return response.json().then(data => {
                    if (data.redirect) {
                        isRedirecting = true;
                        showPageLoader();
                        window.location.href = data.redirect;
                        return;
                    }

                    successMessage.textContent = data.message || 'Registration successful!';
                    successAlert.style.display = 'block';
                    successAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }

            if (response.status === 422) {
                return response.json().then(data => {
                    if (data.errors) {
                        displayErrors(data.errors);
                    }
                });
            }

            return response.text().then(text => {
                throw new Error(text || 'Registration failed');
            });
        })
        .catch(error => {
            console.error('Unexpected Error:', error);
            alert('An unexpected error occurred. Please try again.');
        })
        .finally(() => {
            if (isRedirecting) return;
            hidePageLoader();
            registerBtn.disabled = false;
            registerBtn.textContent = 'Register';
        });
    });

    // Also attach click handler to the button to trigger the same submit flow
    if (registerBtn) {
        registerBtn.addEventListener('click', function (e) {
            e.preventDefault();
            // Dispatch a submit event on the form so the form submit handler runs
            const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
            form.dispatchEvent(submitEvent);
        });
    }

});
