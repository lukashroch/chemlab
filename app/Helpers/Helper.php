<?php

namespace ChemLab\Helpers;

use Illuminate\Support\Facades\Storage;
use ZIPARCHIVE;

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

    // TODO: unit stuff should be reworked at some point
    public static function unit($unit, $val)
    {
        if (empty($val))
            return "";

        $aUnit = explode(',', $unit);
        $aUnit = array_values(array_diff($aUnit, array(0)));
        if (!count($aUnit))
            return $val . __('chemical.unit');

        $aUnitDef = array(
            [1000, 'mG', 'µL', 'unit'],
            [1, 'G', 'mL', 'unit'],
            [0.001, 'kG', 'L', 'unit']);

        $mp = $val >= 1 ? ceil($val / 1000) : 0;
        $mp = $mp > 2 ? 2 : $mp;
        $val = $val * $aUnitDef[$mp][0];

        $sUnit = "";
        foreach ($aUnit as $key => $value) {
            $sUnit != "" && $sUnit .= "/";
            $sUnit .= $aUnitDef[$mp][$value];
        }

        return round($val, 2) . $sUnit;
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

        $zip = new ZipArchive();
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

        $zip = new ZipArchive();
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

        $zip = new ZipArchive();
        if ($zip->open($archive, ZIPARCHIVE::CREATE) !== true)
            return false;

        $zip->addFromString($file, $content);
        $zip->close();
        return true;
    }
}
