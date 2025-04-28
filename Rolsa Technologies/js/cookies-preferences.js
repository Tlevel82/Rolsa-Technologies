document.addEventListener('DOMContentLoaded', () => {
    const analyticsCookies = document.getElementById('analyticsCookies');
    const marketingCookies = document.getElementById('marketingCookies');
    const savePreferences = document.getElementById('savePreferences');

    // Load saved preferences
    const savedPreferences = JSON.parse(localStorage.getItem('cookiePreferences')) || {};
    analyticsCookies.checked = savedPreferences.analytics || false;
    marketingCookies.checked = savedPreferences.marketing || false;

    // Save preferences
    savePreferences.addEventListener('click', () => {
        const preferences = {
            analytics: analyticsCookies.checked,
            marketing: marketingCookies.checked
        };

        localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
        alert('Your cookie preferences have been saved.');
    });
});