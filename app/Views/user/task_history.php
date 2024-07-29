<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
    <div class="profile-feed">
        <div class="d-flex align-items-start profile-feed-item">
            <img src="<?= base_url() ?>vendors/images/faces/face13.jpg" alt="profile" class="img-sm rounded-circle"/>
            <div class="ml-4">
                <h6>
                    Mason Beck
                    <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                </h6>
                <p>
                    There is no better advertisement campaign that is low cost and also successful at the same time.
                </p>
                <p class="small text-muted mt-2 mb-0">
                              <span>
                                <i class="fa fa-star mr-1"></i>4
                              </span>
                    <span class="ml-2">
                                <i class="fa fa-comment mr-1"></i>11
                              </span>
                    <span class="ml-2">
                                <i class="fa fa-mail-reply"></i>
                              </span>
                </p>
            </div>
        </div>
        <div class="d-flex align-items-start profile-feed-item">
            <img src="<?= base_url() ?>vendors/images/faces/face16.jpg" alt="profile" class="img-sm rounded-circle"/>
            <div class="ml-4">
                <h6>
                    Willie Stanley
                    <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                </h6>
                <img src="<?= base_url() ?>vendors/images/samples/1280x768/12.jpg" alt="sample" class="rounded mw-100"/>
                <p class="small text-muted mt-2 mb-0">
                              <span>
                                <i class="fa fa-star mr-1"></i>4
                              </span>
                    <span class="ml-2">
                                <i class="fa fa-comment mr-1"></i>11
                              </span>
                    <span class="ml-2">
                                <i class="fa fa-mail-reply"></i>
                              </span>
                </p>
            </div>
        </div>
        <div class="d-flex align-items-start profile-feed-item">
            <img src="<?= base_url() ?>vendors/images/faces/face19.html" alt="profile" class="img-sm rounded-circle"/>
            <div class="ml-4">
                <h6>
                    Dylan Silva
                    <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                </h6>
                <p>
                    When I first got into the online advertising business, I was looking for the magical combination
                    that would put my website into the top search engine rankings
                </p>
                <img src="<?= base_url() ?>vendors/images/samples/1280x768/5.jpg" alt="sample" class="rounded mw-100"/>
                <p class="small text-muted mt-2 mb-0">
                    <span>
                        <i class="fa fa-star mr-1"></i>4
                    </span>
                    <span class="ml-2">
                        <i class="fa fa-comment mr-1"></i>11
                    </span>
                    <span class="ml-2">
                        <i class="fa fa-mail-reply"></i>
                    </span>
                </p>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
