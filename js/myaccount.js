// switch between login and register 

const registerBtn = document.querySelector('.create-account-btn');
const registerForm = document.querySelector('.woocommerce-form-register');
const loginBtn = document.querySelector('.return-login-btn');
const loginForm = document.querySelector('.woocommerce-form-login');

registerBtn.addEventListener('click', () => {

    registerForm.classList.toggle('hide');
    loginForm.classList.toggle('hide');
});

loginBtn.addEventListener('click', () => {

    registerForm.classList.toggle('hide');
    loginForm.classList.toggle('hide');
});