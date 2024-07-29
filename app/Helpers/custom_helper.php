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
?>
