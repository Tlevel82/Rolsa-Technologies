document.addEventListener('DOMContentLoaded', () => {
    const termsForm = document.getElementById('termsForm');
    const acceptTerms = document.getElementById('acceptTerms');

    termsForm.addEventListener('submit', (event) => {
        if (!acceptTerms.checked) {
            event.preventDefault(); // Prevent form submission if checkbox is not checked
            alert('You must accept the Terms and Conditions to proceed.');
        } else {
            alert('Thank you for accepting the Terms and Conditions!');
        }
    });
});