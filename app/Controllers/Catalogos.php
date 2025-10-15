<?php

namespace App\Controllers;

use App\Models\Uc_user_rolModel;
use App\Models\Uc_userModel;
use App\Models\V_uc_userModel;
use App\Models\C_instructores;
use App\Models\C_instructoresModel;

class Catalogos extends BaseController
{
    public function __construct() {}

    /**
     * VISTAS
     */

    public function usuarios()
    {
        $V_uc_userModel = new V_uc_userModel();
        $usuarios = $V_uc_userModel->where("id !=", 0)->orderBy("username", "ASC")->findAll();
        $data = ["usuarios" => $usuarios];
        return view("template/header_sneat") . view("catalogos/usuarios", $data) . view("template/footer_sneat");
    }

    public function instructores()
    {
        $C_instructores = new C_instructoresModel();
        $instructores = $C_instructores->orderBy("id", "DESC")->findAll();
        $data = ["instructores" => $instructores];
        return view("template/header_sneat") . view("catalogos/instructores", $data) . view("template/footer_sneat");
    }



    /**
     * CRUD
     */

    public function updateUsuarioAction()
    {
        if (!isset($_POST["id"], $_POST["username"], $_POST["name"], $_POST["first_lastname"], $_POST["second_lastname"], $_POST["email"], $_POST["phone"], $_POST["status"], $_POST["rol"]))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        $Uc_userModel = new Uc_userModel();
        $username = $Uc_userModel->where("id !=", intval($_POST["id"]))->where("username", $_POST["username"])->findAll();
        if (!empty($username))
            return $this->response->setJson(["status" => 0, "msg" => "Nombre de usuario ya existe"]);
        $data = [
            "username" => $_POST["username"],
            "name" => $_POST["name"],
            "first_lastname" => $_POST["first_lastname"],
            "second_lastname" => $_POST["second_lastname"],
            "email" => $_POST["email"],
            "phone" => $_POST["phone"],
            "status" => $_POST["status"]
        ];
        $Uc_userModel->update(intval($_POST["id"]), $data);
        return $this->response->setJson(["status" => 1, "msg" => "Información actualizada correctamente"]);
    }

    public function insertUsuarioAction()
    {
        if (!isset($_POST["username"], $_POST["name"], $_POST["first_lastname"], $_POST["second_lastname"], $_POST["email"], $_POST["phone"], $_POST["status"], $_POST["rol"], $_POST["password"], $_POST["repassword"]))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        $Uc_userModel = new Uc_userModel();
        $username = $Uc_userModel->where("username", $_POST["username"])->findAll();
        if ($_POST["password"] !== $_POST["repassword"] || $_POST["password"] == "")
            return $this->response->setJson(["status" => 0, "msg" => "Contraseñas no coinciden"]);
        if (!empty($username))
            return $this->response->setJson(["status" => 0, "msg" => "Nombre de usuario ya existe"]);
        $data = [
            "username" => $_POST["username"],
            "name" => $_POST["name"],
            "first_lastname" => $_POST["first_lastname"],
            "password" => \App\Libraries\Utilidades::create_password_hash($_POST["password"]),
            "second_lastname" => $_POST["second_lastname"],
            "email" => $_POST["email"],
            "phone" => $_POST["phone"],
            "status" => $_POST["status"]
        ];
        $id = $Uc_userModel->insert($data);
        if ($id > 0) {
            $Uc_user_rolModel = new Uc_user_rolModel();
            $data = ["id_user" => $id, "id_rol" => $_POST["rol"]];
            $Uc_user_rolModel->insert($data);
            return $this->response->setJson(["status" => 1, "msg" => "Elemento insertado satisfactoriamente"]);
        } else {
            return $this->response->setJson(["status" => 0, "msg" => "No puso insertar el elemento. Intente de nuevo"]);
        }
    }

    public function updateInstructorAction()
    {
        if (!isset($_POST["id"], $_POST["nombre"], $_POST["status"]))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        $C_instructoresModel = new C_instructoresModel();
        $data = [
            "nombre" => $_POST["nombre"],
            "status" => $_POST["status"]
        ];
        $C_instructoresModel->update(intval($_POST["id"]), $data);
        return $this->response->setJson(["status" => 1, "msg" => "Información actualizada correctamente"]);
    }

    public function insertInstructorAction()
    {
        if (!isset($_POST["nombre"], $_POST["status"]))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        $C_instructoresModel = new C_instructoresModel();
        $data = [
            "nombre" => $_POST["nombre"],
            "status" => $_POST["status"]
        ];
        $id = $C_instructoresModel->insert($data);
        if($id == 0)
            return $this->response->setJson(["status" => 0, "msg" => "No puso insertar el elemento. Intente de nuevo"]);
        return $this->response->setJson(["status" => 1, "msg" => "Información actualizada correctamente"]);
    }
}
