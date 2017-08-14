<?php

namespace ChemLab\Helpers\Parser;

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
        $this->callback = camel_case($callback);
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
        $url = url(str_replace('%', $this->catalogId, $brandUrl));

        if (function_exists('file_get_contents')) {
            $content = @file_get_contents($url);
            if ($content === FALSE)
                return false;
        } else {
            $ch = curl_init();

            //curl_setopt($ch, CURLOPT_URL, $url . '?lang=en&region=US');
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);

            $content = curl_exec($ch);
            curl_close($ch);
        }

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

            $callback = kebab_case(str_replace([__NAMESPACE__ . '\\', 'Trait'], '', $trait));
            $list[$callback] = $callback;
        }
        return $list;
    }
}
