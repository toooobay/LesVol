// document.addEventListener('DOMContentLoaded', function() {
//     const portfolioContainer = document.getElementById('portfolio-list');
//     let cardsHTML = '';

//     for (let i = 1; i <= 9; i++) {
//         cardsHTML += `
//             <div class="portfolio-card">
//                 <div class="portfolio-img-placeholder"></div>
                
//                 <div class="portfolio-details">
//                     <h3 class="portfolio-name">Nama Aktivitas ${i}</h3>
//                     <p class="portfolio-meta">Date: 19-05-2026</p>
//                     <p class="portfolio-contribution">
//                         <strong>Contribution:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
//                     </p>
//                 </div>
                
//                 <div class="portfolio-actions-wrapper">
//                     <button class="three-dots-btn" onclick="togglePortfolioDropdown(event, 'drop-${i}')">
//                         <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
//                             <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
//                         </svg>
//                     </button>
                    
//                     <div id="drop-${i}" class="dropdown-menu portfolio-dropdown">
//                         <a href="edit-portfolio" class="dropdown-item flex-row" style="gap: 10px;">
//                             <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
//                             Edit Portfolio
//                         </a>
//                         <a href="#" class="dropdown-item flex-row" style="gap: 10px;">
//                             <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
//                             Delete Portfolio
//                         </a>
//                     </div>
//                 </div>
//             </div>
//         `;
//     }

//     portfolioContainer.innerHTML = cardsHTML;
// });

// function togglePortfolioDropdown(event, dropdownId) {
//     event.stopPropagation();
    
//     const allDropdowns = document.querySelectorAll('.portfolio-dropdown');
//     allDropdowns.forEach(dropdown => {
//         if (dropdown.id !== dropdownId) {
//             dropdown.classList.remove('open');
//         }
//     });

//     const currentDropdown = document.getElementById(dropdownId);
//     currentDropdown.classList.toggle('open');
// }

// document.addEventListener('click', function() {
//     const allDropdowns = document.querySelectorAll('.portfolio-dropdown');
//     allDropdowns.forEach(dropdown => {
//         dropdown.classList.remove('open');
//     });
// });