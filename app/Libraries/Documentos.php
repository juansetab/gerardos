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
        $pdf->Image(base_url("public/images/constancia_base_pdf_2348659823759237523456.jpg"), 0, 0, 279, 215.5, 'JPG');
        $filename = WRITEPATH . "/uploads/temp/" . $constancia["qr"] . ".png";
        $pdf->Image($filename, 210, 140, 55, 55, "png");

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetXY(210, 35);
        $pdf->Cell(50, 7, $this->UFT8(mb_strtoupper("FOLIO", "UTF-8")), 0, 1, "C");
        $pdf->SetFont('Arial', 'B', 25);
        $pdf->SetXY(210, 42);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(50, 8, $this->UFT8(mb_strtoupper("G-$y{$constancia["folio"]}", "UTF-8")), 0, 1, "C");
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 25);
        $pdf->SetXY(37, 103);
        $pdf->Cell(212, 12, $this->UFT8(mb_strtoupper($constancia["nombre_alumno"], "UTF-8")), 0, 1, "C");
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 196);
        $pdf->Cell(212, 12, $this->UFT8("Framboyán 116, Col. Jesús García", "UTF-8"), 0, 1, "L");
        $pdf->SetXY(100, 196);
        $pdf->Cell(212, 12, $this->UFT8("993 322 6612", "UTF-8"), 0, 1, "L");
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
