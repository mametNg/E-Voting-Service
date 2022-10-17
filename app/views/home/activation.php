<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <div class="main-content main-cls" main="activation">
    <div class="container h-100vh d-flex align-items-center">
      <div class="col">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5 col-xl-4">
            <div>
              <div class="mb-5 text-center">
                <h6 class="h3">Activation</h6>
                <p class="text-muted mb-0">Enter your activation code below to proceed.</p>
              </div>
              <span class="clearfix"></span>
              <form role="form" method="POST" action="" >
                <div class="form-group">
                  <label class="form-control-label">Code</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="text" name="code" class="form-control" id="input-code" placeholder="123456" required="">
                  </div>
                  <div class="text-danger small" id="msg-input-code"><?= $this->e($data['status']) ?></div>
                </div>

                <div class="mt-4">
                  <button id="submit-code" type="button" class="btn btn-block btn-primary">Activation</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>