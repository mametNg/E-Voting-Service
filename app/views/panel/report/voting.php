<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <!-- Main content -->
  <div class="main-content main-cls" main="stats">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">

        <div class="row ">

          <div class="col-lg-4">
            <div class="card card-stats bg-primary">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= ($data['vote']['vote']['total']) ?></span>
                    <span class="text-white">Vote</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-vote-yea"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card card-stats bg-warning">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= ($data['vote']['notvote']['total']) ?></span>
                    <span class="text-white">Not Vote</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-vote-nay"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card card-stats bg-info">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= ($data['vote']['must']['total']) ?></span>
                    <span class="text-white">Must Vote</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-box-ballot"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row ">
          <div class="col-lg-9">
            <div class="row ">
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex">
                    <h5 class="pt-2">Quic Count</h5>
                    <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto" data-toggle="modal" data-target="#modal-reset-votes">
                      <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Vote">
                        <i class="fas fa-sync-alt"></i>
                      </span>
                      <span class="btn-inner--text d-none d-lg-block">Reset Vote</span>
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="chart-bar">
                      <canvas id="myBarChart"></canvas>
                    </div>
                    <?php foreach ($data['voting'] as $voting => $votingDetails) : ?>
                      <div class="d-none" id="chart-name">Candidate Number <?= $this->e($votingDetails['number']) ?></div>
                      <div class="d-none" data-candidate="<?= $this->e($voting) ?>" id="chart-votes"><?= $this->e($votingDetails['votes']) ?></div>
                    <?php endforeach ; ?>
                    <div class="d-none" id="chart-total"><?= $this->e($data['total_user']['total']) ?></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row ">
              <?php foreach ($data["candidate"] as $candidateKey => $candidate) : ?>
                <div class="col-lg">

                  <div class="card card-stats bg-dark">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <span class="d-block h5 text-white mr-2 mb-1" id="chart-votes" data-candidate="<?= $this->e($candidateKey) ?>">0</span>
                          <?php $name = ""; foreach ($candidate as $userKey => $user) $name .= (count($candidate) == 2 ? $user['name']. " & ": $user['name']); ?>
                          <span class="text-white text-sm"><?= $this->e($name, '& ') ?></span>
                        </div>
                        <div>
                          <div class="text-white">
                            <div class="avatar-parent-child">
                              <a href="#" class="avatar avatar-md rounded-circle">
                                <img alt="Image placeholder" src="<?= $this->base_url() ?>/assets/img/candidate/thumbnail/<?= $this->e($candidate[0]['image']) ?>">
                              </a>

                              <span class="avatar-child bg-success text-center"><span class="absolute-center text-xs"><?= $this->e($candidate[0]['number']) ?></span></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card card-stats bg-gradient-info" type="button" data-toggle="modal" data-target="#modal-class">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['class']) ?></span>
                    <span class="text-white">Class</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-user-tag"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-stats bg-gradient-primary" type="button" data-toggle="modal" data-target="#modal-role">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['role']) ?></span>
                    <span class="text-white">Roles</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-portrait"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-stats bg-gradient-success" type="button" data-toggle="modal" data-target="#modal-since">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['since']) ?></span>
                    <span class="text-white">Sinces</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-calendar-alt"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- Modal Reset Vote -->
  <div class="modal modal-secondary fade" id="modal-reset-votes" tabindex="-1" role="dialog" aria-labelledby="modal-reset-votes" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to reset votes!</h5>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="reset-votes" data-class="" class="btn btn-danger">Reset Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Since -->
  <div class="modal fade ml-4" id="modal-since" tabindex="-1" role="dialog" aria-labelledby="modal-since" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Since Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-since">
                <option selected disabled>Choose a since</option>
                <?php foreach ($data['since'] as $since) : ?>
                  <option value="<?= $this->e($since['code']) ?>"><?= $this->e($since['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-since"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal class -->
  <div class="modal fade ml-4" id="modal-class" tabindex="-1" role="dialog" aria-labelledby="modal-class" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Class Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-class">
                <option selected disabled>Choose a class</option>
                <?php foreach ($data['class'] as $class) : ?>
                  <option value="<?= $this->e($class['code']) ?>"><?= $this->e($class['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-class"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal roles -->
  <div class="modal fade ml-4" id="modal-role" tabindex="-1" role="dialog" aria-labelledby="modal-role" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Role Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-role">
                <option selected disabled>Choose a role</option>
                <?php foreach ($data['role'] as $role) : ?>
                  <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-role"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Report -->
  <div class="modal fade ml-4" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="modal-report" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Role Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-role">
                <option selected disabled>Choose a role</option>
                <?php foreach ($data['role'] as $role) : ?>
                  <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-role"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>