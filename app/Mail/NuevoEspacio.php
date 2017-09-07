<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Espacio;
use App\User;

class NuevoEspacio extends Mailable
{
    use Queueable, SerializesModels;

    public $espacio;
    public $usuario;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Espacio $espacio, User $user)
    {
        $this->espacio = $espacio;
        $this->usuario = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@wimet.co')
            ->subject('Se registro un nuevo espacio!')
            ->view('emails.nuevo-espacio');
    }
}
