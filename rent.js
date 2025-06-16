document.addEventListener("DOMContentLoaded", function () {
    const cariMobilBtn = document.getElementById("cariMobilBtn");
    const kotaInput = document.getElementById("kota");
    const tanggalMulaiInput = document.getElementById("tanggalMulai");
    const waktuMulaiInput = document.getElementById("waktuMulai");
    const tanggalSelesaiInput = document.getElementById("tanggalSelesai");
    const waktuSelesaiInput = document.getElementById("waktuSelesai");

    const currentRentalTypeSpan = document.getElementById("currentRentalType");
    const currentLocationSpan = document.getElementById("currentLocation");
    const currentDatesSpan = document.getElementById("currentDates");

    const vehicleListContainer = document.getElementById("vehicle-list");
    const filterCollapseElement = document.getElementById('filterCollapse');
    const filterCollapseInstance = new bootstrap.Collapse(filterCollapseElement, { toggle: false });

    function updateSearchSummary() {
        const rentalTypeLabel = "Rental ";
        const kota = kotaInput.options[kotaInput.selectedIndex].text;
        const tanggalMulai = new Date(tanggalMulaiInput.value).toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
        const waktuMulai = waktuMulaiInput.value;
        const tanggalSelesai = new Date(tanggalSelesaiInput.value).toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
        const waktuSelesai = waktuSelesaiInput.value;

        currentRentalTypeSpan.innerText = rentalTypeLabel;
        currentLocationSpan.innerText = kota;
        currentDatesSpan.innerText = `${tanggalMulai}, ${waktuMulai} - ${tanggalSelesai}, ${waktuSelesai}`;
    }

    updateSearchSummary();

    cariMobilBtn.addEventListener("click", function () {
        const kota = kotaInput.value;
        const tanggalMulai = tanggalMulaiInput.value;
        const waktuMulai = waktuMulaiInput.value;
        const tanggalSelesai = tanggalSelesaiInput.value;
        const waktuSelesai = waktuSelesaiInput.value;

        vehicleListContainer.innerHTML = `<div class="d-flex justify-content-center my-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

        if (!kota || !tanggalMulai || !waktuMulai || !tanggalSelesai || !waktuSelesai) {
            vehicleListContainer.innerHTML = `
                <div class="alert alert-warning text-center" role="alert">
                    Semua filter harus diisi!
                </div>
            `;
            return;
        }

        updateSearchSummary();
        filterCollapseInstance.hide();

        fetch("index.php?c=vehicle&m=filterVehicles", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                kota,
                tanggalMulai,
                waktuMulai,
                tanggalSelesai,
                waktuSelesai
            }),
        })
            .then((res) => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then((data) => {
                vehicleListContainer.innerHTML = ""; // Kosongkan lagi setelah fetch berhasil

                if (data.error || data.length === 0) {
                    const errorMessage = data.error || "Tidak ada kendaraan ditemukan.";
                    vehicleListContainer.innerHTML = `
                        <div class="alert alert-info text-center" role="alert">
                            ${errorMessage}
                        </div>
                    `;
                    return;
                }

                const filterParams = new URLSearchParams({
                    kota: kota,
                    tanggalMulai: tanggalMulai,
                    waktuMulai: waktuMulai,
                    tanggalSelesai: tanggalSelesai,
                    waktuSelesai: waktuSelesai
                }).toString();

        data.forEach((item) => {
            const formattedHarga = new Intl.NumberFormat('id-ID').format(item.harga_per_hari);
            const imageUrl = item.gambar_url ?? 'style/assets/default.png';
            const sewaUrl = `?c=vehicle&m=sewa&id=${item.id_vehicle}&${filterParams}`;

            vehicleListContainer.innerHTML += `
                <div class="list-group-item list-group-item-action mb-3 p-3">
                    <div class="row g-3 align-items-center">

                        <div class="col-md-8" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal${item.id_vehicle}">
                            <div class="d-flex align-items-center">
                                <img src="${imageUrl}" alt="${item.merk}" class="img-fluid rounded" style="width: 120px; height: 80px; object-fit: cover;">
                                <div class="ms-3">
                                    <h5 class="mb-1">${item.merk}</h5>
                                    <small class="text-muted">${item.detail_kendaraan || 'Detail tidak tersedia'}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-md-end">
                            <p class="mb-2">Mulai dari<br><strong class="fs-5 text-primary">IDR ${formattedHarga}</strong>/hari</p>
                            <a href="${sewaUrl}" class="btn btn-primary w-50 w-md-auto">Sewa Sekarang</a>
                        </div>

                    </div>
                </div>

                <div class="modal fade" id="modal${item.id_vehicle}" tabindex="-1" aria-labelledby="modalLabel${item.id_vehicle}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${item.merk}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Detail lebih lanjut tentang ${item.merk}...</p>
                                <ul>
                                    <li>Jenis Kendaraan: ${item.jenis_kendaraan || '-'}</li>
                                    <li>Merk: ${item.merk || '-'}</li>
                                    <li>Detail: ${item.detail_kendaraan || '-'}</li>
                                    <li>Kota: ${item.kota || '-'}</li>
                                    <li>Harga: IDR ${formattedHarga}/hari</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
            }) 
            .catch((err) => {
                console.error("Fetch error:", err);
                vehicleListContainer.innerHTML = `
                    <div class="alert alert-danger text-center" role="alert">
                        Gagal mengambil data kendaraan. Silakan coba lagi nanti. Error: ${err.message}
                    </div>
                `;
            });
    });

    filterCollapseElement.addEventListener('shown.bs.collapse', function () {
        console.log('Filter collapse is shown');
    });

    filterCollapseElement.addEventListener('hidden.bs.collapse', function () {
        console.log('Filter collapse is hidden');
    });
});
