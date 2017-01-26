<?php

class Programa extends ActiveRecord {
    public function programas() {
        return $this->find('columns: *', 'order: nombre_programa');
    }
}
