<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                <h5 class="card-title text-primary">Selamat Ananda <?=ucwords($santri['fullname']);?> Telah Melengkapi Data! 🎉</h5>
                <p class="mb-4">Pendaftaran Santri Telah <span class="fw-bold">Diterima Sistem</span>. Mohon selanjutnya untuk mengecek kembali data yang ada pada profile santri bagian pemberkasan maupun data informasi pribadi santri!.</p>

                <a href="#informasisantri" class="btn btn-label-warning">Cek Data! &raquo;</a>
                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                <img src="../dashboard/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-light-img="illustrations/man-with-laptop-light.png" data-app-dark-img="illustrations/man-with-laptop-dark.html">
                </div>
            </div>
            </div>
        </div>
        </div>
</div>
<div class="row" id="informasisantri">
            <div class="col-lg-12">
            <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active"><i class="tf-icons bx bx-home"></i> Informasi Santri</button>
                  </li>
                </ul>
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#datapribadi" aria-controls="datapribadi" aria-selected="false"><i class="tf-icons bx bx-user"></i>Data Pribadi Santri</button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#datasekolah" aria-controls="datasekolah" aria-selected="false"><i class="tf-icons bx bx-buildings"></i>Data Sekolah</button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#dataayah" aria-controls="dataayah" aria-selected="false"><i class="tf-icons bx bx-male"></i>Data Ayah</button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#dataibu" aria-controls="dataibu" aria-selected="false"><i class="tf-icons bx bx-female"></i>Data Ibu</button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#datapenunjang" aria-controls="datapenunjang" aria-selected="false"><i class="tf-icons bx bx-data"></i>Data Penunjang</button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#dataprestasi" aria-controls="dataprestasi" aria-selected="false"><i class="tf-icons bx bx-trophy"></i>Data Prestasi</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="tab-content">
                    <!-- Profile Overview -->
                    <div class="tab-pane fade show active" id="datapribadi" role="tabpanel">
                        <?php
                        $datapribadi = query("SELECT santri.NIS,santri.NIK,data_penunjang.anakke,data_penunjang.jumlah_saudara, data_ayah.status AS 'stats_ayah', data_ibu.status AS 'stats_ibu' FROM santri,data_penunjang,data_ayah,data_ibu WHERE data_penunjang.id_santri = santri.id_santri AND data_ayah.id_santri = santri.id_santri AND data_ibu.id_santri = santri.id_santri AND santri.id_santri = $idsan")[0];
                        // $datapribadi = query("SELECT santri.NIS,santri.NIK,data_penunjang.anakke,data_penunjang.jumlah_saudara, data_ayah.status, data_ibu.status FROM santri INNER JOIN data_penunjang ON data_penunjang.id_santri = santri.id_santri INNER JOIN data_ayah ON data_ayah.id_santri = santri.id_santri INNER JOIN data_ibu ON data_ibu.id_santri = santri.id_santri WHERE santri.id_santri = '$idsan';")[0]
                        ?>
                        <div class="card mb-4">
                        <div class="card-body">
                            <!-- <small class="text-muted text-uppercase"></small> -->
                            <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user-check"></i><span class="fw-semibold mx-2">Tahun Ajaran: </span> <span style="font-weight: bolder;"><?=ucwords($tahunajaran);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-home-alt"></i><span class="fw-semibold mx-2">Kelas: </span> <span><?=ucwords($kelas);?></span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span class="fw-semibold mx-2">Status:</span> <span><?=ucwords($santri['status']);?></span></li>
                            
                            </ul>
                            <hr>
                            <form onsubmit="false">
                            <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                <div class="row g-3">
                                    <div class="col-12">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                        <div class="form-check custom-option custom-option-icon border-warning">
                                            <label class="form-check-label custom-option-content" for="customRadioBuilder">
                                            <span class="custom-option-body">
                                                <i class="bx bx-pencil"></i>
                                                <span class="custom-option-title">Saya menyetujui</span>
                                                <small>Bahwa saya yakin dan sadar akan mengisi form ini dengan data yang benar dan valid.</small>
                                            </span>
                                            <input name="acc" class="form-check-input bg-danger border-warning" type="radio" value="1" id="customRadioBuilder" checked disabled/>
                                            </label>
                                        </div>
                                        </div>
                                        
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="anakke">Anak ke</label>
                                        <input type="number" id="anakke" name="anakke" class="form-control" value="<?=$datapribadi['anakke'];?>" disabled/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="jumlahsaudara">Jumlah Saudara</label>
                                        <input type="number" id="jumlahsaudara" name="jumlahsaudara" class="form-control" value="<?=$datapribadi['jumlah_saudara'];?>" disabled/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="nis">NISN (Nomor Induk Siswa Nasional) <span class="text-danger">*)</span></label>
                                        <input type="text" id="nis" name="nis" class="form-control" value="<?=$datapribadi['NIS'];?>" disabled/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="nik">NIK (Nomor Induk Kependudukan) <span class="text-danger">*)</span></label>
                                        <input type="text" id="nik" name="nik" class="form-control" value="<?=$datapribadi['NIK'];?>" disabled/>
                                    </div>
                                    <div class="col-sm-6">
                                                <label class="form-label" for="status_ayah">Status Ayah Kandung <span class="text-danger">*)</span></label>
                                                <select class="select2" id="status_ayah" name="status_ayah" disabled>
                                                <option value="0">--Pilih Status--</option>
                                                <option value="Masih Hidup" <?php if ($datapribadi['stats_ayah'] === "Masih Hidup") {
                                                    echo "selected";
                                                } ?>>Masih Hidup</option>
                                                <option value="Sudah Wafat" <?php if ($datapribadi['stats_ayah'] === "Sudah Wafat") {
                                                    echo "selected";
                                                } ?>>Sudah Wafat</option>
                                                </select>
                                    </div>
                                    <div class="col-sm-6">
                                                <label class="form-label" for="status_ibu">Status Ibu Kandung <span class="text-danger">*)</span></label>
                                                <select class="select2" id="status_ibu" name="status_ibu" disabled>
                                                <option value="0">--Pilih Status--</option>
                                                <option value="Masih Hidup" <?php if ($datapribadi['stats_ibu'] === "Masih Hidup") {
                                                    echo "selected";
                                                } ?>>Masih Hidup</option>
                                                <option value="Sudah Wafat" <?php if ($datapribadi['stats_ibu'] === "Sudah Wafat") {
                                                    echo "selected";
                                                } ?>>Sudah Wafat</option>
                                                </select>
                                    </div>
                                    
                                    
                                </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>
                    <!--/ Profile Overview -->
                    <!-- Data Sekolah -->
                    <div class="tab-pane fade" id="datasekolah" role="tabpanel">
                        <?php
                        $datasekolah = query("SELECT * FROM data_sekolah WHERE id_santri = '$idsan';")[0];
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                            <form onsubmit="false">
                                <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                <div class="row g-3">
                                    <div class="col-12">
                                    <div class="row">
                                        <div class="col-xl mb-xl-0 mb-2">
                                        <div class="form-check custom-option custom-option-icon">
                                            <label class="form-check-label custom-option-content" for="customRadioSell">
                                            <span class="custom-option-body">
                                                <i class="bx bx-home"></i>
                                                <span class="custom-option-title">Negeri</span>
                                                <small>Pilih jika status sekolah asal sebelumnya adalah negeri.</small>
                                            </span>
                                            <input disabled name="status_sekolah" class="form-check-input" type="radio" value="negeri" id="customRadioSell" <?php if ($datasekolah['status_sekolah'] === "negeri") {
                                                echo "checked";
                                            } ?>/>
                                            </label>
                                        </div>
                                        </div>
                                        <div class="col-xl mb-xl-0 mb-2">
                                        <div class="form-check custom-option custom-option-icon">
                                            <label class="form-check-label custom-option-content" for="customRadioRent">
                                            <span class="custom-option-body">
                                                <i class="bx bx-wallet"></i>
                                                <span class="custom-option-title">Swasta</span>
                                                <small>Pilih jika status sekolah asal sebelumnya adalah swasta.<br /></small>
                                            </span>
                                            <input disabled name="status_sekolah" class="form-check-input" type="radio" value="swasta" id="customRadioRent" <?php if ($datasekolah['status_sekolah'] === "swasta") {
                                                echo "checked";
                                            } ?>/>
                                            </label>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="jenis_sekolah">Jenis Sekolah Asal</label>
                                        <select disabled id="jenis_sekolah" name="jenis_sekolah" class="select2 form-select" data-allow-clear="true">
                                            <option value="0">Pilih Jenis Sekolah</option>
                                            <option value="PAUD" <?php if ($datasekolah['jenis_sekolah'] === "PAUD") {
                                                echo "selected";
                                            } ?>>PAUD</option>
                                            <option value="TK" <?php if ($datasekolah['jenis_sekolah'] === "TK") {
                                                echo "selected";
                                            } ?>>TK</option>
                                            <option value="SD" <?php if ($datasekolah['jenis_sekolah'] === "SD") {
                                                echo "selected";
                                            } ?>>SD</option>
                                            <option value="MI" <?php if ($datasekolah['jenis_sekolah'] === "MI") {
                                                echo "selected";
                                            } ?>>MI</option>
                                            <option value="SMP" <?php if ($datasekolah['jenis_sekolah'] === "SMP") {
                                                echo "selected";
                                            } ?>>SMP</option>
                                            <option value="MTs" <?php if ($datasekolah['jenis_sekolah'] === "MTs") {
                                                echo "selected";
                                            } ?>>MTs</option>
                                            <option value="Paket A" <?php if ($datasekolah['jenis_sekolah'] === "Paket A") {
                                                echo "selected";
                                            } ?>>Paket A</option>
                                            <option value="Paket B" <?php if ($datasekolah['jenis_sekolah'] === "Paket B") {
                                                echo "selected";
                                            } ?>>Paket B</option>
                                            <option value="Bukan Sekolah Formal" <?php if ($datasekolah['jenis_sekolah'] === "Bukan Sekolah Formal") {
                                                echo "selected";
                                            } ?>>Bukan Sekolah Formal</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="nama_sekolah">Nama Sekolah <span class="text-danger">*)</span></label>
                                        <input disabled type="text" id="nama_sekolah" name="nama_sekolah" class="form-control" value="<?=$datasekolah['nama_sekolah'];?>"/>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label" for="alamat_sekolah">Alamat Sekolah Asal</label>
                                        <textarea disabled id="alamat_sekolah" name="alamat_sekolah" class="form-control" rows="2"><?=$datasekolah['alamat_sekolah'];?></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="tahun_lulus">Tahun Lulus <span class="text-danger">*)</span></label>
                                        <select disabled id="tahun_lulus" class="select2 form-select" name="tahun_lulus">
                                        <?php
                                        for ($year = (int)date('Y'); 1900 <= $year; $year--): ?>
                                            <option value="<?=$year;?>" <?php if ($datasekolah['tahun_lulus'] === "$year") {
                                                echo "selected";
                                            } ?>><?=$year;?></option>
                                        <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Data Sekolah -->

                    <!-- Data Ayah -->
                    <div class="tab-pane fade" id="dataayah" role="tabpanel">
                        <?php
                        $dataayah = query("SELECT * FROM data_ayah WHERE id_santri = '$idsan'")[0];
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                            <form onsubmit="false">
                                <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                    <label class="form-label d-block" for="nama_ayah">Nama Ayah <span class="text-danger">*)</span></label>
                                    <input disabled type="text" id="nama_ayah" name="nama_ayah" class="form-control" value="<?=ucwords($dataayah['nama_ayah']);?>"/>
                                    </div>
                                    <div class="col-sm-12">
                                    <label class="form-label" for="nika">NIK <span class="text-danger">*)</span></label>
                                    <input disabled type="number" id="nika" name="nika" class="form-control" value="<?=$dataayah['nik'];?>"/>
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="ayah_status">Status Ayah</label>
                                    <select disabled id="ayah_status" name="ayah_status" class="select2 form-select">
                                        <option value="0">Pilih Status</option>
                                        <option value="Ayah Kandung" <?php if ($dataayah['status_kandung'] === "Ayah Kandung") {
                                            echo "selected";
                                        } ?>>Ayah Kandung</option>
                                        <option value="Ayah Tiri" <?php if ($dataayah['status_kandung'] === "Ayah Tiri") {
                                            echo "selected";
                                        } ?>>Ayah Tiri</option>
                                        <option value="Ayah Angkat" <?php if ($dataayah['status_kandung'] === "Ayah Angkat") {
                                            echo "selected";
                                        } ?>>Ayah Angkat</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="pendidikan_ayah">Pendidikan Terakhir Ayah <span class="text-danger">*)</span></label>
                                    <select disabled id="pendidikan_ayah" name="pendidikan_ayah" class="select2 form-select">
                                        <option value="0">Pilih Pendidikan</option>
                                        <option value="SD/MI" <?php if ($dataayah['pendidikan_terakhir'] === "SD/MI") {
                                            echo "selected";
                                        } ?>>SD/MI</option>
                                        <option value="SLTP/MTs" <?php if ($dataayah['pendidikan_terakhir'] === "SLTP/MTs") {
                                            echo "selected";
                                        } ?>>SLTP/MTs</option>
                                        <option value="SLTA/MA" <?php if ($dataayah['pendidikan_terakhir'] === "SLTA/MA") {
                                            echo "selected";
                                        } ?>>SLTA/MA</option>
                                        <option value="D1" <?php if ($dataayah['pendidikan_terakhir'] === "D1") {
                                            echo "selected";
                                        } ?>>D1</option>
                                        <option value="D2" <?php if ($dataayah['pendidikan_terakhir'] === "D2") {
                                            echo "selected";
                                        } ?>>D2</option>
                                        <option value="D3" <?php if ($dataayah['pendidikan_terakhir'] === "D3") {
                                            echo "selected";
                                        } ?>>D3</option>
                                        <option value="D4" <?php if ($dataayah['pendidikan_terakhir'] === "D4") {
                                            echo "selected";
                                        } ?>>D4</option>
                                        <option value="S1" <?php if ($dataayah['pendidikan_terakhir'] === "S1") {
                                            echo "selected";
                                        } ?>>S1</option>
                                        <option value="S2" <?php if ($dataayah['pendidikan_terakhir'] === "S2") {
                                            echo "selected";
                                        } ?>>S2</option>
                                        <option value="S3" <?php if ($dataayah['pendidikan_terakhir'] === "S3") {
                                            echo "selected";
                                        } ?>>S3</option>
                                        <option value="Non Formal" <?php if ($dataayah['pendidikan_terakhir'] === "Non Formal") {
                                            echo "selected";
                                        } ?>>Non Formal</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-12">
                                    <label class="form-label" for="pekerjaan_ayah">Pekerjaan <span class="text-danger">*)</span></label>
                                    <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                        <?php
                                        $koneksi = mysqli_connect("localhost","rdmittif_simak_uji","1234qwer4897","rdmittif_simak_uji");
                                        $jobayah = explode(",",$dataayah['pekerjaan']);
                                        $sqljoba = "";
                                        $jumjobayah = count($jobayah);
                                        for ($i=0; $i < count($jobayah); $i++) { 
                                            $jobayahfix = $jobayah[$i];
                                            $sqljoba .= " AND pekerjaan != '$jobayahfix'";
                                            ?>
                                        <div class="form-check">
                                        <input disabled class="form-check-input" type="checkbox" name="pekerjaan_ayah[]" value="<?=$jobayahfix;?>" id="defaultCheck<?=$i;?>" checked/>
                                        <label class="form-check-label" for="defaultCheck<?=$i;?>">
                                            <?=ucwords($jobayahfix);?>
                                        </label>
                                        </div>                                            
                                        <?php }
                                        $sqljoba = "SELECT * FROM pekerjaan WHERE pekerjaan != 'NULL'".$sqljoba;
                                        // var_dump($sqljoba);
                                        $query = mysqli_query($koneksi, "$sqljoba");
                                        $i = $jumjobayah;
                                        while ($job = mysqli_fetch_assoc($query)) {?>

                                        <div class="form-check">
                                        <input disabled class="form-check-input" type="checkbox" name="pekerjaan_ayah[]" value="<?=$job['pekerjaan'];?>" id="defaultCheck<?=$i;?>"/>
                                        <label class="form-check-label" for="defaultCheck<?=$i;?>">
                                            <?=ucwords($job['pekerjaan']);?>
                                        </label>
                                        </div>
                                        <?php $i++; }?>
                                    </select>
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="penghasilan_ayah">Penghasilan / Bulan <span class="text-danger">*)</span></label>
                                    <select disabled id="penghasilan_ayah" name="penghasilan_ayah" class="select2 form-select">
                                        <option value="0">Pilih Penghasilan</option>
                                        <option value="gol1" <?php if ($dataayah['penghasilan'] === "gol1") {
                                            echo "selected";
                                        }?>><= Rp 500.000</option>
                                        <option value="gol2" <?php if ($dataayah['penghasilan'] === "gol2") {
                                            echo "selected";
                                        } ?>>Rp 500.001 - Rp 1.000.000</option>
                                        <option value="gol3" <?php if ($dataayah['penghasilan'] === "gol3") {
                                            echo "selected";
                                        } ?>>Rp 1.000.001 - Rp 2.000.000</option>
                                        <option value="gol4" <?php if ($dataayah['penghasilan'] === "gol4") {
                                            echo "selected";
                                        } ?>>Rp 2.000.001 - Rp 3.000.000</option>
                                        <option value="gol5" <?php if ($dataayah['penghasilan'] === "gol5") {
                                            echo "selected";
                                        } ?>>Rp 3.000.001 - Rp 5.000.000</option>
                                        <option value="gol6" <?php if ($dataayah['penghasilan'] === "gol6") {
                                            echo "selected";
                                        } ?>>> Rp 5.000.000</option>
                                        <option value="gol0" <?php if ($dataayah['penghasilan'] === "gol0") {
                                            echo "selected";
                                        } ?>>Rp. 0 (sudah wafat/Tidak Berpenghasilan)</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6 mb-4">
                                    <label class="form-label" for="notelp">Nomor Whatsapp <span class="text-danger">(Yang Dapat Dihubungi)</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">IDN (+62)</span>
                                            <input disabled type="number" name="notelp" class="form-control" value="<?=$dataayah['notelp'];?>"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Data Ayah -->

                    <!-- Data Ibu -->
                    <div class="tab-pane fade" id="dataibu" role="tabpanel">
                        <?php
                        $dataibu = query("SELECT * FROM data_ibu WHERE id_santri = '$idsan'")[0];
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                            <form onsubmit="false">
                                <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                    <label class="form-label d-block" for="nama_ibu">Nama Ibu <span class="text-danger">*)</span></label>
                                    <input disabled type="text" id="nama_ibu" name="nama_ibu" class="form-control" value="<?=ucwords($dataibu['nama_ibu']);?>"/>
                                    </div>
                                    <div class="col-sm-12">
                                    <label class="form-label" for="nik_ibu">NIK <span class="text-danger">*)</span></label>
                                    <input disabled type="number" id="nik_ibu" name="nik_ibu" class="form-control" value="<?=$dataibu['nik'];?>"/>
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="ibu_status">Status Ibu</label>
                                    <select disabled id="ibu_status" name="ibu_status" class="select2 form-select">
                                        <option value="0">Pilih Status</option>
                                        <option value="Ibu Kandung" <?php if ($dataibu['status_kandung'] === "Ibu Kandung") {
                                            echo "selected";
                                        } ?>>Ibu Kandung</option>
                                        <option value="Ibu Tiri" <?php if ($dataibu['status_kandung'] === "Ibu Tiri") {
                                            echo "selected";
                                        } ?>>Ibu Tiri</option>
                                        <option value="Ibu Angkat" <?php if ($dataibu['status_kandung'] === "Ibu Angkat") {
                                            echo "selected";
                                        } ?>>Ibu Angkat</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="pendidikan_ibu">Pendidikan Terakhir Ayah <span class="text-danger">*)</span></label>
                                    <select disabled id="pendidikan_ibu" name="pendidikan_ibu" class="select2 form-select">
                                        <option value="0">Pilih Pendidikan</option>
                                        <option value="SD/MI" <?php if ($dataibu['pendidikan_terakhir'] === "SD/MI") {
                                            echo "selected";
                                        } ?>>SD/MI</option>
                                        <option value="SLTP/MTs" <?php if ($dataibu['pendidikan_terakhir'] === "SLTP/MTs") {
                                            echo "selected";
                                        } ?>>SLTP/MTs</option>
                                        <option value="SLTA/MA" <?php if ($dataibu['pendidikan_terakhir'] === "SLTA/MA") {
                                            echo "selected";
                                        } ?>>SLTA/MA</option>
                                        <option value="D1" <?php if ($dataibu['pendidikan_terakhir'] === "D1") {
                                            echo "selected";
                                        } ?>>D1</option>
                                        <option value="D2" <?php if ($dataibu['pendidikan_terakhir'] === "D2") {
                                            echo "selected";
                                        } ?>>D2</option>
                                        <option value="D3" <?php if ($dataibu['pendidikan_terakhir'] === "D3") {
                                            echo "selected";
                                        } ?>>D3</option>
                                        <option value="D4" <?php if ($dataibu['pendidikan_terakhir'] === "D4") {
                                            echo "selected";
                                        } ?>>D4</option>
                                        <option value="S1" <?php if ($dataibu['pendidikan_terakhir'] === "S1") {
                                            echo "selected";
                                        } ?>>S1</option>
                                        <option value="S2" <?php if ($dataibu['pendidikan_terakhir'] === "S2") {
                                            echo "selected";
                                        } ?>>S2</option>
                                        <option value="S3" <?php if ($dataibu['pendidikan_terakhir'] === "S3") {
                                            echo "selected";
                                        } ?>>S3</option>
                                        <option value="Non Formal" <?php if ($dataibu['pendidikan_terakhir'] === "Non Formal") {
                                            echo "selected";
                                        } ?>>Non Formal</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-12">
                                    <label class="form-label" for="pekerjaan_ibu">Pekerjaan <span class="text-danger">*)</span></label>
                                    <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                        <?php
                                        $koneksi = mysqli_connect("localhost","rdmittif_simak_uji","1234qwer4897","rdmittif_simak_uji");
                                        $jobibu = explode(",",$dataibu['pekerjaan']);
                                        $sqljobi = "";
                                        $jumjobibu = count($jobibu);
                                        for ($i=0; $i < count($jobibu); $i++) { 
                                            $jobibufix = $jobibu[$i];
                                            $sqljobi .= " AND pekerjaan != '$jobibufix'";
                                            ?>
                                        <div class="form-check">
                                        <input disabled class="form-check-input" type="checkbox" name="pekerjaan_ibu[]" value="<?=$jobibufix;?>" id="defaultChecki<?=$i;?>" checked/>
                                        <label class="form-check-label" for="defaultChecki<?=$i;?>">
                                            <?=ucwords($jobibufix);?>
                                        </label>
                                        </div>                                            
                                        <?php }
                                        $sqljobi = "SELECT * FROM pekerjaan WHERE pekerjaan != 'NULL'".$sqljobi;
                                        // var_dump($sqljobi);
                                        $query = mysqli_query($koneksi, "$sqljobi");
                                        $i = $jumjobibu;
                                        while ($job = mysqli_fetch_assoc($query)) {?>

                                        <div class="form-check">
                                        <input disabled class="form-check-input" type="checkbox" name="pekerjaan_ibu[]" value="<?=$job['pekerjaan'];?>" id="defaultChecki<?=$i;?>"/>
                                        <label class="form-check-label" for="defaultChecki<?=$i;?>">
                                            <?=ucwords($job['pekerjaan']);?>
                                        </label>
                                        </div>
                                        <?php $i++; }?>
                                    </select>
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="penghasilan_ibu">Penghasilan / Bulan <span class="text-danger">*)</span></label>
                                    <select disabled id="penghasilan_ibu" name="penghasilan_ibu" class="select2 form-select">
                                        <option value="0">Pilih Penghasilan</option>
                                        <option value="gol1" <?php if ($dataibu['penghasilan'] === "gol1") {
                                            echo "selected";
                                        }?>><= Rp 500.000</option>
                                        <option value="gol2" <?php if ($dataibu['penghasilan'] === "gol2") {
                                            echo "selected";
                                        } ?>>Rp 500.001 - Rp 1.000.000</option>
                                        <option value="gol3" <?php if ($dataibu['penghasilan'] === "gol3") {
                                            echo "selected";
                                        } ?>>Rp 1.000.001 - Rp 2.000.000</option>
                                        <option value="gol4" <?php if ($dataibu['penghasilan'] === "gol4") {
                                            echo "selected";
                                        } ?>>Rp 2.000.001 - Rp 3.000.000</option>
                                        <option value="gol5" <?php if ($dataibu['penghasilan'] === "gol5") {
                                            echo "selected";
                                        } ?>>Rp 3.000.001 - Rp 5.000.000</option>
                                        <option value="gol6" <?php if ($dataibu['penghasilan'] === "gol6") {
                                            echo "selected";
                                        } ?>>> Rp 5.000.000</option>
                                        <option value="gol0" <?php if ($dataibu['penghasilan'] === "gol0") {
                                            echo "selected";
                                        } ?>>Rp. 0 (sudah wafat/Tidak Berpenghasilan)</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6 mb-4">
                                    <label class="form-label" for="notelp">Nomor Whatsapp <span class="text-danger">(Yang Dapat Dihubungi)</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">IDN (+62)</span>
                                            <input disabled type="number" name="notelp" class="form-control" value="<?=$dataibu['notelp'];?>"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Data Ibu -->

                    <!-- Data Penunjang -->
                    <div class="tab-pane fade" id="datapenunjang" role="tabpanel">
                        <?php
                        $datapenunjang = query("SELECT data_penunjang.*,data_alamat.* FROM data_penunjang INNER JOIN data_alamat ON data_alamat.id_santri = data_penunjang.id_santri WHERE data_penunjang.id_santri = '$idsan';")[0];
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                            <form onsubmit="false">
                                <input type="hidden" name="id_santri" value="<?=$idsan;?>">
                                <div class="row g-3">
                                    <h4>Data Alamat Orang Tua/Wali</h4>
                                    <div class="col-sm-6">
                                    <label class="form-label" for="form_prov">Pilih Provinsi<span class="text-danger">*)</span></label>
                                    <input disabled type="text" class="form-control" name="form_prov" id="form_prov" value="<?=ucwords($datapenunjang['provinsi']);?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="form_kab">Pilih Kabupaten<span class="text-danger">*)</span></label>
                                        <input disabled type="text" class="form-control" name="form_kab" id="form_kab" value="<?=ucwords($datapenunjang['kabupaten']);?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="form_kec">Pilih Kecamatan<span class="text-danger">*)</span></label>
                                        <input disabled type="text" class="form-control" name="form_kec" id="form_kec" value="<?=ucwords($datapenunjang['kecamatan']);?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="form_des">Pilih Desa<span class="text-danger">*)</span></label>
                                        <input disabled type="text" class="form-control" name="form_des" id="form_des" value="<?=ucwords($datapenunjang['kelurahan']);?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="rtrw">RT / RW /No Rumah<span class="text-danger">*)</span></label>
                                        <input disabled type="text" class="form-control" name="rtrw" id="rtrw" value="<?=$datapenunjang['rt']?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="jalan">Jalan<span class="text-danger">*)</span></label>
                                        <input disabled type="text" class="form-control" name="jalan" id="jalan" value="<?=$datapenunjang['jalan'];?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="kodepos">Kode POS<span class="text-danger">*)</span></label>
                                        <input disabled type="text" class="form-control" name="kodepos" id="kodepos" value="<?=$datapenunjang['kode_pos'];?>">
                                    </div>
                                    <h4>Data Penunjang Lainnya</h4>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="transport">Transportasi dari Rumah ke Pondok <span class="text-danger">*)</span></label>
                                        <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                        <?php
                                        $transportall = ["jalan kaki","sepeda motor","mobil pribadi","angkutan umum","mukim","lainnya"];
                                        $transport = explode(",",$datapenunjang['transport']);
                                        // $jumtransport = count($transport);
                                        $transportfix = array_diff($transportall,$transport);
                                        for ($i=0; $i < count($transport); $i++) { ?>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="transport[]" value="<?=$transport[$i];?>" id="defaultChecktransport<?=$i;?>" checked/>
                                            <label class="form-check-label" for="defaultChecktransport<?=$i;?>">
                                            <?=ucwords($transport[$i]);?>
                                            </label>
                                        </div>
                                        <?php }?>

                                        <?php $z=0; foreach ($transportfix as $trp) {?>
                                            <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="transport[]" value="<?=$trp;?>" id="defaultChecktransport<?=$i+$z;?>"/>
                                            <label class="form-check-label" for="defaultChecktransport<?=$i+$z;?>">
                                            <?=ucwords($trp);?>
                                            </label>
                                        </div>
                                        <?php $z++;} ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="penyakit">Penyakit diderita <span class="text-danger">*)</span></label>
                                        <small class="text-light fw-semibold">Data medis akan dilaporkan kepada kepengasuhan dan unit kesehatan pondok guna antisipasi, pencegahan dan tindakan medis lainnya. <span class="text-danger"> Jika Tidak Ada Harap tetap diisi dengan "Tidak Ada Riwayat Penyakit"</span></small>
                                        <textarea disabled id="penyakit" name="penyakit" class="form-control" rows="2"><?=$datapenunjang['penyakit'];?></textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="bahasa">Penguasaan Bahasa <span class="text-danger">*)</span></label>
                                        <small class="text-light fw-semibold">Bisa memilih lebih dari satu. Pilih Semua yang Sesuai</small>
                                        <?php
                                        $bahasaall = ["Inggris","Arab","Jepang","Mandarin"];
                                        $bahasa = explode(",",$datapenunjang['bahasa']);
                                        $bahasafix = array_diff($bahasaall,$bahasa);
                                        for ($i=0; $i < count($bahasa); $i++) { ?>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="bahasa[]" value="<?=$bahasa[$i];?>" id="defaultCheckbahasa<?=$i;?>" checked/>
                                            <label class="form-check-label" for="defaultCheckbahasa<?=$i;?>">
                                            <?=$bahasa[$i];?>
                                            </label>
                                        </div>
                                        <?php }?>

                                        <?php $z=0; foreach ($bahasafix as $bhs) {?>
                                            <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="bahasa[]" value="<?=$bhs;?>" id="defaultCheckbahasa<?=$i+$z;?>"/>
                                            <label class="form-check-label" for="defaultCheckbahasa<?=$i+$z;?>">
                                            <?=ucwords($bhs);?>
                                            </label>
                                        </div>
                                        <?php $z++;} ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="hafalan">Hafalan Al-Quran <span class="text-danger">*)</span></label>
                                            <select disabled class="select2" id="hafalan" name="hafalan">
                                            <option value="0">--Jumlah Hafalan--</option>
                                            <option value="Belum Ada">Belum Ada</option>
                                            <?php for ($j=1; $j < 31; $j++) { ?>
                                                <option value="<?=$j;?>" <?php if ($j == $datapenunjang['hafalan']) {
                                                    echo "selected";
                                                }?>><?=$j;?> Juz</option>
                                            <?php } ?>
                                            </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="hobi">Hobi <span class="text-danger">*)</span></label>
                                        <small class="text-light fw-semibold">Data Ini digunakan untuk mengetahui minat dan bakat anak</small>
                                        <?php
                                        $hobiall = ["olahraga","kesenian","membaca","menulis","traveling","lainnya"];
                                        $hobi = explode(",",$datapenunjang['hobi']);
                                        $hobifix = array_diff($hobiall,$hobi);
                                        for ($i=0; $i < count($hobi); $i++) { ?>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="hobi[]" value="<?=$hobi[$i];?>" id="defaultCheckhobi<?=$i;?>" checked/>
                                            <label class="form-check-label" for="defaultCheckhobi<?=$i;?>">
                                            <?=ucwords($hobi[$i]);?>
                                            </label>
                                        </div>
                                        <?php }?>

                                        <?php $z=0; foreach ($hobifix as $hbi) {?>
                                            <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="hobi[]" value="<?=$hbi;?>" id="defaultCheckhobi<?=$i+$z;?>"/>
                                            <label class="form-check-label" for="defaultCheckhobi<?=$i+$z;?>">
                                            <?=ucwords($hbi);?>
                                            </label>
                                        </div>
                                        <?php $z++;} ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="info">Info Lainnya <span class="text-danger">*)</span></label>
                                        <small class="text-light fw-semibold">Informasi yang perlu perhatian khusus pada calon santri, seperti kebiasaan buruk dan lain sebagainya <span class="text-danger">(Harus diisi agar tidak kosong)</span></small>
                                        <textarea disabled id="info" name="info" class="form-control" rows="2"><?=$datapenunjang['info'];?></textarea>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Data Penunjang -->

                    <!-- Data Prestasi -->
                    <div class="tab-pane fade" id="dataprestasi" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                            <div class="card-datatable table-responsive">
                                <table id="manprestasi" class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Lomba</th>
                                    <th>Juara</th>
                                    <th>Tingkat</th>
                                    <th>Keterangan</th>
                                    <th>Bukti Sertifikat</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    $prestasi = query("SELECT * FROM prestasi WHERE id_santri = '$idsan'");
                                    foreach ($prestasi as $prst) :?>
                                    <tr>
                                        <td><?=$i;?></td>
                                        <td><?=date('l, d F Y', strtotime($prst["waktu"]));?></td>
                                        <td><?=ucwords($prst['lomba']);?></td>
                                        <td><?=ucwords($prst['juara']);?></td>
                                        <td><?=ucwords($prst['tingkat']);?></td>
                                        <td><?=ucwords($prst['keterangan'])?></td>
                                        <td><a href="../dashboard/assets/img/prove/<?=$prst['sertif'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat Sertifikat</a></td>
                                    </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Lomba</th>
                                    <th>Juara</th>
                                    <th>Tingkat</th>
                                    <th>Keterangan</th>
                                    <th>Bukti Sertifikat</th>
                                </tr>
                                </tfoot>
                                </table>
                                    <script>
                                        $(document).ready(function() {
                                            $('#manprestasi').DataTable( {
                                                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                dom: 'Blftipr',
                                                buttons: [
                                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                                ]
                                            } );
                                        } );
                                </script> 
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Data Prestasi -->
                </div>
                </div>
            </div> 
                
            </div>
            </div>
            </div>
</div>



<div class="row" id="pemberkasan">
    <div class="col-xl-12 col-lg-12 col-md-12">
    <div class="mb-3 card">
        <div class="card-body">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active"><i class="tf-icons bx bx-book"></i> Berkas Santri</button>
            </li>
        </ul>
        <?php
        if ($rowberkas == NULL) {
            $jumdataberkas = 10;
        }elseif ($rowberkas !== NULL){
            $idrowberkas = $rowberkas[0]['id_data_berkas'];
            // hitung berkas yang NULL
            $databerkas = query("SELECT * FROM data_berkas WHERE id_data_berkas = '$idrowberkas'")[0];
            $jumdataberkas = validdata($databerkas);
        }?>
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
            <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#berkaswajib" aria-controls="berkaswajib" aria-selected="false"><i class="tf-icons bx bx-data"></i>Berkas Wajib <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger"><?=$jumdataberkas;?></button>
            </li>
            <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#berkasopsi" aria-controls="berkasopsi" aria-selected="false"><i class="tf-icons bx bx-notepad"></i>Berkas Opsional</button>
            </li>
        </ul>
        <div class="tab-content">
        <div class="tab-pane fade show active" id="berkaswajib" role="tabpanel">
        <?php
        if ($rowberkas == NULL || $jumdataberkas > 0) {?>
            <div class="alert alert-warning mb-4" role="alert">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                    <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2">
                        <i class="bx bx-sm bx-upload fs-4"></i>
                    </span>
                    </div>
                    <div class="flex-grow-1">
                    <div class="fw-bold">Lengkapi Berkas Anda</div>
                    <ul class="list-unstyled mb-0">
                        <li> - Silakan lengkapi form pemberkasan di bawah ini untuk melengkapi data anda! <br/>Sebelum mengisi data, mohon menyiapkan berkas untuk di foto/scan, berikut adalah daftar berkas anda yang belum terdaftar pada sistem:
                                            <!--list berkas yang belum diupload  -->
                                            <?php if ($rowberkas == NULL) {?>
                                            <span class="text-danger">*(Belum ada berkas yang diupload)</span>
                                            <ol>
                                                <li>Kartu Keluarga</li>
                                                <li>KTP Ayah dan Ibu</li>
                                                <li>Akta Kelahiran</li>
                                                <li>Pas Foto berwarna</li>
                                                <li>Raport Terakhir (Jika ada)</li>
                                                <li>Surat Keterangan Lulus (Jika ada)</li>
                                                <li>Ijazah Terakhir (Jika ada)</li>
                                            </ol> 
                                            <?php } elseif ($rowberkas !== NULL) {
                                            $idrowberkas = $rowberkas[0]['id_data_berkas'];
                                            // hitung berkas yang NULL
                                            $databerkas = query("SELECT * FROM data_berkas WHERE id_data_berkas = '$idrowberkas'")[0];
                                            validdata($databerkas);
                                            echo "<span class='text-danger'>*($validdata berkas yang belum diupload)</span>";
                                            echo "<ol>";
                                            $nama_berkas = "";
                                            foreach ($databerkas as $berkas => $value) {
                                                if ($value == NULL) {
                                                    switch ($berkas) {
                                                        case 'kartu_keluarga':
                                                            $nama_berkas = "Kartu Keluarga";
                                                            break;
                                                        case 'ktp_ayah':
                                                            $nama_berkas = "KTP Ayah";
                                                            break;
                                                        case 'ktp_ibu':
                                                            $nama_berkas = "KTP Ibu";
                                                            break;                               
                                                        case 'akta_kelahiran':
                                                            $nama_berkas = "Akta Kelahiran";
                                                            break;                        
                                                        case 'ijazah_terakhir':
                                                            $nama_berkas = "Ijazah Terakhir";
                                                            break;          
                                                        case 'pas_foto':
                                                            $nama_berkas = "Pas Foto";
                                                            break;
                                                        case 'skl':
                                                            $nama_berkas = "SKL";
                                                            break;
                                                        case 'raport_terakhir':
                                                            $nama_berkas = "Raport Terakhir";
                                                            break;   
                                                        case 'bpjs':
                                                            $nama_berkas = "BPJS";
                                                            break;
                                                        case 'kip':
                                                            $nama_berkas = "KIP";
                                                            break;
                                                        default:
                                                            $nama_berkas = "";
                                                            break;
                                                    }
                                                    echo "<li>$nama_berkas</li>";
                                                }
                                            }
                                            echo "</ol>";
                                            }?>
                        </li>
                        <li> - Setelah data anda dikirim, maka admin akan memverifikasi data yang telah anda kirimkan apakah valid </li>
                        <li> -  Mohon untuk melengkapi berkas yang sesuai karena data anda akan dicek kebenarannya oleh sistem</li>
                    </ul>
                    </div>
                </div>
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } else {?> 
                <div class="alert alert-success mb-4" role="alert">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                        <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                            <i class="bx bx-sm bx-data fs-4"></i>
                        </span>
                        </div>
                        <div class="flex-grow-1">
                        <div class="fw-bold">Terima Kasih , Berkas Anda Telah Lengkap!</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php }?>
        <div class="card-datatable table-responsive">
            <table id="manberkas" class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>Kartu Keluarga</th>
                <th>KTP Ayah</th>
                <th>KTP Ibu</th>
                <th>Akta Kelahiran</th>
                <th>Ijazah Terakhir</th>
                <th>Pas Foto Berwarna</th>
                <th>SKL</th>
                <th>Raport Terakhir</th>
                <th>BPJS</th>
                <th>KIP</th>
                <th>Tanggal Upload</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($rowberkas == NULL) {?>
                <tr>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Kosong</span></td>
                    <td><span class="badge bg-label-danger">Belum Ada Data</span></td>
                </tr>
                <?php }elseif ($rowberkas !== NULL) {?>
                <tr>
                    <?php if ($rowberkas[0]['kartu_keluarga'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['kartu_keluarga'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['ktp_ayah'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['ktp_ayah'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['ktp_ibu'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['ktp_ibu'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['akta_kelahiran'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['akta_kelahiran'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['ijazah_terakhir'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['ijazah_terakhir'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['pas_foto'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['pas_foto'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['skl'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['skl'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['raport_terakhir'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['raport_terakhir'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['bpjs'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['bpjs'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <?php if ($rowberkas[0]['kip'] !== NULL) {?>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rowberkas[0]['kip'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                    <?php }else {
                        echo "<td><span class='badge bg-label-danger'>Kosong</span></td>";
                    } ?>
                    <td><?=date('l, d F Y', strtotime($rowberkas[0]["created_at"]));?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Kartu Keluarga</th>
                <th>KTP Ayah</th>
                <th>KTP Ibu</th>
                <th>Akta Kelahiran</th>
                <th>Ijazah Terakhir</th>
                <th>Pas Foto Berwarna</th>
                <th>SKL</th>
                <th>Raport Terakhir</th>
                <th>BPJS</th>
                <th>KIP</th>
                <th>Tanggal Upload</th>
            </tr>
            </tfoot>
            </table>
                <script>
                        $(document).ready(function() {
                            $('#manberkas').DataTable( {
                                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                dom: 'Blftipr',
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                            } );
                        } );
                </script> 
        </div>
        <hr>
        </div>
        <div class="tab-pane fade" id="berkasopsi" role="tabpanel">
        <?php
        $rowberkasopsi = query("SELECT * FROM data_berkas_pendukung WHERE id_santri = '$idsan'");
        ?>
        <div class="alert alert-success mb-4" role="alert">
            <div class="d-flex gap-3">
                <div class="flex-shrink-0">
                <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                    <i class="bx bx-sm bx-data fs-4"></i>
                </span>
                </div>
                <div class="flex-grow-1">
                <div class="fw-bold">Ini adalah halaman untuk melengkapi berkas yang ingin anda tambahkan! Berkas ini tidak wajib/pilihan anda sendiri untuk melengkapinya!</div>
                </div>
            </div>
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="card-datatable table-responsive">
            <table id="manberkasopsi" class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>Jenis Berkas</th>
                <th>Berkas</th>
                <th>Tanggal Upload</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($rowberkasopsi == NULL) {?>
                <tr>
                    <td colspan="4" class="text-center bg-warning"><span class="badge bg-label-danger">Belum Ada Data</span></td>
                </tr>
                <?php }elseif ($rowberkasopsi !== NULL) {?>
                    <?php foreach ($rowberkasopsi as $rbk) :?>
                        <tr>
                        <td><?=ucwords($rbk['jenis_berkas']);?></td>
                        <td><span class='badge bg-label-primary'><a href="../dashboard/assets/img/prove/<?=$rbk['nama_berkas'];?>" target="_blank"><i class='bx bxs-file-blank'></i>Lihat File</a></span></td>
                        <td><?=date('l, d F Y', strtotime($rbk["created_at"]));?></td>
                        <td>
                            <a class="btn btn-danger" href="func/hapusberkasopsi.php?id=<?=$rbk['id_data_berkas_pendukung'];?>&idsan=<?=$idsan;?>" onclick="return confirm('Apakah Anda Yakin Menghapus Berkas Ini?')" class="dropdown-item text-danger delete-record">Hapus</a>
                        </td>
                        </tr>
                    <?php endforeach;?>
                <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Jenis Berkas</th>
                <th>Berkas</th>
                <th>Tanggal Upload</th>
                <th>Aksi</th>
            </tr>
            </tfoot>
            </table>
                <script>
                        $(document).ready(function() {
                            $('#manberkasopsi').DataTable( {
                                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                dom: 'Blftipr',
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                            } );
                        } );
                </script> 
        </div>
        <hr>
                    
        </div>
        </div>
        </div>
    </div>
    </div>
</div>