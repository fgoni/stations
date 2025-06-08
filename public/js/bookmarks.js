// Bookmark functionality
const BookmarkManager = {
    init() {
        this.bindEvents();
        this.initializeBookmarkStates();
    },

    bindEvents() {
        document.addEventListener('DOMContentLoaded', () => {
            if (window.location.pathname !== '/bookmarks') {
                this.initializeBookmarkStates();
            }
        });
    },

    initializeBookmarkStates() {
        const bookmarks = this.getBookmarks();
        document.querySelectorAll('.image-container').forEach(container => {
            const url = container.getAttribute('data-url');
            const button = container.querySelector('.bookmark-btn');
            if (bookmarks.some(b => b.url === url)) {
                button.classList.add('bookmarked');
            }
        });
    },

    getBookmarks() {
        return JSON.parse(localStorage.getItem('bookmarks') || '[]');
    },

    saveBookmarks(bookmarks) {
        localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
    },

    showToast(message, isBookmarked) {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
                background: "white",
                color: "black",
                border: "1px solid black",
            }
        }).showToast();
    },

    toggleBookmark(station, button) {
        const bookmarks = this.getBookmarks();
        const existingIndex = bookmarks.findIndex(b => b.url === station.url);
        
        if (existingIndex !== -1) {
            bookmarks.splice(existingIndex, 1);
            button.classList.remove('bookmarked');
            this.showToast('Station removed from bookmarks', false);
        } else {
            bookmarks.unshift(station);
            button.classList.add('bookmarked');
            this.showToast('Station added to bookmarks', true);
        }
        
        this.saveBookmarks(bookmarks);

        if (window.location.pathname === '/bookmarks') {
            const container = button.closest('.image-container');
            if (container) {
                container.remove();
                const bookmarksContainer = document.getElementById('bookmarks-container');
                if (bookmarksContainer && bookmarksContainer.children.length === 0) {
                    bookmarksContainer.innerHTML = '<p class="text-white text-center w-full">No bookmarked stations yet.</p>';
                }
            }
        }
    }
};

// Initialize bookmark manager
BookmarkManager.init();

// Export for use in other files
window.BookmarkManager = BookmarkManager; 