<?php
namespace App\Models;
use CodeIgniter\Model;

class Uc_permissionModel extends Model{

protected $table = 'uc_permission';
protected $primaryKey = 'id';
protected $useAutoIncrement = true;
protected $returnType     = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ["id_rol","id_page","crud_create","crud_read","crud_update","crud_delete"];
protected $useTimestamps = false;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
protected $deletedField  = 'deleted_at';
protected $validationRules    = [];
protected $validationMessages = [];
protected $skipValidation     = false; 

}
