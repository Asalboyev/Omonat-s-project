<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZayavkaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $zayavka;

    /**
     * Create a new message instance.
     *
     * @param $zayavka
     */
    public function __construct($zayavka)
    {
        $this->zayavka = $zayavka;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $content = "New Zayavka Submitted\n\n" .
                   "First Name: {$this->zayavka['first_name']}\n" .
                   "Phone Number: {$this->zayavka['phone_number']}\n";

        return $this->subject('New Zayavka Submission')
                    ->text($content);
    }
}
