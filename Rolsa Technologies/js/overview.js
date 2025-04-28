document.addEventListener('DOMContentLoaded', function () {
    fetch('includes/fetch_overview_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Display calculation summary
            const carbonFootprint = data.calculation?.total_carbon_footprint || 'No data available';
            const calculationDate = data.calculation?.created_at || '';
            document.getElementById('carbon-footprint').textContent = `Carbon Footprint: ${carbonFootprint} kg CO2`;
            document.getElementById('calculation-date').textContent = `Date: ${calculationDate}`;

            // Display latest booking
            const bookingService = data.booking?.service_name || 'No bookings found';
            const bookingDate = data.booking?.booking_date || '';
            document.getElementById('latest-booking').textContent = `Service: ${bookingService}`;
            document.getElementById('booking-date').textContent = `Date: ${bookingDate}`;

            // Display latest installation
            const installationDate = data.installation?.preferred_date || 'No installations found';
            const installationTime = data.installation?.preferred_time || '';
            document.getElementById('latest-installation').textContent = `Date: ${installationDate}, Time: ${installationTime}`;
            document.getElementById('installation-date').textContent = '';
        })
        .catch(error => console.error('Error fetching overview data:', error));
});