<?php

namespace App\Controllers;

use App\Models\CctModel;

class Dev extends BaseController
{


    /**
     * Imprime la información de PHP
     */
    public function phpinfo()
    {
        echo phpinfo();
    }

    /**
     * Obtiene la ip
     */
    public function remote_addr()
    {
        echo 'http://' . getHostByName(getHostName()) . '/';
    }

    /**
     * Imprime la variable $_POST
     */
    public function post()
    {
        echo json_encode($_POST);
    }

    /**
     * Imprime la variable GET
     */
    public function get()
    {
        echo json_encode($_GET);
    }

    /**
     * Imprime la variable $_SERVER que contiene toda la información del servidor
     */
    public function server()
    {
        return json_encode($_SERVER);
    }

    /**
     * Imprime la versión del codeigniter
     */
    public function ci_version()
    {
        echo \CodeIgniter\CodeIgniter::CI_VERSION;
    }

    /**
     * Crea el formulario una tabla
     */
    public function create_form_html()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        echo "<form id='' action='<?= base_url('')?>' method='POST'>" . PHP_EOL;
        echo "	<div class='row'>";
        $c = 1;
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            if ($field == "status") {
                echo PHP_EOL . "		<div class='form-group col-md-4 col-sm-12 col-lg-4'>" . PHP_EOL .
                    "			<label class='form-label' for='$field'>" . ucfirst($field) . ": </label>" . PHP_EOL .
                    "			<select class='form-control form-control-sm' id='$field' name='$field'>" . PHP_EOL .
                    "				<option value='1'>Activo</option>" . PHP_EOL .
                    "				<option value='0'>Inactivo</option>" . PHP_EOL .
                    "			</select>" . PHP_EOL .
                    "		</div>";
            } else {
                $col_num = $field == 'rfc' || $field == 'description' ? "8" : "4";
                $datatype =    substr($f["Type"], 0, 3) == 'int' || substr($f["Type"], 0, 5) == 'float' ? "number" : "text";
                echo PHP_EOL . "		<div class='form-group col-md-$col_num col-sm-12 col-lg-$col_num'>" . PHP_EOL .
                    "       			<label class='form-label' for='$field'>" . ucfirst($field) . ": </label>" . PHP_EOL .
                    "       			<input type='$datatype' class='form-control form-control-sm' id='$field' name='$field' placeholder='' required />" . PHP_EOL .
                    "    		</div>";
            }
        }
        echo PHP_EOL . "	</div>" . PHP_EOL .
            "	<button type='submit' class='btn btn-sm btn-primary'>Guardar</button>" . PHP_EOL .
            "</form>";
    }

    /**
     * Crea una tabla en html desde php con los campos rellenos
     */
    public function php_foreach_table_html()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        echo "<table id='" . $_GET['t'] . "' class='table table-striped table-sm text-center table-bordered text-nowrap'>" . PHP_EOL;
        echo "	<thead>" . PHP_EOL;
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        echo "		<th>ACCIONES</th>" . PHP_EOL;
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            echo "		<th class='text-center'>" . strtoupper($field) . "</th>" . PHP_EOL;
        }
        echo "	</thead>" . PHP_EOL;
        echo "	<tbody>" . PHP_EOL;
        echo '		<?php foreach ($element as $r) { ?>' . PHP_EOL;;
        echo '		<tr id="tr_<?= $r["id"] ?>"  data-id-row="<?= $r["id"] ?>">' . PHP_EOL;
        echo '			<td>' . PHP_EOL;
        echo '				<div class="btn-group btn-group-xs" role="group">' . PHP_EOL;
        echo '					<button type="button" class="btn btn-success btn-sm" onclick="callModalEdit(this)"><i class="fa fa-edit"></i></button>' . PHP_EOL;
        echo '				</div>' . PHP_EOL;
        echo '			</td>' . PHP_EOL;
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            echo '			<td id="' . $field . '"><?= $r["' . $field . '"] ?></td>' . PHP_EOL;
        }
        echo "		</tr>" . PHP_EOL;
        echo '		<?php } ?>' . PHP_EOL;;
        echo "	</tbody>" .  PHP_EOL;
        echo "</table>";
    }

    /**
     * Crea un elemento tr para una tabla html
     */
    public function create_tr_javascript()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        echo '		tr = `' . PHP_EOL;
        echo '		<tr id="tr_"${value.id}" data-id-row="${value.id}">' . PHP_EOL;
        echo '			<td>' . PHP_EOL;
        echo '				<div class="btn-group btn-group-xs" role="group">' . PHP_EOL;
        echo '					<button type="button" class="btn btn-success btn-sm" onclick="callModalEdit(this)"><i class="fa fa-edit"></i></button>' . PHP_EOL;
        echo '				</div>' . PHP_EOL;
        echo '			</td>' . PHP_EOL;
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            echo '			<td id="${value.' . $field . '}">${value.' . $field . '}</td>' . PHP_EOL;
        }
        echo "		</tr>`;" . PHP_EOL;
    }

    /**
     * Obtiene datos en javascript de una tabla html
     */
    public function get_table_javascript()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            echo '"' . $field . '": $(tr).find("#' . $field . '").html(),' . PHP_EOL;
        }
    }

    /**
     * Crea insert para modelo de ci
     */
    public function create_array_ci_insert()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        echo '$data = [';
        foreach ($fields->getResultArray() as $f) {
            echo '"' . $f["Field"] . '" => ' . '$_POST["' . $f["Field"] . '"], ';
        }
        echo "];" . PHP_EOL . '$id = $' . ucfirst(strtolower($_GET["t"])) . 'Model->insert($data);';
    }

    /**
     * Crea set de update para modelo de ci
     */
    public function create_array_ci_update()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        echo '$' . ucfirst(strtolower($_GET["t"])) . 'Model';
        foreach ($fields->getResultArray() as $f) {
            echo '->set("' . $f["Field"] . '", $_POST["' . $f["Field"] . '"])';
        }
        echo PHP_EOL . '->where("id", $_POST["id"])->update();';
    }

    /**
     * Lista los campos de una tabla en base de datos
     */
    public function list_of_fields()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        foreach ($fields->getResultArray() as $f) {
            echo '"' . $f["Field"] . '", ';
        }
    }

    /**
     * Lista los campos de una tabla en base de datos como variables POST de php
     */
    public function list_of_fields_post()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        foreach ($fields->getResultArray() as $f) {
            echo '$_POST["' . $f["Field"] . '"], ';
        }
    }

    /**
     * Lista los campos de una tabla en base de datos como un array de php
     */
    public function list_of_fields_array()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        foreach ($fields->getResultArray() as $f) {
            echo '"' . $f["Field"] . '" => $r["' . $f["Field"] . '"], ' . PHP_EOL;
        }
    }

    /**
     * Lista los campos de una tabla en base de datos con todos sus campos em mayúsculas
     */
    public function list_of_fields_upper()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        foreach ($fields->getResultArray() as $f) {
            echo '"' . strtoupper($f["Field"]) . '", ';
        }
    }

    public function controller()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $name = $_GET['t'];
        $data =  "<?php" . PHP_EOL . PHP_EOL .
            "namespace App\Controllers;" . PHP_EOL . PHP_EOL .
            "class " . ucfirst(strtolower($name)) . " extends BaseController" . PHP_EOL .
            "{" . PHP_EOL . PHP_EOL .
            "	public function __construct()" . PHP_EOL .
            "   {" . PHP_EOL . PHP_EOL .
            "   }" . PHP_EOL .
            "}" . PHP_EOL;
        $controller = fopen(getcwd() . "/app/Controllers/" . ucfirst(strtolower($name)) . ".php", "w") or die("Unable to write file!");
        fwrite($controller, $data);
        fclose($controller);
        echo "Archivo " . getcwd() . "/app/Controllers/" . ucfirst(strtolower($name)) . ".php escrito!";
    }

    /**
     * Crea un modelo de ci a partir de una tabla en base de datos
     */
    public function model()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $table = $_GET['t'];
        $tableModel = $table . "Model";
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");
        $list_of_fields = [];
        foreach ($fields->getResultArray() as $f) {
            array_push($list_of_fields, $f["Field"]);
        }

        $data =  "<?php" . PHP_EOL .
            "namespace App\Models;" . PHP_EOL .
            "use CodeIgniter\Model;" . PHP_EOL .
            "use Exception;\n" . PHP_EOL .
            "class " . ucfirst($tableModel) . " extends Model{\n" . PHP_EOL .
            "protected \$table = '$table';" . PHP_EOL .
            "protected \$primaryKey = 'id';" . PHP_EOL .
            "protected \$useAutoIncrement = true;" . PHP_EOL .
            "protected \$returnType     = 'array';" . PHP_EOL .
            "protected \$useSoftDeletes = false;" . PHP_EOL .
            "protected \$allowedFields = " . json_encode($list_of_fields) . ";" . PHP_EOL .
            "protected \$useTimestamps = false;" . PHP_EOL .
            "protected \$createdField  = 'created_at';" . PHP_EOL .
            "protected \$updatedField  = 'updated_at';" . PHP_EOL .
            "protected \$deletedField  = 'deleted_at';" . PHP_EOL .
            "protected \$validationRules    = [];" . PHP_EOL .
            "protected \$validationMessages = [];" . PHP_EOL .
            "protected \$skipValidation     = false; \n" . PHP_EOL .
            "	public function insertData(\$data){" . PHP_EOL .
            "		try{" . PHP_EOL .
            "			\$this->insert(\$data);" . PHP_EOL .
            "			\$insert = \$this->getInsertID();" . PHP_EOL .
            "			return array('status' => 1, 'id' => \$insert);" . PHP_EOL .
            "		}catch(Exception \$e){" . PHP_EOL .
            "			die(json_encode(array('status' => 0, 'msg' => 'Error. '.\$e)));" . PHP_EOL .
            "		}" . PHP_EOL .
            "	}" . PHP_EOL .
            "}" . PHP_EOL;
        $model_file = fopen(getcwd() . "/app/Models/" . ucfirst($tableModel) . ".php", "w") or die("Unable to write file!");
        fwrite($model_file, $data);
        fclose($model_file);
        echo "Archivo " . getcwd() . "/app/Models/" . ucfirst($tableModel) . ".php escrito!";
    }

    /**
     * Crea una vista de ci a partir de una tabla en base de datos 
     */
    public function view()
    {
        $this->response->setHeader('Content-Type', 'text/plain');
        $array = [];
        $table = $_GET['t'];
        $db = db_connect();
        $fields = $db->query("SHOW COLUMNS FROM $table;");

        $array["__form_edit__"] = $this->create_template_form($fields, "edit");
        $array["__form_insert__"] = $this->create_template_form($fields, "insert");
        $array["__table__"] = $this->create_template_table($fields);

        $path_filename = dirname(__FILE__, 3) . "/app/Views/plantilla.php";
        $archivo = fopen($path_filename, 'r');
        while ($linea = fgets($archivo)) {
            if (strpos($linea, "__tabledb__") !== false)
                $linea = str_replace("__tabledb__", $_GET["t"], $linea);
            if (strstr($linea, '__') !== false) {
                echo $array[trim($linea)];
            } else {
                echo $linea;
            }
        }
        fclose($archivo);
    }

    public function create_template_form($fields, $form_crud)
    {
        $string = "";
        $string .= "<form id='form_$form_crud' action='<?= base_url('')?>' method='POST'>" . PHP_EOL;
        $string .= "	<div class='row'>";
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            if ($field == "status") {
                $string .= PHP_EOL . "		<div class='form-group col-md-4 col-sm-12 col-lg-4'>" . PHP_EOL .
                    "			<label class='form-label' for='$field'>" . ucfirst($field) . ": </label>" . PHP_EOL .
                    "			<select class='form-control form-control-sm' id='$field' name='$field'>" . PHP_EOL .
                    "				<option value='1'>Activo</option>" . PHP_EOL .
                    "				<option value='0'>Inactivo</option>" . PHP_EOL .
                    "			</select>" . PHP_EOL .
                    "		</div>" . PHP_EOL;
            } else if ($field == "id") {
                if ($form_crud == "edit") {
                    $string .= "<input type='hidden' id='id' name='id' placeholder='' />" . PHP_EOL;
                }
            } else {
                $col_num = $field == 'rfc' || $field == 'description' ? "8" : "4";
                $datatype =    substr($f["Type"], 0, 3) == 'int' || substr($f["Type"], 0, 5) == 'float' ? "number" : "text";
                $string .= PHP_EOL . "		<div class='form-group col-md-$col_num col-sm-12 col-lg-$col_num'>" . PHP_EOL .
                    "       			<label class='form-label' for='$field'>" . ucfirst($field) . ": </label>" . PHP_EOL .
                    "       			<input type='$datatype' class='form-control form-control-sm' id='$field' name='$field' placeholder='' required />" . PHP_EOL .
                    "    		</div>";
            }
        }
        $string .= PHP_EOL . "	</div>" . PHP_EOL .
            "	<button type='submit' class='btn btn-sm btn-primary'>Guardar</button>" . PHP_EOL .
            "</form>" .  PHP_EOL;
        return $string;
    }

    public function create_template_table($fields)
    {
        $string = "";
        $string .= "<table id='" . $_GET['t'] . "' class='table table-striped table-sm text-center table-bordered text-nowrap'>" . PHP_EOL;
        $string .= "	<thead>" . PHP_EOL;
        $string .= "		<th class='text-center'>ACCIONES</th>" . PHP_EOL;
        $id = false;
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            $string .= "		<th class='text-center'>" . strtoupper($field) . "</th>" . PHP_EOL;
            if ($field == "id")
                $id = true;
        }
        $string .= "			<thead>" . PHP_EOL;
        $string .= "			<tbody>" . PHP_EOL;
        $string .= '				<?php foreach ($' . $_GET['t'] . ' as $r) { ?>' . PHP_EOL;
        $tr_head = $id == true ? '<tr id="tr_<?= $r["id"] ?>"  data-id-row="<?= $r["id"] ?>">' : '<tr>';
        $string .= '				' . $tr_head . PHP_EOL;
        $string .= '					<td>' . PHP_EOL;
        $string .= '						<div class="btn-group btn-group-xs" role="group">' . PHP_EOL;
        $string .= '							<button type="button" class="btn btn-success btn-sm" onclick="callModalEdit(this)"><i class="fa fa-edit"></i></button>' . PHP_EOL;
        $string .= '						</div>' . PHP_EOL;
        $string .= '					</td>' . PHP_EOL;
        foreach ($fields->getResultArray() as $f) {
            $field = $f["Field"];
            $string .= '					<td id="' . $field . '"><?= $r["' . $field . '"] ?></td>' . PHP_EOL;
        }
        $string .= "				</tr>" . PHP_EOL;
        $string .= '				<?php } ?>' . PHP_EOL;;
        $string .= "			</tbody>" .  PHP_EOL;
        $string .= "		</table>" .  PHP_EOL;
        return $string;
    }

    /**
     * Imprime en una tabla html los elementos que no existen en un folder a partir de una lista de php
     */
    public function files_existe_archivo()
    {
        $c = 1;
        echo "<table>";
        foreach ($this->ARRAY as $r) {
            $nombre_fichero = "C:\Users\HOME\Desktop\INFO JUAN\PDF LISTOS PARA ENTREGA/" . $r[1];
            if (!file_exists($nombre_fichero)) {
                echo "
				<tr>
                    <td>" . $c . "</td>
					<td>" . $r[0] . "</td>
                    <td>" . $r[1] . "</td>
				</tr>
				";
                $c++;
            }
        }
        echo "</table>";
    }

    /**
     * Lista en una tabla html los subdirectorios de un directorio
     */
    public function files_listar_directorios()
    {
        $directorio = 'C:\Users\HOME\Desktop\INFO JUAN/';
        $ficheros  = scandir($directorio);
        echo "<table>";
        $c = 1;
        foreach ($ficheros as $K => $r) {
            if ($r != "." && $r != ".." && substr($r, -5) != ".xlsx") {
                echo "
				<tr>
                    <td>" . $c++ . "</td>
					<td>" . $r . "</td>
				</tr>
				";
            }
        }
        echo "</table>";
    }

    /**
     * Lista en una tabla html los archivos de un directorio
     */
    public function files_listar_archivos()
    {
        $directorio = 'C:\Users\HOME\Desktop\CFDI U080 2023\CFDIS\Honorarios\Dic\pdf';
        $ficheros  = scandir($directorio);
        echo "<table>";
        $c = 1;
        foreach ($ficheros as $K => $r) {
            if ($r != "." && $r != ".." && substr($r, -4) == ".pdf") {
                echo "
				<tr>
					<td>" . $r . "</td>
				</tr>
				";
            }
        }
        echo "</table>";
    }

    /**
     * Crea carpetas a partir del nombre de un archivo quitando la extensión del archivo y mueve los archivos a la ubicación de la carpeta creada
     */
    public function files_crear_carpeta()
    {
        $directorio = 'C:\Users\HOME\Desktop\05DIC2022/';
        $ficheros  = scandir($directorio);
        echo "<table>";
        $c = 1;
        foreach ($ficheros as $k => $r) {
            if (substr($r, -4) == ".pdf") {
                $estructura = 'C:\Users\HOME\Desktop\05DIC2022/' . str_replace(".pdf", "", $r);
                if (!mkdir($estructura, 0777, true)) {
                    echo "
                        <tr>
                            <td>ERROR</td>
                            <td>" . str_replace(".pdf", "", $r) . "</td>
                        </tr>
                    ";
                } else {
                    $currentLocation = 'C:\Users\HOME\Desktop\05DIC2022/' . $r;
                    $newLocation = 'C:\Users\HOME\Desktop\05DIC2022/' . str_replace(".pdf", "", $r) . '/' . $r;
                    $moved = rename($currentLocation, $newLocation);
                    if ($moved) {
                        echo "
                        <tr>
                            <td>$c</td>
                            <td>OK</td>
                            <td>" . str_replace(".pdf", "", $r) . "</td>
                        </tr>
                        ";
                        $c++;
                    } else {
                        echo "
                        <tr>
                            <td></td>
                            <td>OK</td>
                            <td>" . str_replace(".pdf", "", $r) . "</td>
                        </tr>
                        ";
                    }
                }
            }
        }
        echo "</table>";
    }

    /**
     * Mueve los archivos a una carpeta
     */
    public function files_integrar_carpetas()
    {
        $directorio = 'C:\Users\HOME\Desktop\integrar_carpetas/';
        $ficheros  = scandir($directorio);
        echo "<table>";
        foreach ($ficheros as $k => $r) {
            if ($r != "." && $r != ".." && !str_contains($r, '.pdf')) {
                $exists = file_exists('C:\Users\HOME\Desktop\integrar_carpetas/' . $r . '.pdf');
                if ($exists) {
                    $currentLocation = 'C:\Users\HOME\Desktop\integrar_carpetas/' . $r . '.pdf';
                    $newLocation = 'C:\Users\HOME\Desktop\integrar_carpetas/' . $r . '/' . $r . '.pdf';
                    $moved = rename($currentLocation, $newLocation);
                    if (!$moved) {
                        echo "
                    <tr>
                        <td>ERROR AL MOVER</td>
                        <td>" . $r . "</td>
                    </tr>
                    ";
                    }
                } else {
                    echo "
                <tr>
                    <td>ARCHIVO NO EXISTE</td>
                    <td>" . $r . "</td>
                </tr>
                ";
                }
            }
        }
        echo "</table>";
    }

    /**
     * Mueve los archivos de una carpeta a otra
     */
    public function files_move_files()
    {
        $directorio_archivos = 'C:\Users\HOME\Desktop\FILES';
        $directorio_folders = 'C:\Users\HOME\Desktop\A TRABAJAR\DIRECCION DE EDUCACION FISICA';
        $directorio = opendir($directorio_archivos);
        //recoger los  datos
        $datos = array();
        while ($archivo = readdir($directorio)) {
            if (($archivo != '.') && ($archivo != '..') && (substr($archivo, -4) == ".pdf" || substr($archivo, -4) == ".PDF")) {
                $nombre = str_replace(".pdf", "", $archivo);
                $nombre = str_replace(".PDF", "", $nombre);
                if (!is_dir($directorio_folders . "/" . $nombre)) {
                    mkdir($directorio_folders . "/" . $nombre, 0777);
                } else {
                }
                rename($directorio_archivos . "/" . $archivo, $directorio_folders . "/" . $nombre . "/" . $archivo);
            }
        }
    }

    /**
     * Mueve los archivos a un folder con su mismo nombre (los crea si no existen)
     */
    public function files_create_to_subfolders()
    {
        $directorio_archivos = 'C:\Users\HOME\Desktop\FILES';
        $directorio_folders = 'C:\Users\HOME\Desktop\A TRABAJAR\DIRECCION DE EDUCACION FISICA';
        $directorio = opendir($directorio_archivos);
        //recoger los  datos
        $datos = array();
        while ($archivo = readdir($directorio)) {
            if (($archivo != '.') && ($archivo != '..') && (substr($archivo, -4) == ".pdf" || substr($archivo, -4) == ".PDF")) {
                $nombre = str_replace(".pdf", "", $archivo);
                $nombre = str_replace(".PDF", "", $nombre);
                if (!is_dir($directorio_folders . "/" . $nombre . "/" . $archivo)) {
                } else {
                    rename($directorio_archivos . "/" . $archivo, $directorio_folders . "/" . $nombre . "/" . $archivo);
                }
            }
        }
    }

    /**
     * Lista todos los archivos de un directorio
     */
    public function files_read_folders()
    {
        $directorio_archivos = 'C:\Users\HOME\Documents\U080 ESTATAL AUDITORIA';
        $directorio = opendir($directorio_archivos);
        while ($archivo = readdir($directorio)) {
            if (($archivo != '.') && ($archivo != '..')) {
                echo "<p>" . $archivo . "</p>";
            }
        }
    }

    public function files_have_subfolders()
    {
        $directorio_archivos = 'C:\Users\HOME\Desktop\AUDITORIA 2023-11-09\ASDLFKHASDFHAS\RESPALDO';
        $directorio = opendir($directorio_archivos);
        //recoger los  datos
        while ($archivo = readdir($directorio)) {
            $subfiles = opendir($directorio_archivos . "/" . $archivo);
            if (($archivo != '.') && ($archivo != '..')) {
                while ($subarchivo = readdir($subfiles)) {
                    if (is_dir($directorio_archivos . "/" . $archivo . "/" . $subarchivo)) {
                        if (($subarchivo != '.') && ($subarchivo != '..')) {
                            echo "<p>" . $directorio_archivos . "/" . $archivo . "/" . $subarchivo . "</p>";
                        }
                    }
                }
            }
        }
    }

    /**
     * Lee datos del timbrado de unas facturas
     */
    public function files_xmls()
    {
        $directorio_archivos = "C:\Users\HOME\Desktop\cfdi\XML 4 de 5";
        $directorio = opendir($directorio_archivos);
        echo "<table>";
        while ($archivo = readdir($directorio)) {
            if (substr($archivo, -4) == ".xml" || substr($archivo, -4) == ".XML") {
                $xml = simplexml_load_file($directorio_archivos . "/" . $archivo);
                $ns = $xml->getNamespaces(true);
                $xml->registerXPathNamespace('t', $ns['tfd']);
                foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
                    echo "<tr>
                        <td>$archivo</td>
                        <td>" . $tfd['FechaTimbrado'] . "</td>
                    </tr>";
                }
            }
        }
    }

    /**
     * Extrae datos de una pagina web de los centros de trabajos
     */ 
    public function extrae_cct()
    {
        $start = microtime(true);
        $CctModel = new CctModel();
        $arr = [];
        $inicio = 11801;
        for ($i = $inicio; $i <= ($inicio + 99); $i++) {
            array_push($arr, $i);
        }
        $cts = $CctModel->whereIn("id", $arr)->findAll(200);
        $tr = "";
        foreach ($cts as $r) {
            $DOMICILIO = "";
            $url = "https://escuelasmex.com/directorio/" . $r["cvect"];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            if ($data === false)
                return $this->response->setJSON(array("status" => 0, "msg" => "Falló la solicitud: " . curl_error($ch)));
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpcode > 199 && $httpcode < 300) {
                //echo $r["id"] . ", ";
                $dataFile = trim(str_replace(["\r\n", "\r", "\n", "\t", "<br>", PHP_EOL], ['', '', '', '', ',', ''], file_get_contents($url)));
                preg_match('/<li><i class="fi-marker"><\/i>(.*?)<\/li>/s', trim($dataFile), $DOM);
                $DOMICILIO = isset($DOM[1]) ? $DOM[1]     : "";
            }
            $tr .= "<tr><td>" . $r["id"] . "</td><td>" . $r["cvect"] . "</td><td>$httpcode</td><td>$DOMICILIO</td></tr>";
        }
        $end = microtime(true);
        $time = round($end - $start, 2);
        echo "<p>Tiempo total de ejecución: <b>$time</b> segundos</p>";
        return "<table><thead><tr><th>ID</th><th>CLAVE CT</th><th>CÓDIGO HTTP</th><th>DOMICILIO</th></tr></thead><tbody>$tr</tbody></table>";
    }
}