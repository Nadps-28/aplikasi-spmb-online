@extends('layouts.app')

@section('title', 'SPMB Online - SMK Bakti Nusantara 666')

@section('content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            min-height: 90vh;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset('images/hal-bn.jpg') }}') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-shapes::before,
        .floating-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-shapes::before {
            width: 200px;
            height: 200px;
            top: 20%;
            right: 10%;
            animation-delay: -2s;
        }

        .floating-shapes::after {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 10%;
            animation-delay: -4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .btn-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }

        .feature-icon:hover {
            transform: translateY(-5px) scale(1.05);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center" style="border-radius: 8px;">
        <div class="floating-shapes"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="mb-4">
                            <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                                <i class="fas fa-graduation-cap me-2"></i>
                                Penerimaan Siswa Baru 2025
                            </span>
                        </div>

                        <h1 class="display-4 fw-bold text-white mb-4">
                            SMK Bakti<br>
                            <span class="text-warning">Nusantara 666</span>
                        </h1>

                        <p class="lead text-white-50 mb-5">
                            Bergabunglah dengan SMK terdepan yang menghasilkan lulusan berkualitas dan siap kerja.
                            Daftar sekarang melalui sistem online yang mudah dan aman.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('login') }}"
                                class="btn btn-outline-light btn-lg px-4 py-3 rounded-3 fw-medium">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-3 fw-medium"
                                style="box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="text-center">
                        <div class="modern-card p-5">
                            <div class="feature-icon bg-primary bg-gradient mb-4">
                                <i class="fas fa-laptop-code fa-2x text-white"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Pendaftaran Online</h4>
                            <p class="text-muted mb-4">Sistem pendaftaran modern yang mudah, cepat, dan aman</p>

                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="feature-icon bg-info bg-gradient">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <small class="fw-medium">24/7</small>
                                </div>
                                <div class="col-4">
                                    <div class="feature-icon bg-success bg-gradient">
                                        <i class="fas fa-shield-alt text-white"></i>
                                    </div>
                                    <small class="fw-medium">Aman</small>
                                </div>
                                <div class="col-4">
                                    <div class="feature-icon bg-warning bg-gradient">
                                        <i class="fas fa-mobile-alt text-white"></i>
                                    </div>
                                    <small class="fw-medium">Mobile</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light" style="border-radius: 8px;">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('images/been.png') }}" alt="Logo SMK" width="200" height="200"
                            class="img-fluid mb-4">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Tentang SMK Bakti Nusantara 666</h2>
                    <p class="lead text-muted mb-4">
                        SMK Bakti Nusantara 666 adalah sekolah menengah kejuruan yang berkomitmen menghasilkan
                        lulusan berkualitas, berkarakter, dan siap menghadapi tantangan dunia kerja modern.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stats-number">15+</div>
                            <p class="text-muted mb-0">Tahun Pengalaman</p>
                        </div>
                        <div class="col-6">
                            <div class="stats-number">1000+</div>
                            <p class="text-muted mb-0">Alumni Sukses</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-warning bg-gradient mb-3">
                            <i class="fas fa-award fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Akreditasi A</h5>
                        <p class="text-muted mb-0">Terakreditasi A dengan standar pendidikan berkualitas tinggi</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-primary bg-gradient mb-3">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Guru Profesional</h5>
                        <p class="text-muted mb-0">Tenaga pengajar berpengalaman dan bersertifikat profesional</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-success bg-gradient mb-3">
                            <i class="fas fa-industry fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Kerjasama Industri</h5>
                        <p class="text-muted mb-0">Bermitra dengan berbagai perusahaan untuk magang dan penempatan kerja</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- School Slogan Section -->
    <section class="py-5 bg-light" style="border-radius: 8px;">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="fw-bold mb-2 text-dark">SAJUTA</h2>
                    <p class="text-muted mb-5">Nilai-nilai yang menjadi fondasi karakter siswa SMK Bakti Nusantara 666</p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 p-4">
                                <div class="text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px; background: #e3f2fd; border-radius: 15px;">
                                        <i class="fas fa-smile fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2 text-dark">SANTUN</h5>
                                    <p class="text-muted mb-0">Berperilaku sopan dan menghormati sesama</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 p-4">
                                <div class="text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px; background: #e8f5e8; border-radius: 15px;">
                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2 text-dark">JUJUR</h5>
                                    <p class="text-muted mb-0">Menjunjung tinggi kejujuran dan integritas</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 p-4">
                                <div class="text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px; background: #fff3e0; border-radius: 15px;">
                                        <i class="fas fa-star fa-2x text-warning"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2 text-dark">TAAT</h5>
                                    <p class="text-muted mb-0">Patuh terhadap aturan dan nilai-nilai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-5" style="border-radius: 8px;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-4">Program Keahlian</h2>
                <p class="lead text-muted">
                    Pilih program keahlian sesuai minat dan bakat Anda untuk masa depan yang cerah
                </p>
            </div>

            <div class="programs-carousel-container">
                <div class="programs-carousel">
                    @foreach ($jurusans as $jurusan)
                        <div class="program-card-scroll">
                            <div class="program-icon mb-4">
                                @php
                                    $imageMap = [
                                        'PPLG' => 'pplg.png',
                                        'Akuntansi' => 'akt.png',
                                        'Animasi' => 'animasi.png',
                                        'DKV' => 'dkv.png',
                                        'BDP' => 'bdp.png',
                                    ];
                                    $imageName =
                                        $imageMap[$jurusan->nama] ??
                                        strtolower(str_replace(' ', '', $jurusan->nama)) . '.png';
                                @endphp
                                <img src="{{ asset('images/jurusan/' . $imageName) }}" alt="{{ $jurusan->nama }}"
                                    width="80" height="80" class="rounded-3">
                            </div>
                            <h5 class="fw-bold mb-2">{{ $jurusan->nama }}</h5>
                            <div class="mb-3">
                                <span class="badge bg-success mb-2">
                                    <i class="fas fa-users me-1"></i>Unlimited
                                </span>
                            </div>
                            @if ($jurusan->nama == 'PPLG')
                                <p class="text-muted mb-3">Pengembangan Perangkat Lunak dan Gim</p>
                                <div class="program-skills">
                                    <span class="badge bg-primary me-2 mb-2">Programming</span>
                                    <span class="badge bg-info me-2 mb-2">Web Development</span>
                                    <span class="badge bg-success mb-2">Game Development</span>
                                </div>
                            @elseif($jurusan->nama == 'Akuntansi')
                                <p class="text-muted mb-3">Pembukuan dan Manajemen Keuangan</p>
                                <div class="program-skills">
                                    <span class="badge bg-warning me-2 mb-2">Pembukuan</span>
                                    <span class="badge bg-danger me-2 mb-2">Pajak</span>
                                    <span class="badge bg-secondary mb-2">Audit</span>
                                </div>
                            @elseif($jurusan->nama == 'Animasi')
                                <p class="text-muted mb-3">Animasi 2D/3D dan Motion Graphics</p>
                                <div class="program-skills">
                                    <span class="badge bg-primary me-2 mb-2">2D Animation</span>
                                    <span class="badge bg-info me-2 mb-2">3D Modeling</span>
                                    <span class="badge bg-success mb-2">VFX</span>
                                </div>
                            @elseif($jurusan->nama == 'DKV')
                                <p class="text-muted mb-3">Desain Komunikasi Visual</p>
                                <div class="program-skills">
                                    <span class="badge bg-warning me-2 mb-2">Graphic Design</span>
                                    <span class="badge bg-danger me-2 mb-2">Branding</span>
                                    <span class="badge bg-secondary mb-2">UI/UX</span>
                                </div>
                            @elseif($jurusan->nama == 'BDP')
                                <p class="text-muted mb-3">Bisnis Daring dan Pemasaran</p>
                                <div class="program-skills">
                                    <span class="badge bg-success me-2 mb-2">E-Commerce</span>
                                    <span class="badge bg-info me-2 mb-2">Digital Marketing</span>
                                    <span class="badge bg-primary mb-2">Social Media</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <!-- Duplicate for infinite scroll -->
                    @foreach ($jurusans as $jurusan)
                        <div class="program-card-scroll">
                            <div class="program-icon mb-4">
                                @php
                                    $imageMap = [
                                        'PPLG' => 'pplg.png',
                                        'Akuntansi' => 'akt.png',
                                        'Animasi' => 'animasi.png',
                                        'DKV' => 'dkv.png',
                                        'BDP' => 'bdp.png',
                                    ];
                                    $imageName =
                                        $imageMap[$jurusan->nama] ??
                                        strtolower(str_replace(' ', '', $jurusan->nama)) . '.png';
                                @endphp
                                <img src="{{ asset('images/jurusan/' . $imageName) }}" alt="{{ $jurusan->nama }}"
                                    width="80" height="80" class="rounded-3">
                            </div>
                            <h5 class="fw-bold mb-2">{{ $jurusan->nama }}</h5>
                            <div class="mb-3">
                                <span class="badge bg-success mb-2">
                                    <i class="fas fa-users me-1"></i>Unlimited
                                </span>
                            </div>
                            @if ($jurusan->nama == 'PPLG')
                                <p class="text-muted mb-3">Pengembangan Perangkat Lunak dan Gim</p>
                            @elseif($jurusan->nama == 'Akuntansi')
                                <p class="text-muted mb-3">Pembukuan dan Manajemen Keuangan</p>
                            @elseif($jurusan->nama == 'Animasi')
                                <p class="text-muted mb-3">Animasi 2D/3D dan Motion Graphics</p>
                            @elseif($jurusan->nama == 'DKV')
                                <p class="text-muted mb-3">Desain Komunikasi Visual</p>
                            @elseif($jurusan->nama == 'BDP')
                                <p class="text-muted mb-3">Bisnis Daring dan Pemasaran</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        .programs-carousel-container {
            overflow: hidden;
            margin: 0 -15px;
        }

        .programs-carousel {
            display: flex;
            animation: scroll 30s linear infinite;
            gap: 2rem;
        }

        .program-card-scroll {
            min-width: 320px;
            background: white;
            border: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .program-card-scroll:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .programs-carousel:hover {
            animation-play-state: paused;
        }

        .program-icon {
            transition: all 0.3s ease;
        }

        .program-card-scroll:hover .program-icon {
            transform: scale(1.1);
        }

        .program-skills .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .program-card-scroll {
                min-width: 280px;
                padding: 1.5rem;
            }

            .programs-carousel {
                animation-duration: 15s;
            }

            .hero-content {
                margin-bottom: 3rem;
            }
        }
    </style>

    <!-- Registration Info -->
    <section class="py-5"
        style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); position: relative; border-radius: 8px;">
        <div class="position-absolute w-100 h-100"
            style="background-image: radial-gradient(circle at 75% 25%, rgba(245, 158, 11, 0.05) 0%, transparent 50%), radial-gradient(circle at 25% 75%, rgba(220, 38, 38, 0.05) 0%, transparent 50%); opacity: 0.7;">
        </div>
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4" style="color: #1e293b;">Informasi Pendaftaran</h2>
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-calendar-alt fa-lg" style="color: #2563eb;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #1e293b;">Periode Pendaftaran</h6>
                                <p class="mb-0" style="color: #64748b;">November - April 2025</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-money-bill-wave fa-lg" style="color: #f59e0b;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #1e293b;">Biaya Pendaftaran</h6>
                                <p class="mb-0" style="color: #64748b;">Rp 5.500.000</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-file-alt fa-lg" style="color: #dc2626;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #1e293b;">Persyaratan</h6>
                                <p class="mb-0" style="color: #64748b;">Ijazah SMP/MTs, Rapor Semester Akhir, KIP, KKS,
                                    Akte
                                    Kelahiran, KK, Pas Foto 3x4</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 p-4 text-center">
                        <h4 class="fw-bold mb-3" style="color: #1e293b;">Siap Mendaftar?</h4>
                        <p class="mb-4" style="color: #64748b;">Bergabunglah dengan ratusan siswa yang telah mempercayai
                            SMK
                            Bakti Nusantara 666</p>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-semibold">
                            <i class="fas fa-rocket me-2"></i>Mulai Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" style="background: #f8fafc; border-radius: 8px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4" style="color: #1e293b;">Hubungi Kami</h2>
                    <p class="lead mb-5" style="color: #64748b;">
                        Ada pertanyaan? Tim kami siap membantu Anda
                    </p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-map-marker-alt fa-2x" style="color: #2563eb;"></i>
                                </div>
                                <h6 class="fw-bold" style="color: #1e293b;">Alamat</h6>
                                <p class="small" style="color: #64748b;">SMK Bakti Nusantara 666, Jl. Raya Percobaan
                                    No.65,
                                    Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-phone fa-2x" style="color: #f59e0b;"></i>
                                </div>
                                <h6 class="fw-bold" style="color: #1e293b;">Telepon</h6>
                                <p class="small" style="color: #64748b;">(021) 666-7777<br>0812-3456-7890</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-envelope fa-2x" style="color: #dc2626;"></i>
                                </div>
                                <h6 class="fw-bold" style="color: #1e293b;">Email</h6>
                                <p class="small" style="color: #64748b;">
                                    info@smkbaktinusantara666.sch.id<br>spmb@smkbaktinusantara666.sch.id</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('terms') }}" class="btn btn-outline-primary">
                            <i class="fas fa-file-contract me-2"></i>Syarat & Ketentuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


@endsection
