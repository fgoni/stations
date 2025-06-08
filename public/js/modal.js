// Modal functionality for help icon
document.addEventListener('DOMContentLoaded', function() {
    const helpIcon = document.getElementById('help-icon');
    const helpModal = document.getElementById('help-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');

    if (helpIcon && helpModal && closeModalBtn) {
        helpIcon.addEventListener('click', function() {
            helpModal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', function() {
            helpModal.classList.add('hidden');
        });

        helpModal.addEventListener('click', function(event) {
            // Close modal if clicking outside the modal content
            if (event.target === helpModal) {
                helpModal.classList.add('hidden');
            }
        });
    }
}); 