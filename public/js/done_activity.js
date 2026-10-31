const grid3 = document.getElementById('done-grid');

for (let i = 0; i < 9; i++) {
    let badgeHTML = '';
    if (i < 2) {
        badgeHTML = `<div class="status-badge badge-alert">!</div>`;
    } else {
        badgeHTML = `<div class="status-badge badge-success">✓</div>`;
    }

    const locationPinSVG = `
        <svg style="width: 1.2em; height: 1.2em; vertical-align: middle; margin-right: 4px;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1-2.5-2.5A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9A2.5 2.5 0 0 1 12 11.5z"/>
        </svg>`;

    const calendarSVG = `
        <svg style="width: 1.1em; height: 1.1em; vertical-align: middle; margin-right: 4px;" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/>
        </svg>`;

    grid3.innerHTML += `
    <div class="activity-card">
        <div class="activity-card-img" style="background:#c8bfb0;">
            ${badgeHTML} </div>
        <div class="activity-card-body">
            <h4>nama aktivitas</h4>
            <div class="activity-meta">
                ${locationPinSVG} lokasi aktivitas
            </div>
            <div class="activity-meta">
                ${calendarSVG} dd/mm/yy
            </div>
            <div class="activity-card-actions">
                <a class="btn-see-more" href="/see-details-done">Details ▶</a>
            </div>
        </div>
    </div>`;
}