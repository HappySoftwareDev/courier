<?php
namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{

    protected $table      = 'api_users';
    protected $primaryKey = 'id';
     protected $allowedFields = [
        'business_name',  'business_email',  'business_phone',  'address', 'password'
    ];

    // protected $returnType     = 'array';
}
?>