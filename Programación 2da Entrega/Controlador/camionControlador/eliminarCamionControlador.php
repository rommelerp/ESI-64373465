<?php

require_once "../Modelo/camionModelo/eliminarCamionModelo.php";

class eliminarCamionControlador 
{

    public function delete() 
    {
        if ($_POST) {

            $modelo = new eliminarCamionModelo();
            $id = $_POST['matricula']; 
            if ($modelo->eliminarCamion($id)) { 
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location:  http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}
?>