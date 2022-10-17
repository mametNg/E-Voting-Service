<?php if (isset($this->allowFile) && $this->allowFile): ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta property="og:site_name" content="MYUA">
  <meta property="og:url" content="<?= $this->base_url() ?>">
  <meta property="og:image" content="<?= $this->e($data['header']['img_title']); ?>">
  <meta name="description" content="<?= $this->e($data['header']['desc']); ?>">
  <meta name="author" content="W3LL Squad">
  <meta name="access-token" content="<?= $this->e(base64_encode($this->RSAPublicKey())) ?>">

  <title><?= $this->e($data['header']['title']); ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= $this->e($data['header']['img_title']); ?>" type="image/png">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="<?= $this->base_url(); ?>/assets/libs/@fontawesome/fontawesome-pro/css/all.min.css"><!-- Page CSS -->
  <link rel="stylesheet" href="<?= $this->base_url(); ?>/assets/css/purpose.css" id="stylesheet">
  <!-- Docs CSS - used only for demo -->
  <link rel="stylesheet" href="<?= $this->base_url(); ?>/assets/css/docs.css">
  <link rel="stylesheet" href="<?= $this->base_url(); ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $this->base_url(); ?>/assets/libs/cropperjs/dist/cropper.css">
</head>

<body class="docs">
<?php endif; ?>