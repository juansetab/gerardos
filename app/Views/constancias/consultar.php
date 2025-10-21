<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url("public/library/sneat_template") ?>/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Iniciar Sesión - <?= CORE_NAME ?></title>
  <meta name="description" content="" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= base_url("public/images") ?>/morelab.ico" type="image/ico" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="<?= base_url("public/library/sneat_template") ?>/vendor/css/pages/page-auth.css" />

  <!-- Helpers -->
  <script src="<?= base_url("public/library/sneat_template") ?>/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?= base_url("public/library/sneat_template") ?>/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Forgot Password -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <img style="max-width: 100%; height : auto;" src="<?= base_url("public/images") ?>/logo_comprimido.jpg" />
            </div>
            <!-- /Logo -->
            <form id="formLogin" class="mb-3" action="<?= base_url("constancias/validar") ?>" method="post">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del alumno(a):</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required />
              </div>
              <div class="mb-3">
                <label for="folio" class="form-label">Ingrese folio:</label>
                <div class="input-group">
                  <span class="input-group-text">G-</span>
                  <input type="text" class="form-control" id="folio" name="folio" required />
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-primary">Consultar</button>
              </div>

            </form>
          </div>
        </div>
        <!-- /Forgot Password -->
      </div>
    </div>
  </div>
  <script>

  </script>
  <script src="<?= base_url("public/library/sneat_template") ?>/vendor/libs/jquery/jquery.js"></script>
  <script src="<?= base_url("public/library/sneat_template") ?>/vendor/libs/popper/popper.js"></script>
  <script src="<?= base_url("public/library/sneat_template") ?>/vendor/js/bootstrap.js"></script>
  <script src="<?= base_url("public/library/sneat_template") ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="<?= base_url("public/library/sneat_template") ?>/vendor/js/menu.js"></script>
  <script src="<?= base_url("public/library/sneat_template") ?>/js/main.js"></script>
</body>

</html>