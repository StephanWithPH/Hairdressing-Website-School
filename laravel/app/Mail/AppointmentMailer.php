<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment, $type)
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == "created") {
            return $this->view('mail.appointment.created')->with([
                'appointment' => $this->appointment
            ])->subject(__('Uw afspraak bij :name is zojuist aangemaakt.', ["name" => env('APP_NAME')]));
        }
        else if($this->type == "changed") {
            return $this->view('mail.appointment.changed')->with([
                'appointment' => $this->appointment
            ])->subject(__('Uw afspraak bij :name is zojuist aangepast.', ["name" => env('APP_NAME')]));
        }
        else if($this->type == "cancelled") {
            return $this->view('mail.appointment.cancelled')->with([
                'appointment' => $this->appointment
            ])->subject(__('Uw afspraak bij :name is geannuleerd.', ["name" => env('APP_NAME')]));
        }
    }
}
