<?php

class Programa extends ActiveRecord {
    public function programas() {
        return $this->find('columns: *', 'order: nombre_programa');
    }
    
    public function programasDocente($docente) {
        return $this->find("columns: programa.*",
                "join: join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia",
                "conditions: id_docente = $docente
                    group by codigo_programa",
                "order: nombre_programa");
    }
}
