@extends('layouts.admin')

@section('title', 'Peta Sebaran')
@section('page-title', 'Peta Sebaran Pendaftar')
@section('page-subtitle', 'Visualisasi geografis lokasi domisili calon siswa')

@section('content')

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1 text-gray-900">Peta Lokasi Pendaftar</h5>
                        <p class="text-sm text-gray-600 mb-0">Sebaran geografis berdasarkan alamat domisili</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" onclick="map.setView([-6.9175, 107.6191], 12)">
                            <i class="fas fa-crosshairs me-1"></i> Reset View
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="fitAllMarkers()">
                            <i class="fas fa-expand-arrows-alt me-1"></i> Lihat Semua
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="toggleFullscreen()">
                            <i class="fas fa-expand me-1"></i> Fullscreen
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 600px; width: 100%; border-radius: 0 0 16px 16px;"></div>
            </div>
        </div>
    </div>

<style>
.text-gray-900 { color: #111827; }
.text-gray-600 { color: #4b5563; }
.text-sm { font-size: 0.875rem; }
</style>
    
    <div class="col-lg-4">
        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-primary text-white rounded-3 p-2 me-3">
                        <i class="fas fa-filter"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0 text-gray-900">Filter Peta</h6>
                        <small class="text-gray-600">Saring data berdasarkan kriteria</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium text-gray-700">Jurusan</label>
                    <select class="form-select border-0 shadow-sm" id="filterJurusan" onchange="filterMarkers()">
                        <option value="">Semua Jurusan</option>
                        @foreach($stats['per_jurusan'] ?? [] as $jurusan => $count)
                        <option value="{{ $jurusan }}">{{ $jurusan }} ({{ $count }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium text-gray-700">Status</label>
                    <select class="form-select border-0 shadow-sm" id="filterStatus" onchange="filterMarkers()">
                        <option value="">Semua Status</option>
                        @foreach($stats['per_status'] ?? [] as $status => $count)
                        <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }} ({{ $count }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-grid">
                    <button class="btn btn-outline-secondary" onclick="resetFilters()">
                        <i class="fas fa-undo me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
</style>
        
        <!-- Statistics Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-success text-white rounded-3 p-2 me-3">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0 text-gray-900">Statistik Sebaran</h6>
                        <small class="text-gray-600">Ringkasan data geografis</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="text-center p-3 bg-primary bg-opacity-10 rounded-3">
                            <div class="h5 fw-bold text-primary mb-0">{{ $stats['total_pendaftar'] ?? 0 }}</div>
                            <small class="text-gray-600 fw-medium">Total</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-3 bg-success bg-opacity-10 rounded-3">
                            <div class="h5 fw-bold text-success mb-0">{{ $pendaftarans->whereNotNull('latitude')->whereNotNull('longitude')->count() }}</div>
                            <small class="text-gray-600 fw-medium">Dengan Lokasi</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-3 bg-warning bg-opacity-10 rounded-3">
                            <div class="h5 fw-bold text-warning mb-0">{{ $pendaftarans->filter(function($p) { return is_null($p->latitude) || is_null($p->longitude); })->count() }}</div>
                            <small class="text-gray-600 fw-medium">Tanpa Lokasi</small>
                        </div>
                    </div>
                </div>

<style>
.bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
</style>
                
                <div class="border-top pt-3">
                    <h6 class="fw-semibold mb-3 text-gray-900">Per Jurusan</h6>
                    @foreach($stats['per_jurusan'] ?? [] as $jurusan => $count)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-gray-700 fw-medium small">{{ $jurusan }}</span>
                            <span class="badge bg-primary">{{ $count }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-gradient-primary" style="width: {{ ($count / ($stats['total_pendaftar'] ?: 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="border-top pt-3">
                    <h6 class="fw-semibold mb-3 text-gray-900">Top Kecamatan</h6>
                    @foreach($stats['per_kecamatan'] ?? [] as $kecamatan => $count)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light bg-opacity-50 rounded">
                        <span class="text-gray-700 fw-medium small">{{ $kecamatan }}</span>
                        <span class="badge bg-success">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Pendaftar Tanpa Koordinat -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-warning text-white rounded-3 p-2 me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0 text-gray-900">Tanpa Koordinat</h6>
                        <small class="text-gray-600">Pendaftar yang belum memiliki data lokasi</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div style="max-height: 300px; overflow-y: auto;">
                    @php
                        $tanpaKoordinat = $pendaftarans->filter(function($p) {
                            return is_null($p->latitude) || is_null($p->longitude);
                        })->take(10);
                    @endphp
                    @forelse($tanpaKoordinat as $pendaftaran)
                    <div class="d-flex align-items-center p-3 border-bottom border-light">
                        <div class="bg-gradient-warning text-white rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; font-size: 0.75rem; font-weight: 600;">
                            {{ strtoupper(substr($pendaftaran->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-gray-900">{{ $pendaftaran->nama_lengkap }}</div>
                            <small class="text-gray-600"><i class="fas fa-map-marker-alt me-1"></i>{{ $pendaftaran->kecamatan ?? 'Tidak ada' }}, {{ $pendaftaran->kelurahan ?? 'Tidak ada' }}</small>
                            <div class="small text-muted mt-1"><i class="fas fa-info-circle me-1"></i>Koordinat: {{ $pendaftaran->latitude ?? 'null' }}, {{ $pendaftaran->longitude ?? 'null' }}</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info mb-1">{{ $pendaftaran->jurusan->nama }}</span>
                            <div>
                                <span class="badge bg-warning">
                                    <i class="fas fa-map-marker-alt me-1"></i>Perlu Koordinat
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                            <i class="fas fa-check text-success fs-4"></i>
                        </div>
                        <p class="text-success fw-semibold mb-0">Semua pendaftar sudah memiliki koordinat!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-info text-white rounded-3 p-2 me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-gray-900">Pendaftar Terbaru</h6>
                        <small class="text-gray-600">10 pendaftar terakhir dengan lokasi</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div style="max-height: 300px; overflow-y: auto;">
                    @php
                        $denganKoordinat = $pendaftarans->filter(function($p) {
                            return !is_null($p->latitude) && !is_null($p->longitude);
                        })->sortByDesc('created_at')->take(10);
                    @endphp
                    @forelse($denganKoordinat as $pendaftaran)
                    <div class="d-flex align-items-center p-3 border-bottom border-light">
                        <div class="bg-gradient-primary text-white rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-size: 0.8rem; font-weight: 700;">
                            {{ strtoupper(substr($pendaftaran->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-gray-900">{{ $pendaftaran->nama_lengkap }}</div>
                            <small class="text-gray-600"><i class="fas fa-map-marker-alt me-1"></i>{{ $pendaftaran->kecamatan }}, {{ $pendaftaran->kelurahan }}</small>
                            <div class="small text-success mt-1"><i class="fas fa-map me-1"></i>{{ number_format($pendaftaran->latitude, 4) }}, {{ number_format($pendaftaran->longitude, 4) }}</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info mb-1">{{ $pendaftaran->jurusan->nama }}</span>
                            <div>
                                <span class="badge bg-{{ $pendaftaran->status == 'lulus' ? 'success' : ($pendaftaran->status == 'tidak_lulus' ? 'danger' : 'warning') }}">
                                    {{ ucfirst(str_replace('_', ' ', $pendaftaran->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                            <i class="fas fa-map-marker-alt text-warning fs-4"></i>
                        </div>
                        <p class="text-warning fw-semibold mb-0">Belum ada pendaftar dengan koordinat!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

<style>
.bg-gradient-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
</style>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
.leaflet-popup-content {
    margin: 8px 12px;
    line-height: 1.4;
    max-width: 300px;
}
.leaflet-popup-content h6 {
    margin-bottom: 8px;
    color: #1e293b;
}
.leaflet-popup-content .btn {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
.info {
    font-size: 12px;
    font-family: 'Inter', sans-serif;
}
.search-control {
    font-family: 'Inter', sans-serif;
}
.custom-marker {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}
.leaflet-control-layers {
    font-family: 'Inter', sans-serif;
}

@media (max-width: 768px) {
    .leaflet-control-container .leaflet-top.leaflet-left,
    .leaflet-control-container .leaflet-top.leaflet-right,
    .leaflet-control-container .leaflet-bottom.leaflet-left,
    .leaflet-control-container .leaflet-bottom.leaflet-right {
        z-index: 500 !important;
    }
    
    .leaflet-control {
        z-index: 500 !important;
    }
}
</style>
<script>
// Initialize map centered on Bandung
var map = L.map('map').setView([-6.9175, 107.6191], 12);

// Add multiple map layers for better accuracy
var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 19
});

var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: '© Esri, Maxar, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community',
    maxZoom: 19
});

var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team',
    maxZoom: 19
});

// Add default layer
osmLayer.addTo(map);

// Layer control
var baseMaps = {
    "Peta Standar": osmLayer,
    "Satelit": satelliteLayer,
    "Jalan Detail": streetLayer
};
L.control.layers(baseMaps).addTo(map);

// Define colors for different jurusan
var jurusanColors = {
    'PPLG': '#2563eb',
    'Akuntansi': '#f59e0b', 
    'Animasi': '#dc2626',
    'DKV': '#7c3aed',
    'BDP': '#059669',
    'Manajemen': '#10b981',
    'Teknik Informatika': '#3b82f6',
    'Multimedia': '#8b5cf6'
};

// Status colors
var statusColors = {
    'lulus': '#10b981',
    'tidak_lulus': '#ef4444',
    'menunggu': '#f59e0b',
    'draft': '#6b7280',
    'dikirim': '#3b82f6',
    'terbayar': '#059669'
};

// Add markers for each pendaftar
var pendaftarans = @json($pendaftarans);
var allMarkers = [];
var markersLayer = L.layerGroup().addTo(map);

function createMarkers() {
    pendaftarans.forEach(function(pendaftaran) {
        if (pendaftaran.latitude && pendaftaran.longitude) {
            var jurusanColor = jurusanColors[pendaftaran.jurusan.nama] || '#64748b';
            var statusColor = statusColors[pendaftaran.status] || '#6b7280';
            
            var marker = L.circleMarker([pendaftaran.latitude, pendaftaran.longitude], {
                radius: 8,
                fillColor: jurusanColor,
                color: statusColor,
                weight: 2,
                opacity: 1,
                fillOpacity: 0.8,
                className: 'custom-marker'
            });
            
            marker.bindPopup(`
                <div class="p-3" style="min-width: 250px;">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 0.7rem;">
                            ${pendaftaran.nama_lengkap.substring(0, 2).toUpperCase()}
                        </div>
                        <h6 class="fw-bold mb-0">${pendaftaran.nama_lengkap}</h6>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">No. Pendaftaran:</small><br>
                        <strong>${pendaftaran.nomor_pendaftaran || '-'}</strong>
                    </div>
                    <div class="mb-2">
                        <span class="badge" style="background-color: ${jurusanColor}">${pendaftaran.jurusan.nama}</span>
                        <span class="badge ms-1" style="background-color: ${statusColor}">${pendaftaran.status.replace('_', ' ').toUpperCase()}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>Alamat Lengkap:</small><br>
                        <strong>${pendaftaran.alamat || 'Tidak ada'}</strong><br>
                        <small>Kel. ${pendaftaran.kelurahan || 'Tidak ada'}, Kec. ${pendaftaran.kecamatan || 'Tidak ada'}</small>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted"><i class="fas fa-crosshairs me-1"></i>Koordinat:</small><br>
                        <code style="font-size: 0.7rem;">${pendaftaran.latitude}, ${pendaftaran.longitude}</code>
                    </div>
                    <div class="d-flex gap-1 mt-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="zoomToLocation(${pendaftaran.latitude}, ${pendaftaran.longitude})">
                            <i class="fas fa-search-plus"></i> Zoom
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="openInGoogleMaps(${pendaftaran.latitude}, ${pendaftaran.longitude})">
                            <i class="fas fa-external-link-alt"></i> Google Maps
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2"><i class="fas fa-calendar me-1"></i>${new Date(pendaftaran.created_at).toLocaleDateString('id-ID')}</small>
                </div>
            `);
            
            // Store additional data for filtering
            marker.pendaftaranData = pendaftaran;
            allMarkers.push(marker);
        }
    });
    
    // Add all markers to layer
    allMarkers.forEach(marker => markersLayer.addLayer(marker));
}

createMarkers();

// Fit map to show all markers
if (allMarkers.length > 0) {
    var group = new L.featureGroup(allMarkers);
    map.fitBounds(group.getBounds().pad(0.1));
}

// Filter functions
function filterMarkers() {
    var selectedJurusan = document.getElementById('filterJurusan').value;
    var selectedStatus = document.getElementById('filterStatus').value;
    
    markersLayer.clearLayers();
    
    var filteredMarkers = allMarkers.filter(function(marker) {
        var data = marker.pendaftaranData;
        var jurusanMatch = !selectedJurusan || data.jurusan.nama === selectedJurusan;
        var statusMatch = !selectedStatus || data.status === selectedStatus;
        return jurusanMatch && statusMatch;
    });
    
    filteredMarkers.forEach(marker => markersLayer.addLayer(marker));
    
    // Update map bounds if there are filtered markers
    if (filteredMarkers.length > 0) {
        var group = new L.featureGroup(filteredMarkers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
    
    // Update counter
    updateCounter(filteredMarkers.length);
}

function resetFilters() {
    document.getElementById('filterJurusan').value = '';
    document.getElementById('filterStatus').value = '';
    
    markersLayer.clearLayers();
    allMarkers.forEach(marker => markersLayer.addLayer(marker));
    
    if (allMarkers.length > 0) {
        var group = new L.featureGroup(allMarkers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
    
    updateCounter(allMarkers.length);
}

function updateCounter(count) {
    // Update info control with current count
    const infoDiv = document.querySelector('.info');
    if (infoDiv) {
        infoDiv.innerHTML = `
            <div style="font-size: 14px;">
                <strong><i class="fas fa-map-marker-alt me-1 text-primary"></i>Menampilkan: ${count} pendaftar</strong><br>
                <small class="text-muted">Zoom: Level ${map.getZoom()}</small>
            </div>
        `;
    }
}

window.fitAllMarkers = function() {
    if (allMarkers.length > 0) {
        var group = new L.featureGroup(allMarkers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
};

window.toggleFullscreen = function() {
    const mapContainer = document.getElementById('map');
    if (!document.fullscreenElement) {
        mapContainer.requestFullscreen().then(() => {
            setTimeout(() => map.invalidateSize(), 100);
        });
    } else {
        document.exitFullscreen().then(() => {
            setTimeout(() => map.invalidateSize(), 100);
        });
    }
};

// Add legend
var legend = L.control({position: 'bottomright'});
legend.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'info legend');
    div.style.backgroundColor = 'white';
    div.style.padding = '10px';
    div.style.borderRadius = '8px';
    div.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
    div.style.fontSize = '12px';
    div.style.maxWidth = '200px';
    div.style.zIndex = '400';
    
    div.innerHTML = '<h6 class="fw-bold mb-2" style="font-size: 14px;">Legenda</h6>';
    
    // Jurusan legend
    div.innerHTML += '<div class="mb-2"><strong>Jurusan (Fill):</strong></div>';
    Object.keys(jurusanColors).forEach(function(jurusan) {
        var count = pendaftarans.filter(p => p.jurusan.nama === jurusan).length;
        if (count > 0) {
            div.innerHTML += `
                <div class="d-flex align-items-center mb-1">
                    <div style="width: 12px; height: 12px; background-color: ${jurusanColors[jurusan]}; border-radius: 50%; margin-right: 8px;"></div>
                    <small>${jurusan} (${count})</small>
                </div>
            `;
        }
    });
    
    // Status legend
    div.innerHTML += '<div class="mt-2 mb-2"><strong>Status (Border):</strong></div>';
    Object.keys(statusColors).forEach(function(status) {
        var count = pendaftarans.filter(p => p.status === status).length;
        if (count > 0) {
            div.innerHTML += `
                <div class="d-flex align-items-center mb-1">
                    <div style="width: 12px; height: 12px; border: 2px solid ${statusColors[status]}; border-radius: 50%; margin-right: 8px;"></div>
                    <small>${status.replace('_', ' ').toUpperCase()} (${count})</small>
                </div>
            `;
        }
    });
    
    return div;
};
legend.addTo(map);

// Add enhanced map controls
var info = L.control({position: 'topleft'});
info.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'info');
    div.style.backgroundColor = 'white';
    div.style.padding = '10px 15px';
    div.style.borderRadius = '8px';
    div.style.boxShadow = '0 4px 8px rgba(0,0,0,0.15)';
    div.style.border = '1px solid #e2e8f0';
    div.style.zIndex = '400';
    div.innerHTML = `
        <div style="font-size: 14px;">
            <strong><i class="fas fa-map-marker-alt me-1 text-primary"></i>Total: ${allMarkers.length} pendaftar</strong><br>
            <small class="text-muted">Zoom: Level ${map.getZoom()}</small>
        </div>
    `;
    return div;
};
info.addTo(map);

// Update zoom level in info control
map.on('zoomend', function() {
    document.querySelector('.info').innerHTML = `
        <div style="font-size: 14px;">
            <strong><i class="fas fa-map-marker-alt me-1 text-primary"></i>Total: ${allMarkers.length} pendaftar</strong><br>
            <small class="text-muted">Zoom: Level ${map.getZoom()}</small>
        </div>
    `;
});

// Add search control for addresses
var searchControl = L.control({position: 'topright'});
searchControl.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'search-control');
    div.style.backgroundColor = 'white';
    div.style.padding = '8px';
    div.style.borderRadius = '8px';
    div.style.boxShadow = '0 4px 8px rgba(0,0,0,0.15)';
    div.style.border = '1px solid #e2e8f0';
    div.style.zIndex = '400';
    div.innerHTML = `
        <div class="input-group" style="width: 250px;">
            <input type="text" id="addressSearch" class="form-control form-control-sm" placeholder="Cari alamat..." style="border: 1px solid #ddd;">
            <button class="btn btn-primary btn-sm" onclick="searchAddress()">
                <i class="fas fa-search"></i>
            </button>
        </div>
    `;
    return div;
};
searchControl.addTo(map);

// Helper functions
window.zoomToLocation = function(lat, lng) {
    map.setView([lat, lng], 18);
};

window.openInGoogleMaps = function(lat, lng) {
    window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
};

window.searchAddress = function() {
    var address = document.getElementById('addressSearch').value;
    if (address.trim() === '') return;
    
    // Simple geocoding using Nominatim (OpenStreetMap)
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address + ', Bandung, Indonesia')}&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                var lat = parseFloat(data[0].lat);
                var lon = parseFloat(data[0].lon);
                map.setView([lat, lon], 16);
                
                // Add temporary marker
                var searchMarker = L.marker([lat, lon]).addTo(map)
                    .bindPopup(`<strong>Hasil Pencarian:</strong><br>${data[0].display_name}`)
                    .openPopup();
                
                // Remove marker after 10 seconds
                setTimeout(() => {
                    map.removeLayer(searchMarker);
                }, 10000);
            } else {
                alert('Alamat tidak ditemukan. Coba dengan kata kunci yang lebih spesifik.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari alamat.');
        });
};

// Add keyboard support for search
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const searchInput = document.getElementById('addressSearch');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchAddress();
                }
            });
        }
    }, 1000);
});
</script>
@endsection