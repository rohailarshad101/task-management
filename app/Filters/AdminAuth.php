<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Assuming you have a session or auth service to check user roles
        $session = session();
        $userRole = $session->get('user_role'); // Example role retrieval

        // Check if the user is an admin
        if ($userRole !== 'super_admin') {
            // If not an admin, redirect to a forbidden page or home page
            return redirect()->to('/forbidden'); // or any other appropriate route
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No need for post-processing in this case
    }
}
