<?php

class Docente extends ActiveRecord {
    public function validarDocente($identificacion,$contrasena){
        $contrasena = addslashes($contrasena);
        $identificacion = addslashes($identificacion);
        
        return $this->find_by_sql('SELECT `validar_docente`("'.$identificacion.'","'.$contrasena.'") AS RESUL;');
    }
}
