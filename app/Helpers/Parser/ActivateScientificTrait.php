<?php

namespace ChemLab\Helpers\Parser;

trait ActivateScientificTrait
{
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
