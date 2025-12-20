import "./bootstrap";
import Chart from 'chart.js/auto';

window.Chart = Chart;

// Smooth scroll for anchor links
document.addEventListener("DOMContentLoaded", () => {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            const href = link.getAttribute("href");

            // Skip if href is just "#"
            if (href === "#") return;

            const target = document.querySelector(href);

            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
});

// Global utility: Format date to French locale
window.formatDateFr = (dateString) => {
    if (!dateString) return "";

    const date = new Date(dateString);

    // Check for invalid date
    if (isNaN(date.getTime())) return dateString;

    return date.toLocaleDateString("fr-FR", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

// Global utility: Format number to French locale
window.formatNumber = (number, decimals = 1) => {
    if (number === null || number === undefined) return "";

    const num = parseFloat(number);

    // Check for invalid number
    if (isNaN(num)) return number;

    return new Intl.NumberFormat("fr-FR", {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
    }).format(num);
};
