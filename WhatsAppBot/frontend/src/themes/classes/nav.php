<?php
include_once("src/db/config.php");
?>

<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.php" class="app-brand-link">
            <img src="src/assets/img/logogbs.png" style="width: 85%;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active open">
            <a href="?page=dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="?page=instance" class="menu-link">
                <i class="menu-icon tf-icons bx bx-message-alt-add"></i>
                <div data-i18n="Analytics">Criar Instância</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="?page=list-instance" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Analytics">Listar Instâncias</div>
            </a>
        </li>

        <li class="menu-item">

            <a href="?page=send-message" class="menu-link">
                <i class='menu-icon tf-icons bx bxl-whatsapp-square'></i>
                <div data-i18n="WhatsApp Api">Mensagem de Texto</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="?page=config-api" class="menu-link">
                <i class='menu-icon tf-icons bx bx-cog'></i>
                <div data-i18n="WhatsApp Api">Config Api</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="<?php echo $url_api ?>/api-docs" class="menu-link" target="_blank">
                <i class="menu-icon tf-icons bx bxl-whatsapp"></i>
                <div data-i18n="Analytics">Documentação API</div>
            </a>
        </li>
        <?php

        // Parametros do End-Point
        $parametros = "/session/status/verificandoStatus";

        // Montando url de ação
        $url = $url_api . $parametros;

        $headers = [
            'accept: image/png',
            'x-api-key: ' . $api_key
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            echo '<div style="padding:30%"><span class="badge rounded-pill bg-success">API ON-LINE!</span></div>';
        } else {
            echo '<div style="padding:30%"><span class="badge rounded-pill bg-danger">API OFF-LINE!</span></div>';
        }

        ?>
        </li>
    </ul>
    <div class="newbtn-exit">
    <a href='?page=logout' class='btn btn-primary btn-block'>Sair</a>
    </div>
    <div class="darkmode-button">
  <button class="button-toggle" onclick="toggleMode()">
    <span id="sun-icon">☀️</span>
    <span id="moon-icon" style="display: none;">🌙</span>
  </button>
</div>
</aside>
<!-- / Menu -->