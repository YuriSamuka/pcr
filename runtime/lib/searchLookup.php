<?php
/**
 * @author : Yuri Samuel
 * @since : 19/02/2017 02:38
 * @version: 1.0
 *
 */

require_once 'crudForm.php';
require_once 'conexao.php';

$buscador = CrudForm::instanciar(Conexao::instaciar());
if ($_REQUEST['busca']){
    $aCampos = [$_REQUEST['lookupCampo']];
    $aRetornos = [$_REQUEST['lookupCampo'], 'id_' . $_REQUEST['lookupTabela']];
    $aBusca = [$_REQUEST['busca']];
    $aAux = $buscador->find($aBusca, $aCampos, $_REQUEST['lookupTabela'], $aRetornos);
    $json = array();
    $json['key'] = $aAux[0]['id_' . $_REQUEST['lookupTabela']];
    $json['value'] = $aAux[0][$_REQUEST['lookupCampo']];
    $sJson = json_encode(array($json), JSON_PRETTY_PRINT);
    $data = fopen('..\..\public\tmp\tmpLookupData.txt', 'w');
    fwrite($data, $sJson);
}