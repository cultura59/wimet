<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Evento;
use App\Espacio;
use App\User;

class ConsultaAnfitrion extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $espacio;
    public $cliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Evento $evento, Espacio $espacio, User $cliente)
    {
        $this->evento = $evento;
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
                ->subject('¡Tienes una nueva consulta, Felicitaciones!')
                ->view('emails.consulta-anfitrion');
    }
}
