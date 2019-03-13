<?php

namespace ChemLab\Helpers\Parser;

use Illuminate\Support\Str;

class Parser
{
    use ActivateScientificTrait, SigmaAldrichTrait;

    /**
     * @var array
     */
    private $brands;

    /**
     * @var string
     */
    private $callback;

    /**
     * @var string
     */
    private $catalogId;

    /**
     * @var array
     */
    private $data;

    /**
     * @param string $catalogId
     * @param callable $callback
     * @param array $brands
     */
    public function __construct($catalogId, $callback, array $brands)
    {
        $this->catalogId = $catalogId;
        $this->callback = Str::camel($callback);
        $this->brands = $brands;

        $this->data = [
            'brand_id' => 0,
            'catalog_id' => $catalogId,
            'name' => '',
            'cas' => '',
            'mw' => '',
            'formula' => '',
            'pubchem' => '',
            'synonym' => '',
            'description' => '',
            // MSDS Data
            'symbol' => [],
            'signal_word' => '',
            'h' => [],
            'p' => []
        ];
    }

    /**
     * Crawl through URL content with defined brands and get data
     *
     * @return array
     */
    public function get()
    {
        foreach ($this->brands as $id => $url) {
            if (method_exists($this, $this->callback))
                $this->data = call_user_func([$this, $this->callback], $id, $url);

            if ($this->data['brand_id'] != 0)
                break;
        }

        return $this->data;
    }

    /**
     * Get Content of defined URL
     *
     * @param string $brandUrl
     * @return bool|\DOMDocument
     */
    private function getUrlContent($brandUrl)
    {
        $url = str_replace("%", $this->catalogId, $brandUrl);

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_ENCODING => "",
            //CURLOPT_USERAGENT      => "",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 30,
        ];

        //curl_setopt($ch, CURLOPT_URL, $url . '?lang=en&region=US');
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content = curl_exec($ch);

        curl_close($ch);

        //$errors = curl_error($ch);
        //$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $dom = new \DOMDocument();
        $dom->recover = true;
        $dom->strictErrorChecking = false;
        @$dom->loadHTML($content);

        return $dom;
    }


    /**
     * Get defined parse callbacks as traits
     *
     * @return array|null
     */
    public static function getParseCallbacks()
    {
        $list = [];
        foreach (get_declared_traits() as $trait) {
            if (strpos($trait, __NAMESPACE__) === false)
                continue;

            $callback = Str::kebab(str_replace([__NAMESPACE__ . '\\', 'Trait'], '', $trait));
            $list[$callback] = $callback;
        }
        return $list;
    }
}
