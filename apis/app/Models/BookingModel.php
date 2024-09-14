<?php
namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{

    protected $table      = 'bookings';
    protected $primaryKey = 'order_id';
    protected $allowedFields = [
        'pick_up_address',
		'pick_up_time',
		'pick_up_date',
		'Name',
		'phone',
		'email',
		'drop_address',
		'drop_date',
		'drop_time',
		'Drop_name',
		'drop_phone',
		'Total_price',
		'distance',
		'weight',
		'insurance',
		'quantity',
		'value',
		'type_of_transport',
		'vehicle_type',
		'order_number',
		'drivers_note',
		'business_id',
		'business_user_id',
		'status'
    ];

    // protected $returnType     = 'array';
}
?>