<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Evento;
use App\Espacio;
use App\User;
use App\Categoria;

class MensajeUsuario extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $espacio;
    public $cliente;
    public $usuario;
    public $categoria;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Evento $evento, Espacio $espacio, User $cliente, User $usuario, Categoria $categoria)
    {
        $this->evento = $evento;
        $this->espacio = $espacio;
        $this->cliente = $cliente;
        $this->usuario = $usuario;
        $this->categoria = $categoria;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@wimet.co')
            ->subject('Tienes un nuevo mensaje sobre tu evento')
            ->view('emails.mensaje-usuario');
    }
}
