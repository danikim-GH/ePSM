// Toggle row details in table
function toggleRowDetails(kursusId) {
    const detailsRow = document.getElementById('details-' + kursusId);
    const button = event.currentTarget;
    
    if (detailsRow.classList.contains('active')) {
        // Close current row
        detailsRow.classList.remove('active');
        button.innerHTML = '<i class="fas fa-info-circle"></i>';
    } else {
        // Close all other open rows
        document.querySelectorAll('.row-details.active').forEach(row => {
            row.classList.remove('active');
        });
        
        // Reset all buttons
        document.querySelectorAll('.btn-detail-table').forEach(btn => {
            btn.innerHTML = '<i class="fas fa-info-circle"></i>';
        });
        
        // Open current row
        detailsRow.classList.add('active');
        button.innerHTML = '<i class="fas fa-times-circle"></i>';
    }
}

// Smooth scroll to top
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.querySelector('.back-to-top');
    
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});

// Auto-submit search form on select change with debounce
let debounceTimer;
document.querySelectorAll('.filter-select').forEach(select => {
    select.addEventListener('change', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            this.form.submit();
        }, 300);
    });
});

// Add loading animation to search button
document.querySelector('.filter-form')?.addEventListener('submit', function() {
    const submitBtn = this.querySelector('.btn-search');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
        submitBtn.disabled = true;
    }
});

// Highlight search terms in table results
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('search');
    
    if (searchTerm && searchTerm.trim() !== '') {
        highlightSearchTerms(searchTerm);
    }
});

function highlightSearchTerms(searchTerm) {
    const terms = searchTerm.toLowerCase().split(' ').filter(term => term.length > 2);
    
    document.querySelectorAll('.td-tajuk strong, .td-tajuk .text-muted, .badge-kategori, td').forEach(element => {
        let text = element.textContent;
        let highlighted = text;
        
        terms.forEach(term => {
            const regex = new RegExp(`(${escapeRegex(term)})`, 'gi');
            highlighted = highlighted.replace(regex, '<mark style="background-color: #fef08a; padding: 2px 4px; border-radius: 3px;">$1</mark>');
        });
        
        if (highlighted !== text) {
            element.innerHTML = highlighted;
        }
    });
}

function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Add row animation on page load
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    entry.target.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }, 50);
                
                observer.unobserve(entry.target);
            }, index * 50);
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.table-row').forEach(row => {
        observer.observe(row);
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.querySelector('.search-input')?.focus();
    }
    
    // Escape to clear search or close details
    if (e.key === 'Escape') {
        const searchInput = document.querySelector('.search-input');
        if (searchInput && document.activeElement === searchInput) {
            searchInput.value = '';
        } else {
            // Close all open details
            document.querySelectorAll('.row-details.active').forEach(row => {
                row.classList.remove('active');
            });
            document.querySelectorAll('.btn-detail-table').forEach(btn => {
                btn.innerHTML = '<i class="fas fa-info-circle"></i>';
            });
        }
    }
});

// Print table functionality
function printTable() {
    // Open all details before printing
    document.querySelectorAll('.row-details').forEach(row => {
        row.classList.add('active');
    });
    
    window.print();
    
    // Close all details after printing
    setTimeout(() => {
        document.querySelectorAll('.row-details').forEach(row => {
            row.classList.remove('active');
        });
    }, 1000);
}

// Add export and print buttons (optional - can be added to blade)
document.addEventListener('DOMContentLoaded', function() {
    // You can add export/print buttons dynamically here if needed
    const tableWrapper = document.querySelector('.table-wrapper');
    if (tableWrapper && document.querySelectorAll('.table-row').length > 0) {
        // Optional: Add action buttons
    }
});

// Double-click row to expand details
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.table-row').forEach(row => {
        row.addEventListener('dblclick', function() {
            const button = this.querySelector('.btn-detail-table');
            if (button) {
                button.click();
            }
        });
    });
});

// Mobile table scroll indicator
document.addEventListener('DOMContentLoaded', function() {
    const tableResponsive = document.querySelector('.table-responsive');
    
    if (tableResponsive) {
        function checkScroll() {
            const isScrollable = tableResponsive.scrollWidth > tableResponsive.clientWidth;
            const isAtEnd = tableResponsive.scrollLeft + tableResponsive.clientWidth >= tableResponsive.scrollWidth - 10;
            
            if (isScrollable && !isAtEnd) {
                tableResponsive.style.boxShadow = 'inset -10px 0 10px -10px rgba(0,0,0,0.2)';
            } else {
                tableResponsive.style.boxShadow = 'none';
            }
        }
        
        tableResponsive.addEventListener('scroll', checkScroll);
        window.addEventListener('resize', checkScroll);
        checkScroll();
    }
});