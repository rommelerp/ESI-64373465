<?php

require_once "../Modelo/loteModelo/eliminarLoteModelo.php";
class eliminarLoteControlador
{

    public function delete()
    {
        if ($_POST) {
            
            $modelo = new eliminarLoteModelo();
            $id = $_POST['idLote'];
            if ($modelo->eliminarLote($id)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location:  http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");

            }



        }

    }
}
?>