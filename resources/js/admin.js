// Admin Panel Utilities
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
    const sidebar = document.querySelector('[data-sidebar]');
    
    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    }

    // Dropdown menus
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        const menuId = button.getAttribute('data-dropdown-toggle');
        const menu = document.getElementById(menuId);
        
        if (menu) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('[data-dropdown-menu]').forEach(menu => {
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    });

    // Flash messages
    const flashMessage = document.querySelector('[data-flash-message]');
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.style.opacity = '0';
            setTimeout(() => {
                flashMessage.remove();
            }, 300);
        }, 3000);
    }
});

// Confirmation dialogs
window.confirmAction = function(message, callback) {
    if (confirm(message)) {
        callback();
    }
};

// Form helpers
window.resetForm = function(formId) {
    document.getElementById(formId).reset();
};

// Dynamic table sorting
window.sortTable = function(columnIndex, tableId) {
    const table = document.getElementById(tableId);
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const headers = table.querySelectorAll('th');
    const currentHeader = headers[columnIndex];
    const isAscending = currentHeader.classList.contains('sort-asc');

    // Reset all headers
    headers.forEach(header => {
        header.classList.remove('sort-asc', 'sort-desc');
    });

    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent;
        const bValue = b.cells[columnIndex].textContent;
        return isAscending ? 
            bValue.localeCompare(aValue) : 
            aValue.localeCompare(bValue);
    });

    // Update header state
    currentHeader.classList.toggle('sort-asc', !isAscending);
    currentHeader.classList.toggle('sort-desc', isAscending);

    // Reorder rows
    const tbody = table.querySelector('tbody');
    rows.forEach(row => tbody.appendChild(row));
};
