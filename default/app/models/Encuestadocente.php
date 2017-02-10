<?php

class Encuestadocente extends ActiveRecord {
    public function cargarEncuestaDocente($docente) {
        return $this->find("columns: encuestadocente.*,docente.nombre_docente,docente.apellido_docente",
                "join: join docente on encuestadocente.id_docente = docente.id_docente",
                "conditions: encuestadocente.id_docente = $docente");
    }
}
