<?php

class Alumno extends ActiveRecord {
    public function cargarDatosAlumno($id) {
        return $this->find("columns: abreviatura_tipodocumento,identificacion_alumno,nombre_alumno,apellido_alumno,nombre_programa",
                "join: join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join tipodocumento on alumno.id_tipodocumento = tipodocumento.id_tipodocumento",
                "conditions: identificacion_alumno = $id");
    }
    
    public function validarCodigo($id) {
        if ($this->exists("identificacion_alumno = '" . $id . "'")) {
            return true;
        } else {
            return false;
        }
    }
}
