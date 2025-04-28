const energyCtx = document.getElementById('energyConsumptionGraph').getContext('2d');
let energyChart;

// Fetch data and render the graph
async function fetchEnergyData() {
    try {
        const response = await fetch('includes/get-energy-data.inc.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        console.log('Fetched Data:', data); // Log the fetched data

        // If no data is returned, provide default values
        if (data.length === 0) {
            return {
                labels: ['No Data'],
                values: [0]
            };
        }

        const labels = data.map(item => item.appliance); // Appliance names
        const values = data.map(item => item.total_energy); // Total energy consumption

        console.log('Labels:', labels); // Log the labels
        console.log('Values:', values); // Log the values

        return { labels, values };
    } catch (error) {
        console.error('Error fetching energy data:', error);
        return {
            labels: ['Error'],
            values: [0]
        };
    }
}

async function renderEnergyGraph() {
    const { labels, values } = await fetchEnergyData();

    if (labels.length === 0 || values.length === 0) {
        console.warn('No data available for energy consumption.');
    }

    if (energyChart) {
        energyChart.destroy(); // Destroy the previous chart instance
    }

    const isDarkMode = document.body.classList.contains('dark-mode'); // Check if dark mode is active

    energyChart = new Chart(energyCtx, {
        type: 'bar', // Bar chart for energy consumption
        data: {
            labels: labels,
            datasets: [{
                label: 'Energy Consumption (kWh)',
                data: values,
                backgroundColor: isDarkMode ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 123, 255, 0.8)',
                borderColor: isDarkMode ? '#ffffff' : '#007BFF',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: isDarkMode ? '#ffffff' : '#000000' // Legend text color
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Appliances',
                        color: isDarkMode ? '#ffffff' : '#000000' // X-axis title color
                    },
                    ticks: {
                        color: isDarkMode ? '#ffffff' : '#000000' // X-axis tick color
                    },
                    grid: {
                        color: isDarkMode ? '#ffffff' : '#e0e0e0' // X-axis grid line color
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Energy Consumption (kWh)',
                        color: isDarkMode ? '#ffffff' : '#000000' // Y-axis title color
                    },
                    ticks: {
                        color: isDarkMode ? '#ffffff' : '#000000' // Y-axis tick color
                    },
                    grid: {
                        color: isDarkMode ? '#ffffff' : '#e0e0e0' // Y-axis grid line color
                    },
                    beginAtZero: true
                }
            }
        }
    });
}

// Listen for dark mode toggle and update the graph
document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            renderEnergyGraph();
        });
    }
});

// Initial render
renderEnergyGraph();