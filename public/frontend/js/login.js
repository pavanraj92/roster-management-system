document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const loginBtn = document.getElementById('loginBtn');
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const emailInput = document.getElementById('login_email');
    const passwordInput = document.getElementById('login_password');
    const otpInput = document.getElementById('login_otp');
    const passwordGroup = document.getElementById('passwordGroup');
    const otpGroup = document.getElementById('otpGroup');
    const otpHelp = document.getElementById('otpHelp');
    const loginTypeInputs = document.querySelectorAll('input[name="login_type"]');
    const otpSendUrl = window.loginOtpSendUrl || '';
    const otpVerifyUrl = window.loginOtpVerifyUrl || '';
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

    function selectedLoginType() {
        const checked = document.querySelector('input[name="login_type"]:checked');
        return checked ? checked.value : 'password';
    }

    function clearErrors() {
        document.querySelectorAll('[id^="error-"]').forEach(function (el) {
            el.classList.add('d-none');
            el.textContent = '';
        });
        document.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
    }

    function displayErrors(errors) {
        clearErrors();
        let first = null;

        for (const field in errors) {
            const displayField = field === 'phone' ? 'email' : field;
            const el = document.getElementById('error-' + displayField);
            const inputId = field === 'email' || field === 'phone' ? 'login_email' : (field === 'password' ? 'login_password' : (field === 'otp' ? 'login_otp' : field));
            const input = document.getElementById(inputId);

            if (el) {
                el.textContent = errors[field][0];
                el.classList.remove('d-none');
            }
            if (input) {
                input.classList.add('is-invalid');
                if (!first) first = input;
            }
        }

        if (first) {
            first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            first.focus();
        }
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function applyMode() {
        const type = selectedLoginType();
        const isOtp = type === 'otp';
        passwordGroup.classList.toggle('d-none', isOtp);
        otpGroup.classList.toggle('d-none', !isOtp);
        passwordInput.required = !isOtp;
        otpInput.required = isOtp;
        loginBtn.textContent = isOtp ? 'Verify OTP & Log in' : 'Log in';
        clearErrors();
    }

    async function postForm(url, formData) {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        return response;
    }

    async function sendOtp() {
        clearErrors();
        const loginValue = emailInput.value.trim();
        let clientErrors = {};

        if (!loginValue) clientErrors.email = ['Email or mobile is required'];
        if (loginValue.includes('@') && !isValidEmail(loginValue)) clientErrors.email = ['Please enter a valid email address'];

        if (Object.keys(clientErrors).length > 0) {
            displayErrors(clientErrors);
            return;
        }

        sendOtpBtn.disabled = true;
        sendOtpBtn.textContent = 'Sending...';

        try {
            const formData = new FormData();
            formData.append('_token', form.querySelector('input[name="_token"]').value);
            formData.append('email', loginValue);

            const response = await postForm(otpSendUrl, formData);
            const data = await response.json();

            if (response.status === 200 && data.success) {
                otpHelp.textContent = data.message || 'OTP sent.';
                otpHelp.classList.remove('text-muted');
                otpHelp.classList.add('text-success');
                otpInput.focus();
                return;
            }

            if (response.status === 422 && data.errors) {
                displayErrors(data.errors);
                return;
            }

            throw new Error('Failed to send OTP');
        } catch (err) {
            console.error('Send OTP error', err);
            alert('Unable to send OTP. Please try again.');
        } finally {
            sendOtpBtn.disabled = false;
            sendOtpBtn.textContent = 'Send OTP';
        }
    }

    async function handleSubmit(e) {
        if (e && typeof e.preventDefault === 'function') e.preventDefault();
        clearErrors();

        const loginType = selectedLoginType();
        const loginValue = emailInput.value.trim();
        const password = passwordInput.value;
        const otp = otpInput.value.trim();
        let clientErrors = {};

        if (!loginValue) clientErrors.email = ['Email or mobile is required'];
        if (loginValue && loginValue.includes('@') && !isValidEmail(loginValue)) clientErrors.email = ['Please enter a valid email address'];
        if (loginType === 'password' && !password) clientErrors.password = ['Password is required'];
        if (loginType === 'otp' && !otp) clientErrors.otp = ['OTP is required'];
        if (loginType === 'otp' && otp && !/^\d{6}$/.test(otp)) clientErrors.otp = ['OTP must be 6 digits'];

        if (Object.keys(clientErrors).length > 0) {
            displayErrors(clientErrors);
            return;
        }

        loginBtn.disabled = true;
        loginBtn.textContent = loginType === 'otp' ? 'Verifying...' : 'Logging in...';
        showPageLoader();

        try {
            const formData = new FormData();
            formData.append('_token', form.querySelector('input[name="_token"]').value);
            formData.append('email', loginValue);
            formData.append('remember', document.getElementById('remember').checked ? '1' : '0');

            let targetUrl = form.action;
            if (loginType === 'password') {
                formData.append('password', password);
            } else {
                targetUrl = otpVerifyUrl;
                formData.append('otp', otp);
            }

            const response = await postForm(targetUrl, formData);
            const data = await response.json();

            if (response.status === 200 && data.success) {
                isRedirecting = true;
                showPageLoader();
                window.location.href = data.redirect || '/';
                return;
            }

            if (response.status === 422 && data.errors) {
                displayErrors(data.errors);
                return;
            }

            throw new Error('Login failed');
        } catch (err) {
            console.error('Login error', err);
            alert('An unexpected error occurred. Please try again.');
        } finally {
            if (isRedirecting) return;
            hidePageLoader();
            loginBtn.disabled = false;
            loginBtn.textContent = selectedLoginType() === 'otp' ? 'Verify OTP & Log in' : 'Log in';
        }
    }

    loginTypeInputs.forEach(function (input) {
        input.addEventListener('change', applyMode);
    });
    if (sendOtpBtn) sendOtpBtn.addEventListener('click', sendOtp);
    form.addEventListener('submit', handleSubmit);
    if (loginBtn) loginBtn.addEventListener('click', handleSubmit);

    applyMode();
});
