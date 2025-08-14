@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>    
    </div>
    <div class="row">
        <!-- Card Jumlah Penduduk -->
        <div class="col-xl-3 col-md-6 mb-4"> {{-- Ubah col-md-4 menjadi col-xl-3 untuk 4 kolom di layar besar --}}
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Jumlah Penduduk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalResidents) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4"> {{-- Kolom baru --}}
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pengurus
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalOfficials) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i> {{-- Icon Pengurus --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4"> {{-- Kolom baru --}}
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Foto Galeri
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalGalleryPhotos) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-image fa-2x text-gray-300"></i> {{-- Icon Gambar --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4"> {{-- Kolom baru --}}
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jumlah UMKM
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalUmkms) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i> {{-- Icon Toko --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Produksi Pertanian --}}
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Produksi Pertanian (Ton) per Komoditi</h6>
                    <div class="dropdown no-arrow">
                        <form action="{{ route('pages.dashboard') }}" method="GET" class="d-flex align-items-center">
                            <label for="tahun_produksi" class="me-2 text-muted small">Filter Tahun:</label>
                            <select name="tahun_produksi" id="tahun_produksi" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach ($availableYearsProduksi as $year)
                                    <option value="{{ $year }}" {{ $selectedYearProduksi == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="produksiPertanianBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labelsProduksi = @json($labelsProduksi);
        const valuesProduksi = @json($valuesProduksi);

        console.log('Labels Produksi (dari PHP):', labelsProduksi); // Debugging
        console.log('Values Produksi (dari PHP):', valuesProduksi); // Debugging

        const ctxProduksi = document.getElementById("produksiPertanianBarChart");
        if (ctxProduksi) {
            new Chart(ctxProduksi, {
                type: 'bar',
                data: {
                    labels: labelsProduksi,
                    datasets: [{
                        label: "Produksi",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: valuesProduksi,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: { left: 10, right: 25, top: 25, bottom: 0 }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: { display: false, drawBorder: false },
                            ticks: { maxTicksLimit: labelsProduksi.length > 0 ? labelsProduksi.length : 1 },
                            maxBarThickness: 25,
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5,
                                padding: 10,
                                callback: function(value, index, values) {
                                    // Pastikan pemformatan sumbu Y benar
                                    return number_format_display(value) + ' Ton';
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
                    legend: { display: false },
                    tooltips: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                // --- TAMBAHKAN DEBUGGING INI ---
                                console.log('TooltipItem:', tooltipItem);
                                console.log('tooltipItem.yLabel:', tooltipItem.yLabel);
                                // --- AKHIR DEBUGGING ---

                                // Pastikan chart.data dan chart.data.labels ada
                                if (chart.data && chart.data.labels && chart.data.labels[tooltipItem.index] !== undefined) {
                                    var label = chart.data.labels[tooltipItem.index] || '';
                                    var value = tooltipItem.yLabel; // Nilai produksi
                                    return label + ': ' + number_format_display(value) + ' Ton';
                                }
                                return '';
                            }
                        }
                    },
                }
            });
        }
        
        // Helper function for number formatting (pastikan ini ada dan berfungsi)
        function number_format_display(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    });
</script>
@endpush