<?php namespace ChemLab\Helpers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * The View Factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new Helper builder instance.
     *
     * @param \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param \Illuminate\Contracts\View\Factory $view
     */
    public function __construct(UrlGenerator $url = null, Factory $view)
    {
        $this->url = $url;
        $this->view = $view;
    }

    public function path($type, $full = false)
    {
        $string = '';
        switch ($type) {
            case 'sdfArchive';
                $string = 'sdfArchive.zip';
                break;
            case 'dump';
                $string = 'dump/';
                break;
        }

        return $full ? storage_path() . '/app/' . $string : $string;
    }

    public function searchSession()
    {
        return Session::has('search') ? Session::get('search') : array(
            'name' => null,
            'brand_no' => null,
            'cas' => null,
            'chemspider' => null,
            'formula' => null,
            'inchikey' => null,
            'store_id' => null,
            'department_id' => null,
            'date' => null,
            'date_operant' => null,
            'sdf' => null,
        );
    }

    public function asort($array, $keyname)
    {
        if (empty($array))
            return array();

        foreach ($array as $key => $row) {
            $aKey[$key] = $row[$keyname];
        }

        array_multisort($aKey, SORT_ASC, $array);
        return $array;
    }

    public function generateKey($length = 10)
    {
        $key = '';
        $possible = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $i = 0;
        while ($i < $length) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            // we don't want this character if it's already in the password
            //if (!strstr($key, $char)) {
            $key .= $char;
            $i++;
            //}
        }
        return $key;
    }

    ///////////////////////////////
    ///////// DATA PARSING ////////
    ///////////////////////////////

    private function curl_download($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?lang=en&region=US');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function parseAldrichData($brandId, $brandNo, $brandPattern)
    {
        $url = url(str_replace('%', $brandNo, $brandPattern));
        if (function_exists('file_get_contents'))
        {
            $content = @file_get_contents($url);
            if ($content === FALSE)
                return false;
        }
        else
            $content = curl_download($url);

        $dom = new \DOMDocument();
        $dom->recover = true;
        $dom->strictErrorChecking = false;
        @$dom->loadHTML($content);

        $data = array(
            'state' => 'valid',
            'brand_id' => '0',
            'cas' => '',
            'pubchem' => '',
            'mw' => '',
            'name' => '',
            'synonym' => '',
            'description' => '');

        if ($dom->getElementsByTagName('title')->item(0) == 'No Result Page')
            return false;   //$data;

        // parse Name
        $h1 = $dom->getElementsByTagName('h1')->item(0);
        if ($h1 && $h1->getAttribute('itemprop') == 'name')
            $data['name'] = $h1->textContent;
        else
            return false;   //$data;

        $data['brand_id'] = $brandId;
        $h2 = $dom->getElementsByTagName('h2')->item(0);
        if ($h2 && $h2->getAttribute('itemprop') == 'description')
            $data['description'] = $h2->textContent;

        // parse Synonyms, CAS, PubChem Substance ID
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

        // There is some Unicode shit spaces in pubChem and we need to remove it, trim won't work!
        $data['pubchem'] = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $data['pubchem']);
        $data = array_map('trim', $data);

        return $data;
    }

    ///////////////////////////////
    //////////// FILES ////////////
    ///////////////////////////////

    public function saveFile($fileName, $data, $utf = false)
    {
        $file = fopen($fileName, "w+");

        if ($utf)
            fwrite($file, pack("CCC", 0xef, 0xbb, 0xbf));

        fwrite($file, $data);
        fclose($file);
    }

    public function readFile($fileName)
    {
        if (file_exists($fileName)) {
            $handle = fopen($fileName, "r");
            $data = fread($handle, filesize($fileName));
            fclose($handle);
            return $data;
        }
        return null;
    }

    // Laravel storage wrapper
    public function getFile($name)
    {
        return Storage::exists($name) ? Storage::get($name) : null;
    }

    public function readFromZip($archive, $file)
    {
        $handle = fopen('zip://' . $archive . '#' . $file, 'r');
        if (!$handle)
            return '';
        $result = '';
        while (!feof($handle)) {
            $result .= fread($handle, 8192);
        }
        fclose($handle);
        return $result;
    }

    public function saveToZip($archive, $file, $content)
    {
        if (!file_exists($archive))
            return false;

        $zip = new \ZipArchive();
        $res = $zip->open($archive);
        if ($res !== true)
            return false;

        $zip->addFromString($file, $content);
        $zip->close();
        return true;
    }

    public function deleteFromZip($archive, $file)
    {
        if (!file_exists($archive))
            return false;

        $zip = new \ZipArchive();
        $res = $zip->open($archive);
        if ($res !== true)
            return false;

        $zip->deleteName($file);
        $zip->close();
        return true;
    }

    public function zipFile($path, $filename, $content)
    {
        $archive = $path . $filename . ".zip";
        $file = $filename . ".sql";
        if (file_exists($archive))
            return false;

        $zip = new \ZipArchive();
        if ($zip->open($archive, \ZIPARCHIVE::CREATE) !== true)
            return false;

        $zip->addFromString($file, $content);
        $zip->close();
        return true;
    }
}
