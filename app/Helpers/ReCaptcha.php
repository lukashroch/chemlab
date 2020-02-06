<?php

namespace ChemLab\Helpers;

class ReCaptcha
{
    /**
     * URL to verify response
     *
     * @var string
     */
    protected $url;

    /**
     * Verify User's response token
     *
     * @param string $token
     * @param string|null $ip
     *
     */
    public function __construct($token, $ip = null)
    {
        $secret = config('services.google.recaptcha.secret');

        $this->url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $token;

        if ($ip)
            $this->url .= "&remoteip=" . $ip;
    }

    /**
     * Verify User's response token
     *
     * @return bool
     */
    public function verify(): bool
    {
        $response = json_decode(file_get_contents($this->url), true);
        return (bool)$response['success'];
    }
}
