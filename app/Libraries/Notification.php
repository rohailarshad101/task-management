<?php
namespace App\Libraries;

class Notification
{
    public function send($userId, $message)
    {
        // Logic to store the notification in the database
        $db = \Config\Database::connect();
        $db->table('notifications')->insert([
            'user_id' => $userId,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
