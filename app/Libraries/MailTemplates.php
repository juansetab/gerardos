<?php 

namespace App\Libraries;

class MailTemplates{

    private function base_template($title, $content, $content_align = "center"){
        return 
        '<div style="text-align:center">
            <img src="https://tabasco.gob.mx/sites/default/files/users/setabasco/LogoEducaTab2.jpg" max-width="70%" height="auto" alt="logo_setab">
        </div>
        <div style="text-align:center">
            <h2>' . $title . '</h2>
        </div>
        <div style="text-align:' . $content_align . '">
            ' . $content . '
        </div>
        <div style="text-align:center">
            <p><i>Correo enviado automáticamente por el portal de trámites de la Dirección General de Administración de la Secretaría de Educación. Este correo es enviado con fines informativos, no se debe responder.</i></p>
        </div>';
    }

    public function documentacion_contratacion_subida(){
        $title = 'Trámite en proceso';
        $content = '<p>Se ha subido la documentación de manera satisfactoria. Se recomienda estar al pendiente del estado de su trámite a través del portal o de su bandeja de entrada de su correo electrónico.</p>
            <p><b>URL:</b> <a href="' . base_url("portal_tramites/contrataciones") . '" target="_blank">Ver trámite</a></p>';
        return $this->base_template($title, $content, "left");
    }

    public function documentacion_solicitud_pago_subida(){
        $title = 'Trámite en proceso';
        $content = '<p>Se ha subido la documentación de manera satisfactoria. Se recomienda estar al pendiente del estado de su trámite a través del portal o de su bandeja de entrada de su correo electrónico.</p>
            <p><b>URL:</b> <a href="' . base_url("portal_tramites/solicitudes_pago") . '" target="_blank">Ver trámite</a></p>';
        return $this->base_template($title, $content, "left");
    }
}