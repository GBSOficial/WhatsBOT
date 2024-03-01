<?php
include 'src/db/config.php';

$instancia = $_GET['instancia'];

try {
    $sql = 'SELECT * FROM config_api';
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        foreach ($results as $result) {
            $instancia_ID = $result['id'];
            $url_api = $result['url_api'];
            $api_key = $result['api_key'];
        }
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Parametros do End-Point
$parametros_status = "/session/status/";
// Montando url de ação
$url = $url_api . $parametros_status . $instancia;

$headers = [
    'accept: application/json',
    'x-api-key: ' . $api_key
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$responseArray = json_decode($response, true);

if ($responseArray['message'] === 'session_not_found') {
    
    // Parametros do End-Point
    $parametros_start = "/session/start/";

    // Montando url de ação
    $url = $url_api . $parametros_start . $instancia;

    $headers = [
        'accept: application/json',
        'x-api-key: ' . $api_key
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "<script>alert('Iniciando a Sessão, caso o QRCODE não apareça atualize a página!'); window.location.href = '?page=qrcode&instancia=$instancia;</script>";
}
include 'src/themes/classes/nav.php';
?>
<!DOCTYPE html>
<html lang="pt-br" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="src/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manager - GBSOficial</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="src/assets/img/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="src/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="src/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="src/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="src/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="src/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="src/assets/vendor/js/helpers.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="src/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Exibindo QRCODE<br><hr>Instancia: <span style="color:red"><?php echo $instancia ?></span><hr></h5>
                            <div style="padding-left: 20px; padding-right:20px"><div class="alert alert-danger" role="alert" style="padding: 20px;">QRCODE é válido por apenas 40 segundos, Caso não apareça ou erro, atualize a página.</div></div>
                            <?php
                            if ($responseArray['state'] === 'CONNECTED') {
                                echo '<div style="margin-left:20px; margin-bottom:20px"><span class="badge" style="padding:10%; border-radius:12px; background-color:green">Instancia Conectada</span></div>';
                            }else{

                            // Parametros do End-Point
                            $parametros = "/session/qr/".$instancia."/image";

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
                                $imageData = base64_encode($response); // Convertendo a imagem para base64
                                $src = 'data:image/png;base64,'.$imageData; // Criando o src da tag img
                                echo "<div><img src=\"$src\"></div>"; // Exibindo a imagem dentro da div
                            } else {
                                echo "Erro ao obter o QR code, atualize a página.";
                            }
                            }

                            ?>                            
                        </div>
                    </div>

                </div>
                <!-- / Content -->
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="src/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="src/assets/vendor/libs/popper/popper.js"></script>
    <script src="src/assets/vendor/js/bootstrap.js"></script>
    <script src="src/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="src/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="src/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="src/assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>