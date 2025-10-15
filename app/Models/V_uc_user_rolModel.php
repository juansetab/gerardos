<?php
namespace App\Models;
use CodeIgniter\Model;

class V_uc_user_rolModel extends Model{

protected $table = 'v_uc_user_rol';
protected $primaryKey = 'id';
protected $useAutoIncrement = true;
protected $returnType     = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ["id_user","id_rol","rolname","username"];
protected $useTimestamps = false;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
protected $deletedField  = 'deleted_at';
protected $validationRules    = [];
protected $validationMessages = [];
protected $skipValidation     = false; 

}
