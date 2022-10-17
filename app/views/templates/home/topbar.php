<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <!-- Nav -->
  <header class="header fixed-top border-bottom">
    <!-- Nav -->
    <nav id="navbar-main" class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <!-- Brand logo -->
        <a class="navbar-brand mr-lg-3" href="<?= $this->base_url(); ?>">
          <span class="font-weight-bolder text-xl"><?= $this->e($data['header']['title']) ?></span>
        </a>

        <div class="sidenav-toggler ml-auto mr-3">
          <img alt="<?= $this->e($data['user']['name']) ?>" style="height: 31.25px; width: 31.25px;" src="<?= $this->base_url(); ?>/assets/img/account/avatar/default.jpg" class="img-fluid rounded-circle border-sm">
          <span class="text-sm text-white ml-lg-2"><?= $this->e(ucwords(trim($data['user']['name']))) ?></span>
        </div>
      </div>
    </nav>
  </header>
<?php endif; ?>