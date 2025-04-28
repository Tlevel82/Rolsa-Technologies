document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');

    let unavailableSlots = {};

    // Fetch unavailable slots from the server
    fetch('includes/fetch_unavailable_slots.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Organize unavailable slots by date
            data.forEach(slot => {
                if (!unavailableSlots[slot.preferred_date]) {
                    unavailableSlots[slot.preferred_date] = [];
                }
                unavailableSlots[slot.preferred_date].push(slot.preferred_time);
            });
        })
        .catch(error => console.error('Error fetching unavailable slots:', error));

    // Disable unavailable times when a date is selected
    dateInput.addEventListener('change', function () {
        const selectedDate = dateInput.value;
        const unavailableTimes = unavailableSlots[selectedDate] || [];

        // Reset time options
        Array.from(timeSelect.options).forEach(option => {
            option.disabled = unavailableTimes.includes(option.value);
        });
    });
});

// Stage navigation functions
function nextStage(stage) {
    const currentStage = document.getElementById(`stage-${stage - 1}`);
    const inputs = currentStage.querySelectorAll('input, select');
    let isValid = true;

    // Validate inputs in the current stage
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
        } else {
            input.classList.remove('error');
        }
    });

    if (!isValid) {
        alert('Please fill out all fields before proceeding.');
        return;
    }

    // Hide all stages and show the next stage
    document.querySelectorAll('.form-stage').forEach(stage => stage.style.display = 'none');
    document.getElementById(`stage-${stage}`).style.display = 'block';
}

function prevStage(stage) {
    // Hide all stages and show the previous stage
    document.querySelectorAll('.form-stage').forEach(stage => stage.style.display = 'none');
    document.getElementById(`stage-${stage}`).style.display = 'block';
}

// Ensure the first stage is visible on page load
document.getElementById('stage-1').style.display = 'block';