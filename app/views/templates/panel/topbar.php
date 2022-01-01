<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <!-- Nav -->
  <header class="header fixed-top border-bottom">
    <!-- Nav -->
    <nav id="navbar-main" class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <!-- Brand logo -->
        <a class="navbar-brand mr-lg-3" href="<?= $this->base_url(); ?>/panel">
          <i class="fas fa-fw fa-code Image placeholder fa-2x py-1"></i>
          <span class="font-weight-bolder text-xl ml-2">PANEL</span>
        </a>
        <!-- Sidenav toggler -->
        <button class="sidenav-toggler ml-auto mr-3" type="button" data-action="sidenav-pin" data-target="#sidenav-main">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </button>
        
        <!-- Navbar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown mr-0 d-flex">
              <a class="nav-link active" href="#" id="dropdown_user_account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img alt="<?= $this->e($data['user']['name']) ?>" style="height: 31.25px; width: 31.25px;" src="<?= $this->base_url(); ?>/assets/img/account/avatar/<?= $this->e($data['user']['avatar']) ?>" class="avatar avatar-sm rounded-circle border-sm">
                <span class="text-sm"><?= $this->e(ucwords(trim($data['user']['name']))) ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_user_account">
                <h6 class="dropdown-header">User menu</h6>
                <a class="dropdown-item" href="#">
                  <span class="float-right badge badge-primary">4</span>
                  <i class="fas fa-envelope text-primary"></i>Messages
                </a>
                <a class="dropdown-item" href="<?= $this->base_url(); ?>/panel/account">
                  <i class="fas fa-cog text-primary"></i>Settings
                </a>
                <div class="dropdown-divider" role="presentation"></div>
                <a class="dropdown-item" href="<?= $this->base_url(); ?>/panel/logout">
                  <i class="fas fa-sign-out-alt text-primary"></i>Log out
                </a>
              </div>
            </li>
          </ul>

        </div>
      </div>
    </nav>
  </header>
<?php endif; ?>