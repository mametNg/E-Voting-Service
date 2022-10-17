<?php if (isset($this->allowFile) && $this->allowFile): ?>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-section-secondary" id="sidenav-main">
    <div class="px-3 scrollbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Navigation -->
        <ul class="navbar-nav navbar-nav-docs">
          <li class="nav-item">
            <a class="nav-link<?= ($this->e($data['active']) == "account") ? " active":"" ?>" href="<?= $this->base_url(); ?>/panel/account">
              <i class="fas fa-fw fa-user"></i>Account
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= ($this->e($data['active']) == "websetting") ? " active":"" ?>" href="<?= $this->base_url(); ?>/panel/websetting">
              <i class="fas fa-fw fa-browser"></i>Web Setting
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= ($this->e($data['active']) == "usermanagement") ? " active":"" ?>" href="#navbar-user-management" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-user-management">
              <i class="fas fa-fw fa-users"></i>User Management
            </a>
            <div class="collapse" id="navbar-user-management">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="<?= $this->base_url(); ?>/panel/usermanagement/role" class="nav-link">Role</a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->base_url(); ?>/panel/usermanagement/since" class="nav-link">Since</a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->base_url(); ?>/panel/usermanagement/major" class="nav-link">Major</a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->base_url(); ?>/panel/usermanagement/class" class="nav-link">Class</a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->base_url(); ?>/panel/usermanagement/users" class="nav-link">Users</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= ($this->e($data['active']) == "report") ? " active":"" ?>" href="<?= $this->base_url(); ?>/panel/report">
              <i class="fas fa-fw fa-table"></i>Report
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= ($this->e($data['active']) == "campaign") ? " active":"" ?>" href="<?= $this->base_url(); ?>/panel/campaign">
              <i class="fas fa-fw fa-vote-yea"></i>Campaign
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= ($this->e($data['active']) == "stats") ? " active":"" ?>" href="<?= $this->base_url(); ?>/panel/stats">
              <i class="fas fa-fw fa-analytics"></i>Campaign Stats
            </a>
          </li>
          <li class="nav-item d-lg-none">
            <a class="nav-link" href="<?= $this->base_url(); ?>/panel/logout">
              <i class="fas fa-fw fa-sign-out-alt"></i>Log out
            </a>
          </li>
        </ul>
        <!-- <h6 class="navbar-heading text-muted mt-4">Resources</h6>
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="<?= $this->base_url(); ?>/docs/support.html">
              <i class="fas fa-question-circle"></i>Support
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://getbootstrap.com" target="_blank">
              <i class="fab fa-twitter"></i>Bootstrap
            </a>
          </li>
        </ul> -->
      </div>
    </div>
  </nav>
<?php endif; ?>