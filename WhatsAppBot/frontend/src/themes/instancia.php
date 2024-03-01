<?php
include 'src/db/config.php';

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

if (isset($_POST['add_instancia'])) {

    $instancia = $_POST['instancia'];

    try { //cadastra a instancia no banco de dados
        $sql = 'INSERT INTO instancias (nome) 
                        VALUES (:nome)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $instancia);
        $stmt->execute();

        // Criando a Instancia na API
        $parametros = "/session/start/";
        $url = $url_api . $parametros . $instancia;

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

        // verificar se a query foi executada com sucesso
        if ($stmt->rowCount() > 0) {
            echo "<script>javascript:alert('Instância criada com sucesso!');javascript:window.location='?page=list-instance';</script>";
        } else {
            echo "<script>javascript:alert('Aconteceu algum erro, tente novamente!');javascript:window.location='?page=list-instance';</script>";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
include 'src/themes/classes/nav.php';
?>
<!DOCTYPE html>
<html lang="pt-br" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="src/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manager - CursoDev</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="src/assets/img/favicon/favicon.ico" />

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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Criar /</span> Instância</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <!-- Account -->
                                    <form id="formAccountSettings" method="POST" enctype="multipart/form-data" name="add_instancia">                                        
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="titulo" class="form-label">Nome da Instância</label>
                                                    <input class="form-control" type="text" id="instancia" name="instancia" value="" autofocus />
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2" name="add_instancia">Criar Instância</button>
                                            </div>
                                    </form>
                                </div>
                                <!-- /Account -->
                            </div>
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
    <script src="src/assets/js/darkmode.js"></script>

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