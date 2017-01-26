<?php

class Validacion extends ActiveRecord {
    public function cargarDatosValidacion($id) {
        return $this->find_first("conditions: id_validacion = $id");
    }
}
