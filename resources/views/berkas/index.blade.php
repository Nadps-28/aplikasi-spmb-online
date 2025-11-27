@extends('layouts.app')

@section('title', 'Upload Berkas')

@section('content')
<div class="container-fluid">
    @include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Upload Berkas Pendaftaran</h4>
                <p class="mb-0">Nomor Pendaftaran: {{ $pendaftaran->nomor_pendaftaran }}</p>
            </div>
            <div class="card-body">
                @php
                    $requiredDocs = [
                        'ijazah' => 'Ijazah SMP/MTs',
                        'rapor' => 'Rapor Semester Terakhir', 
                        'kk' => 'Kartu Keluarga (KK)',
                        'akta' => 'Akta Kelahiran',
                        'pas_foto' => 'Pas Foto 3x4'
                    ];
                    
                    $optionalDocs = [
                        'kip' => 'Kartu Indonesia Pintar (KIP)',
                        'kks' => 'Kartu Keluarga Sejahtera (KKS)'
                    ];
                    
                    $uploadedDocs = $berkas->keyBy('jenis');
                @endphp

                <!-- Required Documents -->
                <h5 class="mb-3">Berkas Wajib</h5>
                <div class="row g-3 mb-4">
                    @foreach($requiredDocs as $jenis => $nama)
                    <div class="col-md-6">
                        <div class="card border-{{ isset($uploadedDocs[$jenis]) ? 'success' : 'warning' }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $nama }}</h6>
                                    @if(isset($uploadedDocs[$jenis]))
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Uploaded
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation"></i> Required
                                        </span>
                                    @endif
                                </div>
                                
                                @if(isset($uploadedDocs[$jenis]))
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $uploadedDocs[$jenis]->nama_file }}</small>
                                        <div>
                                            <a href="{{ asset("storage/" . $uploadedDocs[$jenis]->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($pendaftaran->status == 'draft')
                                            <form method="POST" action="{{ route('berkas.destroy', $uploadedDocs[$jenis]) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    @if($pendaftaran->status == 'draft' || $pendaftaran->status == 'dikirim')
                                    <form method="POST" action="{{ route('berkas.store', $pendaftaran) }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="jenis" value="{{ $jenis }}">
                                        <div class="mb-2">
                                            <input type="file" class="form-control form-control-sm" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <small class="text-muted">PDF, JPG, PNG. Max 2MB</small>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Optional Documents -->
                <h5 class="mb-3">Berkas Opsional</h5>
                <div class="row g-3 mb-4">
                    @foreach($optionalDocs as $jenis => $nama)
                    <div class="col-md-6">
                        <div class="card border-{{ isset($uploadedDocs[$jenis]) ? 'success' : 'secondary' }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $nama }}</h6>
                                    @if(isset($uploadedDocs[$jenis]))
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Uploaded
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-info"></i> Optional
                                        </span>
                                    @endif
                                </div>
                                
                                @if(isset($uploadedDocs[$jenis]))
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $uploadedDocs[$jenis]->nama_file }}</small>
                                        <div>
                                            <a href="{{ asset("storage/" . $uploadedDocs[$jenis]->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($pendaftaran->status == 'draft')
                                            <form method="POST" action="{{ route('berkas.destroy', $uploadedDocs[$jenis]) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    @if($pendaftaran->status == 'draft' || $pendaftaran->status == 'dikirim')
                                    <form method="POST" action="{{ route('berkas.store', $pendaftaran) }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="jenis" value="{{ $jenis }}">
                                        <div class="mb-2">
                                            <input type="file" class="form-control form-control-sm" name="file" accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">PDF, JPG, PNG. Max 2MB</small>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Progress Summary -->
                @php
                    $requiredUploaded = collect($requiredDocs)->keys()->filter(function($jenis) use ($uploadedDocs) {
                        return isset($uploadedDocs[$jenis]);
                    })->count();
                    $totalRequired = count($requiredDocs);
                    $progress = ($requiredUploaded / $totalRequired) * 100;
                @endphp

                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Status Upload</h6>
                    <div class="progress mb-2">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ round($progress) }}%
                        </div>
                    </div>
                    <p class="mb-0">{{ $requiredUploaded }}/{{ $totalRequired }} berkas wajib telah diupload</p>
                    @if($progress < 100)
                        <small class="text-muted">Lengkapi semua berkas wajib sebelum mengirim pendaftaran</small>
                    @else
                        <small class="text-success">✓ Semua berkas wajib sudah lengkap</small>
                    @endif
                </div>

                <div class="mt-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection