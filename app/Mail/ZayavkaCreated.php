<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZayavkaCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $zayavka;

    public function __construct($zayavka)
    {
        $this->zayavka = $zayavka;
    }

    public function build()
    {
        return $this->subject('New Zayavka Created')
                    ->text('emails.zayavka_created'); // Raw matnli email uchun
    }
}
