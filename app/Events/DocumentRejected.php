<?php

namespace App\Events;

use App\Models\Pendaftaran;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentRejected
{
    use Dispatchable, SerializesModels;

    public $pendaftaran;
    public $message;

    public function __construct(Pendaftaran $pendaftaran, $message)
    {
        $this->pendaftaran = $pendaftaran;
        $this->message = $message;
    }
}