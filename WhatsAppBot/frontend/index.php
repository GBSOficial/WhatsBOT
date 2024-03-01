<?php
session_start();
include 'src/db/config.php';

$pg = "";
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $pg = addslashes($_GET['page']);
}

switch($pg)
{
    case 'home': 
        require 'src/themes/home.php';
    break;
    case 'instance':
        require 'src/themes/instancia.php';
        break;
    case 'list-instance':
        require 'src/themes/listar_instancias.php';
        break;
    case 'send-message':
        require 'src/themes/enviar_msg_txt.php';
        break;
    case 'config-api':
        require 'src/themes/config_api.php';
        break;
    case 'qrcode':
        require 'src/themes/exibir_qrcode.php';
        break;
}
?>