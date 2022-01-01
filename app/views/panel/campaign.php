<?php if (isset($this->allowFile) && $this->allowFile): ?>


  <!-- Main content -->
  <div class="main-content main-cls" main="campaign">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">

        <!-- Data Tables Campaign -->
        <div class="row justify-content-between" id="page-candidate">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Campaigns Management</h5>
                <button id="open-new-candidate" type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Candidate">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Add Candidate</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">

                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>Number</th>
                        <th>Name</th>
                        <th>Campaign</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <th>Number</th>
                        <th>Name</th>
                        <th>Campaign</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['candidate'] as $candidate) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center" id="number-<?= $this->e(strtolower($candidate['candidate_code'])) ?>">
                            <?= $this->e($candidate['number']) ?>
                          </td>
                          <td>
                            <div class="media align-items-center">
                              <div>
                                <img id="avatar-<?= $this->e(strtolower($candidate['candidate_code'])) ?>" alt="Image placeholder" src="<?= $this->base_url() ?>/assets/img/candidate/thumbnail/<?= $this->e($candidate['image']) ?>" class="avatar  rounded-circle">
                              </div>
                              <div class="media-body ml-4">
                                <span class="name mb-0 text-sm" id="name-<?= $this->e(strtolower($candidate['candidate_code'])) ?>"><?= $this->e($candidate['name']) ?></span>
                              </div>
                            </div>
                          </td>
                          <td class="text-wrap align-middle" id="as-<?= $this->e(strtolower($candidate['candidate_code'])) ?>">
                            <?= $this->e($candidate['role']) ?>
                          </td>
                          <td class="text-wrap align-middle">
                            <div class="d-flex justify-content-center">

                              <div class="m-1">
                                <a href="#" id="open-edit-candidate" data-candidate="<?= $this->e(strtolower($candidate['candidate_code'])) ?>" data-toggle="collapse" class="badge badge-success">
                                  <i class="fas fa-fw fa-edit mr-2"></i>Change
                                </a>
                              </div>

                              <div class="m-1">
                                <a href="#" id="open-delete-candidate" data-candidate="<?= $this->e(strtolower($candidate['candidate_code'])) ?>" data-toggle="modal" data-target="#modal-delete-candidate" class="badge badge-danger">
                                  <i class="fas fa-fw fa-trash mr-2"></i>Delete
                                </a>
                              </div>

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

        <!-- Add New Candidate -->
        <div class="row justify-content-between d-none" id="page-new-candidate">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Add New Candidate</h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="new-candidate-number">Candidate number</label>
                  <select class="custom-select" id="new-candidate-number">
                    <option selected disabled>Choose a candidate number</option>
                    <?php foreach ($data['number_candidate'] as $number_candidate) : ?>
                      <option value="<?= $this->e($number_candidate['code']) ?>"><?= $this->e($number_candidate['number']) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback" id="msg-new-candidate-number"></div>
                </div>
                <div class="form-group">
                  <label for="new-candidate-name">Full name</label>
                  <input class="form-control" type="text" id="new-candidate-name" placeholder="Full name">
                  <div class="invalid-feedback" id="msg-new-candidate-name"></div>
                </div>
                <div class="form-group">
                  <label for="as-new-candidate">As candidate</label>
                  <select class="custom-select" id="as-new-candidate">
                    <option selected disabled>Choose a as candidate</option>
                    <?php foreach ($data['role_candidate'] as $role_candidate) : ?>
                      <option value="<?= $this->e($role_candidate['code']) ?>"><?= $this->e($role_candidate['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback" id="msg-as-new-candidate"></div>
                </div>

                <div class="form-row mb-2 align-items-center">
                  <div class="form-group col-4 col-lg-2">
                    <img id="new-img-thumbnail" src="<?= $this->base_url() ?>/assets/img/candidate/thumbnail/default.jpg" class="img-thumbnail"> 
                  </div>

                  <div class="form-group col-8 col-lg-10 pl-lg-4">
                    <label>Image</label>
                    <input type="file" accept="image/*" id="new-choose-image" data-choose="new" class="custom-input-file custom-input-file--2">
                    <label for="new-choose-image">
                      <i class="fa fa-upload"></i>
                      <span class="new-file-name">Choose a image</span>
                    </label>
                    <div class="invalid-feedback" id="msg-new-choose-image"></div>
                  </div>
                </div>

                <div class="form-group">
                  <button class="btn btn-primary btn-block" id="add-new-candidate">Add new candidate</button>
                  <button class="btn btn-secondary btn-block" id="close-new-candidate">Cancel</button>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- Chage Candidate -->
        <div class="row justify-content-between d-none" id="page-change-candidate">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Change Candidate</h5>
              </div>
              <div class="card-body">
                <div id="candidate-code" data-code=""></div>
                <div class="form-group">
                  <label for="change-candidate-number">Candidate number</label>
                  <select class="custom-select" id="change-candidate-number">
                    <option selected disabled>Choose a candidate number</option>
                    <?php foreach ($data['number_candidate'] as $number_candidate) : ?>
                      <option value="<?= $this->e($number_candidate['code']) ?>"><?= $this->e($number_candidate['number']) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback" id="msg-change-candidate-number"></div>
                </div>
                <div class="form-group">
                  <label for="change-candidate-name">Full name</label>
                  <input class="form-control" type="text" id="change-candidate-name" placeholder="Full name">
                  <div class="invalid-feedback" id="msg-change-candidate-name"></div>
                </div>
                <div class="form-group">
                  <label for="change-as-candidate">As candidate</label>
                  <select class="custom-select" id="change-as-candidate">
                    <option selected disabled>Choose a as candidate</option>
                    <?php foreach ($data['role_candidate'] as $role_candidate) : ?>
                      <option value="<?= $this->e($role_candidate['code']) ?>"><?= $this->e($role_candidate['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback" id="msg-change-as-candidate"></div>
                </div>

                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="turn-image">
                    <label class="custom-control-label" for="turn-image" id="label-turn-image">Enable change image</label>
                  </div>
                </div>

                <div class="form-row mb-2 align-items-center">
                  <div class="form-group col-4 col-lg-2">
                    <img id="change-img-thumbnail" src="<?= $this->base_url() ?>/assets/img/candidate/thumbnail/default.jpg" class="img-thumbnail"> 
                  </div>

                  <div class="form-group col-8 col-lg-10 pl-lg-4">
                    <label>Image</label>
                    <input type="file" accept="image/*" id="change-choose-image" data-choose="change" class="custom-input-file" disabled>
                    <label for="change-choose-image">
                      <i class="fa fa-upload"></i>
                      <span class="change-file-name">Choose a image</span>
                    </label>
                    <div class="invalid-feedback" id="msg-change-choose-image"></div>
                  </div>
                </div>

                <div class="form-group">
                  <button class="btn btn-primary btn-block" id="save-change-candidate">Change candidate</button>
                  <button class="btn btn-secondary btn-block" id="close-change-candidate">Cancel</button>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal Delete Candidate -->
  <div class="modal modal-secondary fade" id="modal-delete-candidate" tabindex="-1" role="dialog" aria-labelledby="modal-delete-candidate" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <div id="candidate-delete" data-code=""></div>
            <h5 class="mt-4">Are you sure you want to delete it now!</h5>
            <p class="text-sm text-sm">Candidate <span class="candidate-delete font-weight-bolder"></span> data will be deleted.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="save-delete-candidate" data-role class="btn btn-danger">Delete Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Crop Image-->
  <div class="modal fade" id="modal-crop-image" tabindex="-1" aria-labelledby="cropImage" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">

          <div class="modal-title d-flex align-items-center" id="cropImage">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-award"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Crop image</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body p-2">

          <div class="card m-0 p-0 border-0">
            <img id="image-cropper" src="assets/img/account/avatar/default.jpg" class="card-img">

            <div class="card-img-overlay p-0 m-0 pointer-none">
              <div class="d-flex justify-content-between absolute-bottom z-1 pointer-none">
                <button id="rotate-l" type="button" class="btn btn-primary pointer-stroke">
                  <i class="fas fa-fw fa-undo-alt"></i>
                </button>

                <button id="scale-l-r" data-scale="true" type="button" class="btn btn-primary pointer-stroke">
                  <i class="fas fa-fw fa-arrows-alt-h"></i>
                </button>

                <button id="rotate-r" type="button" class="btn btn-primary pointer-stroke">
                  <i class="fas fa-fw fa-redo-alt"></i>
                </button>
              </div>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="crop-image" class="btn btn-primary">Crop</button>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>