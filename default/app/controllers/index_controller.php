<?php

class IndexController extends AppController {
    public function index($banInicio = 0) {
        (Input::request('banInicio') > 0)?View::template(NULL):'';
    }
    
    public function institucion() {
        View::template(NULL);
    }
    
    public function visitanos() {
        View::template(NULL);
    }
}
