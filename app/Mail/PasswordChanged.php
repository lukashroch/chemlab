<?php

namespace ChemLab\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->data['userLoc']->default == true)
            $this->data['userLoc'] = $this->data['userLoc']->ip;
        else
            $this->data['userLoc'] = $this->data['userLoc']->ip . " (" . $this->data['userLoc']->city . ", " . $this->data['userLoc']->country . ", " . $this->data['userLoc']->iso_code . ")";

        return $this->subject('Password changed for ChemLab account')
            ->markdown('email.user.password-changed')->with($this->data);
    }
}
