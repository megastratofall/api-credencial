<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class UserModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerDatosAfiliadoPorNumDoc($tipdoc, $numdoc, $clave) {
        $query = "SELECT tipdoc, numdoc, nombre, baja, numero, orden, ingre, nacim FROM padron WHERE tipdoc = '$tipdoc' AND numdoc = $numdoc";
        
        $result = $this->db->query($query);
        
        if ($result === false) {
            die('Error en la consulta: ' . $this->db->error);
        }
        
        $afiliado = $result->fetch_assoc();
        
        // Verifica si la clave coincide con el número de documento
        if ($afiliado !== null && $clave == $afiliado['numdoc']) {
            return $afiliado;
        } else {
            return null; // No se encontró el afiliado o la clave no coincide
        }
    }

    public function obtenerDescripPorPlan($tipdoc, $numdoc, $clave) {
        $query = "SELECT valores.descrip 
        FROM padron 
        JOIN valores ON padron.plan = valores.plan 
        WHERE padron.tipdoc = '$tipdoc' AND padron.numdoc = $numdoc";
        $result = $this->db->query($query);
        
        if ($result === false) {
            die('Error en la consulta: ' . $this->db->error);
        }

        $row = $result->fetch_assoc();
        
        return ($row !== null) ? $row['descrip'] : null;
    }
}
?>
