<?php
// Mengambil data jumlah pengguna berdasarkan peran
$totreviewer = query("SELECT COUNT(id_user) AS 'totreviewer' FROM users WHERE `role` = 'reviewer'")[0];
$totuploader = query("SELECT COUNT(id_user) AS 'totuploader' FROM users WHERE `role` = 'uploader'")[0];

// Mengambil data jumlah sumur dan dokumen
$totsumur = query("SELECT COUNT(id_sumur) AS 'totsumur' FROM sumur")[0];
// Mengambil data jumlah total AFE berdasarkan pengelompokan dari nama AFE
$totalAFE = query("SELECT COUNT('no_afe') AS total FROM wonder;")[0]['total'];
$wonder_onprogress = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') AS month, 
                    COUNT(*) AS total 
              FROM wonder 
              WHERE progress = 0 
              GROUP BY month
              ORDER BY month;";
              $result_on_progress = mysqli_query($conn, $wonder_onprogress);

              $data_on_progress = [];
              while ($row = mysqli_fetch_assoc($result_on_progress)) {
                  $data_on_progress[] = $row;
              }

              $query_complete = "SELECT 
                      DATE_FORMAT(created_at, '%Y-%m') AS month, 
                      COUNT(*) AS total 
                  FROM wonder
                  WHERE progress = 1 
                  GROUP BY month
                  ORDER BY month";              
              
                  $result_complete = mysqli_query($conn, $query_complete);

              $data_complete = [];
              while ($row = mysqli_fetch_assoc($result_complete)) {
                  $data_complete[] = $row;
              }
              
              // Format data untuk Chart.js
              $months = array_column($data_on_progress, 'month');
              $totals_on_progress = array_column($data_on_progress, 'total');
              $totals_complete = array_column($data_complete, 'total');
              $totprogress = array_sum($totals_on_progress);
              $totcomplete = array_sum($totals_complete);
              
?>
<div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row g-6">
            <!-- Ratings -->
            <div class="col-lg-3 col-sm-3">
              <div class="card">
                <div class="row">
                  <div class="col-6">
                    <div class="card-body">
                      <div class="card-info">
                        <h6 class="mb-4 pb-1 text-nowrap">Reviewer</h6>
                        <div class="d-flex align-items-center mb-3">
                          <h4 class="mb-0 me-2"><?=$totreviewer['totreviewer'];?></h4>
                          <p class="text-success mb-0">Orang</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="h-100 position-relative">
                      <img src="../dashboard/assets/img/illustrations/illustration-2.png" alt="Ratings" class="position-absolute card-img-position scaleX-n1-rtl bottom-0 w-auto end-0 me-3 me-xl-0 me-xxl-3 pe-2" width="95">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Ratings -->
            <!-- Sessions -->
            <div class="col-lg-3 col-sm-3">
              <div class="card">
                <div class="row">
                  <div class="col-6">
                    <div class="card-body">
                      <div class="card-info">
                        <h6 class="mb-4 pb-1 text-nowrap">Uploader</h6>
                        <div class="d-flex align-items-center mb-3">
                          <h4 class="mb-0 me-2"><?=$totuploader['totuploader'];?></h4>
                          <p class="text-danger mb-0">Orang</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="h-100 position-relative">
                      <img src="../dashboard/assets/img/illustrations/illustration-3.png" alt="Ratings" class="position-absolute card-img-position scaleX-n1-rtl bottom-0 w-auto end-0 me-3 me-xl-0 me-xxl-3 pe-2" width="81">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Sessions -->
            <!-- Transactions -->
            <div class="col-xxl-6 align-self-end">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Visualisasi Sistem Wonder</h5>
                    <div class="dropdown">
                      <button class="btn text-muted p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-24px"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        <a class="dropdown-item" href="javascript:void(0);">Update</a>
                      </div>
                    </div>
                  </div>
                  <p class="small mb-0"><span class="h6 mb-0">Total <?= json_encode($totprogress); ?> Sumur On Progress Berjalan</span> 😎</p>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-3 col-6">
                      <div class="d-flex align-items-center">
                        <div class="avatar">
                          <!-- Tombol untuk membuka modal -->
                          <a href="#" data-toggle="modal" data-target="#afeModal">
                          <div class="avatar-initial bg-primary rounded shadow-xs">
                            <i class="ri-pie-chart-2-line ri-24px"></i>
                          </div>
                          </a>
                        </div>
                        <div class="ms-3">
                          <p class="mb-0">Total AFE</p>
                          <h5 class="mb-0"><?= number_format($totalAFE, 0); ?></h5>
                        </div>
                      </div>

                      <!-- Modal -->
                      <div class="modal fade" id="afeModal" tabindex="-1" role="dialog" aria-labelledby="afeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="afeModalLabel">Jumlah AFE Berdasarkan No. AFE</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <table id="afeTable" class="table table-responsive table-bordered" style="width:100%">
                                          <thead>
                                              <tr>
                                                  <th>No. AFE</th>
                                                  <th>Jumlah</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php
                                              // Query untuk mengambil data jumlah AFE berdasarkan no_afe
                                              $query_afe = "
                                                  SELECT 
                                                      no_afe, 
                                                      COUNT(*) AS jumlah 
                                                  FROM wonder 
                                                  GROUP BY no_afe
                                              ";
                                              $result_afe = mysqli_query($conn, $query_afe);

                                              while ($row = mysqli_fetch_assoc($result_afe)) {
                                                  echo "<tr>";
                                                  echo "<td>" . htmlspecialchars($row['no_afe']) . "</td>";
                                                  echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                                                  echo "</tr>";
                                              }
                                              ?>
                                          </tbody>
                                      </table>
                                      <script>
                                      $(document).ready(function() {
                                          $('#afeModal').on('shown.bs.modal', function () {
                                              $('#afeTable').DataTable( {
                                              lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                              dom: 'Blftipr',
                                              buttons: [
                                                  'copy', 'csv', 'excel', 'pdf', 'print'
                                                    ]
                                              });
                                          });
                                      });
                                      </script>
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>
                    <div class="col-md-3 col-6">
                      <div class="d-flex align-items-center">
                        <div class="avatar">
                        <a href="#" data-toggle="modal" data-target="#sumurModal">
                          <div class="avatar-initial bg-info rounded shadow-xs">
                            <i class="ri-macbook-line ri-24px"></i>
                          </div>
                        </a>
                        </div>
                        <div class="ms-3">
                          <p class="mb-0">Sumur</p>
                          <h5 class="mb-0"><?=$totsumur['totsumur'];?></h5>
                        </div>
                      </div>
                      <!-- Modal untuk daftar sumur minyak -->
                      <div class="modal fade" id="sumurModal" tabindex="-1" role="dialog" aria-labelledby="sumurModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="sumurModalLabel">Daftar Sumur Minyak</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <table id="sumurTable" class="display" style="width:100%">
                                          <thead>
                                              <tr>
                                                  <th>No.</th>
                                                  <th>Nama Sumur</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php
                                              // Query untuk mengambil data daftar sumur minyak
                                              $query_sumur = "SELECT * FROM sumur";
                                              $result_sumur = mysqli_query($conn, $query_sumur);
                                              $i = 1;
                                              while ($row = mysqli_fetch_assoc($result_sumur)) {
                                                  echo "<tr>";
                                                  echo "<td>" . htmlspecialchars($i) . "</td>";
                                                  echo "<td>" . htmlspecialchars($row['nama_sumur']) . "</td>";
                                                  echo "</tr>";
                                                  $i++;
                                              }
                                              ?>
                                          </tbody>
                                      </table>
                                      <script>
                                      $(document).ready(function() {
                                          $('#sumurModal').on('shown.bs.modal', function () {
                                              $('#sumurTable').DataTable( {
                                              lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                              dom: 'Blftipr',
                                              buttons: [
                                                  'copy', 'csv', 'excel', 'pdf', 'print'
                                                    ]
                                              });
                                          });
                                      });
                                      </script>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-6">
                      <div class="d-flex align-items-center">
                        <div class="avatar">
                        <a href="#" data-toggle="modal" data-target="#progressModal">
                          <div class="avatar-initial bg-warning rounded shadow-xs">
                            <i class="ri-group-line ri-24px"></i>
                          </div>
                        </a>
                        </div>
                        <div class="ms-3">
                          <p class="mb-0">Wonder On Progress</p>
                          <h5 class="mb-0"><?= number_format($totprogress, 0); ?></h5>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-3 col-6">
                      <div class="d-flex align-items-center">
                        <div class="avatar">
                          <div class="avatar-initial bg-success rounded shadow-xs">
                            <i class="ri-file-line ri-24px"></i>
                          </div>
                        </div>
                        <div class="ms-3">
                          <p class="mb-0">Wonder Complete</p>
                          <h5 class="mb-0"><?= number_format($totcomplete, 0); ?></h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Transactions -->
            <!-- Total Sales Chart-->
            <div class="col-xxl-3 col-md-6">
              <div class="card h-100">
                <div class="card-header">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Total Sumur On Progress</h5>
                    <div class="dropdown">
                      <button class="btn text-muted p-0" type="button" id="totalSalesDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-24px"></i>
                      </button>
                      
                    </div>
                  </div>
                  <p class="card-subtitle mb-0"></p>
                </div>
                <div class="card-body">
                    <div class="container">
                      <div id="sumurProgressChart"></div>
                    </div>
                    <script>
                    // Data dari PHP
                    const months = <?php echo json_encode($months); ?>;
                    const totals = <?php echo json_encode($totals_on_progress); ?>;

                    // Konfigurasi ApexCharts
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Total Sumur On Progress',
                            data: totals
                        }],
                        xaxis: {
                            categories: months,
                            labels: {
                                formatter: function(value) {
                                    // Format label untuk hanya menampilkan nama bulan
                                    const date = new Date(value);
                                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                    return monthNames[date.getMonth()];
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Total Sumur'
                            }
                        },
                        title: {
                            text: 'Total Sumur On Progress per Bulan',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#sumurProgressChart"), options);
                    chart.render();
                  </script>
                </div>
              </div>
            </div>
            <!--/ Total Sales Chart-->

            <div class="col-xxl-3 col-md-6">
              <div class="card h-100">
                <div class="card-header">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Total Sumur Complete</h5>
                    <div class="dropdown">
                      <button class="btn text-muted p-0" type="button" id="totalSalesDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-24px"></i>
                      </button>
                      
                    </div>
                  </div>
                  <p class="card-subtitle mb-0"></p>
                </div>
                <div class="card-body">
                    <div class="container">
                      <div id="sumurCompleteChart"></div>
                    </div>
                    <script>
                      // Data dari PHP
                      const monthsComplete = <?php echo json_encode($months); ?>;
                      const totalsComplete = <?php echo json_encode($totals_complete); ?>;

                      // Konfigurasi ApexCharts
                      var options = {
                          chart: {
                              type: 'bar',
                              height: 350
                          },
                          series: [{
                              name: 'Total Sumur Complete',
                              data: totalsComplete
                          }],
                          xaxis: {
                              categories: monthsComplete,
                              labels: {
                                formatter: function(value) {
                                    // Format label untuk hanya menampilkan nama bulan
                                    const date = new Date(value);
                                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                    return monthNames[date.getMonth()];
                                }
                            }
                          },
                          yaxis: {
                              title: {
                                  text: 'Total Sumur'
                              }
                          },
                          title: {
                              text: 'Total Sumur Complete per Bulan',
                              align: 'center'
                          }
                      };

                      var chart = new ApexCharts(document.querySelector("#sumurCompleteChart"), options);
                      chart.render();
                  </script>
                </div>
              </div>
            </div>
            <!--/ Total Sales Chart-->


            <!-- Revenue Report Chart-->
            <div class="col-xxl-3 col-md-6">
              <div class="card h-100">
                <div class="card-header">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-0">Selisih Progress dan Complete</h5>
                    <div class="dropdown">
                      <button class="btn text-muted p-0" type="button" id="revenueReportDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-24px"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="revenueReportDropdown">
                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                <div class="container">
                    <div id="completeChartPerbadingan"></div>
                </div>

                <script>
                    // Data dari PHP
                    const monthsPerbandingan = <?php echo json_encode($months); ?>;
                    const totalsOnProgress = <?php echo json_encode($totals_on_progress); ?>;
                    const totalsCompletePerbandingan = <?php echo json_encode($totals_complete); ?>;

                    // Konfigurasi ApexCharts
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Sumur On Progress',
                            data: totalsOnProgress
                        }, {
                            name: 'Sumur Complete',
                            data: totalsCompletePerbandingan
                        }],
                        xaxis: {
                            categories: monthsPerbandingan,
                            labels: {
                                formatter: function(value) {
                                    // Format label untuk hanya menampilkan nama bulan
                                    const date = new Date(value);
                                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                    return monthNames[date.getMonth()];
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Total Sumur'
                            }
                        },
                        title: {
                            text: 'Perbandingan Sumur On Progress dan Complete per Bulan',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#completeChartPerbadingan"), options);
                    chart.render();
                </script>
                </div>
              </div>
            </div>
            <!--/ Revenue Report Chart-->
            <!-- Sales Overview Chart -->
            <div class="col-xl-6">
              <div class="card h-100">
                <div class="card-header">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-0">Overview Sumur On progress dan Complete</h5>
                    <div class="dropdown">
                      <button class="btn text-muted p-0" type="button" id="salesOverviewDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-24px"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesOverviewDropdown">
                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-lg-5">
                  <div class="row align-items-center">
                  <div class="container">
                    <div id="overviewPerbandingan"></div>
                  </div>
                  <script>
                  // Data dari PHP
                  const totalOnProgressOverview = <?php echo json_encode($totals_on_progress); ?>;
                  const totalCompleteOverview = <?php echo json_encode($totals_complete); ?>;

                  // Konfigurasi ApexCharts
                  var options = {
                      chart: {
                          type: 'pie',
                          height: 350,
                          options3d: {
                              enabled: true,
                              alpha: 45,
                              beta: 0
                          }
                      },
                      series: [totalOnProgressOverview, totalCompleteOverview],
                      labels: ['Sumur On Progress', 'Sumur Complete'],
                      title: {
                          text: 'Perbandingan Sumur On Progress dan Complete',
                          align: 'center'
                      },
                      plotOptions: {
                          pie: {
                              depth: 45
                          }
                      }
                  };

                  var chart = new ApexCharts(document.querySelector("#overviewPerbandingan"), options);
                  chart.render();
              </script>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Sales Overview Chart -->
            <!-- Activity Timeline -->
            <div class="col-xl-12 col-lg-12">
              <div class="card h-100">
                <div class="card-header">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-0">Total AFE Berdasarkan Tahun Pengerjaan</h5>
                  </div>
                </div>
                <div class="card-body pt-4">
                  <?php
                  $query = "SELECT 
                      no_afe, 
                      YEAR(tahun_pengerjaan) AS year, 
                      COUNT(*) AS total 
                  FROM wonder 
                  GROUP BY no_afe, year
                  ORDER BY year, no_afe;";
                  $result = mysqli_query($conn, $query);

                  $data = [];
                  while ($row = mysqli_fetch_assoc($result)) {
                      $data[] = $row;
                  }
                  
                  // Format data untuk ApexCharts
                  $no_afes = array_unique(array_column($data, 'no_afe'));
                  $years = array_unique(array_column($data, 'year'));
                  
                  $series = [];
                  foreach ($no_afes as $no_afe) {
                      $afe_data = array_filter($data, function($item) use ($no_afe) {
                          return $item['no_afe'] === $no_afe;
                      });
                      $afe_totals = [];
                      foreach ($years as $year) {
                          $year_data = array_filter($afe_data, function($item) use ($year) {
                              return $item['year'] == $year;
                          });
                          $afe_totals[] = count($year_data) > 0 ? array_values($year_data)[0]['total'] : 0;
                      }
                      $series[] = [
                          'name' => $no_afe,
                          'data' => $afe_totals
                      ];
                  }
                  ?>

                  <div class="container">
                      <div id="afeSumurChart"></div>
                  </div>

                      <script>
                          // Data dari PHP
                          const years = <?php echo json_encode($years); ?>;
                          const series = <?php echo json_encode($series); ?>;

                          // Konfigurasi ApexCharts
                          var options = {
                              chart: {
                                  type: 'bar',
                                  height: 350
                              },
                              series: series,
                              xaxis: {
                                  categories: years,
                                  title: {
                                      text: 'Tahun Pengerjaan'
                                  }
                              },
                              yaxis: {
                                  title: {
                                      text: 'Total Sumur'
                                  }
                              },
                              title: {
                                  text: 'Total Sumur Berdasarkan Nama AFE dan Tahun Pengerjaan',
                                  align: 'center'
                              },
                              plotOptions: {
                                  bar: {
                                      horizontal: false,
                                      dataLabels: {
                                          position: 'top'
                                      }
                                  }
                              },
                              dataLabels: {
                                  enabled: true,
                                  formatter: function (val) {
                                      return val;
                                  },
                                  offsetY: -20,
                                  style: {
                                      fontSize: '12px',
                                      colors: ["#304758"]
                                  }
                              }
                          };

                          var chart = new ApexCharts(document.querySelector("#afeSumurChart"), options);
                          chart.render();
                      </script>
                </div>
              </div>
            </div>
            <!--/ Activity Timeline -->
            
            <!-- Meeting Schedule -->
            <!-- <div class="col-xxl-4 col-md-6">
              <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="card-title m-0 me-2">Meeting Schedule</h5>
                  <div class="dropdown">
                    <button class="btn text-muted p-0" type="button" id="meetingSchedule" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="ri-more-2-line ri-24px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="meetingSchedule">
                      <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                      <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                      <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <ul class="p-0 m-0">
                    <li class="d-flex mb-4 pb-2">
                      <div class="avatar flex-shrink-0 me-4">
                        <img src="../dashboard/assets/img/avatars/4.png" alt="avatar" class="rounded-circle">
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <h6 class="mb-0">Call with Woods</h6>
                          <small class="d-flex align-items-center">
                            <i class="ri-calendar-line ri-14px"></i>
                            <span class="ms-2">21 Jul | 08:20-10:30</span>
                          </small>
                        </div>
                        <div class="badge bg-label-primary rounded-pill">Business</div>
                      </div>
                    </li>
                    <li class="d-flex mb-4 pb-2">
                      <div class="avatar flex-shrink-0 me-4">
                        <img src="../dashboard/assets/img/avatars/5.png" alt="avatar" class="rounded-circle">
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <h6 class="mb-0">Conference call</h6>
                          <small class="d-flex align-items-center">
                            <i class="ri-calendar-line ri-14px"></i>
                            <span class="ms-2">21 Jul | 08:20-10:30</span>
                          </small>
                        </div>
                        <div class="badge bg-label-warning rounded-pill">Dinner</div>
                      </div>
                    </li>
                    <li class="d-flex mb-4 pb-2">
                      <div class="avatar flex-shrink-0 me-4">
                        <img src="../dashboard/assets/img/avatars/3.png" alt="avatar" class="rounded-circle">
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <h6 class="mb-0">Meeting with Mark</h6>
                          <small class="d-flex align-items-center">
                            <i class="ri-calendar-line ri-14px"></i>
                            <span class="ms-2">21 Jul | 08:20-10:30</span>
                          </small>
                        </div>
                        <div class="badge bg-label-secondary rounded-pill">Meetup</div>
                      </div>
                    </li>
                    <li class="d-flex mb-4 pb-2">
                      <div class="avatar flex-shrink-0 me-4">
                        <img src="../dashboard/assets/img/avatars/14.png" alt="avatar" class="rounded-circle">
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <h6 class="mb-0">Meeting in Oakland</h6>
                          <small class="d-flex align-items-center">
                            <i class="ri-calendar-line ri-14px"></i>
                            <span class="ms-2">21 Jul | 08:20-10:30</span>
                          </small>
                        </div>
                        <div class="badge bg-label-danger rounded-pill">Dinner</div>
                      </div>
                    </li>
                    <li class="d-flex mb-4 pb-2">
                      <div class="avatar flex-shrink-0 me-4">
                        <img src="../dashboard/assets/img/avatars/8.png" alt="avatar" class="rounded-circle">
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <h6 class="mb-0">Call with hilda</h6>
                          <small class="d-flex align-items-center">
                            <i class="ri-calendar-line ri-14px"></i>
                            <span class="ms-2">21 Jul | 08:20-10:30</span>
                          </small>
                        </div>
                        <div class="badge bg-label-success rounded-pill">Meditation</div>
                      </div>
                    </li>
                    <li class="d-flex">
                      <div class="avatar flex-shrink-0 me-4">
                        <img src="../dashboard/assets/img/avatars/1.png" alt="avatar" class="rounded-circle">
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <h6 class="mb-0">Meeting with Carl</h6>
                          <small class="d-flex align-items-center">
                            <i class="ri-calendar-line ri-14px"></i>
                            <span class="ms-2">21 Jul | 08:20-10:30</span>
                          </small>
                        </div>
                        <div class="badge bg-label-primary rounded-pill">Business</div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div> -->
            <!--/ Meeting Schedule -->
            <!-- Developer Meetup -->
            <!-- <div class="col-xxl-4 col-md-6">
              <div class="card h-100">
                <img class="card-img-top h-px-200" src="../dashboard/assets/img/elements/laptop.png" alt="laptop image cap" style="object-fit: cover;">
                <div class="card-body">
                  <div class="d-flex border-bottom pb-4">
                    <div class="badge bg-label-primary d-flex flex-column justify-content-center px-4 rounded-3 me-4">
                      <h6 class="text-primary mb-0 fw-normal">Jan</h6>
                      <h5 class="text-primary mb-0">24</h5>
                    </div>
                    <div>
                      <h6 class="card-title mb-1">Developer Meetup</h6>
                      <small class="mb-0">The WordPress open source,free software project is the community behind the…</small>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between border-bottom mt-4">
                    <div class="text-center">
                      <span class="ri-star-smile-line ri-24px"></span>
                      <p class="mt-1">Interested</p>
                    </div>
                    <div class="text-center">
                      <span class="ri-check-double-line ri-24px"></span>
                      <p class="mt-1">Joined</p>
                    </div>
                    <div class="text-center text-primary">
                      <span class="ri-group-line ri-24px"></span>
                      <p class="mt-1">Invited</p>
                    </div>
                    <div class="text-center">
                      <span class="ri-more-fill ri-24px"></span>
                      <p class="mt-1">More</p>
                    </div>
                  </div>
                  <div>
                    <div class="d-flex mt-4 gap-2">
                      <span class="ri-time-line ri-20px"></span>
                      <div>
                        <p class="mb-0">Tuesday, 24 january, 10:20 - 12:30</p>
                        <p class="mb-0">After 1 week</p>
                      </div>
                    </div>
                    <div class="d-flex mt-3 gap-2">
                      <span class="ri-map-pin-line ri-20px"></span>
                      <div>
                        <p class="mb-0">The Rochard NYC</p>
                        <p class="mb-0">1305 Lexington Ave, New York</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <!--/ Developer Meetup -->
          </div>

          </div>
          <!-- / Content -->
          <!-- Footer -->
          <?php include 'include/footer.php'; ?>
          <!-- / Footer -->
        </div>
        <!-- Content wrapper -->