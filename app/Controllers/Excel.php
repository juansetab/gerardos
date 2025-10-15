<?php

namespace App\Controllers;

use App\Models\C_analisisModel;
use App\Models\C_clientesModel;
use App\Models\V_excel_analisisModel;
use App\Models\V_muestrasModel;
use App\Models\V_reporte_generalModel;

class Excel extends BaseController
{
    public function __construct()
    {
    }

    public function reportesAction()
    {   
        $C_clientesModel = new C_clientesModel();
        $clientes = $C_clientesModel->select("primer_apellido, segundo_apellido, nombres, clinica, telefono, correo, status, creacion")->findAll();
        $data = ["Primer apellido", "Segundo apellido", "Nombre", "Clínica", "Teléfono", "Correo electrónico", "Status", "Creación"];
        array_unshift($clientes , $data);
        \App\Libraries\Utilidades::download_xlsx("catalogo_clientes", $clientes);
    }
}
