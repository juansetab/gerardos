<?php 

namespace App\Libraries;

use App\Models\Uc_actionsModel;
use App\Models\Uc_pageModel;
use App\Models\Uc_userModel;
use App\Models\V_uc_permissionsModel;

class UserControl{

    public static function login_validation($user, $pass){
        $model_users = new Uc_userModel();
        $user_result = $model_users->where("status", 1)->like("username", substr($user, 0, 3), 'after')->findAll();
        if($model_users === false)
            return array("status" => false, "msg" => "Ha ocurrido un error, contacte al administrador");
		foreach($user_result as $u){
            $vrfy_pass = \App\Libraries\Utilidades::verify_password($pass, $u["password"]);
			if($vrfy_pass == true && $user == $u["username"]){
                $model_permissions = new V_uc_permissionsModel();
                $user_permissions = $model_permissions->where("username", $user)->findAll();
                $finded = array_search("0", array_column($user_permissions, 'id_rol')); //Busca si existe el controlador y nombre
                if($finded !== false){
                    $superadmin = true;
                    $uc_pagesModel = new uc_pageModel();
                    $user_permissions = $uc_pagesModel->select("*, name as page, concat(controller,name) as search_key")->findAll();
                }else{
                    $superadmin = false;
                }
				$user_data = array(
					'id'  => $u["id"],
					'username'  => $u["username"],
					'name'  => $u["name"],
					'first_lastname'  => $u["first_lastname"],
					'second_lastname'  => $u["second_lastname"],
                    'img'  => $u["img"],
                    'isSuperAdmin' => $superadmin
				);
                //die("ok");
                session()->set("session_started", true);
                session()->set("user_data", $user_data);
                session()->set("user_permissions", $user_permissions);
				return array("status" => true);
			}
		}
        return array("status" => false, "msg" => "Credenciales erróneas");
    }

    /**
     * Valida que el usuario tenga acceso a la página web
     * @param user es el id del usuario
     * @param page es el id de la página
     * @return bool true si existe registro, false si no existe registro
     */
    
    private static function user_page_validation($controller, $page, $crud){
        $session = session();
        if($session->get('session_started') != true) //Valida si existe la variable session_started que se asigna al momento de iniciar sesión
            return array("status" => false, "msg" => "No ha iniciado una sesión por lo que no tiene permiso de acceder"); //Si no existe es que no se inició sesión
        $permissions = $session->get('user_permissions');
        if(empty($permissions))
            return array("status" => false, "msg" => "No se te han otorgado accesos, contacta al administrador");
        if($session->get('user_data')['isSuperAdmin'] === true)
            return array("status" => true);
        $finded = array_search(ucfirst($controller).$page, array_column($permissions, 'search_key')); //Busca si existe el controlador y nombre
        if($finded !== false){
                if($crud){ //Si solo valida los permisos del crud
                    return array("status" => boolval($permissions[$finded][$crud]));
                }
                return array("status" => true, "permissions" => array("update" => $permissions[$finded]['update'], 
                            "create" => $permissions[$finded]['create'], "delete" => $permissions[$finded]['delete']));
        }else{
            return array("status" => false, "msg" => "No tiene las credenciales necesarias para ver esta página");
        }
    }

    public static function page_permission($controller, $page){
        $permissions = self::user_page_validation(strtolower($controller), $page, false);
        if($permissions["status"] == true){
            return true;
        }else{
            $data = array("controller" => $controller, "page" => $page, "msg" => $permissions["msg"]);
            die(view('login/index', $data));
        }
    }

    public static function crud_permission($controller, $page, $crud){
        $permissions = self::user_page_validation($controller, $page, $crud);
        if($permissions["status"] == true){
            return $permissions;
        }else{
            die(json_encode(array("status" => 0, "msg" => "No tiene permitido realizar esta acción")));
        }
    }

    public static function action_permission($action){
        if(session()->get('session_started') !== true) //Valida si existe la variable session_started que se asigna al momento de iniciar sesión
            die(json_encode(array("status" => false, "msg" => "No ha iniciado una sesión por lo que no tiene permiso de acceder"))); //Si no existe es que no se inició sesión
        if(session()->get('user_data')['isSuperAdmin'] === true)
            return array("status" => true);
        $uc_actionsModel = new uc_actionsModel();
        $permissions = $uc_actionsModel->where("name", $action)->findAll(1);
        if(empty($permissions))
            die(json_encode(array("status" => false, "msg" => "Error 404. El método al que intentas acceder no existe")));
        $permissions = $permissions[0];
        $finded = array_search($permissions["search_key"], array_column(session()->get("user_permissions"), 'search_key')); //Busca si existe el controlador y nombre
        if($finded === false)
            die(json_encode(array("status" => false, "msg" => "Error 403. No tienes permitido accesar a este método")));
        if(session()->get("user_permissions")[$finded][$permissions["crud"]] != "1")
            die(json_encode(array("status" => false, "msg" => "Error 403. No tienes permitido ejecutar esta acción")));
        return array("status" => true);
    }
    
}