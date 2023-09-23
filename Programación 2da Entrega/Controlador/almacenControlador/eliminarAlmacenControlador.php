<?php

require_once "../Modelo/almacenModelo/eliminarAlmacenModelo.php";

class eliminarAlmacenControlador 
{

    public function delete() 
    {
        if ($_POST) {

            $modelo = new eliminarAlmacenModelo();
            $id = $_POST['idAlmacen']; 
            if ($modelo->eliminarAlmacen($id)) { 
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location:  http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}
?>