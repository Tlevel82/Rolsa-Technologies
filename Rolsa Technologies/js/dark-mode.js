document.addEventListener('DOMContentLoaded', () => {
    console.log("Dark mode script loaded"); // Debugging statement

    const toggleContainer = document.getElementById('toggleDarkMode');
    const body = document.body;

    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark-mode');
        toggleContainer.classList.add('active');
    }

    toggleContainer.addEventListener('click', () => {
        console.log("Toggle clicked"); // Debugging statement
        toggleContainer.classList.toggle('active');
        if (toggleContainer.classList.contains('active')) {
            body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
        }
    });
});