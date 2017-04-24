<?php

namespace ChemLab\Helpers;

class Parser
{
    /**
     * @var array
     */
    private $brands;

    /**
     * @var callable
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

    public function __construct($catalogId, callable $callback, array $brands)
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
     * @param $brandId
     * @param $brandUrl
     * @return array|bool
     */
    private function sigmaAldrich($brandId, $brandUrl)
    {
        $data = $this->data;

        $dom = $this->getUrlContent($brandUrl);
        if (!$dom)
            return $data;

        if ($dom->getElementsByTagName('title')->item(0) == 'No Result Page')
            return $data;

        // parse Name
        $h1 = $dom->getElementsByTagName('h1')->item(0);
        if ($h1 && $h1->getAttribute('itemprop') == 'name')
            $data['name'] = $h1->textContent;
        else
            return $data;

        // Data seems legit, set brand ID and continue gathering rest of data
        $data['brand_id'] = $brandId;

        $h2 = $dom->getElementsByTagName('h2')->item(0);
        if ($h2 && $h2->getAttribute('itemprop') == 'description')
            $data['description'] = $h2->textContent;

        // Synonyms, CAS, PubChem Substance ID
        foreach ($dom->getElementsByTagName('p') as $item) {
            if (empty($data['synonym']) && $item->getAttribute('class') == 'synonym')
                $data['synonym'] = strip_tags(str_replace('Synonym:', '', preg_replace("/\s\s+/", " ", $item->textContent)));
            else if (empty($data['cas']) && stripos(($item->textContent), 'CAS Number') !== false)
                $data['cas'] = strip_tags(str_replace('CAS Number', '', $item->textContent));
            else if (empty($data['mw']) && stripos(($item->textContent), 'Molecular Weight') !== false)
                $data['mw'] = strip_tags(str_replace('Molecular Weight', '', $item->textContent));
            else if (empty($data['pubchem']) && stripos(($item->textContent), 'PubChem Substance ID') !== false)
                $data['pubchem'] = strip_tags(str_replace('PubChem Substance ID ', '', $item->textContent));
        }

        // MSDS Data
        foreach ($dom->getElementsByTagName('div') as $item) {

            if ($item->getAttribute('class') != 'safetyRight')
                continue;

            switch ($item->getAttribute('id')) {
                case 'Symbol':
                    $data['symbol'] = explode(',', strip_tags(str_replace(' ', '', $item->textContent)));
                    $data['symbol'] = array_map('trim', $data['symbol']);
                    break;
                case 'Signal word':
                    $data['signal_word'] = strip_tags($item->textContent);
                    break;
                case 'Hazard statements':
                    $data['h'] = explode('-', strip_tags(str_replace(' ', '', $item->textContent)));
                    $data['h'] = array_map('trim', $data['h']);
                    break;
                case 'Precautionary statements':
                    $data['p'] = explode('-', strip_tags(str_replace(' ', '', $item->textContent)));
                    $data['p'] = array_map('trim', $data['p']);
                    break;
                default:
                    break;
            }
        }

        // There is some Unicode shit spaces in pubChem and we need to remove it, trim won't work!
        $data['pubchem'] = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $data['pubchem']);
        $data['symbol'] = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $data['symbol']);
        $data = array_map(function ($data) {
            return is_string($data) ? trim($data) : $data;
        }, $data);

        return $data;
    }

    /**
     * @param $brandId
     * @param $brandUrl
     * @return array|bool
     */
    private function activateScientific($brandId, $brandUrl)
    {
        $data = $this->data;

        $dom = $this->getUrlContent($brandUrl);
        if (!$dom)
            return $data;

        // parse Name
        $h1 = $dom->getElementsByTagName('h1')->item(0);
        if ($h1 && $h1->getAttribute('itemprop') == 'name')
            $data['name'] = $h1->textContent;
        else
            return $data;

        // Data seems legit, set brand ID and continue gathering rest of data
        $data['brand_id'] = $brandId;

        // TODO: watch out - there is a second table with same id
        $table = $dom->getElementById('ArtikelThisInfoBox');

        // parse Synonyms, CAS, PubChem Substance ID
        foreach ($table->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');

            switch (str_replace(['#', ':', ''], '', $tds->item(0)->textContent)) {
                case 'C.A.S.':
                    $data['cas'] = str_replace(['[', ']'], '', $tds->item(1)->textContent);
                    break;
                case 'Formula':
                    $data['formula'] = $tds->item(1)->textContent;
                    break;
                case 'Mass':
                    $data['mw'] = $tds->item(1)->textContent;
                    break;
                case 'Appearance':
                case 'Colour':
                case 'Hazardous Classification':
                case 'Storage Temp':
                    $data['description'][] = $tds->item(1)->textContent;
                    break;
            }
        }

        $data['description'] = implode(';', $data['description']);

        $data = array_map(function ($data) {
            return is_string($data) ? trim($data) : $data;
        }, $data);

        return $data;
    }
}
