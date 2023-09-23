<?php

require_once "../Modelo/paqueteModelo/asignarLotePaqueteModelo.php";

class asignarLotePaquete
{
    
    public function asignar()
    {
        if ($_POST) {
            $modelo = new asignarLotePaqueteModelo();
            $idPaquete = $_POST['idPaquete'];
            $lote_modificado = $_POST['idLote'];

            $lote = [
                'idPaquete' => $idPaquete,
                'idLote' => $lote_modificado
            ];

            if ($modelo->asignar($lote)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}

?>