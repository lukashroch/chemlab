<?php

namespace ChemLab\Helpers;

use Sabre\DAV\Client;

class WebDAVClient extends Client
{
    function __construct(array $settings)
    {
        parent::__construct($settings);

        $this->addCurlSetting(CURLOPT_CAINFO, $settings['certificate']);
        $this->addCurlSetting(CURLOPT_SSL_VERIFYPEER, true);
    }
}
