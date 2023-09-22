<?php
require_once "../Modelo/loteModelo/modificarLoteModelo.php";

class modificarLoteControlador
{
private $modelo;

public function __construct()
    {
        $this->modelo = new modificarLoteModelo();
    }


    public function update()
    {
        if ($_POST) {
            $id = $_POST['idLote'];
            $filas = $this->modelo->obtenerLoteByIdModelo($id);
            require_once "../Vista/vistaFuncionarioAlmacen/vistaLote/modificarLote2.php";
            

            
        }
    }


    public function update2()
    {
        if ($_POST) {
            $idLoteActual = $_POST['idLoteActual'];
            $id_modificado = $_POST['idLote'];
            
            
            $lote = [
                'idLote' => $id_modificado,
                'idLoteActual' => $idLoteActual
            ];

            if ($this->modelo->actualizarLote($lote)) {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=true");
            } else {
                header("Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/index.html?exito=false");
            }
        }
    }
}
?>