<?php 
namespace Apps\Models;

use Cygnite\Database\Schema;
use Cygnite\Foundation\Application;
use Cygnite\Common\UrlManager\Url;
use Cygnite\Database\ActiveRecord;

class User extends ActiveRecord
{

    //your database connection name
    protected $database = 'tutorials';

    // your table name here (Optional)
    //protected $tableName = 'shopping_product';

    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }
}// End of the ShoppingProducts Model