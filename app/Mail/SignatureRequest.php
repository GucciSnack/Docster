<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Signer;

class SignatureRequest extends Mailable
{
    use Queueable, SerializesModels;

    private $authCode;
    private $signer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Signer $signer, string $authCode)
    {
        $this->signer = $signer;
        $this->authCode = $authCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.signatureRequest', [
            'signer'    => $this->signer,
            'auth_code' => $this->authCode
        ]);
    }
}
