const blogs = [
    {
        title: "10 Ways to Reduce Your Carbon Footprint",
        description: "Learn practical tips to minimize your environmental impact.",
        link: "https://example.com/reduce-carbon-footprint"
    },
    {
        title: "Top 5 Green Energy Products in 2025",
        description: "Discover the best green energy products available this year.",
        link: "https://example.com/green-energy-products"
    },
    {
        title: "How Solar Panels Can Save You Money",
        description: "Explore the financial benefits of installing solar panels.",
        link: "https://example.com/solar-panels"
    },
    {
        title: "The Future of Electric Vehicles",
        description: "Find out how EVs are shaping the future of transportation.",
        link: "https://example.com/electric-vehicles"
    },
    {
        title: "Wind Turbines for Home Use",
        description: "Learn about small-scale wind turbines for residential areas.",
        link: "https://example.com/wind-turbines"
    }
];

function getRandomBlogs(count) {
    const shuffled = blogs.sort(() => 0.5 - Math.random());
    return shuffled.slice(0, count);
}

function renderRandomBlogs() {
    const container = document.getElementById('randomBlogContainer');
    container.innerHTML = '';

    const randomBlogs = getRandomBlogs(3); // Display 3 random blogs

    randomBlogs.forEach(blog => {
        const card = document.createElement('div');
        card.classList.add('random-blog-card');

        card.innerHTML = `
            <h3>${blog.title}</h3>
            <p>${blog.description}</p>
            <a href="${blog.link}" target="_blank">Read More</a>
        `;

        container.appendChild(card);
    });
}

// Render random blogs on page load
document.addEventListener('DOMContentLoaded', renderRandomBlogs);