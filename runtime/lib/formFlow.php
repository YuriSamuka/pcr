<?php
/**
 * @author : Yuri Samuel
 * @since : 19/02/2017 02:38
 * @version: 1.0
 *
 */

require_once 'conexao.php';
require_once 'crudForm.php';
require_once 'rastreabilidade.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$nomeForm = $_GET['form'];
define('FORM', $nomeForm);
if (is_file('..\\' . FORM . '.php')){
    require_once '..\\' . FORM . '.php';
    $formulario = new $nomeForm();
    if ($acao){
        $formulario->$acao();
    } else {
        $formulario->inicializar();
    }
}else {
    echo 'não acheeei! (sem zoas, tratar essa exeção)   ' . $nomeForm;
}
echo '<script type="text/javascript" src="public\js\ajax.js"></script>';
echo '<script type="text/javascript" src="jquery-1.8.2.min.js"></script>';
echo '<script type="text/javascript" src="public\js\jquery.fcbkcomplete_lookup.js?version=19" type="text/javascript" charset="utf-8"></script>';
echo '<script type="text/javascript" src="public\js\lookup.js?version=19"></script>';
