<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <div class="main-content main-cls" main="login">
    <div class="container h-100vh d-flex align-items-center">
      <div class="col">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5 col-xl-4">
            <div>
              <div class="mb-3 text-center">
                <h6 class="h3">Login</h6>
                <p class="text-muted mb-0">Welcome To Panel Dashboard.</p>
                <div id="msg-login"></div>
              </div>
              <span class="clearfix"></span>
              <form role="form">
                <div class="form-group">
                  <label class="form-control-label">Email address</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="email" class="form-control" id="input-email" placeholder="name@example.com" required="" value="<?= $data['user'] ?>">
                  </div>
                  <div class="text-danger" id="msg-input-email"></div>
                </div>
                <div class="form-group mb-4">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <label class="form-control-label">Password</label>
                    </div>
                  </div>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" id="input-password" placeholder="Password" required="">
                    <div class="input-group-append">
                      <span class="input-group-text" id="show-input-password">
                        <i class="fas fa-eye"></i>
                      </span>
                    </div>
                  </div>
                  <div class="text-danger" id="msg-input-password"></div>
                </div>
                <div class="mt-4">
                  <button type="button" id="login" class="btn btn-block btn-primary">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>