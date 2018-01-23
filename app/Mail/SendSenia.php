<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Espacio;
use App\User;

class SendSenia extends Mailable
{
    use Queueable, SerializesModels;

    public $duenio;
    public $espacio;
    public $cliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $duenio, Espacio $espacio, User $cliente)
    {
        $this->duenio = $duenio;
        $this->espacio = $espacio;
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@wimet.co')
            ->subject('¡Felicitaciones!, estos son los datos del espacio de wimet')
            ->view('emails.senia');
    }
}
