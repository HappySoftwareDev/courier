<?php
namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{

    protected $table      = 'api_users_business';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'api_key', 'business_name', 'business_email', 'business_phone',  'address', 'api_user_id', 
        'join_date', 'status'
    ];

    // protected $returnType     = 'array';
}
?>