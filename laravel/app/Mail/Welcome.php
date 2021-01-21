<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;
    public $nombres='';
    public $apellidos='';
    public $token='';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($apellidos,$nombres,$token)
    {
        $this->apellidos=$apellidos;
        $this->nombres=$nombres;
        $this->token=$token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //la siguiente linea es para enviar una copia del correo a otra direccion
        //->cc('correox@gmail.com')
         return $this->view('email.welcome')
         ->subject('Recuperacion de clave J-SOFTWARE');
    }
}
