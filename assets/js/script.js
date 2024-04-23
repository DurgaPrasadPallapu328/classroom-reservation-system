// Example: Toggle navigation menu on smaller screens
const navToggle = document.querySelector('.nav-toggle');
const navLinks = document.querySelector('.nav-links');

navToggle.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});

// Example: Form validation
const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    // Add your form validation logic here
    // If validation passes, submit the form
    form.submit();
});