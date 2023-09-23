<?php
require_once "../Modelo/camionModelo/modificarCamionModelo.php";

class modificarCamionControlador
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new modificarCamionModelo();
    }

    public function update()
    {
        if ($_POST) {
            $id = $_POST['matricula'];
            $filas = $this->modelo->obtenerCamionByIdModelo($id);
            require_once "../Vista/vistaFuncionarioAlmacen/vistaCamion/modificarCamion2.php";
        }
    }

    public function update2()
    {
        if ($_POST) {
            $idCamionActual = $_POST['matriculaActual'];
            $id_modificado = $_POST['matricula'];

            $camion = [
                'matricula' => $id_modificado,
                'matriculaActual' => $idCamionActual
            ];

            if ($this->modelo->actualizarCamion($camion)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}
?>