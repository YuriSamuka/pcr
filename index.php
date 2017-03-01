<?php
/**
 * @author : Yuri Samuel
 * @since : 29/01/2017 01:21
 * @version: 1.0
 *
 */

require_once 'runtime\lib\conexao.php';
require_once 'runtime\lib\crudForm.php';
require_once 'runtime\lib\form.php';
require_once 'runtime\lib\rastreabilidade.php';

require_once 'runtime\lib\Template.php';

$titlePage = 'Cadastro de RF';
$nomeProjeto = 'AdvMaster';
$dataInici = '21/01/2017';
$dataPreveisaoFim = '31/012/2030';

$t = new Template('PCR - ' . $titlePage, $nomeProjeto, $dataInici, $dataPreveisaoFim);
$t->header();
$nomeForm = $_GET['form'];
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
define('FORM', $nomeForm);
if (is_file('runtime\\' . FORM . '.php')){
    require_once 'runtime\\' . FORM . '.php';
    $formulario = new $nomeForm();
    if ($acao){
        $formulario->$acao();
    } else {
        $formulario->inicializar();
    }
}
//                        **************************************************************************************************************************
//                        **************************************************************************************************************************
//                        ***********************************************CONTINUAR APARTIR DAQUI****************************************************
//                            EU ESTAVA TRABALHANDO NA CLASS Template  E ESTAVA QUASE "ACABANDO"
//
//                            ---------LER LISTA DE COISAS HA FAZER NO NOTE PAD PARA SE ORIENTAR------
//
//                            -----------------------NOTE PAD--------------------------------
$t->footer();