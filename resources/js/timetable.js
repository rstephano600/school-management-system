/**
 * Timetable Management JavaScript
 * Handles interactive features, search, filtering, and mobile responsiveness
 */

class TimetableManager {
    constructor() {
        this.searchTimeout = null;
        this.currentFilters = {};
        this.isLoading = false;
        this.touchStartX = 0;
        this.touchStartY = 0;
        
        this.init();
    }
    
    init() {
        this.initializeTooltips();
        this.setupEventListeners();
        this.setupTouchGestures();
        this.setupKeyboardNavigation();
        this.setupAutoSave();
        this.handleResponsiveFeatures();
    }
    
    /**
     * Initialize Bootstrap tooltips
     */
    initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        this.tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover',
                delay: { show: 500, hide: 100 }
            });
        });
    }
    
    /**
     * Setup all event listeners
     */
    setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.performSearch(e.target.value);
                }, 300);
            });
        }
        
        // Filter form auto-submit
        const filterSelects = document.querySelectorAll('#filterForm select[name]');
        filterSelects.forEach(select => {
            select.addEventListener('change', () => {
                this.submitFilters();
            });
        });
        
        // Timetable item interactions
        document.addEventListener('click', (e) => {
            if (e.target.closest('.timetable-item')) {
                this.handleTimetableItemClick(e.target.closest('.timetable-item'));
            }
        });
        
        // Export modal
        const exportModal = document.getElementById('exportModal');
        if (exportModal) {
            exportModal.addEventListener('show.bs.modal', this.setupExportModal.bind(this));
        }
        
        // Print functionality
        const printBtn = document.querySelector('[onclick="window.print()"]');
        if (printBtn) {
            printBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handlePrint();
            });
        }
        
        // Responsive table scroll
        const tableContainer = document.querySelector('.table-responsive');
        if (tableContainer) {
            tableContainer.addEventListener('scroll', this.handleTableScroll.bind(this));
        }
        
        // Window resize handler
        window.addEventListener('resize', this.handleResize.bind(this));
    }
    
    /**
     * Setup touch gestures for mobile
     */
    setupTouchGestures() {
        const tableContainer = document.querySelector('.table-responsive');
        if (!tableContainer) return;
        
        tableContainer.addEventListener('touchstart', (e) => {
            this.touchStartX = e.touches[0].clientX;
            this.touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
        tableContainer.addEventListener('touchmove', (e) => {
            if (e.touches.length > 1) return; // Ignore multi-touch
            
            const touchX = e.touches[0].clientX;
            const touchY = e.touches[0].clientY;
            const deltaX = this.touchStartX - touchX;
            const deltaY = this.touchStartY - touchY;
            
            // If horizontal swipe is more prominent, prevent vertical scroll
            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                e.preventDefault();
            }
        }, { passive: false });
    }
    
    /**
     * Setup keyboard navigation
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            // Escape key to close modals or clear search
            if (e.key === 'Escape') {
                const searchInput = document.getElementById('searchInput');
                if (searchInput && searchInput.value) {
                    searchInput.value = '';
                    this.performSearch('');
                }
            }
            
            // Ctrl+P for print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                this.handlePrint();
            }
            
            // Ctrl+F for search
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.focus();
                }
            }
        });
    }
    
    /**
     * Setup auto-save for form states
     */
    setupAutoSave() {
        // Save filter states to localStorage
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            const inputs = filterForm.querySelectorAll('select, input');
            inputs.forEach(input => {
                // Load saved value
                const savedValue = localStorage.getItem(`timetable_${input.name}`);
                if (savedValue && input.type !== 'submit') {
                    input.value = savedValue;
                }
                
                // Save on change
                input.addEventListener('change', () => {
                    localStorage.setItem(`timetable_${input.name}`, input.value);
                });
            });
        }
    }
    
    /**
     * Handle responsive features
     */
    handleResponsiveFeatures() {
        this.updateMobileView();
        this.setupStickyHeaders();
    }
    
    /**
     * Perform search functionality
     */
    performSearch(query) {
        const table = document.getElementById('timetableTable');
        if (!table) return;
        
        const rows = table.querySelectorAll('tbody tr');
        const lowerQuery = query.toLowerCase();
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td:not(.time-slot)');
            let rowVisible = false;
            
            cells.forEach(cell => {
                const items = cell.querySelectorAll('.timetable-item');
                let cellHasVisibleItems = false;
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const isVisible = !query || text.includes(lowerQuery);
                    
                    item.style.display = isVisible ? '' : 'none';
                    if (isVisible) {
                        cellHasVisibleItems = true;
                        rowVisible = true;
                        this.highlightSearchTerm(item, query);
                    }
                });
            });
            
            row.style.display = rowVisible ? '' : 'none';
        });
        
        this.updateSearchResults(query);
    }
    
    /**
     * Highlight search terms
     */
    highlightSearchTerm(element, term) {
        if (!term) {
            // Remove existing highlights
            element.querySelectorAll('.search-highlight').forEach(span => {
                span.outerHTML = span.innerHTML;
            });
            return;
        }
        
        const regex = new RegExp(`(${term})`, 'gi');
        const walker = document.createTreeWalker(
            element,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );
        
        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }
        
        textNodes.forEach(textNode => {
            if (regex.test(textNode.textContent)) {
                const highlightedHTML = textNode.textContent.replace(regex, '<span class="search-highlight bg-warning">$1</span>');
                const wrapper = document.createElement('div');
                wrapper.innerHTML = highlightedHTML;
                
                while (wrapper.firstChild) {
                    textNode.parentNode.insertBefore(wrapper.firstChild, textNode);
                }
                textNode.remove();
            }
        });
    }
    
    /**
     * Update search results counter
     */
    updateSearchResults(query) {
        const visibleItems = document.querySelectorAll('.timetable-item:not([style*="display: none"])');
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput && query) {
            const resultsText = `${visibleItems.length} results found`;
            searchInput.setAttribute('title', resultsText);
            
            // Update placeholder or add results indicator
            if (visibleItems.length === 0) {
                this.showNoResults();
            } else {
                this.hideNoResults();
            }
        }
    }
    
    /**
     * Show no results message
     */
    showNoResults() {
        let noResultsDiv = document.getElementById('noResultsMessage');
        if (!noResultsDiv) {
            noResultsDiv = document.createElement('div');
            noResultsDiv.id = 'noResultsMessage';
            noResultsDiv.className = 'alert alert-info text-center my-3';
            noResultsDiv.innerHTML = `
                <i class="fas fa-search"></i>
                <p class="mb-0">No matching timetable entries found. Try adjusting your search or filters.</p>
            `;
            
            const tableContainer = document.querySelector('.table-responsive');
            tableContainer.parentNode.insertBefore(noResultsDiv, tableContainer.nextSibling);
        }
        noResultsDiv.style.display = 'block';
    }
    
    /**
     * Hide no results message
     */
    hideNoResults() {
        const noResultsDiv = document.getElementById('noResultsMessage');
        if (noResultsDiv) {
            noResultsDiv.style.display = 'none';
        }
    }
    
    /**
     * Submit filters
     */
    submitFilters() {
        const filterForm = document.getElementById('filterForm');
        if (filterForm && !this.isLoading) {
            this.isLoading = true;
            this.showLoadingState();
            filterForm.submit();
        }
    }
    
    /**
     * Handle timetable item click
     */
    handleTimetableItemClick(item) {
        // Toggle selection
        item.classList.toggle('selected');
        
        // Show details in a modal or sidebar
        this.showItemDetails(item);
    }
    
    /**
     * Show item details
     */
    showItemDetails(item) {
        const isClass = item.classList.contains('class-item');
        const title = item.querySelector('.fw-semibold, strong').textContent;
        
        // Create or update details modal
        let modal = document.getElementById('itemDetailsModal');
        if (!modal) {
            modal = this.createDetailsModal();
        }
        
        const modalTitle = modal.querySelector('.modal-title');
        const modalBody = modal.querySelector('.modal-body');
        
        modalTitle.textContent = title;
        modalBody.innerHTML = this.generateItemDetailsHTML(item, isClass);
        
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }
    
    /**
     * Create details modal
     */
    createDetailsModal() {
        const modal = document.createElement('div');
        modal.id = 'itemDetailsModal';
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        return modal;
    }
    
    /**
     * Generate item details HTML
     */
    generateItemDetailsHTML(item, isClass) {
        const details = this.extractItemDetails(item);
        
        let html = `<div class="row">`;
        
        if (isClass) {
            html += `
                <div class="col-md-6">
                    <strong>Subject:</strong> ${details.subject}<br>
                    <strong>Code:</strong> ${details.code}<br>
                    <strong>Teacher:</strong> ${details.teacher}<br>
                    <strong>Room:</strong> ${details.room}
                </div>
                <div class="col-md-6">
                    <strong>Grade:</strong> ${details.grade}<br>
                    <strong>Section:</strong> ${details.section}<br>
                    <strong>Duration:</strong> ${details.duration}<br>
                    <strong>Capacity:</strong> ${details.capacity}
                </div>
            `;
        } else {
            html += `
                <div class="col-12">
                    <strong>Activity:</strong> ${details.activity}<br>
                    <strong>Duration:</strong> ${details.duration}<br>
                    ${details.description ? `<strong>Description:</strong> ${details.description}` : ''}
                </div>
            `;
        }
        
        html += `</div>`;
        return html;
    }
    
    /**
     * Extract item details from DOM
     */
    extractItemDetails(item) {
        const details = {};
        
        details.subject = item.querySelector('.fw-semibold')?.textContent || '';
        details.code = item.querySelector('strong')?.textContent || '';
        details.duration = item.querySelector('.badge')?.textContent || '';
        
        const textElements = item.querySelectorAll('.text-muted');
        textElements.forEach(el => {
            const text = el.textContent.trim();
            if (text.includes('👤') || text.includes('fas fa-user')) {
                details.teacher = text.replace(/.*?(\w+.*)/, '$1');
            } else if (text.includes('🚪') || text.includes('fas fa-door')) {
                details.room = text.replace(/.*?(\w+.*)/, '$1');
            } else if (text.includes('👥') || text.includes('fas fa-users')) {
                const parts = text.replace(/.*?(\w+.*)/, '$1').split(' - ');
                details.grade = parts[0] || '';
                details.section = parts[1] || '';
            }
        });
        
        return details;
    }
    
    /**
     * Setup export modal
     */
    setupExportModal() {
        const form = document.querySelector('#exportModal form');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleExport(new FormData(form));
            });
        }
    }
    
    /**
     * Handle export functionality
     */
    handleExport(formData) {
        const format = formData.get('format');
        const includeClasses = formData.get('include_classes');
        const includeGeneral = formData.get('include_general');
        
        // Show loading state
        this.showExportProgress();
        
        // Submit export request
        fetch('/timetable/export', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `timetable_${new Date().toISOString().slice(0, 10)}.${format}`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Export failed:', error);
            this.showExportError();
        })
        .finally(() => {
            this.hideExportProgress();
        });
    }
    
    /**
     * Handle print functionality
     */
    handlePrint() {
        // Temporarily modify page for better printing
        document.body.classList.add('printing');
        
        // Hide unnecessary elements
        const elementsToHide = document.querySelectorAll('.btn, .modal, .card-header, .badge');
        elementsToHide.forEach(el => el.style.display = 'none');
        
        window.print();
        
        // Restore elements after print dialog
        setTimeout(() => {
            document.body.classList.remove('printing');
            elementsToHide.forEach(el => el.style.display = '');
        }, 1000);
    }
    
    /**
     * Handle table scroll for sticky elements
     */
    handleTableScroll(e) {
        const scrollLeft = e.target.scrollLeft;
        const timeColumn = document.querySelector('.time-slot');
        
        if (timeColumn) {
            timeColumn.style.transform = `translateX(${scrollLeft}px)`;
        }
    }
    
    /**
     * Handle window resize
     */
    handleResize() {
        this.updateMobileView();
        this.recalculateTooltips();
    }
    
    /**
     * Update mobile view
     */
    updateMobileView() {
        const isMobile = window.innerWidth < 768;
        const table = document.getElementById('timetableTable');
        
        if (table) {
            table.classList.toggle('mobile-view', isMobile);
        }
        
        // Adjust filter collapse behavior
        const filtersCollapse = document.getElementById('filtersCollapse');
        if (filtersCollapse && isMobile) {
            const collapse = bootstrap.Collapse.getInstance(filtersCollapse);
            if (collapse) {
                collapse.hide();
            }
        }
    }
    
    /**
     * Setup sticky headers
     */
    setupStickyHeaders() {
        const table = document.getElementById('timetableTable');
        if (!table) return;
        
        const thead = table.querySelector('thead');
        if (thead) {
            // Calculate and set sticky top position
            const navbar = document.querySelector('.navbar');
            const stickyTop = navbar ? navbar.offsetHeight : 0;
            thead.style.top = `${stickyTop}px`;
        }
    }
    
    /**
     * Show loading state
     */
    showLoadingState() {
        const table = document.querySelector('.table-responsive');
        if (table) {
            table.classList.add('timetable-loading');
        }
    }
    
    /**
     * Show export progress
     */
    showExportProgress() {
        const modal = document.getElementById('exportModal');
        const submitBtn = modal.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            submitBtn.disabled = true;
        }
    }
    
    /**
     * Hide export progress
     */
    hideExportProgress() {
        const modal = document.getElementById('exportModal');
        const submitBtn = modal.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = 'Export';
            submitBtn.disabled = false;
        }
    }
    
    /**
     * Show export error
     */
    showExportError() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.innerHTML = `
            <strong>Export Failed!</strong> Please try again or contact support.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const modal = document.getElementById('exportModal');
        const modalBody = modal.querySelector('.modal-body');
        modalBody.insertBefore(alert, modalBody.firstChild);
    }
    
    /**
     * Recalculate tooltips positions
     */
    recalculateTooltips() {
        if (this.tooltipList) {
            this.tooltipList.forEach(tooltip => {
                tooltip.update();
            });
        }
    }
    
    /**
     * Clean up resources
     */
    destroy() {
        if (this.tooltipList) {
            this.tooltipList.forEach(tooltip => tooltip.dispose());
        }
        
        clearTimeout(this.searchTimeout);
    }
}

// Initialize timetable manager when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.timetableManager = new TimetableManager();
});

// Legacy functions for backward compatibility
function searchTimetable() {
    if (window.timetableManager) {
        const searchInput = document.getElementById('searchInput');
        window.timetableManager.performSearch(searchInput ? searchInput.value : '');
    }
}