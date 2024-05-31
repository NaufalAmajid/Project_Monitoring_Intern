<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Laporan & Riwayat Absensi Siswa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="?page=riwayat&sub=absensi">Laporan & Riwayat Absensi</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<div class="row mb-4">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <li><a class="nav-link text-start active" id="v-pills-home-tab" data-bs-toggle="pill" href="#today">Hari Ini <?= $func->dateIndonesia(date('Y-m-d')) ?></a></li>
                    <li><a class="nav-link text-start" id="v-pills-profile-tab" data-bs-toggle="pill" href="#unverified">Belum Diverifikasi</a>
                    </li>
                    <li><a class="nav-link text-start" id="v-pills-messages-tab" data-bs-toggle="pill" href="#all">Semua</a>
                    </li>
                    <li><a class="nav-link text-start" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="today">
                        <p class="mb-0">Cillum ad ut irure tempor velit nostrud occaecat ullamco
                            aliqua anim Lorem sint. Veniam sint duis incididunt do esse magna
                            mollit excepteur laborum qui. Id id reprehenderit sit est
                            eu aliqua
                            occaecat quis et velit excepteur laborum mollit dolore eiusmod.
                            Ipsum dolor in occaecat commodo et voluptate minim reprehenderit
                            mollit pariatur. Deserunt non laborum enim et cillum eu deserunt
                            excepteur ea incididunt minim occaecat.</p>
                    </div>
                    <div class="tab-pane fade" id="unverified">
                        <p class="mb-0">Culpa dolor voluptate do laboris laboris irure
                            reprehenderit id incididunt duis pariatur mollit aute magna pariatur
                            consectetur. Eu veniam duis non ut dolor deserunt commodo et
                            minim in quis
                            laboris ipsum velit id veniam. Quis ut consectetur adipisicing
                            officia excepteur non sit. Ut et elit aliquip labore Lorem enim eu.
                            Ullamco mollit occaecat dolore ipsum id officia mollit qui
                            esse anim eiusmod do sint minim consectetur qui.</p>
                    </div>
                    <div class="tab-pane fade" id="all">
                        <p class="mb-0">Fugiat id quis dolor culpa eiusmod anim velit excepteur
                            proident dolor aute qui magna. Ad proident laboris ullamco esse anim
                            Lorem Lorem veniam quis Lorem irure occaecat velit
                            nostrud magna
                            nulla. Velit et et proident Lorem do ea tempor officia dolor.
                            Reprehenderit Lorem aliquip labore est magna commodo est ea veniam
                            consectetur.</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <p class="mb-0">Eu dolore ea ullamco dolore Lorem id cupidatat excepteur
                            reprehenderit consectetur elit id dolor proident in cupidatat
                            officia. Voluptate excepteur commodo labore nisi cillum duis
                            aliqua do.
                            Aliqua amet qui mollit consectetur nulla mollit velit aliqua veniam
                            nisi id do Lorem deserunt amet. Culpa ullamco sit adipisicing labore
                            officia magna elit nisi in aute tempor commodo eiusmod.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>