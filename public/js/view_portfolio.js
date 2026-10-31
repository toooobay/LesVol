document.addEventListener('DOMContentLoaded', function() {
    const portfolioContainer = document.getElementById('portfolio-list');
    let cardsHTML = '';

    for (let i = 1; i <= 9; i++) {
        cardsHTML += `
            <div class="portfolio-card">
                <div class="portfolio-img-placeholder"></div>
                
                <div class="portfolio-details">
                    <h3 class="portfolio-name">Nama Aktivitas ${i}</h3>
                    <p class="portfolio-meta">Date: 19-05-2026</p>
                    <p class="portfolio-contribution">
                        <strong>Contribution:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
            </div>
        `;
    }

    portfolioContainer.innerHTML = cardsHTML;
});