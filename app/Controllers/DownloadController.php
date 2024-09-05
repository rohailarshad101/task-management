<?php


namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class DownloadController extends BaseController
{
    public function downloadFile($filename)
    {
        // Set the path to the writable/uploads/task_related_documents directory
        $filePath = FCPATH . 'uploads/task_related_documents/' . $filename;

        // Check if the file exists
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setBody('File not found');
        }

        // Use the response object to initiate the download
        return $this->response->download($filePath, null);
    }
}
