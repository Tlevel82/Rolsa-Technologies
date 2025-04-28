document.addEventListener('DOMContentLoaded', () => {
    // Extract data for the graph
    const rawLabels = carbonFootprintData.map(data => new Date(data.created_at));
    const rawPowerHeatingLightingData = carbonFootprintData.map(data => parseFloat(data.power_heating_lighting));
    const rawTransportData = carbonFootprintData.map(data => parseFloat(data.transport));
    const rawTotalCarbonFootprintData = carbonFootprintData.map(data => parseFloat(data.total_carbon_footprint));

    // Function to group data by timeframe
    function groupDataByTimeframe(timeframe) {
        const groupedData = {};
        const labels = [];
        const powerHeatingLightingData = [];
        const transportData = [];
        const totalCarbonFootprintData = [];

        rawLabels.forEach((date, index) => {
            let key;
            if (timeframe === 'daily') {
                key = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }); // Example: "Jan 1, 2025"
            } else if (timeframe === 'monthly') {
                key = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' }); // Example: "Jan 2025"
            } else if (timeframe === 'yearly') {
                key = date.getFullYear().toString(); // Example: "2025"
            }

            if (!groupedData[key]) {
                groupedData[key] = {
                    powerHeatingLighting: 0,
                    transport: 0,
                    totalCarbonFootprint: 0,
                    count: 0,
                };
                labels.push(key);
            }

            groupedData[key].powerHeatingLighting += rawPowerHeatingLightingData[index];
            groupedData[key].transport += rawTransportData[index];
            groupedData[key].totalCarbonFootprint += rawTotalCarbonFootprintData[index];
            groupedData[key].count += 1;
        });

        labels.forEach(label => {
            powerHeatingLightingData.push(groupedData[label].powerHeatingLighting / groupedData[label].count);
            transportData.push(groupedData[label].transport / groupedData[label].count);
            totalCarbonFootprintData.push(groupedData[label].totalCarbonFootprint / groupedData[label].count);
        });

        return { labels, powerHeatingLightingData, transportData, totalCarbonFootprintData };
    }

    // Initial graph rendering
    let currentTimeframe = 'daily';
    let chartInstance;

    function renderGraph(timeframe) {
        const { labels, powerHeatingLightingData, transportData, totalCarbonFootprintData } = groupDataByTimeframe(timeframe);

        if (chartInstance) {
            chartInstance.destroy(); // Destroy the previous chart instance
        }

        const ctx = document.getElementById('carbonFootprintGraph').getContext('2d');
        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Power, Heating, Lighting (kg CO2)',
                        data: powerHeatingLightingData,
                        borderColor: '#007BFF',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        fill: true,
                    },
                    {
                        label: 'Transport (kg CO2)',
                        data: transportData,
                        borderColor: '#28A745',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        fill: true,
                    },
                    {
                        label: 'Total Carbon Footprint (kg CO2)',
                        data: totalCarbonFootprintData,
                        borderColor: '#DC3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'kg CO2',
                        },
                    },
                },
            },
        });
    }

    // Render the initial graph
    renderGraph(currentTimeframe);

    // Handle timeframe selection
    document.getElementById('timeframe').addEventListener('change', (event) => {
        currentTimeframe = event.target.value;
        renderGraph(currentTimeframe);
    });
});