<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Email Verification Mail',
        );
    }

    /**
     * Genera el contenido del correo electrónico.
     * 
     * Este método devuelve una instancia de la clase `Content` que define la vista utilizada para el cuerpo del correo 
     * y los datos que se pasarán a dicha vista.
     * 
     * @return \Illuminate\Mail\Mailables\Content
     * 
     * - `view`: Especifica la vista Blade que se usará como plantilla del correo electrónico.
     * - `with`: Un arreglo de datos que se pasan a la vista, en este caso, se incluye una clave `url` 
     *   con el valor proporcionado por `$this->url`.
     */
    public function content()
    {
        return new Content(
            view: 'mail.emailverify', // Ruta de la vista Blade para el correo
            with: ['url' => $this->url] // Datos pasados a la vista, incluye la URL para la verificación

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
