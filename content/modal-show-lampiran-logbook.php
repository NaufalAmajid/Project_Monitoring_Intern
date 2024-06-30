<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Lampiran Logbook
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <?php
                $lampirans = explode('#', $_POST['lampiran']);
                ?>
                <?php foreach ($lampirans as $lampiran) : ?>
                    <div class="col-lg-3 mb-3">
                        <a href="lampiran/logbook/<?= $lampiran ?>" target="_blank">
                            <img src="lampiran/logbook/<?= $lampiran ?>" class="img-thumbnail" alt="lampiran" style="width: 100%; height: 100px;">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>