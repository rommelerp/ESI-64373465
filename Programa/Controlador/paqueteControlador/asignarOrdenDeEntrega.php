<?php

require_once "../Modelo/paqueteModelo/asignarOrdenDeEntregaModelo.php";

class asignarOrdenDeEntrega
{
    
    public function asignar()
    {
        if ($_POST) {
            $modelo = new asignarOrdenDeEntregaModelo();
            $idPaquete = $_POST['idPaquete'];
            $ordenDeEntrega = $_POST['ordenDeEntrega'];

            $ordenDeEntrega = [
                'idPaquete' => $idPaquete,
                'ordenDeEntrega' => $ordenDeEntrega
            ];

            if ($modelo->asignar($ordenDeEntrega)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}

?>