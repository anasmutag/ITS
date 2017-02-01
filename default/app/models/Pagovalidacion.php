<?php

class Pagovalidacion extends ActiveRecord {
    public function cargarDatosPagoValidacion($id) {
        return $this->find_first("conditions: id_validacion = $id");
    }
}
