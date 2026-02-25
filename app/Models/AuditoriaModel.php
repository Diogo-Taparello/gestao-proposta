<?php 
namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table      = 'auditoria'; // Specifies the database table
    protected $primaryKey = 'id';    // Specifies the primary key

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // 'array' or 'object'
    protected $useSoftDeletes = false;    // Enables soft deletes

    // Fields that are allowed to be inserted/updated
    protected $allowedFields = ['proposta_id', 'actor', 'evento', 'payload'];

    // Dates
    protected $useTimestamps = false; // Automatically manage created_at and updated_at
    protected $createdField  = 'created_at';

    // Validation
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}