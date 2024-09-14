<?php

namespace App\Controllers;

use App\Models\StoreModel;

class Login extends BaseController
{
    public $db;
    private $store;
    function __construct()
    {
        // $this->db = \Config\Database::connect();
        // parent::__construct();
        parent::__construct();
        $this->db = db_connect();
        $this->store = new StoreModel();
    }
    public function index()
    {
        return redirect()->to('login');
    }
    public function login()
    {
        if ($this->session->has('logged_in')) {
            // var_dump('expresdddddsion'); die;
            return redirect()->to('dashboard');
        } else {
            // var_dump('expression'); die;
            return view('login');
        }
    }
    public function forget_password()
    {
        if ($this->session->has('logged_in')) {
            // var_dump('expresdddddsion'); die;
            return redirect()->to('dashboard');
        } else {
            if ($_POST) {
                $newpassword = rand();
                $email = $this->request->getVar('email');
                $a = $this->store->getWhere(array('business_email' => $email))->getRow();
                if (!empty($a)) {
                    $storeid = $a->id;
                    $newdata = [
                        'password'  => $newpassword,
                    ];

                    $ok = $this->store->update($storeid, $newdata);
                    if ($ok) {
                        $msg = 'Your  password successfully changed<br>New Password is: ' . $newpassword . '<br>Thanks for your business with us.<br>Merchantcourier Team';
                        $subject = 'Password Recovered';
                        $to = $a->business_email;
                        $ok = send_mail($msg, $subject, $to);
                        $this->session->setFlashdata('msg', 'Please check your email and follow the instructions');

                        return redirect()->to(base_url() . '/login');
                    } else {
                        $this->session->setFlashdata('error', 'Email not found');

                        return redirect()->to(base_url() . '/forget-password');
                        // var_dump($this->session->get('userdata'));
                    }
                } else {
                    $this->session->setFlashdata('error', 'Email not found');

                    return redirect()->to(base_url() . '/forget-password');
                }
            }
            return view('forgot-password');
        }
    }
    public function register()
    {
        if ($this->session->has('logged_in')) {
            // var_dump('expresdddddsion'); die;
            return redirect()->to('dashboard');
        } else {
            if ($_POST) {
                $newpassword = rand();
                $validation =  \Config\Services::validation();
                $validation->setRules([
                    "name" => ["label" => "Business Name", "rules" => "required|min_length[3]|max_length[50]"],
                    "phone" => ["label" => "Phone", "rules" => "required|min_length[3]|max_length[14]"],
                    "email" => ["label" => "Email", "rules" => "required|min_length[3]|max_length[50]|valid_email|is_unique[api_users.business_email]"],
                ]);
                if ($validation->withRequest($this->request)->run()) {
                    $datum = array(
                        'business_name' => $this->request->getVar('name'),
                        'business_email' => $this->request->getVar('email'),
                        'business_phone' => $this->request->getVar('phone'),
                        'password' => $newpassword,
                        'join_date' => date('Y-m-d h:s:i'),
                    );
                    $ok = $this->store->insert($datum, false);
                    // 	$ok = false;
                    if ($ok) {
                        $msg = 'Your account created successfully<br>Your Password is: ' . $newpassword . '<br>Please login to your account create your store, get API key and start delivery at customers home. Thanks for your business with us.<br>Merchantcourier Team';
                        $subject = 'Account Created';
                        $to = $this->request->getVar('email');
                        $ok = send_mail($msg, $subject, $to);
                        $this->session->setFlashdata('msg', 'Please check your email and follow the instructions');

                        return redirect()->to(base_url() . '/login');
                    } else {
                        $this->session->setFlashdata('error', 'Something went wrong please try again');
                        return redirect()->back()->withInput();
                    }
                } else {
                    return redirect()->back()->withInput();
                }
            }
            return view('register');
        }
    }
    public function logincheck()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $a = $this->store->getWhere(array('business_email' => $email, 'password' => $password))->getRow();
        // var_dump($a); die;
        if (!empty($a)) {
            if ($a->status == 'active') {

                $newdata = [
                    'userdata'  => $a,
                    'logged_in' => TRUE
                ];

                $this->session->set($newdata);
                echo "ok";
            } else {
                echo "notok";

                // var_dump($this->session->get('userdata'));
            }
        } else {
            echo "not_found";
        }
        // var_dump($this->session());
    }

    public function logout()
    {
        $this->session->remove('userdata');
        $this->session->remove('logged_in');
        return view('login');
    }


    //--------------------------------------------------------------------

}
