<?php
namespace App\Models;
use CodeIgniter\Model;

class V_uc_permissionsModel extends Model{

protected $table = 'v_uc_permissions';
protected $primaryKey = 'id';
protected $useAutoIncrement = true;
protected $returnType     = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ["id_user","id_rol","rol","username","page","controller","create","read","update","delete"];
protected $useTimestamps = false;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
protected $deletedField  = 'deleted_at';
protected $validationRules    = [];
protected $validationMessages = [];
protected $skipValidation     = false; 

}