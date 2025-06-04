/**
 * Skrip JavaScript untuk Dashboard Inventaris
 * 
 * File ini berisi fungsi-fungsi untuk inisialisasi dan konfigurasi chart
 * serta komponen interaktif lainnya pada dashboard
 */

// Tunggu sampai dokumen sepenuhnya dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Chart Status Peminjaman
    initStatusPeminjamanChart();
    
    // Inisialisasi Chart Distribusi Kategori
    initKategoriDistribusiChart();
    
    // Inisialisasi dropdown dan event listener lainnya
    initDropdowns();
    
    // Inisialisasi filter tanggal
    initDateRangeFilter();
});

/**
 * Inisialisasi Chart Status Peminjaman (Line Chart)
 */
function initStatusPeminjamanChart() {
    const ctx = document.getElementById('statusPeminjamanChart');
    
    // Periksa apakah elemen canvas ada
    if (!ctx) return;
    
    // Contoh data - dalam implementasi nyata, ini harus diambil dari controller
    const chartLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
    const peminjamanData = [5, 10, 8, 15, 12, 9, 11, 14, 16, 12, 10, 8];
    const pengembalianData = [3, 8, 7, 12, 10, 8, 9, 12, 14, 11, 9, 7];
    
    const statusPeminjamanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: "Peminjaman",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: peminjamanData,
                },
                {
                    label: "Pengembalian",
                    lineTension: 0.3,
                    backgroundColor: "rgba(28, 200, 138, 0.05)",
                    borderColor: "rgba(28, 200, 138, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(28, 200, 138, 1)",
                    pointBorderColor: "rgba(28, 200, 138, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                    pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: pengembalianData,
                }
            ],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        beginAtZero: true,
                        callback: function(value) {
                            return value;
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: true,
                position: 'top'
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        const datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + tooltipItem.yLabel;
                    }
                }
            }
        }
    });
    
    // Tambahkan event listener untuk dropdown filter
    document.querySelectorAll('#dropdownMenuLink + .dropdown-menu .dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const filterType = this.textContent.trim();
            updateStatusPeminjamanChart(statusPeminjamanChart, filterType);
        });
    });
}

/**
 * Update data chart status peminjaman berdasarkan filter
 * @param {Chart} chart - Objek chart yang akan diupdate
 * @param {string} filterType - Tipe filter (Minggu Ini, Bulan Ini, Tahun Ini)
 */
function updateStatusPeminjamanChart(chart, filterType) {
    // Contoh data dummy untuk berbagai filter
    let newLabels = [];
    let newPeminjamanData = [];
    let newPengembalianData = [];
    
    switch(filterType) {
        case 'Minggu Ini':
            newLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            newPeminjamanData = [2, 3, 1, 4, 2, 0, 1];
            newPengembalianData = [1, 2, 1, 3, 1, 0, 0];
            break;
            
        case 'Bulan Ini':
            newLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
            newPeminjamanData = [8, 12, 6, 10];
            newPengembalianData = [6, 10, 5, 8];
            break;
            
        case 'Tahun Ini':
            newLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
            newPeminjamanData = [5, 10, 8, 15, 12, 9, 11, 14, 16, 12, 10, 8];
            newPengembalianData = [3, 8, 7, 12, 10, 8, 9, 12, 14, 11, 9, 7];
            break;
    }
    
    // Update chart dengan data baru
    chart.data.labels = newLabels;
    chart.data.datasets[0].data = newPeminjamanData;
    chart.data.datasets[1].data = newPengembalianData;
    chart.update();
    
    // Update judul dropdown
    const dropdownButton = document.querySelector('#dropdownMenuLink');
    if (dropdownButton) {
        dropdownButton.innerHTML = `<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>`;
    }
}

/**
 * Inisialisasi Chart Distribusi Kategori (Donut Chart)
 */
function initKategoriDistribusiChart() {
    const ctxPie = document.getElementById('kategoriDistribusiChart');
    
    // Periksa apakah elemen canvas ada
    if (!ctxPie) return;
    
    // Data kategori
    const kategoriLabels = ['Elektronik', 'Furnitur', 'Alat Tulis', 'Peralatan', 'Lainnya'];
    const kategoriData = [35, 25, 20, 15, 5];
    const backgroundColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
    const hoverBackgroundColors = ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617'];
    
    const kategoriDistribusiChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: kategoriLabels,
            datasets: [{
                data: kategoriData,
                backgroundColor: backgroundColors,
                hoverBackgroundColor: hoverBackgroundColors,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        const dataset = data.datasets[tooltipItem.datasetIndex];
                        const total = dataset.data.reduce((previousValue, currentValue) => previousValue + currentValue);
                        const currentValue = dataset.data[tooltipItem.index];
                        const percentage = Math.round((currentValue/total) * 100);
                        return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                    }
                }
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
            animation: {
                animateRotate: true,
                animateScale: true
            }
        },
    });
    
    // Update legenda manual
    updateKategoriLegend(kategoriLabels, backgroundColors);
}

/**
 * Update legenda kategori manual di bawah chart donut
 */
function updateKategoriLegend(labels, colors) {
    const legendContainer = document.querySelector('.mt-4.text-center.small');
    if (!legendContainer) return;
    
    // Hapus legenda yang ada
    legendContainer.innerHTML = '';
    
    // Buat legenda baru
    labels.forEach((label, index) => {
        const legendItem = document.createElement('span');
        legendItem.className = 'mr-2';
        legendItem.innerHTML = `<i class="fas fa-circle" style="color: ${colors[index]}"></i> ${label}`;
        legendContainer.appendChild(legendItem);
    });
}

/**
 * Inisialisasi dropdown dan event listener lainnya
 */
function initDropdowns() {
    // Inisialisasi semua dropdown Bootstrap
    const dropdownElements = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    
    // Cek jika Bootstrap sudah dimuat
    if (typeof bootstrap !== 'undefined') {
        dropdownElements.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
    }
    
    // Event listener untuk tombol "Generate Laporan"
    const generateReportBtn = document.querySelector('a.btn-primary i.fa-download').parentElement;
    if (generateReportBtn) {
        generateReportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            generateReport();
        });
    }
    
    // Event listener untuk tombol "Lihat Semua" pada tabel peminjaman
    const viewAllBtn = document.querySelector('.card-body a.btn-primary');
    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', function(e) {
            // Implementasi link diatur di template Blade
        });
    }
}

/**
 * Inisialisasi filter tanggal
 */
function initDateRangeFilter() {
    // Implementasi filter tanggal jika diperlukan
    // Misalnya, menggunakan DateRangePicker atau plugin serupa
}

/**
 * Fungsi untuk menghasilkan laporan
 */
function generateReport() {
    // Menampilkan indikator loading
    showLoading();
    
    // Simulasi fetch data untuk laporan (dalam implementasi nyata, ini akan berupa AJAX request)
    setTimeout(() => {
        hideLoading();
        
        // Tampilkan modal atau redirect ke halaman laporan
        showReportModal();
    }, 1500);
}

/**
 * Menampilkan indikator loading
 */
function showLoading() {
    // Cek apakah elemen loading sudah ada
    let loadingEl = document.getElementById('loading-indicator');
    
    if (!loadingEl) {
        // Buat elemen loading
        loadingEl = document.createElement('div');
        loadingEl.id = 'loading-indicator';
        loadingEl.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center';
        loadingEl.style.backgroundColor = 'rgba(0,0,0,0.5)';
        loadingEl.style.zIndex = '9999';
        
        loadingEl.innerHTML = `
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
        
        document.body.appendChild(loadingEl);
    } else {
        loadingEl.style.display = 'flex';
    }
}

/**
 * Menyembunyikan indikator loading
 */
function hideLoading() {
    const loadingEl = document.getElementById('loading-indicator');
    if (loadingEl) {
        loadingEl.style.display = 'none';
    }
}

/**
 * Menampilkan modal laporan
 */
function showReportModal() {
    // Cek apakah elemen modal sudah ada
    let modalEl = document.getElementById('reportModal');
    
    if (!modalEl) {
        // Buat modal
        modalEl = document.createElement('div');
        modalEl.id = 'reportModal';
        modalEl.className = 'modal fade';
        modalEl.tabIndex = '-1';
        modalEl.setAttribute('aria-labelledby', 'reportModalLabel');
        modalEl.setAttribute('aria-hidden', 'true');
        
        modalEl.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Laporan Inventaris</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3">
                            <i class="fas fa-file-pdf fa-3x text-danger"></i>
                        </div>
                        <p class="text-center">Laporan berhasil dibuat!</p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" id="downloadReportBtn">
                                <i class="fas fa-download me-2"></i> Download PDF
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="emailReportBtn">
                                <i class="fas fa-envelope me-2"></i> Kirim via Email
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modalEl);
        
        // Tambahkan event listener untuk tombol download
        document.getElementById('downloadReportBtn').addEventListener('click', function() {
            // Simulasi download
            alert('Laporan sedang diunduh...');
            
            // Tutup modal setelah download
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
        
        // Tambahkan event listener untuk tombol email
        document.getElementById('emailReportBtn').addEventListener('click', function() {
            // Simulasi pengiriman email
            alert('Laporan akan dikirim via email...');
            
            // Tutup modal setelah email
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    }
    
    // Tampilkan modal
    if (typeof bootstrap !== 'undefined') {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } else {
        console.error('Bootstrap tidak dimuat. Modal tidak dapat ditampilkan.');
    }

    // Atau alternatif jika jQuery tersedia
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.modal !== 'undefined') {
        jQuery(modalEl).modal('show');
    }
}

/**
 * Fungsi untuk menginisialisasi progress bar
 */
function initProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const value = parseInt(bar.getAttribute('aria-valuenow'));
        const max = parseInt(bar.getAttribute('aria-valuemax'));
        const percentage = (value / max) * 100;
        
        // Atur warna berdasarkan persentase
        if (percentage < 20) {
            bar.classList.remove('bg-danger');
            bar.classList.add('bg-danger');
        } else if (percentage < 50) {
            bar.classList.remove('bg-danger');
            bar.classList.add('bg-warning');
        } else {
            bar.classList.remove('bg-danger');
            bar.classList.add('bg-success');
        }
        
        // Animasi progress bar
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease';
            bar.style.width = percentage + '%';
        }, 200);
    });
}

// Inisialisasi semua progress bar
initProgressBars();

/**
 * Fungsi untuk memperbarui data kartu summary
 * @param {Object} data - Data terbaru untuk kartu summary
 */
function updateSummaryCards(data) {
    // Update Total Barang
    const totalBarangEl = document.querySelector('.text-primary.text-uppercase').nextElementSibling;
    if (totalBarangEl && data.totalBarang !== undefined) {
        totalBarangEl.textContent = data.totalBarang;
    }
    
    // Update Total Kategori
    const totalKategoriEl = document.querySelector('.text-success.text-uppercase').nextElementSibling;
    if (totalKategoriEl && data.totalKategori !== undefined) {
        totalKategoriEl.textContent = data.totalKategori;
    }
    
    // Update Total Peminjaman
    const totalPeminjamanEl = document.querySelector('.text-info.text-uppercase').nextElementSibling;
    if (totalPeminjamanEl && data.totalPeminjaman !== undefined) {
        totalPeminjamanEl.textContent = data.totalPeminjaman;
    }
    
    // Update Total Pengembalian
    const totalPengembalianEl = document.querySelector('.text-warning.text-uppercase').nextElementSibling;
    if (totalPengembalianEl && data.totalPengembalian !== undefined) {
        totalPengembalianEl.textContent = data.totalPengembalian;
    }
}

/**
 * Fungsi untuk memuat data dashboard dari server
 */
function loadDashboardData() {
    // Simulasi AJAX request
    // Dalam implementasi nyata, ini akan menjadi fetch atau AJAX request ke server
    
    // Tampilkan loading
    showLoading();
    
    // Simulasi delay network
    setTimeout(() => {
        // Data dummy
        const dashboardData = {
            totalBarang: 120,
            totalKategori: 8,
            totalPeminjaman: 45,
            totalPengembalian: 32,
            chartData: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                peminjaman: [5, 10, 8, 15, 12, 9, 11, 14, 16, 12, 10, 8],
                pengembalian: [3, 8, 7, 12, 10, 8, 9, 12, 14, 11, 9, 7]
            },
            kategoriData: {
                labels: ['Elektronik', 'Furnitur', 'Alat Tulis', 'Peralatan', 'Lainnya'],
                data: [35, 25, 20, 15, 5]
            }
        };
        
        // Update UI dengan data baru
        updateSummaryCards(dashboardData);
        
        // Sembunyikan loading
        hideLoading();
    }, 1000);
}

// Fungsi inisialisasi utama
function init() {
    // Inisialisasi semua komponen
    initStatusPeminjamanChart();
    initKategoriDistribusiChart();
    initDropdowns();
    initDateRangeFilter();
    initProgressBars();
    
    // Muat data dashboard
    loadDashboardData();
}

// Mulai inisialisasi ketika halaman dimuat
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}