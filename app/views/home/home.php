<?php if (isset($this->allowFile) && $this->allowFile): ?>

	<div class="main-content main-cls" main="home-vote">
    <section class="min-vh-100 d-flex align-items-center bg-section-light">
      <div class="container-fluid">

        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="text-center">
              <h1 class="font-weight-bolder"><?= $this->e($data['header']['title']) ?></h1>
              <p><?= $this->e($data['header']['desc']) ?></p>
            </div>

            <div class="row justify-content-center row-cols-1 row-cols-md-3 g-4 mt-5">

              <?php foreach ($data['candidate'] as $candidateKeys => $candidate) : ?>
                <div class="col-lg-3">
                  <div class="card card-overlay card-hover-overlay shadow text-white border-0">

                    <div class="d-flex border">
                      <?php foreach ($candidate as $detailsCandidate) : ?>
                        <?php if (count($candidate) == 2) : ?>
                          <div>
                            <img src="<?= $this->base_url(); ?>/assets/img/candidate/original/<?= $this->e($detailsCandidate['image']); ?>" class="boder-0 rounded img-content" alt="...">
                          </div>
                        <?php else : ?>
                          <img src="<?= $this->base_url(); ?>/assets/img/candidate/thumbnail/<?= $this->e($detailsCandidate['image']); ?>" class="boder-0 rounded img-content" alt="...">
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>

                    <div class="card-img-overlay-2">

                      <div class="m-2 ">
                        <button type="button" class="btn btn-dark btn-sm float-right p-2 border-0">
                          <span>Candidate number</span>

                          <span class="badge badge-primary">
                            <?= $this->e($candidateKeys); ?>
                          </span>
                        </button>
                      </div>
                    </div>

                    <div class="card-img-overlay d-flex flex-column align-items-center p-0" type="button" id="open-modal-vote" data-candidate="<?= $this->e($candidate[0]['code']) ?>" data-key="<?= $this->e($candidateKeys); ?>" data-toggle="modal" data-target="#modal-vote-candidate">
                      <div class="overlay-text w-75 mt-auto">
                        <div class="row mt-10 pt-5">
                          <?php foreach ($candidate as $detailsCandidate) : ?>
                            <?php if (count($candidate) == 2) : ?>
                              <div class="col-6">
                                <span class="link link-underline-white font-weight-bold"><?= $this->e($detailsCandidate['name']) ?></span>
                                <p class="lead text-sm mt-2"><?= $this->e($detailsCandidate['role']) ?></p>
                              </div>
                            <?php else : ?>
                              <div class="col-lg-12">
                                <span class="link link-underline-white font-weight-bold"><?= $this->e($detailsCandidate['name']) ?></span>
                                <p class="lead text-sm mt-2"><?= $this->e($detailsCandidate['role']) ?></p>
                              </div>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </div>
                      </div>
                      <div class="overlay-actions w-100 card-footer mt-auto">
                        <div class="text-center">
                          <span class="h6 mb-0">Vote as candidate</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- Modal Vote Candidate -->
  <div class="modal modal-secondary fade" id="modal-vote-candidate" tabindex="-1" role="dialog" aria-labelledby="modal-vote-candidate" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-warning">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <div id="candidate-vote" data-code=""></div>
            <h5 class="mt-4">Are you sure</h5>
            <p class="text-sm text-sm">You will vote candidate number  <span class="candidate-numb font-weight-bolder">132</span>.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="save-vote-candidate" data-cadidate="" class="btn btn-warning">Vote Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal user -->
  <div class="modal modal-success fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="modal_success" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="py-3 text-center">
            <i class="fas fa-user-headset fa-4x"></i>
            <h5 class="heading h4 mt-4">Welcome to E-VOTING SERVICE</h5>
            <p class="text-sm fw-lighter">Hi <span class="fw-bold"><?= $this->e(ucwords($data['user']['name'])) ?></span>, LAYANAN E-VOTING adalah sistem pemungutan suara digital yang dilakukan secara online.</p>
            <p class="text-sm fw-lighter fst-italic">Hi <span class="fw-bold"><?= $this->e(ucwords($data['user']['name'])) ?></span>, E-VOTING SERVICE is a digital voting system conducted online.</p>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Next</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Rules -->
  <div class="modal modal-secondary fade" id="modal-rules" tabindex="-1" role="dialog" aria-labelledby="modal-rules" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-warning">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Rules</h5>
            <p class="text-sm fw-lighter">Gunakan Hak Suara Anda. Pilih Kandidat yang Bisa Menginspirasi Siswa.</p>
            <p class="text-sm fw-lighter fst-italic">Use Your Voting Rights. Choose Candidates Who Can Inspire Students.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Let's get started</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php endif; ?>