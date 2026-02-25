<?php 
namespace App\Models;

use CodeIgniter\Model;

class PropostaModel extends Model
{
    protected $table      = 'proposta'; // Specifies the database table
    protected $primaryKey = 'id';    // Specifies the primary key

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // 'array' or 'object'
    protected $useSoftDeletes = true;    // Enables soft deletes

    // Fields that are allowed to be inserted/updated
    protected $allowedFields = ['cliente_id', 'produto', 'valor_mensal', 'status', 'origem', 'versao'];

    // Dates
    protected $useTimestamps = false; // Automatically manage created_at and updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}