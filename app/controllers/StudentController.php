<?php 
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); 
class StudentController extends Controller
{
    public function index()
    {
        // Allow access to profile route
        $_SESSION['student_access'] = true;
        
        $this->call->view('student_homepage');
    }

    public function profile()
    {
        $student = [
            'student_id' => 'MCC2024-00088',
            'name'       => 'John Eris B. De Guzman',
            'course'     => 'BS Information Technology',
            'year'       => '3rd Year',
            'section'    => '3F2',
            'email'      => 'johnerisdg@gmail.com',
            'address'    => 'Brgy. Tawiran Gumamela St. Calapan City Oriental Mindoro, Philippines',
            'contact'    => '+63 909 567 8451',
            'skills'     => 'A bit of HTML, Computer Assembly, UI Design',
            'hobbies'    => 'Gaming, Listening to Music, Watching Movies, Drawing/Painting ',
            'quote'      => 'Nothing changes if nothing changes.'
        ];

        $this->call->view('student_profile', $student);
    }
}
