<?php namespace ChemLab\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function path($type, $full = false)
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

    public static function asort($array, $keyname)
    {
        if (empty($array))
            return array();

        foreach ($array as $key => $row) {
            $aKey[$key] = $row[$keyname];
        }

        array_multisort($aKey, SORT_ASC, $array);
        return $array;
    }

    public static function generateKey($length = 10)
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
    //////////// FILES ////////////
    ///////////////////////////////

    public static function saveFile($fileName, $data, $utf = false)
    {
        $file = fopen($fileName, "w+");

        if ($utf)
            fwrite($file, pack("CCC", 0xef, 0xbb, 0xbf));

        fwrite($file, $data);
        fclose($file);
    }

    public static function readFile($fileName)
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
    public static function getFile($name)
    {
        return Storage::exists($name) ? Storage::get($name) : null;
    }

    public static function readFromZip($archive, $file)
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

    public static function saveToZip($archive, $file, $content)
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

    public static function deleteFromZip($archive, $file)
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

    public static function zipFile($path, $filename, $content)
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
