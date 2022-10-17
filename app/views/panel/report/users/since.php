<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <!-- Main content -->
  <div class="main-content main-cls" main="report-roles">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">

        <div class="row justify-content-between">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Since Management</h5>
                <div class="ml-auto d-flex">
                  <!-- <form method="post" class="m-1">
                    <button type="submit" class="btn btn-sm btn-primary btn-icon-label" name="export" value="pdf">
                      <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add User">
                        <i class="fas fa-save"></i>
                      </span>
                      <span class="btn-inner--text d-none d-lg-block">Export to PDF</span>
                    </button>
                  </form> -->
                  <form method="post" class="m-1">
                    <button type="submit" class="btn btn-sm btn-primary btn-icon-label" name="export" value="excel">
                      <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add User">
                        <i class="fas fa-save"></i>
                      </span>
                      <span class="btn-inner--text d-none d-lg-block">Export to Excel</span>
                    </button>
                  </form>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr class="text-center font-weight-bolder">
                        <th>NIM</th>
                        <th>Name</th>
                        <th>CLASS</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr class="text-center font-weight-bolder">
                        <th>NIM</th>
                        <th>Name</th>
                        <th>CLASS</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['users'] as $role) : ?>
                        <tr>
                          <td id="nim-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle text-center">
                            <?= $this->e($role['nim']) ?>
                          </td>
                          <td id="name-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle">
                            <?= $this->e($role['name']) ?>
                          </td>
                          <td id="class-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle">
                            <?= $this->e($role['class']) ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

<?php endif; ?>