<?php

class Tipoprograma extends ActiveRecord {
    public function tipoProgramas() {
        return $this->find();
    }
}
