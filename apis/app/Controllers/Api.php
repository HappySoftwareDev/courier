<?php

namespace App\Controllers;

use App\Models\StoreModel;

use App\Models\SettingModel;
use App\Models\BookingModel;

use App\Models\BusinessModel;
use App\Models\PrizelistModel;
use App\Models\WeightpriceModel;


class Api extends BaseController
{
    private $resp = array();
    private $db;
    private $pk_test;
    private $api_key;
    private $istest_key;

    function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->pk_test = 'pktest_' . md5('merchantcouriers.com');
        $this->istest_key = '';

        $this->store = new StoreModel();
        $this->setting = new SettingModel();
        $this->booking = new BookingModel();
        $this->business = new BusinessModel();
        $this->prizelist = new PrizelistModel();
        $this->weightprice = new WeightpriceModel();
    }
    public function index()
    {
        if ($this->request->getVar('api_key') && $this->request->getVar('api_key') != '') {
            //  print_r($this->request->getVar('api_key'));
            $api_key = $this->request->getVar('api_key');
            if ($api_key == $this->pk_test) {
                return true;
            } else {
                $business_info = $this->business->getWhere(array('api_key' => $api_key))->getRowArray();
                if (!$business_info) {
                    $this->invalidkey();
                } else {
                    return true;
                }
                // $this->invalidkey();
            }
        } else {
            $this->invalidkey();
        }
        /*$this->api_key = $this->set_api_key();
		if($this->istest_key=='invalid')
		{
			$this->invalidkey();
		}
		elseif($this->istest_key=='no')
		{
			//$this->livekey();
		}
		elseif($this->istest_key=='yes')
		{
			$this->testkey();
		}*/
    }
    public function resp($code = '201', $data)
    {
        $this->resp['code'] = $code;
        $this->resp['data'] = $data;
        echo json_encode($this->resp);
    }
    public function print_err($value = '')
    {
        echo "<div style='width:100%; border:1px solid #ededed; background:#ededed; border-radius:5px; margin:0px; padding:0px;'>";
        echo "<pre>";
        print_r($value ? $value : 'Nothing to print');
        echo "</pre>";
        echo "</div>";
        die;
    }
    private function set_api_key()
    {
        if ($this->request->getVar('api_key')) {
            $api_key = $this->request->getVar('api_key');
            $apikey = substr($api_key, 0, 6);
            if ($apikey == 'pktest') {
                //$this->istest_key = 'yes';
            } elseif ($apikey == 'pklive') {
                // $this->istest_key = 'no';
            } else {
                $this->istest_key = 'invalid';
            }
        } else {
            $api_key = $this->pk_test;
            $this->istest_key = 'yes';
        }
        return $api_key;
    }
    private function testkey()
    {
        $code = 200;
        $data = 'Welcome to test APIs panel. Please pass arguments to get response';
        $this->resp($code, $data);
        exit;
    }
    private function invalidkey()
    {
        $code = 201;
        $data = 'Ivalid API key';
        $this->resp($code, $data);
        exit;
    }
    private function livekey()
    {
        $code = 200;
        $data = 'Welcome to APIs panel. Please pass arguments to get response';
        $this->resp($code, $data);
    }
    public function get_pickup_areas()
    {
        $this->index();
        $areas = array();
        $areas[] = 'Harare';
        $areas[] = 'Bulawayo';
        $areas[] = 'Chinhoyi';
        $areas[] = 'Mutare';
        $areas[] = 'Kariba';
        $areas[] = 'Kwekwe';
        $areas[] = 'Kadoma';
        $areas[] = 'Chegutu';
        $areas[] = 'Gweru';
        $areas[] = 'Plumtree';
        $areas[] = 'Gwanda';
        $areas[] = 'Zvishavane';
        $areas[] = 'Masvingo';
        $areas[] = 'Beitbridge';
        $areas[] = 'Chivhu';
        $areas[] = 'Chiredzi';
        $areas[] = 'Bindura';
        $areas[] = 'Victoria Falls';
        $areas[] = 'Other';
        $code = 200;
        $data = $areas;
        $this->resp($code, $data);
    }
    public function get_dropoff_areas()
    {
        $this->index();
        $areas = array();
        $areas[] = 'Harare';
        $areas[] = 'Bulawayo';
        $areas[] = 'Chinhoyi';
        $areas[] = 'Mutare';
        $areas[] = 'Kariba';
        $areas[] = 'Kwekwe';
        $areas[] = 'Kadoma';
        $areas[] = 'Chegutu';
        $areas[] = 'Gweru';
        $areas[] = 'Plumtree';
        $areas[] = 'Gwanda';
        $areas[] = 'Zvishavane';
        $areas[] = 'Masvingo';
        $areas[] = 'Beitbridge';
        $areas[] = 'Chivhu';
        $areas[] = 'Chiredzi';
        $areas[] = 'Bindura';
        $areas[] = 'Victoria Falls';
        $areas[] = 'Other';
        $code = 200;
        $data = $areas;
        $this->resp($code, $data);
    }
    public function get_package_weight()
    {
        $this->index();
        $weight = array();
        $weight[] = "0-1 KG";
        $weight[] = "1.1-2 KG";
        $weight[] = "2.1-3 KG";
        $weight[] = "3.1-4 KG";
        $weight[] = "4.1-5 KG";
        $weight[] = "5.1-6 KG";
        $weight[] = "6.1-7 KG";
        $weight[] = "7.1-8 KG";
        $weight[] = "8.1-9 KG";
        $weight[] = "9.1-10 KG";
        $weight[] = "10.1-11 KG";
        $weight[] = "11.1-12 KG";
        $weight[] = "12.1-13 KG";
        $weight[] = "13.1-14 KG";
        $weight[] = "14.1-15 KG";
        $weight[] = "15.1-16 KG";
        $weight[] = "16.1-17 KG";
        $weight[] = "17.1-18 KG";
        $weight[] = "18.1-19 KG";
        $weight[] = "19.1-20 KG";
        $weight[] = "more";
        $code = 200;
        $data = $weight;
        $this->resp($code, $data);
    }
    public function get_package_value()
    {
        $this->index();
        $data[] = "$1,00 - $50,00";
        $data[] = "$50,00 - $100,00";
        $data[] = "$100,00 - $500,00";
        $data[] = "$500,00 - $1000,00";
        $data[] = "$1000,00 - Above";
        $code = 200;
        $this->resp($code, $data);
    }
    public function get_package_quantity()
    {
        $this->index();
        $data[1] = '1 Package';
        $data[2] = '2 Packages';
        $data[3] = '3 Packages';
        $data[4] = '4 Packages';
        $data[5] = '5 Packages';
        $data[6] = '6 Packages';
        $data[7] = '7 Packages';
        $data[8] = '8 Packages';
        $data[9] = '9 Packages';
        $data[10] = '10 Packages';
        $data[11] = '11 Packages';
        $data[12] = '12 Packages';
        $data[13] = '13 Packages';
        $data[14] = '14 Packages';
        $data[15] = '15 Packages';
        $data[16] = '16 Packages';
        $data[17] = '17 Packages';
        $data[18] = '18 Packages';
        $data[19] = '19 Packages';
        $data[15] = '15 Packages';
        $data[16] = '16 Packages';
        $data[17] = '17 Packages';
        $data[18] = '18 Packages';
        $data[19] = '19 Packages';
        $data[15] = '15 Packages';
        $data[16] = '16 Packages';
        $data[17] = '17 Packages';
        $data[18] = '18 Packages';
        $data[19] = '19 Packages';
        $data[20] = '20 Packages';
        $data[21] = '21 Packages';
        $data[22] = '22 Packages';
        $data[23] = '23 Packages';
        $data[24] = '24 Packages';
        $data[25] = '25 Packages';
        $code = 200;
        $this->resp($code, $data);
    }
    public function get_transport_options()
    {
        $this->index();

        $data['Car'] = 'Car';
        $data['Motorbike'] = 'Motorbike';
        $data['Van'] = 'Van';

        $code = 200;
        $this->resp($code, $data);
    }
    public function get_insurance_options()
    {
        $this->index();

        $data['yes'] = 'Yes';
        $data['no'] = 'No';

        $code = 200;
        $this->resp($code, $data);
    }
    public function get_pickup_time_options()
    {
        $this->index();
        $data[] = '6:00 am - to - 7:00 am';
        $data[] = '7:00 am - to - 8:00 am';
        $data[] = '8:00 am - to - 9:00 am';
        $data[] = '9:00 am - to - 10:00 am';
        $data[] = '10:00 am  to - 11:00 am';
        $data[] = '11:00 am - to - 12:00 pm';
        $data[] = '12:00 pm - to - 1:00 pm';
        $data[] = '1:00 pm - to - 2:00 pm';
        $data[] = '2:00 pm - to - 3:00 pm';
        $data[] = '3:00 pm - to - 4:00 pm';
        $data[] = '4:00 pm - to - 5:00 pm';
        $data[] = '5:00 pm - to - 6:00 pm';
        $data[] = '6:00 pm - to - 7:00 pm';

        $code = 200;
        $this->resp($code, $data);
    }
    public function get_deliver_time_options()
    {
        $this->index();
        $data[] = '6:00 am - to - 7:00 am';
        $data[] = '7:00 am - to - 8:00 am';
        $data[] = '8:00 am - to - 9:00 am';
        $data[] = '9:00 am - to - 10:00 am';
        $data[] = '10:00 am  to - 11:00 am';
        $data[] = '11:00 am - to - 12:00 pm';
        $data[] = '12:00 pm - to - 1:00 pm';
        $data[] = '1:00 pm - to - 2:00 pm';
        $data[] = '2:00 pm - to - 3:00 pm';
        $data[] = '3:00 pm - to - 4:00 pm';
        $data[] = '4:00 pm - to - 5:00 pm';
        $data[] = '5:00 pm - to - 6:00 pm';
        $data[] = '6:00 pm - to - 7:00 pm';

        $code = 200;
        $this->resp($code, $data);
    }
    public function save_booking()
    {


        $validation =  \Config\Services::validation();
        $validation->setRules([
            "api_key" => ["label" => "Api Key", "rules" => "required"],
            "pickup_date" => ["label" => "Pickup Date", "rules" => "required"],
            "pickup_time" => ["label" => "Pickup Time", "rules" => "required"],
            "customer_name" => ["label" => "Customer Name", "rules" => "required|min_length[3]|max_length[50]"],
            "Customer_email" => ["label" => "Customer Email", "rules" => "required|min_length[3]|max_length[60]|valid_email"],
            "Customer_phone" => ["label" => "Customer phone", "rules" => "required"],
            "receiver_name" => ["label" => "receiver Name", "rules" => "required"],
            "receiver_phone" => ["label" => "Receiver Phone", "rules" => "required"],
            "drop_address" => ["label" => "Drop Address", "rules" => "required"],
            "drop_time" => ["label" => "Drop Time", "rules" => "required"],
            "drop_date" => ["label" => "Drop date", "rules" => "required"],
            "drop_area" => ["label" => "Drop Area", "rules" => "required"],
            "price_in" => ["label" => "Price Unit", "rules" => "required"],
            "insurance" => ["label" => "Insurance Confirmation", "rules" => "required"],
            "weight_of_package" => ["label" => "Package Weight", "rules" => "required"],
            "value_of_package" => ["label" => "Package Value", "rules" => "required"],
            "package_quantity" => ["label" => "Package Quantity", "rules" => "required"],
            "transport" => ["label" => "Transport Type", "rules" => "required"],
            "total_price" => ["label" => "Total Price", "rules" => "required"]
        ]);
        if ($validation->withRequest($this->request)->run()) {
            $api_key = $this->request->getVar('api_key');
            // 			print_r($this->request->getVar()); die;
            $business_info = $this->business->getWhere(array('api_key' => $api_key))->getRowArray();

            /*$data = $business_info;
					$code = 200;
					$this->resp($code, $data);
					die;*/
            if ($business_info) {


                $pickup_time = $this->request->getVar('pickup_time');
                $pickup_date = $this->request->getVar('pickup_date');
                $user_fullname = $this->request->getVar('customer_name');
                $user_email = $this->request->getVar('Customer_email');
                $user_phone = $this->request->getVar('Customer_phone');
                $drop_address = $this->request->getVar('drop_address');
                $drop_area = $this->request->getVar('drop_area');
                $drop_date = $this->request->getVar('drop_date');
                $drop_time = $this->request->getVar('drop_time');
                $receiver_name = $this->request->getVar('receiver_name');
                $receiver_phone = $this->request->getVar('receiver_phone');
                $weight_of_package = $this->request->getVar('weight_of_package');
                $value_of_package = $this->request->getVar('value_of_package');
                $package_quantity = $this->request->getVar('package_quantity');
                $total_price = $this->request->getVar('total_price');

                $transport = $this->request->getVar('transport');
                $vehicle_type = 'Parcel Delivery';
                $order_number = rand(10000, 99999);
                $note = $this->request->getVar('note');
                $price_in = $this->request->getVar('price_in');
                $insurance  = $this->request->getVar('insurance');
                $more_weight  = $this->request->getVar('more_weight');

                // var_dump($business_info); die;
                $payable = $this->calculateTotal($price_in, $business_info['address'], $drop_address, $total_price, $business_info['area'], $drop_area, $weight_of_package, $value_of_package, $transport, $package_quantity, $chk = 0, $more_weight, $insurance);
                // var_dump($payable); die;
                $outputDistt = $this->getDistance($business_info['address'], $drop_address);
                $insert_booking = array(
                    'pick_up_address' => $business_info['address'],
                    'pick_up_time' => $pickup_time,
                    'pick_up_date' => $pickup_date,
                    'Name' => $user_fullname,
                    'phone' => $user_phone,
                    'email' => $user_email,
                    'drop_address' => $drop_address,
                    'drop_date' => $drop_date,
                    'drop_time' => $drop_time,
                    'Drop_name' => $receiver_name,
                    'drop_phone' => $receiver_phone,
                    'Total_price' => $payable,
                    'distance' => $outputDistt . 'km',
                    'weight' => $weight_of_package,
                    'insurance' => $insurance,
                    'quantity' => $package_quantity,
                    'value' => $value_of_package,
                    'type_of_transport' => $transport,
                    'vehicle_type' => $vehicle_type,
                    'order_number' => $order_number,
                    'drivers_note' => $note,
                    'business_id' => $business_info['id'],
                    'business_user_id' => $business_info['api_user_id']
                );
                $ok = $this->booking->insert($insert_booking);
                if ($ok) {
                    $data = 'your Booking id is : ' . $ok . ' and order number is : ' . $order_number;
                    $code = 200;
                    $this->resp($code, $data);
                } else {
                    $data = 'Something went wrong please try again';
                    $code = 201;
                    $this->resp($code, $data);
                }
            } else {
                $data = 'API Key error';
                $code = 201;
                $this->resp($code, $data);
            }
        } else {
            $data = $validation->getErrors();
            $code = 201;
            $this->resp($code, $data);
        }
    }
    public function getInterCityPrice($area_deliva = '')
    {
        // $company_name =
        $row_type = $this->prizelist->getWhere(array('company_name' => 'merchant'))->getRowArray();

        $InterCityPrice = 0;
        $ID = $row_type['ID'];
        $Price_per_km = $row_type['Price_per_km'];

        $weight = $row_type['Weight'];
        $Insurance = $row_type['Insurance'];
        $Base_price = $row_type['Base_price'];
        $Cost_per_item = $row_type['Cost_per_item'];

        $min_freight = $row_type['min_freight'];


        switch ($area_deliva) {
            case "Harare":
                $InterCityPrice = $row_type['Harare'];
                break;
            case "Bulawayo":
                $InterCityPrice = $row_type['Bulawayo'];
                break;
            case "Banket":
                $InterCityPrice = $row_type['Banket'];
                break;
            case "Karoi":
                $InterCityPrice = $row_type['Karoyi'];
                break;
            case "Chinhoyi":
                $InterCityPrice = $row_type['Chinhoyi'];
                break;
            case "Chegutu":
                $InterCityPrice = $row_type['Chegutu'];
                break;
            case "Gweru":
                $InterCityPrice = $row_type['Gweru'];
                break;
            case "Kwekwe":
                $InterCityPrice = $row_type['Kwekwe'];
                break;
            case "Kadoma":
                $InterCityPrice = $row_type['Kadoma'];
                break;
            case "Mutare":
                $InterCityPrice = $row_type['Mutare'];
                break;
            case "Kariba":
                $InterCityPrice = $row_type['Kariba'];
                break;
            case "Plumtree":
                $InterCityPrice = $row_type['Plumtree'];
                break;
            case "Gwanda":
                $InterCityPrice = $row_type['Gwanda'];
                break;
            case "Zvishavane":
                $InterCityPrice = $row_type['Zvishavane'];
                break;
            case "Masvingo":
                $InterCityPrice = $row_type['Masvingo'];
                break;
            case "Beitbridge":
                $InterCityPrice = $row_type['Beitbridge'];
                break;
            case "Chivhu":
                $InterCityPrice = $row_type['Chivhu'];
                break;
            case "Bubi":
                $InterCityPrice = $row_type['Bupi'];
                break;
            case "Chiredzi":
                $InterCityPrice = $row_type['Chiredzi'];
                break;
            case "Hwange":
                $InterCityPrice = $row_type['Hwange'];
                break;
            case "Rusape":
                $InterCityPrice = $row_type['Rusape'];
                break;
            case "Bindura":
                $InterCityPrice = $row_type['Bindura'];
                break;
            case "Mt Darwin":
                $InterCityPrice = $row_type['MtDarwin'];
                break;
            case "Mvurwi":
                $InterCityPrice = $row_type['Mvurwi'];
                break;
            case "Victoria Falls":
                $InterCityPrice = $row_type['VictoriaFalls'];
                break;
            case "Binga":
                $InterCityPrice = $row_type['Binga'];
                break;
            case "Other":
                $InterCityPrice = $row_type['other'];
                break;
        }
        return $InterCityPrice;
    }
    public function getWeightPrice($selectedValue = '', $more_weight = '')
    {
        $row_type = $this->weightprice->getWhere(array('id' => 1))->getRowArray();
        $id = $row_type['id'];
        $weight_range = $row_type['weight_range0'];
        $weight_range1 = $row_type['weight_range1'];
        $weight_range2 = $row_type['weight_range2'];
        $weight_range3 = $row_type['weight_range3'];
        $weight_range4 = $row_type['weight_range4'];
        $weight_range5 = $row_type['weight_range5'];
        $weight_range6 = $row_type['weight_range6'];
        $weight_range7 = $row_type['weight_range7'];
        $weight_range8 = $row_type['weight_range8'];
        $weight_range9 = $row_type['weight_range9'];
        $weight_range10 = $row_type['weight_range10'];
        $weight_range11 = $row_type['weight_range11'];
        $weight_range12 = $row_type['weight_range12'];
        $weight_range13 = $row_type['weight_range13'];
        $weight_range14 = $row_type['weight_range14'];
        $weight_range15 = $row_type['weight_range15'];
        $weight_range16 = $row_type['weight_range16'];
        $weight_range17 = $row_type['weight_range17'];
        $weight_range18 = $row_type['weight_range18'];
        $weight_range19 = $row_type['weight_range19'];
        $weight_range20 = $row_type['weight_range20'];

        $packageWeightRange = 0;
        switch ($selectedValue) {
            case "0-1 KG":
                $packageWeightRange = $weight_range;
                break;
            case "1.1-2 KG":
                $packageWeightRange = $weight_range1;
                break;
            case "2.1-3 KG":
                $packageWeightRange = $weight_range2;
                break;
            case "3.1-4 KG":
                $packageWeightRange = $weight_range3;
                break;
            case "4.1-5 KG":
                $packageWeightRange = $weight_range4;
                break;
            case "5.1-6 KG":
                $packageWeightRange = $weight_range5;
                break;
            case "6.1-7 KG":
                $packageWeightRange = $weight_range6;
                break;
            case "7.1-8 KG":
                $packageWeightRange = $weight_range7;
                break;
            case "8.1-9 KG":
                $packageWeightRange = $weight_range8;
                break;
            case "9.1-10 KG":
                $packageWeightRange = $weight_range9;
                break;
            case "10.1-11 KG":
                $packageWeightRange = $weight_range10;
                break;
            case "11.1-12 KG":
                $packageWeightRange = $weight_range11;
                break;
            case "12.1-13 KG":
                $packageWeightRange = $weight_range12;
                break;
            case "13.1-14 KG":
                $packageWeightRange = $weight_range13;
                break;
            case "14.1-15 KG":
                $packageWeightRange = $weight_range14;
                break;
            case "15.1-16 KG":
                $packageWeightRange = $weight_range15;
                break;
            case "16.1-17 KG":
                $packageWeightRange = $weight_range16;
                break;
            case "17.1-18 KG":
                $packageWeightRange = $weight_range17;
                break;
            case "18.1-19 KG":
                $packageWeightRange = $weight_range18;
                break;
            case "19.1-20 KG":
                $packageWeightRange = $weight_range19;
                break;
            case "20 KG-above":
                $packageWeightRange = $weight_range20;
                break;
            case "more":
                $w20_more = $weight_range20;
                $weight2019 = $weight_range19;
                $above_weight_p = $w20_more * $more_weight - $weight2019;
                $packageWeightRange = $weight2019 + $above_weight_p;
                break;
        }
        return $packageWeightRange;
    }
    function getValuePrice($value = '')
    {
        $row_type = $this->prizelist->find(array('company_name' => 'merchant'));
        $value_L1 = $row_type['value_L1'];
        $value_L2 = $row_type['value_L2'];
        $value_L3 = $row_type['value_L3'];
        $value_L4 = $row_type['value_L4'];
        $value_L5 = $row_type['value_L5'];
        $packageValuePrice = 0;
        switch ($value) {
            case  "$1,00 - $50,00":
                $packageValuePrice = $value_L1;
            case  "$50,00 - $100,00":
                $packageValuePrice = $value_L2;
            case  "$100,00 - $500,00":
                $packageValuePrice = $value_L3;
            case  "$500,00 - $1000,00":
                $packageValuePrice = $value_L4;
            case  "$1000,00 - Above":
                $packageValuePrice = $value_L5;
        }
        return $packageValuePrice;
    }


    private function getQuantityPrice($quantity = 0)
    {
        $row_type = $this->prizelist->getWhere(array('company_name' => 'merchant'))->getRowArray();
        $Cost_per_item = $row_type['Cost_per_item'];
        $packageQuantityPrice = 0;
        $totalQuantity = $Cost_per_item;
        $selectedQuantity = $quantity;
        $packageQuantityPrice = (float)$totalQuantity * (float)$selectedQuantity;
        // var_dump($packageQuantityPrice); die;

        return $packageQuantityPrice;
    }

    private function getCarPrice($transport = '')
    {
        $row_type = $this->prizelist->getWhere(array('company_name' => 'merchant'))->getRowArray();
        $Car_per_km = $row_type['Car_per_km'];
        $bike = $row_type['bike'];
        $van = $row_type['van'];
        $CarPrice = 0;
        switch ($transport) {
            case "Car":
                $CarPrice = $Car_per_km;
                break;
            case "Motorbike":
                $CarPrice = $bike;
                break;
            case "Van":
                $CarPrice = $van;
                break;
        }
        return $CarPrice;
    }

    private function getInsurancePrice($price_in = 'USD', $selectedInsurance = 'no', $total_rice)
    {
        $row_type = $this->prizelist->getWhere(array('company_name' => 'merchant'))->getRowArray();
        $zim_dollar_rate = $row_type['zim_dollar_rate'];
        $Insurance = $row_type['Insurance'];

        $InsurancePrice = 0;
        $rate_price_in = $price_in;
        $zim_rtgs_rate = $zim_dollar_rate;
        $totPricett = $total_rice;
        $InsurancePercentage = $Insurance;
        // $selectedInsurance = $insurance;
        if ($selectedInsurance == "yes") {
            if ($rate_price_in == "RTGS") {
                $totPricett = $totPricett / $zim_rtgs_rate;
            }
            $InsurancePrice = ($InsurancePercentage / 100) * $totPricett;
        } else if ($selectedInsurance == "no") {
            $InsurancePrice = 0;
        }
        return $InsurancePrice;
    }

    private function getDistance($addressFrom, $addressTo, $unit = 'K')
    {

        // Google API key
        $setting = $this->get_settings();
        $apiKey = $setting->google_api;

        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);

        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if (!empty($outputFrom->error_message)) {
            return $outputFrom->error_message;
        }

        // Geocoding API request with end address
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrTo . '&sensor=false&key=' . $apiKey);
        $outputTo = json_decode($geocodeTo);
        if (!empty($outputTo->error_message)) {
            return $outputTo->error_message;
        }

        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;

        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;

        // Convert unit and return distance
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return round($miles * 1.609344, 2);
        } elseif ($unit == "M") {
            return round($miles * 1609.344, 2) . ' meters';
        } else {
            return round($miles, 2) . ' miles';
        }
    }
    public function calculateTotal($price_in = 'USD', $addressFrom, $addressTo, $total_rice, $area_pick = '', $area_d = '', $weight = '', $value = '', $transport = '', $quantity = '', $chk = 0, $more_weight = '', $insurance = 'no')
    {
        $row_type = $this->prizelist->getWhere(array('company_name' => 'merchant'))->getRowArray();
        $zim_dollar_rate = $row_type['zim_dollar_rate'];
        $intaCityP = $this->getInterCityPrice($area_d);
        $WeightRangeP = $this->getWeightPrice($weight, $more_weight);
        $InsPrice = $this->getInsurancePrice($price_in, $insurance, $total_rice);
        // $InsPrice = 0;
        $valueprice = $this->getValuePrice($value);
        $carprice = $this->getCarPrice();
        $quantityprice = $this->getQuantityPrice($quantity);
        $actaulPrice = $valueprice + $carprice + $quantityprice + $InsPrice;
        $outputDistt = $this->getDistance($addressFrom, $addressTo);
        $totDist = $outputDistt * (float)$row_type['zim_dollar_rate'];
        if ($area_pick != $area_d) {
            $roundTp = $WeightRangeP + $intaCityP + $InsPrice;
            $roundTpp = $WeightRangeP + $intaCityP + $InsPrice;
            $min = (float)$row_type['min_parcel'];
            // var_dump($min); die;
            if ($roundTpp < $min) {
                $roundTpp =  $min;
            }
            if ($roundTp < $min) {
                $roundTp =  $min;
            }
        } else if ($area_pick == $area_d) {
            $roundTp = $totDist + $actaulPrice;
            $roundTpp = $totDist + $actaulPrice;
            $min = (float)$row_type['min_parcel'];

            if ($roundTpp < $min) {
                $roundTpp = $min;
            }
            if ($roundTp < $min) {
                $roundTp = $min;
            }
        }

        if ($price_in == "RTGS") {

            $roundTp = $roundTp * $zim_dollar_rate;
            $roundTpp = $roundTpp * $zim_dollar_rate;
        } else if ($price_in == "USD") {
            $roundTp = $roundTp;
            $roundTpp = $roundTpp;
        }
        // var_dump($roundTpp); die;
        return $roundTpp;
        /*_('tp_phase1').innerHTML = roundTp.toFixed(2);
		_('tp_phase2').innerHTML = roundTp.toFixed(2);
	    _('tp').innerHTML = roundTp.toFixed(2);
	    _('tpp').value = roundTpp.toFixed(2);*/
    }
    private function get_settings()
    {
        return $this->setting->get()->getRow();
    }

}