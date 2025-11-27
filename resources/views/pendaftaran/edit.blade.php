@extends('layouts.app')

@section('title', 'Edit Pendaftaran')

@section('content')
<div class="container-fluid">
    @include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Pendaftaran SPMB</h4>
                <p class="mb-0">Nomor Pendaftaran: {{ $pendaftaran->nomor_pendaftaran }}</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pendaftaran.update', $pendaftaran) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Pilihan Jurusan & Gelombang</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <select class="form-select @error('jurusan_id') is-invalid @enderror" name="jurusan_id" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" {{ $pendaftaran->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jurusan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gelombang</label>
                                <select class="form-select @error('gelombang_id') is-invalid @enderror" name="gelombang_id" required>
                                    <option value="">Pilih Gelombang</option>
                                    @foreach($gelombangs as $gelombang)
                                        <option value="{{ $gelombang->id }}" {{ $pendaftaran->gelombang_id == $gelombang->id ? 'selected' : '' }}>
                                            {{ $gelombang->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gelombang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Data Pribadi</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                   <label class="form-label">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                       name="nik" value="{{ old('nik', $pendaftaran->nik) }}" maxlength="16" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       name="nama_lengkap" value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
                                    <option value="">Pilih</option>
                                    <option value="L" {{ $pendaftaran->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $pendaftaran->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       name="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir?->format('Y-m-d')) }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Agama</label>
                                <select class="form-select @error('agama') is-invalid @enderror" name="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ $pendaftaran->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ $pendaftaran->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ $pendaftaran->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ $pendaftaran->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ $pendaftaran->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ $pendaftaran->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          name="alamat" rows="3" required>{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" 
                                       name="kecamatan" value="{{ old('kecamatan', $pendaftaran->kecamatan) }}" required>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kelurahan</label>
                                <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" 
                                       name="kelurahan" value="{{ old('kelurahan', $pendaftaran->kelurahan) }}" required>
                                @error('kelurahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('kodepos') is-invalid @enderror" 
                                       name="kodepos" value="{{ old('kodepos', $pendaftaran->kodepos) }}" required>
                                @error('kodepos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" 
                                       name="asal_sekolah" value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" required>
                                @error('asal_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Data Orang Tua/Wali</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" 
                                       name="nama_ayah" value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}" required>
                                @error('nama_ayah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pekerjaan Ayah</label>
                                <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" 
                                       name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) }}" required>
                                @error('pekerjaan_ayah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" 
                                       name="nama_ibu" value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}" required>
                                @error('nama_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan Ibu</label>
                                <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" 
                                       name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) }}" required>
                                @error('pekerjaan_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Wali (Opsional)</label>
                                <input type="text" class="form-control @error('nama_wali') is-invalid @enderror" 
                                       name="nama_wali" value="{{ old('nama_wali', $pendaftaran->nama_wali) }}">
                                @error('nama_wali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. HP Orang Tua</label>
                                <input type="text" class="form-control @error('phone_ortu') is-invalid @enderror" 
                                       name="phone_ortu" value="{{ old('phone_ortu', $pendaftaran->phone_ortu) }}" required>
                                @error('phone_ortu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection