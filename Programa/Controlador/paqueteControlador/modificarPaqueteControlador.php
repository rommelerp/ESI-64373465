<?php
require_once "../Modelo/paqueteModelo/modificarPaqueteModelo.php";

class modificarPaqueteControlador
{
private $modelo;

public function __construct()
    {
        $this->modelo = new modificarPaqueteModelo();
    }


    public function update()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $filas = $this->modelo->obtenerPaqueteByIdModelo($id);
            require_once "../Vista/vistaFuncionarioAlmacen/vistaPaquete/modificarPaquete2.php";
            

            
        }
    }


    public function update2()
    {
        if ($_POST) {
            $id_modificado = $_POST['idPaquete'];
            $destino_modificado = $_POST['destino'];
            $idPaqueteActual = $_POST['idPaqueteActual'];

            $paquete = [
                'idPaquete' => $id_modificado,
                'destino' => $destino_modificado,
                'idPaqueteActual' => $idPaqueteActual
            ];

            if ($this->modelo->actualizarPaquete($paquete)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}
?>