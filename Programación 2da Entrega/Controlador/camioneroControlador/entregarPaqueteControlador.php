<?php

require_once "../Modelo/camioneroModelo/entregarPaqueteModelo.php";
class entregarPaqueteControlador
{

    public function entregar()
    {
        if ($_POST) {
            
            $modelo = new entregarPaqueteModelo();
            $id = $_POST['idPaquete'];
            $entrega = $_POST['entrega'];
            if ($modelo->entregarPaquete($id, $entrega)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaCamionero/index.html?exito=true");
            } else {
                header("Location:  http://localhost/PROGRAMA/Vista/vistaCamionero/index.html?exito=false");

            }



        }

    }
}
?>