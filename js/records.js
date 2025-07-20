function toggleDetails(el) {
    const detailsRow = el.closest('tr').nextElementSibling;
    const detailsDiv = detailsRow.querySelector('.details');
    const isVisible = detailsDiv.style.display === 'block';

    detailsDiv.style.display = isVisible ? 'none' : 'block';
    el.innerHTML = isVisible ? '&#x25BC;' : '&#x25B2;'; // down / up arrow
}