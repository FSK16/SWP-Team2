<?php
function createfile(string $filepath, string $filename, string $phpcode){

    if (!is_dir($filepath)) {

        if (mkdir($filepath, 0755, true)) {
        }
    }

    $filename = $filepath.'/'.$filename;

    if (file_put_contents($filename, $phpcode)) 
    {

    } 
    else {


    }

}

/**
 * @param $datum Das Datum muss im Format YYYY-MM-DD Uhrzeit sein
 */
function formatdate($datum)
{
    $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datum);
    return $datetime->format('d.m.Y');
}


?>