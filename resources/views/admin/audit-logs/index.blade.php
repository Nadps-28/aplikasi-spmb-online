@extends('layouts.app')

@section('content')
@include('layouts.back-button', ['backUrl' => route('dashboard'), 'backText' => 'Kembali ke Dashboard'])

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Log</h3>
                </div>
                
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="action" class="form-control">
                                    <option value="">Semua Aksi</option>
                                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
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
                                <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Audit Logs Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                    <th>Model</th>
                                    <th>ID</th>
                                    <th>IP Address</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($auditLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $log->user ? $log->user->name : 'System' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $log->action == 'created' ? 'success' : ($log->action == 'updated' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td>{{ class_basename($log->model_type) }}</td>
                                    <td>{{ $log->model_id }}</td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td>
                                        @if($log->old_values || $log->new_values)
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{ $log->id }}">
                                            Lihat Detail
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                
                                <!-- Detail Modal -->
                                @if($log->old_values || $log->new_values)
                                <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Audit Log</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if($log->old_values)
                                                <h6>Data Lama:</h6>
                                                <pre>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                @endif
                                                
                                                @if($log->new_values)
                                                <h6>Data Baru:</h6>
                                                <pre>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data audit log</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $auditLogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection