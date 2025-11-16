<?php

namespace App\Controllers;

use App\Models\V_constanciasModel;

class Excel extends BaseController
{
    public function __construct()
    {
    }

    public function constanciasAction()
    {   
        $url = "https://portal.gerardosescuelademanejo.com.mx/constancias/pdf/";
        $V_constanciasModel = new V_constanciasModel();
        $constancias = $V_constanciasModel->select("id_instructor, CONCAT('G-', year(fecha), folio) folio, nombre_alumno, fecha_inicio, fecha_final, fecha, concat('$url', qr) qr, creacion")->findAll();
        $data = ["Instructor", "Folio", "Alumno", "Inicio de curso", " Fin de curso", "Fecha de constancia", "QR de validacion", "Creación del registro"];
        array_unshift($constancias , $data);
        \App\Libraries\Utilidades::download_xlsx("constancias", $constancias);
    }
}
