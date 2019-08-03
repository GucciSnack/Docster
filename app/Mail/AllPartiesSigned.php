<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AllPartiesSigned extends Mailable
{
    use Queueable, SerializesModels;

    private $document_name;
    private $fake_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $document_name, string $fake_path)
    {
        $this->document_name = $document_name;
        $this->fake_path = $fake_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.allPartiesSigned', [
            'document_name' => $this->document_name,
            'fake_path' => $this->fake_path,
        ]);
    }
}
