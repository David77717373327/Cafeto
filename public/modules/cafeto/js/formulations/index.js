// Debounce function to limit frequent calls
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Initialize AOS and DataTables
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({ once: true });
    const dataTableOptions = {
        pageLength: 25, // Default number of entries
        lengthMenu: [10, 25, 50, 100], // Options for entries per page
        order: [[2, 'desc']],
        language: '{{ session('lang') }}' === 'es' ? language_datatables : {},
        dom: 'lfrtip', // Ensure length menu is included in the layout
    };
    $('#tableFormulations').DataTable(dataTableOptions);

    // Initialize tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    // SweetAlert2 for delete confirmation
    window.handleDelete = (event, message) => {
        event.preventDefault();
        const form = event.target.closest('form');
        Swal.fire({
            title: '{{ trans('cafeto::formulations.Title_Confirm_Delete') }}',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ trans('cafeto::formulations.Btn_Confirm') }}',
            cancelButtonText: '{{ trans('cafeto::formulations.Btn_Cancel') }}',
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                Swal.fire(
                    '{{ trans('cafeto::formulations.Title_Cancelled') }}',
                    '{{ trans('cafeto::formulations.Text_Cancelled') }}',
                    'info'
                );
            }
        });
        return false;
    };

    // Display success/error messages
    const successMessage = "{{ session('success') }}";
    const errorMessage = "{{ session('error') }}";
    if (successMessage) {
        Swal.fire('{{ trans('cafeto::formulations.Title_Success') }}', successMessage, 'success');
    }
    if (errorMessage) {
        Swal.fire('{{ trans('cafeto::formulations.Title_Error') }}', errorMessage, 'error');
    }
});

// Toggle details row in table
function toggleDetails(row, id) {
    const detailsRow = document.getElementById(`details-${id}`);
    detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
}

// Toggle mobile details
function toggleMobileDetails(id) {
    const details = document.getElementById(`mobile-details-${id}`);
    details.style.display = details.style.display === 'none' ? 'block' : 'none';
}

// Filter table with debouncing
const filterTable = () => {
    const elementFilter = document.getElementById('filter-element').value.toLowerCase();
    const statusFilter = document.getElementById('filter-status').value.toLowerCase();
    const dateFilter = document.getElementById('filter-date').value;
    const rows = document.querySelectorAll('#tableFormulations tbody tr.table-row');
    const mobileCards = document.querySelectorAll('.mobile-card');

    rows.forEach(row => {
        const element = row.cells[0].textContent.toLowerCase();
        const status = row.cells[3].textContent.toLowerCase();
        const date = row.cells[2].textContent;
        const show = (!elementFilter || element.includes(elementFilter)) &&
                     (!statusFilter || status.includes(statusFilter)) &&
                     (!dateFilter || date.includes(dateFilter));
        row.style.display = show ? '' : 'none';
        document.getElementById(`details-${row.cells[4].querySelector('a').href.split('/').pop()}`).style.display = 'none';
    });

    mobileCards.forEach(card => {
        const element = card.querySelector('h6').textContent.toLowerCase();
        const status = card.querySelector('.status-badge').textContent.toLowerCase();
        const date = card.querySelector('p:nth-child(2)').textContent.split(': ')[1];
        const show = (!elementFilter || element.includes(elementFilter)) &&
                     (!statusFilter || status.includes(statusFilter)) &&
                     (!dateFilter || date.includes(dateFilter));
        card.style.display = show ? 'block' : 'none';
        card.querySelector('.mobile-details').style.display = 'none';
    });
};

const debouncedFilterTable = debounce(filterTable, 300);

// Export table as CSV or PDF
function exportTable(format) {
    try {
        const table = document.getElementById('tableFormulations');
        const rows = table.querySelectorAll('tr.table-row');
        if (format === 'csv') {
            let csv = 'Element,Amount,Date,Status\n';
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                csv += `"${cells[0].textContent}",${cells[1].textContent},${cells[2].textContent},${cells[3].textContent}\n`;
            });
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'formulations.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        } else if (format === 'pdf') {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text('Formulations List', 10, 10);
            doc.setFontSize(12);
            let y = 20;
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                doc.text(`Element: ${cells[0].textContent}`, 10, y);
                doc.text(`Amount: ${cells[1].textContent}`, 60, y);
                doc.text(`Date: ${cells[2].textContent}`, 90, y);
                doc.text(`Status: ${cells[3].textContent}`, 130, y);
                y += 10;
            });
            doc.save('formulations.pdf');
        }
    } catch (error) {
        Swal.fire('Error', 'Failed to export the table. Please try again.', 'error');
    }
}