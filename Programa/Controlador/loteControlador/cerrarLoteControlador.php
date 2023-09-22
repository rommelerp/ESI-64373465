<?php

require_once "../Modelo/loteModelo/cerrarLoteModelo.php";
class cerrarLoteControlador
{

    public function cerrar()
    {
        if ($_POST) {
            
            $modelo = new cerrarLoteModelo();
            $id = $_POST['idLote'];
            if ($modelo->cerrarLote($id)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location:  http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");

            }



        }

    }
}
?>