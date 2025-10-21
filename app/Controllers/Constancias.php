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


    public function consultar()
    {
        return view("constancias/consultar");
    }

    public function validar()
    {
        if(!isset($_POST["nombre"], $_POST["folio"]))
            return view("errors/html/error_404");
        if (!preg_match('/^G-\d{8}$/', "G-".$_POST["folio"]))
            return view("errors/html/error_404");
        $nombre = $this->request->getPost('nombre');
        $V_constanciasModel = new V_constanciasModel();
        $nombre = $V_constanciasModel->escapeLikeString($nombre);
        $constancia = $V_constanciasModel->like('nombre_alumno', $nombre, 'both')->findAll();
        if(empty($constancia))
            return view("errors/html/error_404");
        return redirect()->to('/constancias/pdf/'.$constancia[0]["qr"]);
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
            return view("errors/html/error_404");
        if (!ctype_xdigit($qr))
            return view("errors/html/error_404");
        $ConstanciasModel = new ConstanciasModel();
        $constancia = $ConstanciasModel->where("qr", $qr)->first();
        if (empty($constancia))
            return view("errors/html/error_404");
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
