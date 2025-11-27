@php
    $backUrl = $backUrl ?? url()->previous();
    $backText = $backText ?? 'Kembali';
    $backClass = $backClass ?? 'btn btn-outline-secondary btn-sm';
@endphp

<div class="d-flex align-items-center mb-7" style="padding: 0 15px; margin-bottom: 3rem !important;">
    <a href="{{ $backUrl }}" class="{{ $backClass }}" style="text-decoration: none; transition: all 0.2s ease;">
        <i class="fas fa-arrow-left me-2"></i>{{ $backText }}
    </a>
</div>

<style>
.btn-outline-secondary:hover {
    transform: translateX(-2px);
}
</style>