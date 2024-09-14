<?php

namespace App\Controllers;

use App\Models\StoreModel;
use App\Models\SettingModel;
use App\Models\BusinessModel;
use App\Models\BookingModel;


class Home extends BaseController
{
    public $db;
    private $store;
    function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->store = new StoreModel();
        $this->setting = new SettingModel();
        $this->business = new BusinessModel();
        $this->booking = new BookingModel();

        // $this->checkloggin();
    }

    public function dashboard()
    {
        // var_dump($this->session->get('logged_in')); die;
        $this->checkloggin();
        $user_id = $this->session->get()['userdata']->id;
        $data['setting'] = $this->get_settings();
        $data['title'] = str_replace('-', ' ', ucfirst($this->request->uri->getSegment(1)));
        $data['username'] = $this->session->get()['userdata']->business_name;
        $data['storecount'] = $this->business->where('api_user_id', $user_id)->get()->getResult();
        $data['data'] =  $this->booking->limit(5)->orderBy('order_id', 'desc')->getWhere(array('business_user_id' => $user_id))->getResult();
        $data['total_business'] = $this->booking->selectSum('Total_price')->where('business_user_id', $user_id)->get()->getRow();
        $data['orders'] = $this->booking->selectCount('order_id')->where('business_user_id', $user_id)->get()->getRow();

        // var_dump($this->business->getLastQuery());
        // var_dump($data['graph']); die;

        return view('dashboard', $data);
    }
    public function add_store()
    {
        $user_id = $this->session->get('userdata')->id;
        // var_dump($user_id); die;
        $data['setting'] = $this->get_settings();
        $data['title'] = $data['title'] = str_replace('-', ' ', ucfirst($this->request->uri->getSegment(1)));
        $data['username'] = $this->session->get()['userdata']->business_name;
        $data['storecount'] = $this->business->where('api_user_id', $user_id)->get()->getResult();
        if ($this->request->getMethod() == "post") {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "business_name" => ["label" => "Business Name", "rules" => "required|min_length[3]|max_length[100]"],
                "phone" => ["label" => "Phone", "rules" => "required|min_length[3]|max_length[15]"],
                "business_email" => ["label" => "Email", "rules" => "required|min_length[3]|max_length[250]|valid_email|is_unique[api_users_business.business_email]"],
                "contact_person" => ["label" => "Contact Person", "rules" => "required|min_length[3]|max_length[100]"],
                "address" => ["label" => "Address", "rules" => "required"],
                "area" => ["label" => "Area", "rules" => "required"],
            ]);
            if ($validation->withRequest($this->request)->run()) {
                $datum = array(
                    'business_name' => $this->request->getVar('business_name'),
                    'business_email' => $this->request->getVar('business_email'),
                    'business_phone' => $this->request->getVar('phone'),
                    'address' => $this->request->getVar('address'),
                    'api_user_id' => $user_id,
                    'join_date' => date('Y-m-d h:s:i'),
                    'area' => $this->request->getVar('address')
                );
                $this->business->insert($datum, false);
                $msg = 'New store succesfuly created with the name ' . $datum['business_name'] . ' on ' . $datum['join_date'] . ' for your account. Please manage your store and create API Key for your new store.<br>Thanks for your business with us.<br>Merchantcourier Team';
                $subject = 'New Store Created';
                $to = $this->session->get('userdata')->business_email;
                $ok = send_mail($msg, $subject, $to);
                if ($ok) {
                    //var_dump('expression');
                } else {
                    //var_dump('expression1');
                }
                // die;
                return redirect()->to(base_url() . '/my-stores');
                // var_dump($this->business->getLastQuery()); die;
            } else {
                $data['errors'] = $validation->getErrors();
            }
        }
        return view('addstore', $data);
    }
    public function my_stores($store_id = '', $action = '')
    {
        $this->checkloggin();
        if ($action == 'inactiveAPI') {
            $up['status'] = 'ban';
            $ok = $this->business->update($store_id, $up);

            $this->session->setFlashdata('msg', 'Deleted');
        }
        if ($action == 'activeAPI') {
            $up['status'] = 'active';
            $ok = $this->business->update($store_id, $up);

            $this->session->setFlashdata('msg', 'Deleted');
        }
        if ($action == 'del') {
            $this->business->delete($store_id);
            $this->session->setFlashdata('msg', 'Deleted');
        }
        if ($action == 'api-key') {
            $store = $this->business->find($store_id);
            // var_dump($store); die;
            $up['api_key'] = 'pklive_' . md5($store['id'] . $store['business_email']);
            $ok = $this->business->update($store_id, $up);
            if ($ok) {
                // $this->business->insert($datum, false);
                $msg = 'API Key succesfuly created for your store.<br>Thanks for your business with us.<br>Merchantcourier Team';
                $subject = 'Api Key Created';
                $to = $this->session->get('userdata')->business_email;
                $ok = send_mail($msg, $subject, $to);
                $this->session->setFlashdata('msg', 'Succesfuly created');
                // return redirect()->to(base_url().'/my-stores');
            } else {
                $this->session->setFlashdata('error', 'something went wrong please try again');
                // return redirect()->to(base_url().'/my-stores');
            }
            // var_dump($up); die;

        }
        $user_id = $this->session->get('userdata')->id;
        $data['setting'] = $this->get_settings();
        $data['title'] = $data['title'] = str_replace('-', ' ', ucfirst($this->request->uri->getSegment(1)));
        $data['username'] = $this->session->get()['userdata']->business_name;
        $data['storecount'] = $this->business->where('api_user_id', $user_id)->get()->getResult();

        return view('stores', $data);
    }

    public function my_orders()
    {
        $this->checkloggin();
        $user_id = $this->session->get('userdata')->id;
        $data['setting'] = $this->get_settings();
        $data['title'] = $data['title'] = str_replace('-', ' ', ucfirst($this->request->uri->getSegment(1)));
        $data['username'] = $this->session->get()['userdata']->business_name;
        $data['storecount'] = $this->business->where('api_user_id', $user_id)->get()->getResult();
        $data['data'] =  $this->booking->getWhere(array('business_user_id' => $user_id))->getResult();
        if ($this->request->getVar('order_id')) {
            $update = array(
                'status' => $this->request->getVar('status'),
            );
            $ok = $this->booking->update($this->request->getVar('order_id'), $update);
            $this->session->setFlashdata('msg', 'Soon a Driver will pickup the delivery');

            return redirect()->to(base_url() . '/my-orders');
        }
        return view('my-orders', $data);
    }
    public function profile()
    {

        $user_id = $this->session->get('userdata')->id;
        // var_dump(expression)
        $data['setting'] = $this->get_settings();
        $data['title'] = $data['title'] = str_replace('-', ' ', ucfirst($this->request->uri->getSegment(1)));
        $data['username'] = $this->session->get()['userdata']->business_name;
        $data['storecount'] = $this->business->where('api_user_id', $user_id)->get()->getResult();
        $data['user'] = $this->store->find($user_id);
        if ($this->request->getMethod() == "post") {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "business_name" => ["label" => "Business Name", "rules" => "required|min_length[3]|max_length[50]"],
                "phone" => ["label" => "Phone", "rules" => "required|min_length[10]|max_length[14]"],

                "address" => ["label" => "Address", "rules" => "required"],
            ]);
            if ($validation->withRequest($this->request)->run()) {
                $datum = array(
                    'business_name' => $this->request->getVar('business_name'),
                    'business_phone' => $this->request->getVar('phone'),
                    'address' => $this->request->getVar('address'),
                );
                $ok = $this->store->update($user_id, $datum);
                if ($ok) {
                    $data['msg'] = 'Updated Successfuly';
                    return redirect()->to(base_url() . '/profile');
                } else {
                    $data['errors'] = 'Something went wrong please try again';
                    return redirect()->to(base_url() . '/profile');
                }
            } else {
                $data['errors'] = $validation->getErrors();
                return redirect()->to(base_url() . '/profile');
            }
        }
        // var_dump($data['user']); die;
        return view('profile', $data);
    }
    public function change_password()
    {

        $user_id = $this->session->get('userdata')->id;
        $data['setting'] = $this->get_settings();
        $data['title'] = $data['title'] = str_replace('-', ' ', ucfirst($this->request->uri->getSegment(1)));
        $data['username'] = $this->session->get()['userdata']->business_name;
        $data['storecount'] = $this->business->where('api_user_id', $user_id)->get()->getResult();
        $data['user'] = $this->store->first($user_id);
        if ($this->request->getMethod() == "post") {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "oldpassword" => ["label" => "Old Password", "rules" => "required|min_length[3]|max_length[50]"],
                "newpassword" => ["label" => "New Password", "rules" => "required|min_length[6]|max_length[50]"],
                "c_password" => ["label" => "Confirm password", "rules" => "required|matches[newpassword]"],
            ]);
            if ($validation->withRequest($this->request)->run()) {
                $password = $this->store->find($user_id);
                // var_dump($password);
                // var_dump($password['password']); die;
                if ($password['password'] == $this->request->getVar('oldpassword')) {
                    $datum = array(
                        'password' => $this->request->getVar('newpassword'),
                    );
                    $ok = $this->store->update($user_id, $datum);
                    if ($ok) {
                        $msg = 'Your password successfully changed<br>Thanks for your business with us.<br>Merchantcourier Team';
                        $subject = 'Password Changed';
                        $to = $this->session->get('userdata')->business_email;
                        $ok = send_mail($msg, $subject, $to);
                        $this->session->setFlashdata('msg', 'Updated Successfuly');
                        return redirect()->back()->withInput();
                    } else {
                        $this->session->setFlashdata('error', 'Something went wrong please try again');
                        return redirect()->back()->withInput();
                    }
                } else {
                    $this->session->setFlashdata('error', 'Old Password does not matched');
                    return redirect()->back()->withInput();
                }
            } else {
                // $this->session->setFlashdata('error', $validation->getErrors());
                return redirect()->back()->withInput();
            }
        }
        // var_dump($data['user']); die;
        return view('password-change', $data);
    }
    public function checkloggin()
    {
        // var_dump($this->session->get('logged_in')); die;
        if ($this->session->get('logged_in') == TRUE) {
        } else {
            return redirect()->to('login');
        }
    }
    private function get_settings()
    {
        return $this->setting->get()->getRow();
    }
    public function mail_test($value = '')
    {
        send_mail();
    }

    //--------------------------------------------------------------------

}
