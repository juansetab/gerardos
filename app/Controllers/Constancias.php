<?php

namespace App\Controllers;

use App\Libraries\Ciqrcode;
use App\Models\C_instructoresModel;
use App\Models\ConstanciasModel;
use App\Models\V_constanciasModel;
use App\Libraries\Documentos;

class Constancias extends BaseController
{
    public function __construct() {}

    /**
     * VISTAS
     */

    public function index()
    {
        $V_constanciasModel = new V_constanciasModel();
        $C_instructores = new C_instructoresModel();
        $contancias = $V_constanciasModel->where("status", 1)->findAll();
        $instructores = $C_instructores->where("status", 1)->findAll();
        $data = ["constancias" => $contancias, "instructores" => $instructores];
        return view("template/header_sneat") . view("constancias/index", $data) . view("template/footer_sneat");
    }

    public function nuevo() {}

    /**
     * CRUD
     */

    public function updateConstanciaAction()
    {
        if (!isset($_POST["id"], $_POST["id_instructor"], $_POST["folio"], $_POST["nombre_alumno"], $_POST["fecha_inicio"], $_POST["fecha_final"], $_POST["fecha"]))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        $ConstanciasModel = new ConstanciasModel();
        $data = [
            "id_instructor" => $_POST["id_instructor"],
            "folio" => $_POST["folio"],
            "nombre_alumno" => $_POST["nombre_alumno"],
            "fecha_inicio" => $_POST["fecha_inicio"],
            "fecha_final" => $_POST["fecha_final"],
            "fecha" => $_POST["fecha"]
        ];
        $ConstanciasModel->update(intval($_POST["id"]), $data);
        return $this->response->setJson(["status" => 1, "msg" => "Información actualizada correctamente"]);
    }

    public function insertConstanciaAction()
    {
        if (!isset($_POST["id_instructor"], $_POST["folio"], $_POST["nombre_alumno"], $_POST["fecha_inicio"], $_POST["fecha_final"], $_POST["fecha"], $_POST["status"]))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        $ConstanciasModel = new ConstanciasModel();
        $data = [
            "id_instructor" => $_POST["id_instructor"],
            "folio" => $_POST["folio"],
            "nombre_alumno" => $_POST["nombre_alumno"],
            "fecha_inicio" => $_POST["fecha_inicio"],
            "fecha_final" => $_POST["fecha_final"],
            "fecha" => $_POST["fecha"],
            "qr" => strtoupper(dechex(time())),
            "status" => 1
        ];
        $id = $ConstanciasModel->insert($data);
        if ($id == 0)
            return $this->response->setJSON(array("status" => 0, "msg" => "No se pudo guardar la información"));
        return $this->response->setJSON(array("status" => 1, "msg" => "¡Guardado!"));
    }

    /**
     * FORMATOS
     */
    public function pdf($qr = null)
    {
        if (is_null($qr))
            return $this->response->setJSON(array("status" => 0, "msg" => "Falta información"));
        if (!ctype_xdigit($qr))
            return $this->response->setJSON(array("status" => 0, "msg" => "Parámetros inválidos"));
        $ConstanciasModel = new ConstanciasModel();
        $constancia = $ConstanciasModel->where("qr", $qr)->first();
        if (empty($constancia))
            return $this->response->setJSON(array("status" => 0, "msg" => "No se halló información"));
        $ciqrcode = new Ciqrcode();
        $filename = WRITEPATH . "/uploads/temp/" . $constancia["qr"] . ".png";
        $config['cacheable'] = true;
        $config['quality'] = true;
        $config['size'] = '1024';
        $config['black'] = [255, 255, 255];
        $config['white'] = [255, 255, 255];
        $ciqrcode->initialize($config);
        $params['data'] = base_url("constancias/validar/" . $constancia["qr"]);
        $params['level'] = 'L';
        $params['size'] = 10;
        $params['savename'] = $filename;
        $ciqrcode->generate($params);
        $Documentos = new Documentos();
        $Documentos->constancia($constancia);
    }
}
