<?php
namespace App\Models;

use CodeIgniter\Model;

class PrizelistModel extends Model
{

    protected $table      = 'prizelist';
    protected $primaryKey = 'ID';
    /*protected $allowedFields = [
        'api_key', 'business_name', 'business_email', 'business_phone',  'address', 'api_user_id', 
        'join_date'
    ];*/

    // protected $returnType     = 'array';
}
?>