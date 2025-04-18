<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailCode extends Mailable
{
    use Queueable, SerializesModels;
    public $random;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $random)
    {
        $this->random = $random;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Send Mail Code',
        );
    }

    /**
     * Genera el contenido del correo electrónico.
     * 
     * Este método devuelve una instancia de la clase `Content`, que define la vista utilizada para el correo 
     * electrónico y los datos dinámicos que se pasarán a dicha vista.
     * 
     * @return \Illuminate\Mail\Mailables\Content
     * 
     * - `view`: Especifica la plantilla Blade que se usará como contenido del correo electrónico.
     * - `with`: Un arreglo que contiene los datos dinámicos que serán enviados a la plantilla. En este caso, 
     *   incluye una clave `random` con el valor proporcionado por `$this->random`.
     */
    public function content()
    {
        return new Content(
            view: 'mail.index',// Plantilla Blade para el correo
            with: ['random' => $this->random] // Datos dinámicos para la plantilla
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
