<?php
namespace App\Models;
use CodeIgniter\Model;

class Uc_userModel extends Model{

protected $table = 'uc_user';
protected $primaryKey = 'id';
protected $useAutoIncrement = true;
protected $returnType     = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ["id","username","password","name","first_lastname","second_lastname","alias","email","phone","img","status","creation","status"];
protected $useTimestamps = false;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
protected $deletedField  = 'deleted_at';
protected $validationRules    = [];
protected $validationMessages = [];
protected $skipValidation     = false; 

}