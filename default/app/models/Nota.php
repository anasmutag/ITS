<?php

class Nota extends ActiveRecord {
    public function cargarTiposNotas($sede, $materia) {
        /*return $this->find_by_sql("select count(*) as resultado"
                . " from ("
                    . "select id_tiponota"
                    . " from nota join alumno on nota.id_alumno = alumno.id_alumno"
                        . " join matricula on alumno.id_alumno = matricula.id_alumno"
                    . " where id_estadomatricula = 1"
                        . " and id_materia = $materia"
                        . " and id_sede = $sede"
                        . " and id_tiponota <> 4"
                    . " group by id_tiponota"
                . ") as table1");*/
        
        return $this->find_by_sql("select count(*) as resultado"
                . " from ("
                    . "select id_tiponota"
                . " from nota join alumno on nota.id_alumno = alumno.id_alumno"
                    . " join matricula on alumno.id_alumno = matricula.id_alumno"
                    . " join materia on nota.id_materia = materia.id_materia"
                    . " join materiaprograma on materia.id_materia = materiaprograma.id_materia"
                . " where id_estadomatricula = 1"
                    . " and matricula.id_semestre = semestre"
                    . " and nota.id_materia = $materia"
                    . " and id_sede = $sede"
                    . " and id_tiponota <> 4"
                . " group by id_tiponota) as table1");
    }
    
    public function cargarSemestresAlumno($id) {
        return $this->find("columns: semestre",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = (
                    select id_alumno
                    from alumno
                    where identificacion_alumno = $id
                ) group by semestre",
                "order: semestre");
    }
    
    public function cargarSemestreAlumno($id, $semestre) {
        return $this->find("columns: semestre",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = (
                    select id_alumno
                    from alumno
                    where identificacion_alumno = $id
                ) and semestre = $semestre group by semestre",
                "order: nombre_materia");
    }
    
    public function cargarMateriasAlumno($id) {
        return $this->find("columns: semestre,materia.id_materia,codigo_materia,nombre_materia",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = (
                    select id_alumno
                    from alumno
                    where identificacion_alumno = $id
                ) group by nombre_materia",
                "order: nombre_materia");
    }
    
    public function cargarMateriasSemestreAlumno($id, $semestre) {
        return $this->find("columns: semestre,materia.id_materia,codigo_materia,nombre_materia",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = (
                    select id_alumno
                    from alumno
                    where identificacion_alumno = $id
                ) and semestre = $semestre group by nombre_materia",
                "order: nombre_materia");
    }
    
    public function cargarNotasAlumno($id) {
        return $this->find("columns: semestre,materia.id_materia,nombre_materia,valor_nota,faltas_nota,nota.id_tiponota,nombre_tiponota",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = (
                    select id_alumno
                    from alumno
                    where identificacion_alumno = $id
                )",
                "order: nota.id_tiponota");
    }
    
    public function cargarNotasSemestreAlumno($id, $semestre) {
        return $this->find("columns: semestre,materia.id_materia,nombre_materia,valor_nota,faltas_nota,nota.id_tiponota,nombre_tiponota",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = (
                    select id_alumno
                    from alumno
                    where identificacion_alumno = $id
                ) and semestre = $semestre",
                "order: nota.id_tiponota,id_nota");
    }
    
    public function cargarNotasMateria($id, $materia) {
        return $this->find("columns: nota.id_tiponota,valor_nota",
                "join: join materia on nota.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join tiponota on nota.id_tiponota = tiponota.id_tiponota",
                "conditions: id_alumno = $id
                    and materia.id_materia = $materia",
                "order: nota.id_tiponota");
    }
    
    public function cargarNotasCv($alumno, $materia) {
        if ($this->exists("id_alumno = $alumno and id_materia = $materia and id_tiponota = 4")) {
            return true;
        } else {
            return false;
        }
    }
}
