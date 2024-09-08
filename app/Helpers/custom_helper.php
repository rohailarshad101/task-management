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

function addTaskComment($task_comment_id, $comment, $status = null)
{
    $taskStatusLogModel = new \App\Models\TaskStatusLog();

    $data = [
        'task_comment_id' => $task_comment_id,
        'comment' => $comment ?? NULL,
        'status' => $status ?? 'No status change',
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $taskStatusLogModel->save($data);
}

function generateRandomPassword($length = 12): string
{
    // Define the characters that will be used in the password.
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    // Generate a random password.
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, $charactersLength - 1);
        $randomPassword .= $characters[$randomIndex];
    }
    return $randomPassword;
}

function hash_password($password) {
   return password_hash($password, PASSWORD_BCRYPT);
}

function calculateTimeDiff($created_at) {
    // Convert the given datetime string to a DateTime object
    $givenDate = new DateTime($created_at);

    // Get the current date and time
    $currentDate = new DateTime();

    // Calculate the difference between the two DateTime objects
    $interval = $currentDate->diff($givenDate);

    // Extract days, hours, minutes, and seconds from the interval
    $daysDifference = $interval->days;
    $hoursDifference = $interval->h;
    $minutesDifference = $interval->i;
    $secondsDifference = $interval->s;

    // Determine the most appropriate time unit to return
    if ($daysDifference > 0) {
        return $daysDifference . ' day(s) ago';
    } elseif ($hoursDifference > 0) {
        return $hoursDifference . ' hour(s) ago';
    } elseif ($minutesDifference > 0) {
        return $minutesDifference . ' minute(s) ago';
    } else {
        return $secondsDifference . ' second(s) ago';
    }
}


?>
