@extends('layouts.app')

@section('content')
@include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Log Notifikasi</h3>
                </div>
                
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="channel" class="form-control">
                                    <option value="">Semua Channel</option>
                                    <option value="email" {{ request('channel') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="whatsapp" {{ request('channel') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="sms" {{ request('channel') == 'sms' ? 'selected' : '' }}>SMS</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Terkirim</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Sampai Tanggal">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.notification-logs') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>{{ $notificationLogs->where('status', 'sent')->count() }}</h5>
                                    <p>Terkirim</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5>{{ $notificationLogs->where('status', 'failed')->count() }}</h5>
                                    <p>Gagal</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>{{ $notificationLogs->where('status', 'pending')->count() }}</h5>
                                    <p>Pending</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>{{ $notificationLogs->count() }}</h5>
                                    <p>Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification Logs Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Channel</th>
                                    <th>Penerima</th>
                                    <th>Subjek</th>
                                    <th>Status</th>
                                    <th>Dikirim</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notificationLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $log->channel == 'email' ? 'primary' : ($log->channel == 'whatsapp' ? 'success' : 'info') }}">
                                            {{ ucfirst($log->channel) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->recipient }}</td>
                                    <td>{{ Str::limit($log->subject, 30) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $log->status == 'sent' ? 'success' : ($log->status == 'failed' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->sent_at ? $log->sent_at->format('d/m/Y H:i:s') : '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#messageModal{{ $log->id }}">
                                            Lihat Pesan
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Message Modal -->
                                <div class="modal fade" id="messageModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Notifikasi</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Channel:</strong> {{ ucfirst($log->channel) }}</p>
                                                <p><strong>Penerima:</strong> {{ $log->recipient }}</p>
                                                @if($log->subject)
                                                <p><strong>Subjek:</strong> {{ $log->subject }}</p>
                                                @endif
                                                <p><strong>Status:</strong> {{ ucfirst($log->status) }}</p>
                                                @if($log->sent_at)
                                                <p><strong>Dikirim:</strong> {{ $log->sent_at->format('d/m/Y H:i:s') }}</p>
                                                @endif
                                                @if($log->error_message)
                                                <p><strong>Error:</strong> {{ $log->error_message }}</p>
                                                @endif
                                                <hr>
                                                <h6>Pesan:</h6>
                                                <div class="border p-3">
                                                    {{ $log->message }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data log notifikasi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $notificationLogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection