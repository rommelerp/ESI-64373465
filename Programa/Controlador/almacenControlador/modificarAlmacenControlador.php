<?php
require_once "../Modelo/almacenModelo/modificarAlmacenModelo.php";

class modificarAlmacenControlador
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new modificarAlmacenModelo();
    }

    public function update()
    {
        if ($_POST) {
            $id = $_POST['idAlmacen'];
            $filas = $this->modelo->obtenerAlmacenByIdModelo($id);
            require_once "../Vista/vistaFuncionarioAlmacen/vistaAlmacen/modificarAlmacen2.php";
        }
    }

    public function update2()
    {
        if ($_POST) {
            $idAlmacenActual = $_POST['idAlmacenActual'];
            $id_modificado = $_POST['idAlmacen'];

            $almacen = [
                'idAlmacen' => $id_modificado,
                'idAlmacenActual' => $idAlmacenActual
            ];

            if ($this->modelo->actualizarAlmacen($almacen)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}
?>