<?php

namespace App\Events;

use App\Models\Pendaftaran;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerificationCompleted
{
    use Dispatchable, SerializesModels;

    public $pendaftaran;
    public $status;
    public $message;

    public function __construct(Pendaftaran $pendaftaran, $status, $message = null)
    {
        $this->pendaftaran = $pendaftaran;
        $this->status = $status;
        $this->message = $message;
    }
}