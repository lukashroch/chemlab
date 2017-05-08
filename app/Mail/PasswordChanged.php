<?php

namespace ChemLab\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    protected $loc;

    /**
     * Create a new message instance.
     *
     * @param string $username
     * @param string $ip
     */
    public function __construct($username, $ip)
    {
        $this->loc = array_merge(['username' => $username], geoip()->getLocation($ip)->toArray());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->loc['default'] == true)
            $loc = $this->loc['ip'];
        else
            $loc = $this->loc['ip'] . " (" . $this->loc['city'] . ", " . $this->loc['country'] . ", " . $this->loc['iso_code'] . ")";

        return $this->subject('Password changed for ChemLab account')
            ->markdown('email.user.password-changed')->with(['username' => $this->loc['username'], 'loc' => $loc]);
    }
}
