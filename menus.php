<?php foreach ($mymenu as $menuId => $menus) : ?>
    <?php if (isset($menus['submenu'])) : ?>
        <li class="nav-item pcoded-hasmenu">
            <a href="#" class="nav-link"><span class="pcoded-micon"><i class="feather icon-grid"></i></span><span class="pcoded-mtext"><?= ucwords($menus['nama_menu']) ?></span></a>
            <ul class="pcoded-submenu">
                <?php foreach ($menus['submenu'] as $submenu) : ?>
                    <li class=""><a href="?page=<?= $menus['nama_menu'] ?>&sub=<?= $submenu['nama_submenu'] ?>" class=""><?= ucwords($submenu['nama_submenu']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php else : ?>
        <li class="nav-item"><a href="?page=<?= $menus['direktori'] ?>" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext"><?= ucwords($menus['nama_menu']) ?></span></a></li>
    <?php endif; ?>
<?php endforeach; ?>