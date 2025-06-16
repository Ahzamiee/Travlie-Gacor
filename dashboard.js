document.addEventListener('DOMContentLoaded', function() {

    // --- LOGIKA UNTUK PROMO DINAMIS ---
    const filterButtons = document.querySelectorAll('.promo-filter-btn');
    const displayArea = document.getElementById('promo-display-area');

    function loadPromos(category) {
        if (!displayArea) return; // Jangan jalankan jika elemen tidak ada di halaman
        displayArea.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        fetch(`?c=promo&m=fetchDefaultPromos&category=${category}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response for promos was not ok');
                return response.json();
            })
            .then(promos => {
                displayArea.innerHTML = '';
                if (promos.length === 0) {
                    displayArea.innerHTML = '<div class="col-12"><p class="text-muted">Tidak ada promo untuk kategori ini.</p></div>';
                    return;
                }
                promos.forEach(promo => {
                    const promoCard = `
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">${promo.title}</h6>
                                    <p class="card-text small text-muted">${promo.description}</p>
                                    <span class="badge bg-primary">${promo.category}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    displayArea.innerHTML += promoCard;
                });
            })
            .catch(error => {
                console.error('Error fetching promos:', error);
                displayArea.innerHTML = '<div class="col-12"><p class="text-danger">Gagal memuat promo.</p></div>';
            });
    }

    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.dataset.category;
                loadPromos(category);
            });
        });
        loadPromos('All'); // Muat promo saat halaman dibuka
    }

    // --- LOGIKA UNTUK AKOMODASI DINAMIS ---
    const accommodationArea = document.getElementById('dashboard-accommodation-list');

    if (accommodationArea) {
        accommodationArea.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"></div></div>';

        fetch('?c=accommodation&m=fetchActiveForDashboard')
            .then(response => {
                if (!response.ok) throw new Error('Network response for accommodations was not ok');
                return response.json();
            })
            .then(accommodations => {
                accommodationArea.innerHTML = '';
                if (accommodations.length === 0) {
                    accommodationArea.innerHTML = '<div class="col-12"><p class="text-muted">Saat ini tidak ada akomodasi yang tersedia.</p></div>';
                    return;
                }
                accommodations.forEach(item => {
                    const safeName = item.nama_akomodasi || 'Nama Tidak Tersedia';
                    const safeCity = item.kota || 'Lokasi Tidak Tersedia';
                    const safeImg = item.url_gambar_utama || 'https://placehold.co/600x400?text=Image';
                    
                    const accommodationCard = `
                        <div class="col">
                            <a href="?c=accommodation&m=detail&id=${item.id_akomodasi}" class="text-decoration-none text-dark">
                                <div class="card h-100">
                                    <img src="${safeImg}" class="card-img-top" alt="${safeName}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title">${safeName}</h6>
                                        <p class="card-text small text-muted">
                                            <i class="bi bi-geo-alt-fill"></i> ${safeCity}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                    accommodationArea.innerHTML += accommodationCard;
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data akomodasi:', error);
                accommodationArea.innerHTML = '<div class="col-12"><p class="text-danger">Gagal memuat daftar akomodasi.</p></div>';
            });
    }
});
