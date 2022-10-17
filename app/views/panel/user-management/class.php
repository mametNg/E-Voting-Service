<?php if (isset($this->allowFile) && $this->allowFile): ?>


  <!-- Main content -->
  <div class="main-content main-cls" main="usermanagement-class">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        
        <div class="row justify-content-between">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Class Management</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto"  data-toggle="modal" data-target="#modal-add-class">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Class">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Add Class</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>Class Name</th>
                        <th>Major</th>
                        <th>Role</th>
                        <th>Since</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>Class Name</th>
                        <th>Major</th>
                        <th>Role</th>
                        <th>Since</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['class'] as $class) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center" id="code-<?= $this->e(strtolower($class['class_code'])) ?>">
                            <?= $this->e($class['class_code']) ?>
                          </td>
                          <td class="text-wrap align-middle" id="class-<?= $this->e(strtolower($class['class_code'])) ?>">
                            <?= $this->e($class['class']) ?>
                          </td>
                          <td class="text-wrap align-middle" id="major-<?= $this->e(strtolower($class['class_code'])) ?>">
                            <?= $this->e($class['major']) ?>
                          </td>
                          <td class="text-wrap align-middle" id="role-<?= $this->e(strtolower($class['class_code'])) ?>">
                            <?= $this->e($class['role']) ?>
                          </td>
                          <td class="text-wrap align-middle" id="since-<?= $this->e(strtolower($class['class_code'])) ?>">
                            <?= $this->e($class['since']) ?>
                          </td>
                          <td class="text-wrap align-middle d-flex justify-content-center">
                            <div class="m-1">
                              <a href="#" id="edit-class" data-class="<?= $this->e(strtolower($class['class_code'])) ?>" data-toggle="modal" data-target="#modal-change-class" class="badge badge-success">
                                <i class="fas fa-fw fa-edit mr-2"></i>Change
                              </a>
                            </div>
                            <div class="m-1">
                              <a href="#" id="delete-class" data-class="<?= $this->e(strtolower($class['class_code'])) ?>" data-toggle="modal" data-target="#modal-delete-class" class="badge badge-danger">
                                <i class="fas fa-fw fa-trash mr-2"></i>Delete
                              </a>
                            </div>
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

  <!-- Modal Add New Class -->
  <div class="modal fade ml-4" id="modal-add-class" tabindex="-1" role="dialog" aria-labelledby="modal-add-class" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-users-class"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Add new Class</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="new-class-name" class="form-control-label">Class name</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                </div>
                <input type="text" class="form-control" id="new-class-name" placeholder="Class name">
              </div>
              <div class="text-danger small" id="msg-new-class-name"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="new-class-major" class="form-control-label">Major</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                </div>
                <select class="custom-select" id="new-class-major">
                  <option selected disabled>Choose a major</option>
                  <?php foreach ($data['major'] as $major) : ?>
                    <option value="<?= $this->e($major['code']) ?>"><?= $this->e($major['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-new-class-major"></div>
            </div>
          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="new-class-role" class="form-control-label">Role</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                </div>
                <select class="custom-select" id="new-class-role">
                  <option selected disabled>Choose a role</option>
                  <?php foreach ($data['role'] as $role) : ?>
                    <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-new-class-role"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="new-class-since" class="form-control-label">Since</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                </div>
                <select class="custom-select" id="new-class-since">
                  <option selected disabled>Choose a since</option>
                  <?php foreach ($data['since'] as $since) : ?>
                    <option value="<?= $this->e($since['code']) ?>"><?= $this->e($since['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-new-class-since"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="add-new-class">Add new class</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Change Class -->
  <div class="modal fade ml-4" id="modal-change-class" tabindex="-1" role="dialog" aria-labelledby="modal-change-class" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-users-class"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Change Class</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="change-class-name" class="form-control-label">Class name</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                </div>
                <input type="text" class="form-control" id="change-class-name" placeholder="Class name">
              </div>
              <div class="text-danger small" id="msg-change-class-name"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="change-class-major" class="form-control-label">Major</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                </div>
                <select class="custom-select" id="change-class-major">
                  <option selected disabled>Choose a major</option>
                  <?php foreach ($data['major'] as $major) : ?>
                    <option value="<?= $this->e($major['code']) ?>"><?= $this->e($major['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-change-class-major"></div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="change-class-role" class="form-control-label">Role</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                </div>
                <select class="custom-select" id="change-class-role">
                  <option selected disabled>Choose a role</option>
                  <?php foreach ($data['role'] as $role) : ?>
                    <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-change-class-role"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="change-class-since" class="form-control-label">Since</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                </div>
                <select class="custom-select" id="change-class-since">
                  <option selected disabled>Choose a since</option>
                  <?php foreach ($data['since'] as $since) : ?>
                    <option value="<?= $this->e($since['code']) ?>"><?= $this->e($since['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-change-class-since"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-code="" id="save-change-class">Save change class</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete Class -->
  <div class="modal modal-secondary fade" id="modal-delete-class" tabindex="-1" role="dialog" aria-labelledby="modal-delete-class" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to delete it now!</h5>
            <p class="text-sm text-sm">data class <span class="class-name-delete font-weight-bolder"></span> will be deleted.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="save-delete-class" data-class="" class="btn btn-danger">Delete Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>