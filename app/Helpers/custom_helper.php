<?php
function getUserFormattedDate($date = null) {
    if(!empty($date)){
        return date("d-m-Y", strtotime($date));
    } else {
        return date('d-m-Y');
    }

}

function getDBFormattedDate($date = null) {
    if(!empty($date)){
        return date("Y-m-d", strtotime($date));
    } else {
        return date('Y-m-d');
    }

}

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
     $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision).' '. $units[$pow];
}

function insertLineBreakAfterLength($message, $length)
{
    if (strlen($message) > $length) {
        $message = substr_replace($message, '<br>', $length, 0);
    }
    return $message;
}

?>
