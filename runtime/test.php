<?php

/**
 * @author : Yuri Samuel
 * @since : 29/01/2017 01:54
 * @version: 1.0
 *
 */

class test extends CrudForm
{
    public function inicializar(){
        $this->beginForm('Outro formulario em outro arquivo');
        $value = (isset($_REQUEST['nome']) && $_REQUEST['nome']) ? $_REQUEST['nome'] : '';
        $this->inputString('','Nome/assunto do Requisito', 62, $value, 'nome');
        $this->button('voltar', 'inicializar', true, 'rf_test');
        $this->endForm();
    }
}