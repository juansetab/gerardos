<?php
namespace App\Models;
use CodeIgniter\Model;

class Uc_rolModel extends Model{

protected $table = 'uc_rol';
protected $primaryKey = 'id';
protected $useAutoIncrement = true;
protected $returnType     = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ["id","name","description","status","creation"];
protected $useTimestamps = false;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
protected $deletedField  = 'deleted_at';
protected $validationRules    = [];
protected $validationMessages = [];
protected $skipValidation     = false; 

}
