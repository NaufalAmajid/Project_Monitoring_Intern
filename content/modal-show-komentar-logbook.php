<?php
require_once '../classes/Logbook.php';
$logbook_id = $_POST['logbook_id'];
$komentar = $logbook->getLogbookById($logbook_id)['komentar'];
?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Komentar Logbook
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <form id="form-komentar">
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3"><?= $komentar ?></textarea>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveKomentar('<?= $_POST['logbook_id'] ?>')">Simpan</button>
        </div>
    </div>
</div>
<script>
    function saveKomentar(logbook_id) {
        var komentar = $('#komentar').val();
        $.ajax({
            url: 'classes/Logbook.php',
            type: 'POST',
            data: {
                logbook_id: logbook_id,
                komentar: komentar,
                action: 'saveKomentar'
            },
            success: function(response) {
                let res = JSON.parse(response);
                swal({
                    title: res.title,
                    text: res.message,
                    icon: res.status,
                    button: false,
                    timer: 2000
                })
            }
        });
    }
</script>