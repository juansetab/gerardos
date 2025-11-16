<?php

namespace App\Libraries;

use App\Libraries\SimpleXLSXGen;
use App\Models\DominiosModel;
use Exception;
use PHPExcel;
use PHPExcel_IOFactory;

class Utilidades
{

    /**
     * Genera un XLSX simple
     * @param string $filename es el nombre del archivo, que luego se concatenará con la fecha actual
     * @param array $data es el array con el contenido del excel, este debe traer su cabecera
     */
    public static function download_xlsx($filename, $data)
    {
        $xlsx = SimpleXLSXGen::fromArray($data);
        $date = date("Y-m-d H_i_s");
        $xlsx->downloadAs("$filename-$date.xlsx");
    }

    /**
     * Calcula a partir de la fecha de nacimiento y una fecha dada, la precisión es de día
     * @param string $fecha_nac es la fecha de nacimiento
     * @param string $fecha es al fecha de la que se hará la resta
     */
    public static function calcula_edad($fecha_nac, $fecha)
    {
        $cumpleanos = new \DateTime($fecha_nac);
        $hoy = new \DateTime($fecha);
        $annos = $hoy->diff($cumpleanos);
        return $annos->y;
    }


    public static function writeRowExcel($rows)
    {
        $DominiosModel = new DominiosModel();
        $location = $DominiosModel->where("dominio", "EXCEL_LOCATION")->findAll();
        if (empty($location))
            die(json_encode(["status" => 0, "msg" => "Existió un error al consultar la localización del archivo de Excel"]));
        copy($location[0]["valor"], dirname(__FILE__, 3) . "/respaldos/" . time() . ".xlsx");
        foreach ($rows as $r) {
            $objPHPExcel = PHPExcel_IOFactory::load($location[0]["valor"]);
            $objPHPExcel->setActiveSheetIndexByName(strval(date("Y")));
            $row = $objPHPExcel->getActiveSheet()->getHighestRow() + 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row, $r['no_caso']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row, self::php_date_to_excel_date($r['fecha_recepcion'], true));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row, $r['hora_recepcion']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row, $r['especie']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row, $r['raza']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row, $r['edad_sexo']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row, $r['nombre']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row, $r['mvz_remitente']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $row, $r['clinica']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $row, $r['anamnesis']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $row, $r['tipo_muestra']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $row, $r['estudios']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $row, self::php_date_to_excel_date($r['muestreo'], true));
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $row, $r['correo']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $row, $r['telefono']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $row, $r['observaciones']);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($location[0]["valor"]);
        }
    }

    /**
     * Genera un xlsx con contraseña a partir de una plantilla existente
     * @param string $filename es el nombre del archivo, que luego se concatenará con la fecha actual
     * @param string $title es el titulo que tendrá el excel
     * @param string $sheet_name es el nombre de la hoja del excel
     * @param array $data es el array con el contenido del excel
     * @param string $password es la contraseña que contendrá el archivo
     * @param string $templatename es el nombre del archivo plantilla
     * @param integer $start es la fila en la que comienza a insertar los datos
     * @param bool $numeration indica si la primera columna es numeracion
     */
    public static function download_xlsx_encrypted_from_template($filename, $title, $sheet_name, $data, $password, $templatename, $start, $numeration = false)
    {
        $template = getcwd() . "/public/files/template/" . $templatename;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Secretaría de Educación del Estado de Tabasco")
            ->setLastModifiedBy("Secretaría de Educación del Estado de Tabasco")
            ->setTitle($title)
            ->setDescription("Archivo generado del SIAD");
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($template);
        $c = $start;
        foreach ($data as $k => $r) {
            $objPHPExcel->getActiveSheet()->fromArray($r, null, "A" . ($c));
            $c++;
        }
        //$objPHPExcel->getActiveSheet()->getStyle('A1:BZ1')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->setTitle($sheet_name);
        $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setSort(false);
        $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(false);
        $objPHPExcel->getActiveSheet()->getProtection()->setPassword($password);
        $objPHPExcel->setActiveSheetIndex(0); // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        $date = date("Y-m-d H_i_s");
        header("Content-disposition: attachment; filename=\"$filename-$date.xlsx\"");
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        flush();
        $objWriter->save('php://output');
    }


    /**
     * Convierte un string en hash
     * @param password es el string que será convertido a hash
     * @return string que contiene el hash 
     */
    public static function create_password_hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifica si un string coincide con hash
     * @param password es el string con el password
     * @param hashed_password es el string con el hash a comprara
     * @return bool true si coinciden, false si no coinciden
     */
    public static function verify_password($password, $hashed_password)
    {
        if (password_verify($password, $hashed_password)) {
            return true;
        }
        return false;
    }


    /**
     * Convierte una cantidad entera a texto (Solo llega hasta ciento de miles)
     * @param number es la cantidad
     * @return string con la cantidad en letras
     */
    public static function numberToText($number)
    {
        $string = "";
        $unidades = ["cero", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
        $decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
        $decenas_c = ["", "dieci", "veinti", "treinta y ", "cuarenta y ", "cincuenta y ", "sesenta y ", "setenta y ", "ochenta y ", "noventa y "];
        $centenas = ["", "cien", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
        $exceptions = [11 => "once", 12 => "doce", 13 => "trece", 14 => "catorce", 15 => "quince"];
        $number = (string)$number;
        $count = strlen($number);
        if ($count >= 1)
            $string = $unidades[substr($number, -1, 1)];
        if ($count >= 2) {
            if (substr($number, -2) > 10 && substr($number, -2) < 16) {
                $string = $exceptions[substr($number, -2, 2)];
            } elseif (substr($number, -1) == "0") {
                $string = $decenas[substr($number, -2, 1)];
            } else {
                $string = $decenas_c[substr($number, -2, 1)] . $string;
            }
        }
        if ($count >= 3) {
            if (substr($number, -3, 1) == "1") {
                $string = "ciento " . $string;
            } else {
                $string = $centenas[substr($number, -3, 1)] . " " . $string;
            }
        }
        if ($count >= 4) {
            if ($count >= 5) {
                if (substr($number, -5, 2) > 10 && substr($number, -5, 2) < 16) {
                    $string = $exceptions[substr($number, -5, 2)] . " mil " . $string;
                } elseif (substr($number, -4, 1) == "0") {
                    $string = $decenas[substr($number, -5, 1)] . " mil " . $string;
                } else {
                    $string = $decenas_c[substr($number, -5, 1)] . $unidades[substr($number, -4, 1)] . " mil " . $string;
                }
            } else {
                if (substr($number, -4, 1) == "1") {
                    $string = "mil " . $string;
                } else {
                    $string = $unidades[substr($number, -4, 1)] . " mil " . $string;
                }
            }
        }
        if ($count >= 6) {
            if (substr($number, -6, 1) == "1") {
                $string = "ciento " . $string;
            } else {
                $string = $centenas[substr($number, -6, 1)] . " " . $string;
            }
        }
        return $string;
    }


    /**
     * Convierte una fecha en formato YYYY-MM-DD a formato texto 
     * @param date es la fecha a convertir
     * @param upper indica si se debe retornar en mayusculas
     * @return array dia, mes, año separados en un array
     */
    static function date_to_text($date, $upper, $day = "d")
    {
        // Día
        $d = date($day, strtotime($date));

        // Mes en español con IntlDateFormatter
        $formatter = new \IntlDateFormatter(
            'es_MX',                        // o 'es_ES' si prefieres España
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            'UTC',
            \IntlDateFormatter::GREGORIAN
        );
        $formatter->setPattern('MMMM');      // nombre completo del mes

        $m = $formatter->format(new \DateTime($date));

        // Año
        $y = date("Y", strtotime($date));

        // Armado del arreglo
        $array = ["d" => $d, "m" => $m, "y" => $y];

        // Convertir a mayúsculas si se pide
        if ($upper) {
            $array = array_map('mb_strtoupper', $array);
        }

        return $array;
    }

    static function php_date_to_excel_date($date, $nullable)
    {
        if (strlen($date) > 10) // Por si es formato con hora, minuto, segundo
            $date = substr($date, 0, 10);
        if ($date === null || $date == "")
            return "";
        if ($nullable && $date == "0000-00-00")
            return "";
        $array = explode("-", $date);
        return $array[2] . "/" . $array[1] . "/" . $array[0];
    }

    static function php_datetime_to_excel_datetime($date, $nullable)
    {
        if (strlen($date) > 10) // Por si es formato con hora, minuto, segundo
            $date_format = substr($date, 0, 10);
        $hour = substr($date, -8, 8);
        if ($date === null || $date == "")
            return "";
        if ($nullable && substr($date, 0, 10) == "0000-00-00")
            return "";
        $array = explode("-", $date_format);
        return $array[2] . "/" . $array[1] . "/" . $array[0] . " " . $hour;
    }

    static function excel_date_to_php_date($date, $nullable)
    {
        if (strlen($date) > 10) // Por si es formato con hora, minuto, segundo
            $date = substr($date, 0, 10);
        if ($date === null || $date == "")
            return "";
        if ($nullable && $date == "00/00/0000")
            return "";
        $array = explode("/", $date);
        return $array[2] . "-" . $array[1] . "-" . $array[0];
    }

    static function money_format($number, $dollar_sign = true)
    {
        $money_format = $dollar_sign == true ? "$ " : "";
        $money_format .= number_format($number, 2, ".", ",");
        return $money_format;
    }

    static function is_valid_value($value)
    {
        if ($value == null || $value == "null" || $value == "0000-00-00" || $value == "" || $value == "0") {
            return false;
        } else {
            return true;
        }
    }

    static function format_valid_value($value)
    {
        if ($value == null || $value == "null" || $value == "0000-00-00" || $value == "" || $value == "0") {
            return "";
        } else {
            return $value;
        }
    }

    /**
     * Revisa que todos los elementos pasados por parámetros existan dentro de $_POST
     * @param array el array con los elementos a evaluar si existen
     * @param desc_error indica si se debe especificar que elemento falta o solo retorna un msj genérico
     */
    static function check_exists_post_values($array, $desc_error = false)
    {
        foreach ($array as $r) {
            if (!array_key_exists($r, $_POST)) {
                $msg = $desc_error == false ? "Faltán parámetros" : "No se encuentra el campo '$r' dentro de los parámetros solicitados";
                return array("status" => false, "msg" => $msg);
            }
        }
        return array("status" => true, "msg" => "Todas las variables existen");
    }

    static function random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Elimina todos los acentos de una cadena sin importar si es mayúsculas o minúsculas
     * @param cadena es el string que contiene las vocales para eliminar acentos
     * @return string sin acentos
     */
    static function delete_accents($cadena)
    {

        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        //$cadena = utf8_encode($cadena);
        //$cadena = mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');

        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena
        );

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena
        );

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena
        );

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena
        );

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('ñ', 'Ñ', 'c', 'C'),
            $cadena
        );

        return $cadena;
    }


    /**
     * Valida que el formato de fecha sea correcto
     * @param date es string con la fecha a evaluar
     * @param format es el formato de fecha. Por defecto es Y-m-d
     * @return bool true si la fecha coincide con el formato correspondiente, falso si no
     */
    static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }


    /**
     * Envía un correo electrónico
     * @param remitente es la dirección de quien envía el correo. Si este parámetro es falso junto con password, toma el correo y contraseña del sistema
     * @param password es el passwors del correo remitente. Si este parámetro es falso junto con remitente, toma el correo y contraseña del sistema
     * @param destinatario es a quien va dirigido el correo
     * @param asunto es el titulo del correo
     * @param html es el cuerpo (en html obligatoriamente) del correo
     */
    static function send_mail($remitente, $password, $destinatario, $asunto, $body)
    {
        if (!$remitente && !$password) {
            $remitente = "siad.setab@outlook.com";
            $password = "c0rr30s3rv3r";
        }
        $mail = new sendmail();
        $mail_status = $mail->send($remitente, $password, $destinatario, $asunto, $body);
        return $mail_status;
    }


    static function uft8_iso($cadena)
    {
        return mb_convert_encoding($cadena, 'ISO-8859-1', 'UTF-8');
    }

    static function iso_uft8($cadena)
    {
        return mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
    }
}
