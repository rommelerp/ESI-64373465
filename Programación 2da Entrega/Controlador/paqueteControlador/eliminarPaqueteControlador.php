<?php

require_once "../Modelo/paqueteModelo/eliminarPaqueteModelo.php";
class eliminarPaqueteControlador
{

    public function delete()
    {
        if ($_POST) {
            
            $modelo = new eliminarPaqueteModelo();
            $id = $_POST['id'];
            if ($modelo->eliminarPaquete($id)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location:  http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");

            }



        }

    }
}
?>