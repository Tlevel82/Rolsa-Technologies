const products = [
    {
        title: "Solar Panels",
        description: "High-efficiency solar panels for your home.",
        link: "https://example.com/solar-panels",
        views: 1200
    },
    {
        title: "Wind Turbines",
        description: "Small-scale wind turbines for residential use.",
        link: "https://example.com/wind-turbines",
        views: 800
    },
    {
        title: "Energy-Efficient Appliances",
        description: "Reduce energy consumption with these appliances.",
        link: "https://example.com/energy-efficient-appliances",
        views: 1500
    },
    {
        title: "Carbon Footprint Calculator",
        description: "Calculate and reduce your carbon footprint.",
        link: "https://example.com/carbon-footprint-calculator",
        views: 500
    },
    {
        title: "Electric Vehicles",
        description: "Explore the latest electric vehicles on the market.",
        link: "https://example.com/electric-vehicles",
        views: 2000
    }
];

function renderResults(filteredProducts) {
    const resultsContainer = document.getElementById('resultsContainer');
    resultsContainer.innerHTML = '';

    filteredProducts.forEach(product => {
        const card = document.createElement('div');
        card.classList.add('result-card');

        card.innerHTML = `
            <h3>${product.title}</h3>
            <p>${product.description}</p>
            <a href="${product.link}" target="_blank">Learn More</a>
        `;

        resultsContainer.appendChild(card);
    });
}

function filterContent() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const filterSelect = document.getElementById('filterSelect').value;

    let filteredProducts = products.filter(product =>
        product.title.toLowerCase().includes(searchInput) ||
        product.description.toLowerCase().includes(searchInput)
    );

    if (filterSelect === 'most-viewed') {
        filteredProducts.sort((a, b) => b.views - a.views);
    } else if (filterSelect === 'least-viewed') {
        filteredProducts.sort((a, b) => a.views - b.views);
    }

    renderResults(filteredProducts);
}

// Initial render
document.addEventListener('DOMContentLoaded', () => {
    renderResults(products);
});