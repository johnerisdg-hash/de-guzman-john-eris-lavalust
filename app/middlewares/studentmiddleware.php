<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle()
    {
        if (isset($_SESSION['student_access']) && $_SESSION['student_access'] === true) {
            return true; // allow access
        } else {
            redirect('student'); // redirect to home if not allowed
            return false;
        }
    }
}