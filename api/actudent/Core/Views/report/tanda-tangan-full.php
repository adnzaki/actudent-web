<table class="no-border">
    <tbody>
        <tr>
            <td class="center-align no-border">
                Mengetahui, <br>Kepala Sekolah
                <p class="mt-80">
                    <strong><?= $kepalaSekolah ?></strong>
                    <br><br><br>NIP. <?= $nipKepsek ?>
                </p>
                
            </td>
            <td class="center-align no-border">
                <br>Waka. Bidang Kurikulum
                <p class="mt-80">
                    <strong><?= $wakaKurikulum ?></strong>
                    <br><br><br>NIP. <?= $nipWakasek ?>
                </p>
            </td>
            <td class="center-align no-border">
                <br>Wali Kelas
                <p class="mt-80">
                    <strong><?= $grade->staff_name ?></strong>
                    <br><br><br>NIK. <?= $grade->staff_nik ?>
                </p>
                
            </td>
        </tr>
    </tbody>
</table>