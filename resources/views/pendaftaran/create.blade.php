@extends('layouts.app')

@section('title', 'Form Pendaftaran')

@section('content')
<div class="container-fluid">
    @include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])
</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Pendaftaran SPMB</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pendaftaran.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Pilihan Jurusan & Gelombang</h5>

                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select class="form-select @error('jurusan_id') is-invalid @enderror" name="jurusan_id"
                                        required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}">
                                                {{ $jurusan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih jurusan sesuai minat Anda</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gelombang</label>
                                    @if($gelombangs->count() > 0)
                                        <select class="form-select @error('gelombang_id') is-invalid @enderror"
                                            name="gelombang_id" required>
                                            <option value="">Pilih Gelombang</option>
                                            @foreach($gelombangs as $gelombang)
                                                <option value="{{ $gelombang->id }}">
                                                    {{ $gelombang->nama }} 
                                                    ({{ $gelombang->tanggal_mulai->format('d/m/Y') }} - {{ $gelombang->tanggal_selesai->format('d/m/Y') }})
                                                    - Aktif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('gelombang_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-success"><i class="fas fa-check-circle me-1"></i>Gelombang dalam periode aktif</small>
                                    @else
                                        @php
                                            $allGelombangs = App\Models\Gelombang::where('aktif', true)->get();
                                            $upcomingGelombangs = $allGelombangs->filter(fn($g) => $g->isUpcoming());
                                            $expiredGelombangs = $allGelombangs->filter(fn($g) => $g->isExpired());
                                        @endphp
                                        
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Tidak ada gelombang pendaftaran yang aktif saat ini.</strong>
                                        </div>
                                        
                                        @if($upcomingGelombangs->count() > 0)
                                            <div class="alert alert-info">
                                                <i class="fas fa-clock me-2"></i>
                                                <strong>Gelombang yang akan datang:</strong>
                                                @foreach($upcomingGelombangs as $gelombang)
                                                    <br>• {{ $gelombang->nama }} - Mulai {{ $gelombang->tanggal_mulai->format('d/m/Y') }}
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        @if($expiredGelombangs->count() > 0)
                                            <div class="alert alert-secondary">
                                                <i class="fas fa-history me-2"></i>
                                                <strong>Gelombang yang telah berakhir:</strong>
                                                @foreach($expiredGelombangs as $gelombang)
                                                    <br>• {{ $gelombang->nama }} - Berakhir {{ $gelombang->tanggal_selesai->format('d/m/Y') }}
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <input type="hidden" name="gelombang_id" value="">
                                    @endif
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
                                    <label class="form-label fw-semibold" style="color: #374151;">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                        value="{{ old('nik') }}" maxlength="16" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" required>
                                        <option value="">Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Agama</label>
                                    <select class="form-select @error('agama') is-invalid @enderror" name="agama" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                        rows="3" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Kecamatan</label>
                                    <select class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan"
                                        id="kecamatan" onchange="updateKelurahan()" required>
                                        <option value="">Pilih Kecamatan</option>
                                        <option value="Andir">Andir</option>
                                        <option value="Astana Anyar">Astana Anyar</option>
                                        <option value="Antapani">Antapani</option>
                                        <option value="Arcamanik">Arcamanik</option>
                                        <option value="Babakan Ciparay">Babakan Ciparay</option>
                                        <option value="Bandung Kidul">Bandung Kidul</option>
                                        <option value="Bandung Kulon">Bandung Kulon</option>
                                        <option value="Bandung Wetan">Bandung Wetan</option>
                                        <option value="Batununggal">Batununggal</option>
                                        <option value="Bojongloa Kaler">Bojongloa Kaler</option>
                                        <option value="Bojongloa Kidul">Bojongloa Kidul</option>
                                        <option value="Buahbatu">Buahbatu</option>
                                        <option value="Cibeunying Kaler">Cibeunying Kaler</option>
                                        <option value="Cibeunying Kidul">Cibeunying Kidul</option>
                                        <option value="Cibiru">Cibiru</option>
                                        <option value="Cicendo">Cicendo</option>
                                        <option value="Cidadap">Cidadap</option>
                                        <option value="Cinambo">Cinambo</option>
                                        <option value="Coblong">Coblong</option>
                                        <option value="Gedebage">Gedebage</option>
                                        <option value="Kiaracondong">Kiaracondong</option>
                                        <option value="Lengkong">Lengkong</option>
                                        <option value="Mandalajati">Mandalajati</option>
                                        <option value="Panyileukan">Panyileukan</option>
                                        <option value="Rancasari">Rancasari</option>
                                        <option value="Regol">Regol</option>
                                        <option value="Sukajadi">Sukajadi</option>
                                        <option value="Sukasari">Sukasari</option>
                                        <option value="Sumur Bandung">Sumur Bandung</option>
                                        <option value="Ujungberung">Ujungberung</option>
                                        <!-- Bandung Timur -->
                                        <option value="Cileunyi">Cileunyi</option>
                                        <option value="Cilengkrang">Cilengkrang</option>
                                        <option value="Cicalengka">Cicalengka</option>
                                        <option value="Rancaekek">Rancaekek</option>
                                        <option value="Majalaya">Majalaya</option>
                                        <option value="Solokan Jeruk">Solokan Jeruk</option>
                                        <option value="Ibun">Ibun</option>
                                        <option value="Paseh">Paseh</option>
                                        <option value="Cikancung">Cikancung</option>
                                        <option value="Nagreg">Nagreg</option>
                                    </select>
                                    @error('kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Kelurahan</label>
                                    <select class="form-select @error('kelurahan') is-invalid @enderror" name="kelurahan"
                                        id="kelurahan" required>
                                        <option value="">Pilih Kecamatan Terlebih Dahulu</option>
                                    </select>
                                    @error('kelurahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Kode Pos</label>
                                    <input type="text" class="form-control @error('kodepos') is-invalid @enderror"
                                        name="kodepos" value="{{ old('kodepos') }}" required>
                                    @error('kodepos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Asal Sekolah</label>
                                    <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror"
                                        name="asal_sekolah" value="{{ old('asal_sekolah') }}" required>
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
                                    <label class="form-label fw-semibold" style="color: #374151;">Nama Ayah</label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                        name="nama_ayah" value="{{ old('nama_ayah') }}" required>
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                                        name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required>
                                    @error('pekerjaan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Nama Ibu</label>
                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                        name="nama_ibu" value="{{ old('nama_ibu') }}" required>
                                    @error('nama_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                                        name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required>
                                    @error('pekerjaan_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Nama Wali
                                        (Opsional)</label>
                                    <input type="text" class="form-control @error('nama_wali') is-invalid @enderror"
                                        name="nama_wali" value="{{ old('nama_wali') }}">
                                    @error('nama_wali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">No. HP Orang Tua</label>
                                    <input type="text" class="form-control @error('phone_ortu') is-invalid @enderror"
                                        name="phone_ortu" value="{{ old('phone_ortu') }}" required>
                                    @error('phone_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" @if($gelombangs->count() == 0) disabled @endif>
                                <i class="fas fa-save"></i> 
                                @if($gelombangs->count() > 0)
                                    Simpan Pendaftaran
                                @else
                                    Tidak Ada Gelombang Aktif
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
var kelurahanData = {
    'Andir': ['Campaka', 'Ciroyom', 'Dungus Cariang', 'Garuda', 'Kebon Jeruk', 'Maleber'],
    'Astana Anyar': ['Cibadak', 'Karanganyar', 'Karasak', 'Nyengseret', 'Panjunan', 'Pelindung Hewan'],
    'Antapani': ['Antapani Kidul', 'Antapani Kulon', 'Antapani Tengah', 'Antapani Wetan'],
    'Arcamanik': ['Cisaranten Bina Harapan', 'Cisaranten Endah', 'Cisaranten Kulon', 'Sukamiskin'],
    'Babakan Ciparay': ['Babakan', 'Babakan Ciparay', 'Cirangrang', 'Margahayu Utara', 'Margasuka', 'Sukahaji'],
    'Bandung Kidul': ['Batununggal', 'Kujangsari', 'Mengger', 'Wates'],
    'Bandung Kulon': ['Caringin', 'Cibuntu', 'Cigondewah Kaler', 'Cigondewah Kidul', 'Cigondewah Rahayu', 'Cijerah', 'Gempolsari', 'Warungmuncang'],
    'Bandung Wetan': ['Cihapit', 'Citarum', 'Tamansari'],
    'Batununggal': ['Binong', 'Cibangkong', 'Gumuruh', 'Kacapiring', 'Kebongedang', 'Kebonwaru', 'Maleer', 'Samoja'],
    'Bojongloa Kaler': ['Babakan Asih', 'Babakan Tarogong', 'Jamika', 'Kopo', 'Suka Asih'],
    'Bojongloa Kidul': ['Kebon Lega', 'Mekarwangi', 'Situsaeur'],
    'Buahbatu': ['Cijawura', 'Jatisari', 'Margasari', 'Sekejati'],
    'Cibeunying Kaler': ['Cigadung', 'Cihaur Geulis', 'Neglasari', 'Sukaluyu'],
    'Cibeunying Kidul': ['Cicadas', 'Cikutra', 'Padasuka', 'Pasirlayung', 'Sukamaju', 'Sukapada'],
    'Cibiru': ['Cipadung', 'Cisurupan', 'Palasari', 'Pasirbiru'],
    'Cicendo': ['Arjuna', 'Husen Sastranegara', 'Pajajaran', 'Pamoyanan', 'Pasirkaliki', 'Sukaraja'],
    'Cidadap': ['Ciumbuleuit', 'Hegarmanah', 'Ledeng'],
    'Cinambo': ['Babakan Penghulu', 'Cisaranten Wetan', 'Pakemitan', 'Sukamulya'],
    'Coblong': ['Cipaganti', 'Dago', 'Lebak Gede', 'Lebak Siliwangi', 'Sadang Serang', 'Sekeloa'],
    'Gedebage': ['Cimincrang', 'Cisaranten Kidul', 'Rancabolang', 'Rancanumpang'],
    'Kiaracondong': ['Babakan Sari', 'Babakansurabaya', 'Cicaheum', 'Kebonkangkung', 'Kebunjayanti', 'Sukapura'],
    'Lengkong': ['Burangrang', 'Cijagra', 'Cikawao', 'Lingkar Selatan', 'Malabar', 'Paledang', 'Turangga'],
    'Mandalajati': ['Jatihandap', 'Karang Pamulang', 'Pasir Impun', 'Sindangjaya'],
    'Panyileukan': ['Cipadung Kidul', 'Cipadung Kulon', 'Cipadung Wetan', 'Mekarmulya'],
    'Rancasari': ['Derwati', 'Manjahlega', 'Rancasari'],
    'Regol': ['Ancol', 'Balonggede', 'Ciateul', 'Cigereleng', 'Ciseureuh', 'Pasirluyu', 'Pungkur'],
    'Sukajadi': ['Cipedes', 'Pasteur', 'Sukabungah', 'Sukagalih', 'Sukawarna'],
    'Sukasari': ['Gegerkalong', 'Isola', 'Sarijadi', 'Sukarasa'],
    'Sumur Bandung': ['Babakan Ciamis', 'Braga', 'Kebon Pisang', 'Merdeka'],
    'Ujungberung': ['Cigending', 'Pasanggrahan', 'Pasirjati', 'Ujungberung'],
    'Cileunyi': ['Cileunyi Kulon', 'Cileunyi Wetan', 'Cinunuk'],
    'Cilengkrang': ['Cilengkrang', 'Girimekar', 'Mekar Rahayu', 'Wangisagara'],
    'Cicalengka': ['Cicalengka Kulon', 'Cicalengka Wetan', 'Dampit', 'Narawita', 'Panenjoan', 'Tanjungwangi'],
    'Rancaekek': ['Bojongloa', 'Cangkuang', 'Cangkuang Kulon', 'Linggar', 'Nanjungmekar', 'Rancaekek Kulon', 'Rancaekek Wetan'],
    'Majalaya': ['Biru', 'Majalaya', 'Majasetra', 'Neglawangi', 'Padamukti', 'Sukamaju', 'Warnasari'],
    'Solokan Jeruk': ['Bojongemas', 'Langensari', 'Pameuntasan', 'Rancakole', 'Solokan Jeruk'],
    'Ibun': ['Dukuh', 'Ibun', 'Karyalaksana', 'Lampegan', 'Laksana', 'Mekar Mukti', 'Neglasari', 'Pangguh', 'Sadu', 'Tanggulun'],
    'Paseh': ['Cijagra', 'Cikitu', 'Drawati', 'Karangtunggal', 'Loa', 'Mekarmukti', 'Paseh', 'Sukamantri', 'Sukanagara'],
    'Cikancung': ['Cikancung', 'Hegarmanah', 'Mandalamekar', 'Srirahayu'],
    'Nagreg': ['Ciaro', 'Ciherang', 'Cimareme', 'Mandalasari', 'Nagreg', 'Neglawangi', 'Sukamanah']
};

function updateKelurahan() {
    var kecamatan = document.getElementById('kecamatan').value;
    var kelurahanSelect = document.getElementById('kelurahan');
    
    kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
    
    if (kecamatan && kelurahanData[kecamatan]) {
        for (var i = 0; i < kelurahanData[kecamatan].length; i++) {
            var option = document.createElement('option');
            option.value = kelurahanData[kecamatan][i];
            option.text = kelurahanData[kecamatan][i];
            kelurahanSelect.appendChild(option);
        }
    }
}
</script>