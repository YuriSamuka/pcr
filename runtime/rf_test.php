<?php

/**
 * @author : Yuri Samuel
 * @since : 29/01/2017 01:54
 * @version: 1.0
 *
 */

class rf_test extends CrudForm
{
    public function inicializar(){
        $this->beginForm('Cadastro de Requisito Funcional');
            $value = (isset($_REQUEST['nome']) && $_REQUEST['nome']) ? $_REQUEST['nome'] : '';
            $this->inputString('','Nome/assunto do Requisito', 62, $value, 'nome');
            $this->inputString('','', 6, 'RF-00', 'codigo', '', true);
            $value = (isset($_REQUEST['descricao']) && $_REQUEST['descricao']) ? $_REQUEST['descricao'] : '';
            $this->inputStringTextarea('', 'Descrição do requisito', 6, 12, 1000, $value, 'descricao');
            $value = (isset($_REQUEST['criterio_aceitacao']) && $_REQUEST['criterio_aceitacao']) ? $_REQUEST['criterio_aceitacao'] : '';
            $this->inputStringTextarea('', 'Criterio de aceitação', 3, 12, 500, $value, 'criterio_aceitacao');
            $value = (isset($_REQUEST['fonte']) && $_REQUEST['fonte']) ? $_REQUEST['fonte'] : '';
            $this->inputString('', 'Fonte do requisito', 120, $value, 'fonte');
            $aLista = self::$prioridades;
            $this->comboBox('Prioridade', 'prioridade', $aLista);
            $this->button('Salvar', 'salvar', true);
        $this->endForm();
    }

    public function salvar(){
//        print_r($_REQUEST);
        $aNomeCampos = ['nome', 'descricao', 'criterio_aceitacao', 'fonte', 'codigo', 'status_rf'];
        $aValores = array();
        $aValores['nome'] = (isset($_REQUEST['nome']) && $_REQUEST['nome']) ? $_REQUEST['nome'] : '';
        $aValores['descricao'] = (isset($_REQUEST['descricao']) && $_REQUEST['descricao']) ? $_REQUEST['descricao'] : '';
        $aValores['criterio_aceitacao'] = (isset($_REQUEST['criterio_aceitacao']) && $_REQUEST['criterio_aceitacao']) ? $_REQUEST['criterio_aceitacao'] : '';
        $aValores['fonte'] = (isset($_REQUEST['fonte']) && $_REQUEST['fonte']) ? $_REQUEST['fonte'] : '';

        $r = new Rastreabilidade;
        $r->requisitoCodigoUnico();

        $aValores['codigo'] = 'RF-00';
        $aValores['prioridade'] = (isset($_REQUEST['prioridade']) && $_REQUEST['prioridade']) ? $_REQUEST['prioridade'] : '';
        $aValores['status_rf'] = 1;
        $this->insert($aValores, 'rf');
        $this->inicializar();
    }

}