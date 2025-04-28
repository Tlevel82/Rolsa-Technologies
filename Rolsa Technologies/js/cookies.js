document.addEventListener('DOMContentLoaded', () => {
    const cookieConsent = document.getElementById('cookieConsent');
    const acceptCookies = document.getElementById('acceptCookies');
    const rejectCookies = document.getElementById('rejectCookies');

    // Check if the user has already made a choice
    if (localStorage.getItem('cookiesAccepted') !== null) {
        cookieConsent.style.display = 'none';
    }

    // Handle Accept Cookies
    acceptCookies.addEventListener('click', () => {
        localStorage.setItem('cookiesAccepted', 'true');
        cookieConsent.style.display = 'none';
        alert('Thank you for accepting cookies!');
    });

    // Handle Reject Cookies
    rejectCookies.addEventListener('click', () => {
        localStorage.setItem('cookiesAccepted', 'false');
        cookieConsent.style.display = 'none';
        alert('You have rejected cookies. Some features may not work properly.');
    });
});