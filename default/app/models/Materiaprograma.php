<?php

class Materiaprograma extends ActiveRecord {
    public function materiasprograma($programa) {
        $programa = filter_var($programa, FILTER_SANITIZE_STRING);
        
        return $this->find("columns: materia.id_materia, materia.codigo_materia, materia.nombre_materia", "join: join materia on materiaprograma.id_materia = materia.id_materia", "conditions: id_programa = " . $programa, "order: nombre_materia" );
    }
}
