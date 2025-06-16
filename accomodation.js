document.addEventListener('DOMContentLoaded', function () {

    // --- Kode Awal (Collapse Icons) ---
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        const targetSelector = button.getAttribute('data-bs-target');
        const target = document.querySelector(targetSelector);
        const icon = button.querySelector('i');

        if (!target || !icon) return;

        target.addEventListener('show.bs.collapse', () => {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        });

        target.addEventListener('hide.bs.collapse', () => {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        });
    });

    // --- Kode Click Card untuk Detail ---
    const cards = document.querySelectorAll('.accommodation-card');
    cards.forEach(function (card) {
        card.addEventListener('click', function (event) { // Tambahkan 'event' sebagai argumen
            const id = card.getAttribute('data-id');
            // Pastikan klik pada tombol admin tidak memicu redirect ke detail
            if (!event.target.closest('.admin-controls') && id) {
                window.location.href = `?c=accommodation&m=detail&id=${id}`;
            }
        });
    });

    // --- Definisi Objek AccommodationAdmin ---
    const AccommodationAdmin = {
        init: function() {
            this.setupAdminControls();
            this.setupConfirmations();
            this.showMessages();
            this.setupQuickActions();
        },

        setupAdminControls: function() {
            const accommodationCards = document.querySelectorAll('.accommodation-card');
            accommodationCards.forEach(card => {
                const adminControls = card.querySelector('.admin-controls');
                if (adminControls) {
                    card.addEventListener('mouseenter', () => {
                        adminControls.style.opacity = '1';
                    });
                    card.addEventListener('mouseleave', () => {
                        adminControls.style.opacity = '0';
                    });
                }
            });
        },

        setupConfirmations: function() {
            document.addEventListener('click', (e) => {
                if (e.target.closest('.btn-danger.admin-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.btn-danger.admin-btn');
                    const card = button.closest('.accommodation-card');
                    const accommodationId = card.dataset.id;
                    const accommodationName = card.querySelector('.card-subtitle').textContent;
                    this.confirmDelete(accommodationId, accommodationName);
                }
            });
            document.addEventListener('click', (e) => {
                // Pastikan selektor ini menangkap tombol toggle
                if (e.target.closest('.btn-secondary.admin-btn, .btn-success.admin-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.admin-btn');
                    const row = button.closest('tr') || button.closest('.accommodation-card'); // Cari tr (untuk manage) atau card (untuk index)
                    const accommodationId = row.dataset.id;
                    const isCurrentlyActive = !row.classList.contains('status-inactive'); // Periksa status dari class CSS
                    this.confirmToggleStatus(accommodationId, isCurrentlyActive);
                }
            });
        },

        confirmDelete: function(id, name) {
            const modal = this.createConfirmModal(
                'Delete Accommodation',
                `Are you sure you want to delete "<strong>${name}</strong>"?<br><small class="text-muted">This action cannot be undone.</small>`,
                'danger',
                'Delete',
                () => { window.location.href = `?c=admin&m=deleteAccommodation&id=${id}`; }
            );
            modal.show();
        },

        // Metode ini dipanggil oleh window.toggleStatus
        confirmToggleStatus: function(id, isCurrentlyActive) {
            const action = isCurrentlyActive ? 'nonaktifkan' : 'aktifkan'; 
            const actionText = isCurrentlyActive ? 'Nonaktifkan' : 'Aktifkan'; 
            const buttonType = isCurrentlyActive ? 'warning' : 'success'; 

            const modal = this.createConfirmModal(
                `${actionText} Akomodasi`,
                `Apakah Anda yakin ingin ${action} akomodasi ini?`,
                buttonType,
                actionText,
                () => { window.location.href = `?c=admin&m=toggleStatus&id=${id}`; }
            );
            modal.show();
        },

        createConfirmModal: function(title, message, type, confirmText, onConfirm) {
            const existingModal = document.getElementById('adminConfirmModal');
            if (existingModal) { existingModal.remove(); }
            const modalHtml = `
                <div class="modal fade" id="adminConfirmModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${title}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body"> ${message} </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-${type}" id="confirmAction">${confirmText}</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('adminConfirmModal'));
            document.getElementById('confirmAction').addEventListener('click', () => {
                modal.hide();
                onConfirm();
            });
            return modal;
        },

        showMessages: function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                const successType = urlParams.get('success');
                const messages = { /* ... messages ... */ 'created': 'Accommodation created successfully!', 'updated': 'Accommodation updated successfully!', 'deleted': 'Accommodation deleted successfully!', 'status_updated': 'Accommodation status updated successfully!'};
                this.showToast(messages[successType] || 'Operation completed successfully!', 'success');
            }
            if (urlParams.has('error')) {
                const errorType = urlParams.get('error');
                const errors = { /* ... errors ... */ 'failed': 'Operation failed! Please try again.', 'delete_failed': 'Failed to delete accommodation!', 'status_failed': 'Failed to update accommodation status!', 'notfound': 'Accommodation not found!', 'access_denied': 'Access denied! Admin privileges required.'};
                this.showToast(errors[errorType] || 'An error occurred!', 'error');
            }
        },

        showToast: function(message, type) { /* ... toast implementation ... */
            const existingToast = document.getElementById('adminToast');
            if (existingToast) { existingToast.remove(); }
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
            const toastHtml = `
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                    <div id="adminToast" class="toast show" role="alert">
                        <div class="toast-header ${bgClass} text-white">
                            <i class="bi bi-${icon} me-2"></i>
                            <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body"> ${message} </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            setTimeout(() => {
                const toast = document.getElementById('adminToast');
                if (toast) { new bootstrap.Toast(toast).hide(); }
            }, 5000);
        },

        setupQuickActions: function() { /* ... quick actions implementation ... */
            document.addEventListener('dblclick', (e) => {
                const card = e.target.closest('.accommodation-card');
                if (card && document.querySelector('.admin-panel')) {
                    const accommodationId = card.dataset.id;
                    window.location.href = `?c=admin&m=editAccommodation&id=${accommodationId}`;
                }
            });
            document.addEventListener('keydown', (e) => {
                if (!document.querySelector('.admin-panel')) return;
                if ((e.ctrlKey || e.metaKey) && e.key === 'n') { e.preventDefault(); window.location.href = '?c=admin&m=createAccommodation'; }
                if ((e.ctrlKey || e.metaKey) && e.key === 'm') { e.preventDefault(); window.location.href = '?c=admin&m=manageAccommodations'; }
            });
        },
        
        // --- Modifikasi setupLiveFilter: JANGAN membuat input baru ---
        setupLiveFilter: function() {
            // Ambil elemen input yang SUDAH ADA di HTML
            const searchInput = document.getElementById('adminQuickSearch');
            
            if (searchInput) { // Pastikan input ditemukan sebelum menambahkan event listener
                searchInput.addEventListener('input', (e) => {
                    const searchTerm = e.target.value.toLowerCase();
                    const cards = document.querySelectorAll('.accommodation-card'); // Ini mungkin perlu disesuaikan jika di halaman manage

                    cards.forEach(card => {
                        const nameElement = card.querySelector('.card-subtitle'); // Untuk index page
                        const locationElement = card.querySelector('.card-text'); // Untuk index page
                        
                        // Periksa apakah ini kartu di index page atau baris di manage page
                        let name = '';
                        let location = '';

                        if (nameElement) { // Ini adalah card dari index page
                            name = nameElement.textContent.toLowerCase();
                            location = locationElement ? locationElement.textContent.toLowerCase() : '';
                        } else { // Asumsi ini baris di manage_accommodations.php
                            // Anda mungkin perlu selektor yang lebih spesifik untuk nama dan lokasi di tabel
                            const rowNameCol = card.querySelector('td:nth-child(2)'); // Nama & Tipe
                            const rowLocationCol = card.querySelector('td:nth-child(3)'); // Lokasi

                            if (rowNameCol) {
                                name = rowNameCol.textContent.toLowerCase();
                            }
                            if (rowLocationCol) {
                                location = rowLocationCol.textContent.toLowerCase();
                            }
                        }
                        
                        if (name.includes(searchTerm) || location.includes(searchTerm)) {
                            card.style.display = ''; // Tampilkan kartu/baris
                        } else {
                            card.style.display = 'none'; // Sembunyikan kartu/baris
                        }
                    });
                });
            }
        },
        // ... (setupBulkActions, jika ada, di sini juga) ...
    }; // End of AccommodationAdmin object

    // --- Inisialisasi AccommodationAdmin (Hanya sekali!) ---
    const adminPanelElement = document.querySelector('.admin-panel'); 
    if (adminPanelElement) {
        AccommodationAdmin.init(); 
        // setupLiveFilter sudah dipanggil di init(), jadi tidak perlu lagi di sini
        // AccommodationAdmin.setupLiveFilter(); // <--- Hapus baris ini
    }

    // --- Fungsi Global (wrapper untuk AccommodationAdmin) ---
    // Pastikan ini ada di lingkup global atau di 'window' agar bisa diakses dari HTML onclick
    window.toggleStatus = function(id) {
        // Ambil status dari DOM, baik di card (index) atau row (manage)
        const element = event.target.closest('.accommodation-card') || event.target.closest('tr');
        const isCurrentlyActive = element ? !element.classList.contains('status-inactive') : true; // Default aktif jika tidak ditemukan

        if (typeof AccommodationAdmin !== 'undefined') {
            AccommodationAdmin.confirmToggleStatus(id, isCurrentlyActive);
        } else {
            console.warn("AccommodationAdmin not defined. Fallback to native confirm.");
            if (confirm(`Apakah Anda yakin ingin ${isCurrentlyActive ? 'nonaktifkan' : 'aktifkan'} akomodasi ini?`)) {
                window.location.href = `?c=admin&m=toggleStatus&id=${id}`;
            }
        }
    };

    window.confirmDelete = function(id, name) {
        if (typeof AccommodationAdmin !== 'undefined') {
            AccommodationAdmin.confirmDelete(id, name);
        } else {
            console.warn("AccommodationAdmin not defined. Fallback to native confirm.");
            if (confirm(`Apakah Anda yakin ingin menghapus akomodasi "${name}"?`)) {
                window.location.href = `?c=admin&m=deleteAccommodation&id=${id}`;
            }
        }
    };

    // --- Bagian PENTING untuk filter otomatis "Show Inactive" (Dipindahkan ke dalam listener utama) ---
    const showInactiveCheckbox = document.getElementById('showInactive');
    const filterForm = showInactiveCheckbox ? showInactiveCheckbox.closest('form') : null;

    if (showInactiveCheckbox && filterForm) {
        showInactiveCheckbox.addEventListener('change', function() {
            console.log('Checkbox "Show Inactive" changed. Submitting form automatically...');
            console.log('Form action:', filterForm.action);
            filterForm.submit();
        });
    }
    // --- Akhir Bagian PENTING ---

    // Export untuk CommonJS jika diperlukan (biarkan di paling bawah)
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = AccommodationAdmin;
    }

}); // <--- Ini adalah penutup UNTUK SATU-SATUNYA DOMContentLoaded listener
