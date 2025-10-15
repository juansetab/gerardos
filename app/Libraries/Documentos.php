<?php

namespace App\Libraries;

use Config\App;

class Documentos
{

    public function __construct() {}

    public function nota_venta($lote, $ALL_DATA, $cliente, $desc)
    {
        $pdf = new FPDF("P", "mm", "LETTER", true, '', false);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetTitle('Nota de venta');

        $subtotal = 0;
        $descuento = 0;
        $iva = 0;
        $total = 0;
        foreach ($ALL_DATA as $r) {
            $pdf->AddPage();
            $pdf->Image(base_url("public/images/morelab-logo-color.jpeg"), 160, 10, 40, 0, 'JPEG');
            $pdf->Image(base_url("public/images/morelab-logo-color-bn.jpg"), 45, 100, 120, 0, 'JPG');

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("LLUVIA GUADALUPE MORENO PEREZ"), 0, 1, "C");
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("MOPL8601017J5"), 0, 1, "C");
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("CALLEJON LOS MANGOS SIN NÚMERO"), 0, 1, "C");
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("Ria. GONZALEZ 1RA SECCION, CENTRO"), 0, 1, "C");
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("C.P. 86280"), 0, 1, "C");
            $pdf->Ln(2);
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("Régimen de las Personas Fisicas con Actividades"), 0, 1, "C");
            $pdf->SetX(58);
            $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("Empresariales y Profesionales"), 0, 1, "C");
            $pdf->Ln(6);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetX(58);
            $pdf->Cell(100, 3, "NOTA DE VENTA", 0, 1, "C");
            $pdf->Ln(5);
            $text_size = 8.5;
            $cell_size = 4;
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Nombre:"), 0, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(78, $cell_size, \App\Libraries\Utilidades::uft8_iso($cliente["nombres"] . " " . $cliente["primer_apellido"] . " " . $cliente["segundo_apellido"]), 0, 0, "L");
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("No. Caso:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(29, $cell_size, \App\Libraries\Utilidades::uft8_iso($r["caso"]["no_caso"]), 1, 0, "L");
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Género:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(29, $cell_size, \App\Libraries\Utilidades::uft8_iso($r["caso"]["sexo"]), 1, 1, "L");
            $pdf->SetX(108);
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Fecha:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $fecha_recepcion = \App\Libraries\Utilidades::php_date_to_excel_date($r["caso"]["fecha_recepcion"], true);
            $pdf->Cell(29, $cell_size, \App\Libraries\Utilidades::uft8_iso(substr($fecha_recepcion, 0, 10)), 1, 0, "L");
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Edad:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $edad = substr(strval($r["caso"]["edad"]), -3, -3) == ".00" ? intval($r["caso"]["edad"]) : $r["caso"]["edad"];
            $pdf->Cell(29, $cell_size, \App\Libraries\Utilidades::uft8_iso($edad), 1, 1, "L");
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Clínica:"), 0, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(78, $cell_size, \App\Libraries\Utilidades::uft8_iso($cliente["clinica"]), 0, 0, "L");
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Especie:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(29, $cell_size, \App\Libraries\Utilidades::uft8_iso($r["caso"]["especie"]), 1, 0, "L");
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Nombre:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(29, $cell_size, \App\Libraries\Utilidades::uft8_iso($r["caso"]["nombre"]), 1, 1, "L");
            $pdf->SetX(108);
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Raza:"), 1, 0, "L");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(78, $cell_size, \App\Libraries\Utilidades::uft8_iso($r["caso"]["raza"]), 1, 1, "L");
            //ITEMS
            $pdf->Ln(3);
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("CANTIDAD"), 1, 0, "C");
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("CLAVE"), 1, 0, "C");
            $pdf->Cell(116, $cell_size, \App\Libraries\Utilidades::uft8_iso("DESCRIPCIÓN"), 1, 0, "C");
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("P.U."), 1, 0, "C");
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("IMPORTE"), 1, 1, "C");
            $pdf->Line(10, 70, 10, 220);
            $pdf->Line(30, 70, 30, 220);
            $pdf->Line(50, 70, 50, 220);
            $pdf->Line(166, 70, 166, 220);
            $pdf->Line(186, 70, 186, 220);
            $pdf->Line(206, 70, 206, 220);
            $pdf->Line(10, 70, 10, 220);
            $pdf->Line(10, 220, 206, 220);
            $cell_size = 6;

            foreach ($r["analisis"] as $v) {
                $subtotal += floatval($v["precio"]);
                $pdf->SetFont('Arial', '', $text_size);
                $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["cantidad"]), 0, 0, "C");
                $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["clave"]), 0, 0, "C");
                $pdf->Cell(116, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["descripcion"]), 0, 0, "L");
                $pdf->Cell(2, $cell_size, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "L");
                $pdf->Cell(18, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["pu"]), 0, 0, "R");
                $pdf->Cell(2, $cell_size, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "L");
                $pdf->Cell(18, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["precio"]), 0, 1, "R");
            }
            $y = $pdf->GetY();
            while ($y < 220) {
                $pdf->Cell(20, $cell_size, "-", 0, 0, "C");
                $pdf->Cell(20, $cell_size, "-", 0, 0, "C");
                $pdf->Cell(116, $cell_size, "-", 0, 0, "L");
                $pdf->Cell(20, $cell_size, "-", 0, 0, "C");
                $pdf->Cell(20, $cell_size, "-", 0, 1, "C");
                $y += $cell_size;
            }
            $pdf->SetY(260);
            $pdf->Cell(196, 10, \App\Libraries\Utilidades::uft8_iso('Página ' . $pdf->PageNo() . '/{nb}'), 0, 0, 'C');
        }
        $descuento_desc = "";
        foreach ($desc as $k => $r) {
            $descuento += floatval($r["precio"]);
            $descuento_desc .= ($k == 0 ? "" : " &") . " " . $r["descripcion"];
        }
        if ($lote["iva"] == 1) {
            $iva = (($subtotal - $descuento) / 100) * 16;
        }

        $total = $subtotal - $descuento + $iva;
        $cell_size = 5;
        $pdf->Ln(10);
        $pdf->SetXY(166, 222);
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("SUBTOTAL"), "", 0, "R");
        $pdf->SetFont('Arial', '', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($subtotal)), "", 1, "R");
        $pdf->SetX(166);
        if ($descuento > 0) {
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso($descuento_desc), "", 0, "R");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($descuento)), "", 1, "R");
            $pdf->SetX(166);
        }
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("IVA"), "", 0, "R");
        $pdf->SetFont('Arial', '', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($iva)), "", 1, "R");
        $pdf->SetX(166);
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("TOTAL"), "", 0, "R");
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($total)), "T", 1, "R");
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Total con letra:"), 0, 0, "L");
        $explode = explode(".", $total);
        $centavos = count($explode) == 1 ? "00" : $explode[1];
        $pdf->Cell(20, $cell_size, strtoupper(\App\Libraries\Utilidades::numberToText($explode[0]) . " PESOS " . "$centavos/100 M.N."), 0, 1, "L");

        $cell_size = 3;
        $pdf->SetFont('Arial', '', 6);
        $pdf->SetY(250);
        $pdf->Cell(30, $cell_size, \App\Libraries\Utilidades::uft8_iso("Calle Dr. Miguel A. Gómez Ventura #121"), 0, 1, "L");
        $pdf->Cell(30, $cell_size, \App\Libraries\Utilidades::uft8_iso("Col. Nueva Pensiones"), 0, 1, "L");
        $pdf->SetTextColor(41, 198, 63);
        $pdf->Cell(30, $cell_size, \App\Libraries\Utilidades::uft8_iso("morelabvhsa@gmail.com"), 0, 1, "L");
        $pdf->SetFont('Arial', 'B', 6);
        $cell_size = 5;
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 50, 0);
        $pdf->SetXY(60, 250);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("993 351 9802"), 0, 1, "L");
        $pdf->SetXY(60, 253);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("993 112 3008"), 0, 1, "L");
        die($pdf->Output("I"));
    }

    public function nota_venta_lote($lote, $ALL_DATA, $cliente, $desc)
    {
        $pdf = new FPDF("P", "mm", "LETTER", true, '', false);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetTitle('Nota de venta');
        /**Inicia cabecera */
        $cell_size = 4;
        $this->cabecera($pdf, $cliente, $cell_size);
        /**Termina cabecera */
        $subtotal = 0;
        $descuento = 0;
        $iva = 0;
        $total = 0;
        $start_y = 52;
        $count = 0; //Va contando cuantos casos van
        foreach ($ALL_DATA as $i => $r) {
            $count++;
            $text_size = 7.5;
            $cell_size = 4;
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->SetXY(10, $start_y);
            $pdf->Cell(12, $cell_size, \App\Libraries\Utilidades::uft8_iso($r["caso"]["no_caso"]), 0, 0, "C");
            $pdf->SetXY(22, $start_y);
            $pdf->MultiCell(
                34,
                $cell_size,
                \App\Libraries\Utilidades::uft8_iso("GÉNERO: " . $r["caso"]["sexo"] .
                    "\nRECEPCIÓN: " . $r["caso"]["fecha_recepcion"] .
                    "\nEDAD: " . $r["caso"]["edad"] .
                    "\nNOMBRE: " . $r["caso"]["nombre"] .
                    "\nESPECIE: " . $r["caso"]["especie"] .
                    "\nRAZA: " . $r["caso"]["raza"]),
                0
            );
            $start_y_analisis = $start_y;
            foreach ($r["analisis"] as $v) {
                $pdf->SetY($start_y_analisis);
                $subtotal += floatval($v["precio"]);
                $pdf->SetFont('Arial', '', $text_size);
                $pdf->SetX(56);
                $pdf->Cell(18, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["cantidad"]), 0, 0, "C");
                $pdf->SetX(74);
                $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["clave"]), 0, 0, "C");
                $pdf->SetX(94);
                $pdf->MultiCell(72, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["descripcion"]), 0, "L");
                $restart = $pdf->GetY();
                $pdf->SetXY(166, $start_y_analisis);
                $pdf->Cell(2, $cell_size, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "L");
                $pdf->Cell(18, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["pu"]), 0, 0, "R");
                $pdf->SetXY(186, $start_y_analisis);
                $pdf->Cell(2, $cell_size, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "L");
                $pdf->Cell(18, $cell_size, \App\Libraries\Utilidades::uft8_iso($v["precio"]), 0, 1, "R");
                $start_y_analisis = $restart;
            }
            $pdf->SetY(260);
            $start_y += 56;
            $pdf->Cell(196, 10, \App\Libraries\Utilidades::uft8_iso('Página ' . $pdf->PageNo() . '/{nb}'), 0, 0, 'C');
            if ($start_y == 220) {
                if (count($ALL_DATA) != $count) {
                    $start_y = 52;
                    /**Inicia cabecera */
                    $cell_size = 4;
                    $this->cabecera($pdf, $cliente, $cell_size);
                    /**Termina cabecera */
                }
            }
        }


        $descuento_desc = "";
        foreach ($desc as $k => $r) {
            if ($r["tipo_descuento"] == "P") {
                $descuento += ($subtotal / 100) * floatval($r["precio"]);
            } else {
                $descuento += floatval($r["precio"]);
            }
            $descuento_desc .= ($k == 0 ? "" : " &") . " " . $r["descripcion"];
        }
        if ($lote["iva"] == 1) {
            $iva = (($subtotal - $descuento) / 100) * 16;
        }
        $total = $subtotal - $descuento + $iva;
        $cell_size = 5;
        $pdf->Ln(10);
        $pdf->SetXY(166, 222);
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("SUBTOTAL"), "", 0, "R");
        $pdf->SetFont('Arial', '', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($subtotal)), "", 1, "R");
        $pdf->SetX(166);
        if ($descuento > 0) {
            $pdf->SetFont('Arial', 'B', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso($descuento_desc), "", 0, "R");
            $pdf->SetFont('Arial', '', $text_size);
            $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($descuento)), "", 1, "R");
            $pdf->SetX(166);
        }
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("IVA"), "", 0, "R");
        $pdf->SetFont('Arial', '', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($iva)), "", 1, "R");
        $pdf->SetX(166);
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("TOTAL"), "", 0, "R");
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso(\App\Libraries\Utilidades::money_format($total)), "T", 1, "R");
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Total con letra:"), 0, 0, "L");
        $explode = explode(".", $total);
        $centavos = count($explode) == 1 ? "00" : $explode[1];
        $pdf->Cell(20, $cell_size, strtoupper(\App\Libraries\Utilidades::numberToText($explode[0]) . " PESOS " . "$centavos/100 M.N."), 0, 1, "L");

        $cell_size = 3;
        $pdf->SetFont('Arial', '', 6);
        $pdf->SetY(250);
        $pdf->Cell(30, $cell_size, \App\Libraries\Utilidades::uft8_iso("Calle Dr. Miguel A. Gómez Ventura #121"), 0, 1, "L");
        $pdf->Cell(30, $cell_size, \App\Libraries\Utilidades::uft8_iso("Col. Nueva Pensiones"), 0, 1, "L");
        $pdf->SetTextColor(41, 198, 63);
        $pdf->Cell(30, $cell_size, \App\Libraries\Utilidades::uft8_iso("morelabvhsa@gmail.com"), 0, 1, "L");
        $pdf->SetFont('Arial', 'B', 6);
        $cell_size = 5;
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 50, 0);
        $pdf->SetXY(60, 250);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("993 351 9802"), 0, 1, "L");
        $pdf->SetXY(60, 253);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("993 112 3008"), 0, 1, "L");
        die($pdf->Output("I"));
    }

    public function cabecera($pdf, $cliente, $cell_size)
    {
        /**Inicia cabecera */
        $pdf->AddPage();
        $pdf->Image(base_url("public/images/morelab-logo-color.jpeg"), 160, 10, 40, 0, 'JPEG');
        $pdf->Image(base_url("public/images/morelab-logo-color-bn.jpg"), 45, 100, 120, 0, 'JPG');
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("LLUVIA GUADALUPE MORENO PEREZ1"), 0, 1, "C");
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("MOPL8601017J5"), 0, 1, "C");
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("CALLEJON LOS MANGOS SIN NÚMERO"), 0, 1, "C");
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("Ria. GONZALEZ 1RA SECCION, CENTRO"), 0, 1, "C");
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("C.P. 86280"), 0, 1, "C");
        $pdf->Ln(2);
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("Régimen de las Personas Fisicas con Actividades"), 0, 1, "C");
        $pdf->SetX(58);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso("Empresariales y Profesionales"), 0, 1, "C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX(58);
        $pdf->Cell(100, 3, "NOTA DE VENTA", 0, 1, "C");
        $pdf->Ln(2);
        $text_size = 8.5;
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Nombre:"), 0, 0, "L");
        $pdf->SetFont('Arial', '', $text_size);
        $pdf->Cell(78, $cell_size, \App\Libraries\Utilidades::uft8_iso($cliente["nombres"] . " " . $cliente["primer_apellido"] . " " . $cliente["segundo_apellido"]), 0, 0, "L");
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("Clínica:"), 0, 0, "L");
        $pdf->SetFont('Arial', '', $text_size);
        $pdf->Cell(78, $cell_size, \App\Libraries\Utilidades::uft8_iso($cliente["clinica"]), 0, 1, "L");
        $pdf->SetFont('Arial', 'B', $text_size);
        $pdf->Ln(2);
        $pdf->Cell(12, $cell_size, \App\Libraries\Utilidades::uft8_iso("CASO"), 1, 0, "C");
        $pdf->Cell(34, $cell_size, \App\Libraries\Utilidades::uft8_iso("DATOS DEL PACIENTE"), 1, 0, "C");
        $pdf->Cell(18, $cell_size, \App\Libraries\Utilidades::uft8_iso("CANTIDAD"), 1, 0, "C");
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("CLAVE"), 1, 0, "C");
        $pdf->Cell(72, $cell_size, \App\Libraries\Utilidades::uft8_iso("DESCRIPCIÓN"), 1, 0, "C");
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("P.U."), 1, 0, "C");
        $pdf->Cell(20, $cell_size, \App\Libraries\Utilidades::uft8_iso("IMPORTE"), 1, 1, "C");
        $pdf->Line(10, 48, 10, 220);
        $pdf->Line(22, 48, 22, 220);
        $pdf->Line(56, 48, 56, 220);
        $pdf->Line(74, 48, 74, 220);
        $pdf->Line(94, 48, 94, 220);
        $pdf->Line(166, 48, 166, 220);
        $pdf->Line(186, 48, 186, 220);
        $pdf->Line(206, 48, 206, 220);
        $pdf->Line(10, 220, 206, 220);
        /**Termina cabecera */
    }

    public function pdf_corte($data)
    {
        $pdf = new FPDF("P", "mm", "LETTER", true, '', false);
        $pdf->AliasNbPages();
        $pdf->SetTitle("Corte de caja");
        $pdf->AddPage();
        $pdf->Image(base_url("public/images/morelab-logo-color-bn.jpg"), 45, 100, 120, 0, 'JPG');
        //CABECERA
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetX(58);
        $pdf->Cell(100, 10, \App\Libraries\Utilidades::uft8_iso("CORTE GENERAL"), 1, 1, "C");
        $fecha = $data["corte"]["desde"] == $data["corte"]["hasta"] ? $data["corte"]["desde"] : $data["corte"]["desde"] . " - " . $data["corte"]["hasta"];
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(58, 22);
        $pdf->Cell(100, 3, \App\Libraries\Utilidades::uft8_iso($fecha), 0, 1, "C");
        $pdf->Ln(3);
        $anterior = [
            ["SALDO ANTERIOR CAJA", "anterior_caja"],
            ["SALDO ANTERIOR BANCO", "anterior_banco"]
        ];
        for ($i = 0; $i < 2; $i++) {
            $pdf->SetX(106);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(50, 6, \App\Libraries\Utilidades::uft8_iso($anterior[$i][0]), 0, 0, "R");
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(5, 6, \App\Libraries\Utilidades::uft8_iso("$"), "TBL", 0, "R");
            $pdf->Cell(45, 6, \App\Libraries\Utilidades::money_format($data["corte"][$anterior[$i][1]], false), "TBR", 1, "R");
        }

        $tables = [
            "ingresos_caja" => ["CAJA", "ingreso_caja"],
            "ingresos_banco" => ["BANCO", "ingreso_banco"],
            "egresos_caja" => ["CAJA", "egreso_caja"],
            "egresos_banco" => ["BANCO", "egreso_banco"]
        ];

        foreach ($tables as $k => $r) {
            if ($k == "ingresos_caja" || $k == "egresos_caja") {
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(196, 6, \App\Libraries\Utilidades::uft8_iso($k == "ingresos_caja" ? "INGRESOS" : "EGRESOS"), 0, 1, "L");
            }
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetX(15);
            $pdf->Cell(196, 6, \App\Libraries\Utilidades::uft8_iso($r[0]), 0, 1, "L");
            $pdf->SetFont('Arial', '', 9);
            foreach ($data[$k] as $i => $f) {
                $pdf->SetX(20);
                $currentY = $pdf->GetY();
                $newY = $currentY;
                $pdf->MultiCell(30, 3, \App\Libraries\Utilidades::uft8_iso($f["casos"]), 0, "R");
                $newY = $pdf->GetY() > $newY ? $pdf->GetY() : $newY;
                $pdf->SetXY(50, $currentY);
                $pdf->MultiCell(80, 3, \App\Libraries\Utilidades::uft8_iso($f["descripcion"]), 0, "J");
                $newY = $pdf->GetY() > $newY ? $pdf->GetY() : $newY;
                $pdf->SetXY(130, $currentY);
                $pdf->Cell(5, 3, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "R");
                $pdf->Cell(19, 3, \App\Libraries\Utilidades::money_format($f["cantidad"], false), 0, 1, "R");
                if ($pdf->GetY() > 230) {
                    $pdf->AddPage();
                    $pdf->SetY(15);
                } else {
                    $pdf->SetY($newY + 3);
                }
            }

            $pdf->SetX(154);
            $pdf->Cell(5, 3, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "R");
            $pdf->Cell(19, 3, \App\Libraries\Utilidades::money_format($data["corte"][$r[1]], false), 0, 1, "R");
            if ($k == "ingresos_banco" || $k == "egresos_banco") {
                if ($k == "ingresos_banco") {
                    $total = $data["corte"]["ingreso_caja"] + $data["corte"]["ingreso_banco"];
                } else {
                    $total = $data["corte"]["egreso_caja"] + $data["corte"]["egreso_banco"];
                }
                $pdf->SetX(178);
                $pdf->Cell(5, 3, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "R");
                $pdf->Cell(19, 3, \App\Libraries\Utilidades::money_format($total, false), 0, 1, "R");
            }
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(196, 6, \App\Libraries\Utilidades::uft8_iso("CRÉDITOS"), 0, 1, "L");
        $pdf->SetFont('Arial', '', 9);

        $pdf->SetX(50);
        $pdf->Cell(80, 3, \App\Libraries\Utilidades::uft8_iso("DEUDA DEL DÍA (Abonos + deuda)"), 0, 0, "J");
        $pdf->Cell(5, 3, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "R");
        $pdf->Cell(19, 3, \App\Libraries\Utilidades::money_format($data["corte"]["credito_dia"], false), 0, 1, "R");
        $pdf->ln(3);


        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetX(50);
        $pdf->Cell(128, 6, \App\Libraries\Utilidades::uft8_iso("SALDO GENERAL AL CORTE"), 1, 1, "C");
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetX(50);
        $pdf->Cell(104, 4, \App\Libraries\Utilidades::uft8_iso("SALDO EN CAJA"), 1, 0, "C");
        $total_caja = ($data["corte"]["ingreso_caja"] - $data["corte"]["egreso_caja"]) + $data["corte"]["anterior_caja"] + $data["corte"]["total_movimientos_caja"];
        $pdf->Cell(24, 4, \App\Libraries\Utilidades::money_format($total_caja), 1, 1, "R");
        $pdf->SetX(50);
        $pdf->Cell(104, 4, \App\Libraries\Utilidades::uft8_iso("SALDO EN BANCO"), 1, 0, "C");
        $total_banco = ($data["corte"]["ingreso_banco"] - $data["corte"]["egreso_banco"])  + $data["corte"]["anterior_banco"];
        $pdf->Cell(24, 4, \App\Libraries\Utilidades::money_format($total_banco), 1, 1, "R");
        $pdf->SetX(178);

        $pdf->Cell(24, 4, \App\Libraries\Utilidades::money_format($total_caja + $total_banco), 0, 1, "R");

        $pdf->SetFont('Arial', '', 9);
        $cant = $data["corte"]["credito_abono"] - $data["corte"]["credito_deuda"];
        $pdf->SetX(50);
        $pdf->Cell(80, 3, \App\Libraries\Utilidades::uft8_iso("CRÉDITOS TOTALES (Abonos + deuda)"), 0, 0, "J");
        $pdf->Cell(5, 3, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "R");
        $pdf->Cell(19, 3, \App\Libraries\Utilidades::money_format($data["corte"]["credito_total"], false), 0, 1, "R");
        $pdf->SetX(50);
        $pdf->Cell(80, 3, \App\Libraries\Utilidades::uft8_iso("MOVIMIENTOS DE CAJAS (Registradora y resguardo)"), 0, 0, "J");
        $pdf->Cell(5, 3, \App\Libraries\Utilidades::uft8_iso("$"), 0, 0, "R");
        $pdf->Cell(19, 3, \App\Libraries\Utilidades::money_format($data["corte"]["total_movimientos_caja"], false), 0, 1, "R");
        $pdf->SetX(50);

        die($pdf->Output("I"));
    }


    public function constancia($constancia)
    {
        $pdf = new FPDF("L", "mm", "LETTER", true, '', false);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetTitle("Constancia {$constancia['folio']}");
        $pdf->AddPage();
        $pdf->Image(base_url("public/images/constancia_base_pdf_2348659823759237523456.jpg"), 0, 0, 279, 215.5, 'JPG');
        $filename = WRITEPATH . "/uploads/temp/" . $constancia["qr"] . ".png";
        $pdf->Image($filename, 210, 140, 55, 55,"png");
        //constancia_base_pdf_2348659823759237523456
        die($pdf->Output("I"));

    }

    public function UFT8($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    }
}
