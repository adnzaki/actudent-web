<div class="pdf-header">
    <div class="logo-bekasi">
        <?php if(ENVIRONMENT === 'development'): ?>
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/actudent/public/images/<?= $logoOPD ?>" alt="">
        <?php elseif(ENVIRONMENT === 'production'): ?>
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/public/images/<?= $logoOPD ?>" alt="">
        <?php endif; ?>
    </div>
    <div class="kop-header">
        <div class="center-align kop-pemkot"><?= $namaOPD ?></div>
        <div class="center-align kop-disdik"><?= $subOPD ?></div>
        <div class="center-align kop-sekolah"><?= $namaSekolah ?></div>
        <div class="center-align kop-alamat"><i>
            <?= $alamatSekolah ?>, <?= $lokasiSekolah ?>, Telp. <?= $telpSekolah ?><br/>
            Website: <?= $webSekolah ?>, Email: <?= $emailSekolah ?></i><br>
        </div>
    </div>
    <div class="logo-sekolah">
        <?php if(ENVIRONMENT === 'development'): ?>
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/actudent/public/images/<?= $logoSekolah ?>" alt="">
        <?php elseif(ENVIRONMENT === 'production'): ?>
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/public/images/<?= $logoSekolah ?>" alt="">
        <?php endif; ?>
    </div>
    <div class="kop-garis-tebal"></div><div class="kop-garis-tipis">.</div>
</div>
