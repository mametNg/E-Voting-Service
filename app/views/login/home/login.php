<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <div class="main-content">
    <section class="min-vh-100 d-flex align-items-center">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-7 col-lg-6 col-xl-4 mx-auto mr-lg-0">
            <div class="px-4 px-lg-6">
              <div>
                <div class="mb-5 text-center">
                  <h6 class="h3">E-VOTING SERVICE</h6>
                  <p class="text-muted mb-0">Use Your Voting Rights. Choose Candidates Who Can Inspire Students.</p>
                </div>
                <span class="clearfix"></span>
                <div class="form-group">
                  <label for="input-id" class="form-control-label">ID</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="input-id" placeholder="NIPD or NIM">
                  </div>
                  <div class="text-danger small" id="msg-input-id"></div>
                </div>
                <div class="form-group">
                  <label for="input-password" class="form-control-label">Password</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" id="input-password" placeholder="Password">
                  </div>
                  <div class="text-danger small" id="msg-input-password"></div>
                </div>
                <div class="form-group">
                  <label for="input-login-as" class="form-control-label">Login as</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                    </div>
                    <select class="custom-select" id="input-login-as">
                      <option selected disabled>Choose a as</option>
                      <?php foreach ($data['role'] as $class) : ?>
                        <option value="<?= $this->e($class['code']) ?>"><?= $this->e($class['name']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="text-danger small" id="msg-input-login-as"></div>
                </div>
                
                <div class="mt-4">
                  <button type="button" id="login" class="btn btn-block btn-primary">Login</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-img-holder top-0 left-0 col-lg-6 col-xl-8 zindex-100 d-none d-lg-block" data-bg-size="cover" data-bg-position="center">
        <img alt="Image placeholder" src="<?= $this->base_url(); ?>/assets/img/backgrounds/ilustrations/campaign.svg">
      </div>
    </section>
  </div>
<?php endif; ?>