<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomConfig extends BaseConfig
{

    public array $file_upload_path = [
        'tasks_file_path' => 'uploads'.DIRECTORY_SEPARATOR.'task_related_documents'.DIRECTORY_SEPARATOR,
    ];

    public array $task_statuses_array = [
//        "Active" => "Active",
        "Pending" => "Pending",
        "In Progress" => "In Progress",
        "On Hold" => "On Hold",
        "Completed" => "Completed",
        "Canceled" => "Canceled",
        "Closed" => "Closed",
    ];

    public array $task_statuses_array_for_user = [
        "Completed" => "Completed",
        "In Progress" => "In Progress",
        "Pending" => "Pending",
    ];

    public array $task_repetition_frequency_array = [
        "Daily" => "Daily",
        "Weekly" => "Weekly",
        "Bi-Weekly" => "Bi-Weekly",
        "Monthly" => "Monthly",
    ];
}
