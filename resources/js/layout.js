document.addEventListener('DOMContentLoaded', function() {
    const layoutToggle = document.getElementById('layoutToggle');
    const contentContainer = document.querySelector('.content-container');
    const icon = layoutToggle.querySelector('i');
    
    // Get saved layout preference or default to 'grid'
    const savedLayout = localStorage.getItem('layoutPreference') || 'grid';
    
    // Set initial layout
    updateLayout(savedLayout);
    
    layoutToggle.addEventListener('click', function() {
        const currentLayout = contentContainer.classList.contains('grid-layout') ? 'grid' : 'column';
        const newLayout = currentLayout === 'grid' ? 'column' : 'grid';
        updateLayout(newLayout);
        localStorage.setItem('layoutPreference', newLayout);
    });
    
    function updateLayout(layout) {
        if (layout === 'grid') {
            contentContainer.classList.add('grid-layout');
            contentContainer.classList.remove('column-layout');
            icon.classList.remove('fa-list');
            icon.classList.add('fa-th-large');
        } else {
            contentContainer.classList.add('column-layout');
            contentContainer.classList.remove('grid-layout');
            icon.classList.remove('fa-th-large');
            icon.classList.add('fa-list');
        }
    }
}); 