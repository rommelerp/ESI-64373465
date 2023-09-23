<?php

require_once "../Modelo/camionModelo/asignarLoteCamionModelo.php";

class asignarLoteCamion
{
    
    public function asignar()
    {
        if ($_POST) {
            $modelo = new asignarLoteCamionModelo();
            $matricula = $_POST['matricula'];
            $idLote = $_POST['idLote'];

            $camion = [
                'matricula' => $matricula,
                'idLote' => $idLote
            ];

            if ($modelo->asignar($camion)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}

?>