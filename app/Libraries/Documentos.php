<?php

namespace App\Libraries;

use Config\App;

class Documentos
{

    public function __construct() {}

    public function constancia($constancia)
    {
        setlocale(LC_ALL, 'es_ES.UTF-8', 'es_ES', 'spanish');
        $pdf = new FPDF("L", "mm", "LETTER", true, '', false);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(false);
        $y = date("Y", strtotime($constancia["fecha"]));
        $pdf->SetTitle("Constancia G-$y{$constancia['folio']}");
        $pdf->AddPage();
        $pdf->Image(base_url("public/images/constancia_base_pdf_2348659823759237523456349567234.jpg"), 0, 0, 279, 215.5, 'JPG');
        $filename = WRITEPATH . "/uploads/temp/" . $constancia["qr"] . ".png";
        $pdf->Image($filename, 210, 140, 45, 45, "png");
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetXY(28, 57.6);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(30, 8, $this->UFT8(mb_strtoupper($constancia['folio'], "UTF-8")), 0, 1, "R");
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetXY(37, 98);
        $pdf->Cell(212, 12, $this->UFT8(mb_strtoupper($constancia["nombre_alumno"], "UTF-8")), 0, 1, "C");
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetXY(10, 135);
        $fechaInicio = \App\Libraries\Utilidades::date_to_text($constancia["fecha_inicio"], false, "d");
        $fechaFinal = \App\Libraries\Utilidades::date_to_text($constancia["fecha_final"], false, "d");
        $periodoTxt = "";
        $fechaInicio["m"] = ucfirst($fechaInicio["m"]);
        $fechaFinal["m"] = ucfirst($fechaFinal["m"]);
        if($fechaInicio["y"] == $fechaFinal["y"]){
            if($fechaInicio["m"] == $fechaFinal["m"]){
                $periodoTxt = "Del " . $fechaInicio["d"] . " al " . $fechaFinal["d"] . " de " . $fechaInicio["m"] . " del " . $fechaInicio["y"];
            }else{
                $periodoTxt = "Del " . $fechaInicio["d"] . " de " . $fechaInicio["m"] . " al " . $fechaFinal["d"] . " de " . $fechaFinal["m"] . " del " . $fechaInicio["y"];
            }
        }else{
            $periodoTxt = "Del " . $fechaInicio["d"] . " de " . $fechaInicio["m"] . " del " . $fechaInicio["y"] . " al " . $fechaFinal["d"] . " de " . $fechaFinal["m"] . " del " . $fechaFinal["y"];

        }
        $pdf->Cell(260, 5, $this->UFT8($periodoTxt, "UTF-8"), 0, 1, "C");
        $fecha = \App\Libraries\Utilidades::date_to_text($constancia["fecha"], false, "d");
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetXY(140, 196);
        $pdf->Cell(212, 12, $this->UFT8("Villahermosa, Tabasco a {$fecha['d']} de {$fecha['m']} de {$fecha['y']}", "UTF-8"), 0, 1, "L");
        die($pdf->Output("I"));
    }

    public function UFT8($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    }
}
