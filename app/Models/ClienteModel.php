<?php 
namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table      = 'cliente'; // Specifies the database table
    protected $primaryKey = 'id';    // Specifies the primary key

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // 'array' or 'object'
    protected $useSoftDeletes = false;    // Enables soft deletes

    // Fields that are allowed to be inserted/updated
    protected $allowedFields = ['nome', 'email', 'document', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true; // Automatically manage created_at and updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}