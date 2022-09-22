
<?php

use app\models\Dopembelianv;
use app\models\MyFormatter;
use app\models\PenjualanT;
use app\models\Penjualanv;
use app\models\Stokterjualv;
use app\models\VariableT;

$this->title = 'Dashboard';


/////Grafik penjualan line
$y = date('Y');
//$modFgrafik = Penjualanv::find()->where('DATE_FORMAT(penjualan_tgl, "%Y") = "'.$y.'"')->groupBy('DATE_FORMAT(penjualan_tgl, "%Y-%m")')->asArray()->all();
$modFgrafik = (new \yii\db\Query())
->select([
'DATE_FORMAT(b.penjualan_tgl, "%M") AS mo',
'SUM(b.total_bayar) AS total'
])
->from('penjualanv b')
->groupBy('MONTH(b.penjualan_tgl)')
->orderBy('MONTH(b.penjualan_tgl) ASC')
->all();
$dataMoN=[];
$dataMoj=[];
if($modFgrafik != null){
    foreach($modFgrafik as $row){
        $dataMoN[] = $row['mo'];
        $dataMoj[] = (int) $row['total'];
    }

}

$dataMoN = json_encode($dataMoN);
$dataMoj = json_encode($dataMoj);

//////Donut
$m = date('Y-m');
$modDon = Stokterjualv::find()
->select('
nama AS brand,
SUM(penjualan_jml) AS jml
')
->where('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$m.'"')
->groupBy('nama')
->limit(10)
->orderBy('jml DESC')
->asArray()->all();
$dataDonutName=[];
$dataDonutQty=[];
if($modDon != null){
    foreach($modDon as $row){
        $dataDonutName[] = $row['brand'];
        $dataDonutQty[] = (int) $row['jml'];
    }
}

$dataDonutName = json_encode($dataDonutName);
$dataDonutQty = json_encode($dataDonutQty);

//Sales Rate
$modSR = Penjualanv::find()
->select('
sales,
COUNT(penjualan) AS jml
')
->where('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$m.'"')
->andWhere('total_bayar > 0 AND total_bayar = total_plus_ppn')
->groupBy('sales')
->asArray()->all();
$dataSRName=[];
$dataSRQty=[];
if($modSR != null){
    foreach($modSR as $row){
        $dataSRName[] = $row['sales'];
        $dataSRQty[] = (int) $row['jml'];
    }
}
$dataSRName = json_encode($dataSRName);
$dataSRQty = json_encode($dataSRQty);
?>
<div class="container-fluid p-4">

<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong><?php $modvar = VariableT::findOne(1); if($modvar != null){echo $modvar->detail; }else{ echo 'Sokomas Cell'; } ?> Analytics</strong> Dashboard</h3>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Sales</h5>
                            <?php $m = date('Y-m');
                            $mbe = date("Y-m-d",strtotime("-30 day"));
                            $mbefore = date('Y-m', strtotime($mbe));

                            $countSale = Penjualanv::find()->where('total_bayar > 0 AND total_bayar = total_plus_ppn')
                            ->andWhere('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$m.'"')
                            ->andWhere('penjualan_status <> "Batal"')
                            ->count();
                            $countSaleb = Penjualanv::find()->where('total_bayar > 0 AND total_bayar = total_plus_ppn')
                            ->andWhere('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$mbefore.'"')
                            ->andWhere('penjualan_status <> "Batal"')
                            ->count();
                            $compSale=0;
                            if($countSaleb < $countSale AND $countSale > 0){
                                $compSale = ($countSale - $countSaleb) / $countSale * 100;
                            }elseif($countSaleb > $countSale AND $countSale > 0){
                                $compSale = ($countSale - $countSaleb) / $countSale * 100;
                            }elseif($countSaleb > 0 AND $countSale == 0){
                                $compSale = 0;
                            }
                            $compSale = MyFormatter::formatNumberForPrint($compSale);
                            $sale = MyFormatter::formatNumberForPrint($countSale);
                            ?>
                            <h1 class="mt-1 mb-3"><?php echo $sale; ?></h1>
                            <div class="mb-1">
                                <?php if($compSale >0){ ?>
                                    <span class="text-success"> <i class="fas fa-angle-double-up"></i> <?php echo $compSale; ?>% </span>
                                <?php }else{ ?>
                                    <span class="text-danger"> <i class="fas fa-angle-double-down"></i> <?php echo $compSale; ?>% </span>
                                <?php } ?>
                                <span class="text-muted">Dari Bulan Lalu</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Nota Beli</h5>
                            <?php
                                $countB = Dopembelianv::find()->where('total_bayar > 0 AND total_bayar = total_plus_ppn')
                                ->where('DATE_FORMAT(do_tgl, "%Y-%m") = "'.$m.'"')
                                ->andWhere('do_status <> "Batal"')
                                ->count();
                                $countBb = Dopembelianv::find()->where('total_bayar > 0 AND total_bayar = total_plus_ppn')
                                ->where('DATE_FORMAT(do_tgl, "%Y-%m") = "'.$mbefore.'"')
                                ->andWhere('do_status <> "Batal"')
                                ->count();
                                $compB=0;
                                if($countBb < $countB AND $countB > 0){
                                    $compB = ($countB - $countBb) / $countB * 100;
                                }elseif($countBb > $countB AND $countB > 0){
                                    $compB = ($countB - $countBb) / $countB * 100;
                                }elseif($countBb > 0 AND $countB == 0){
                                    $compB = 0;
                                }
                                $compB = MyFormatter::formatNumberForPrint($compB);
                                $Buy = MyFormatter::formatNumberForPrint($countB);
                            ?>
                            <h1 class="mt-1 mb-3"><?php echo $Buy; ?></h1>
                            <div class="mb-1">
                                <?php if($compB >0){ ?>
                                    <span class="text-success"> <i class="fas fa-angle-double-up"></i> <?php echo $compB; ?>% </span>
                                <?php }else{ ?>
                                    <span class="text-danger"> <i class="fas fa-angle-double-down"></i> <?php echo $compB; ?>% </span>
                                <?php } ?>
                                <span class="text-muted">Dari Bulan Lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Gross Income</h5>
                            <?php
                                
                            $earn = Penjualanv::find()->select('SUM(total_bayar) AS ttl')->where('total_bayar > 0 AND total_bayar = total_plus_ppn')
                            ->andWhere('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$m.'"')
                            ->asArray()->one();
                            $earnb = Penjualanv::find()->select('SUM(total_bayar) AS ttl')->where('total_bayar > 0 AND total_bayar = total_plus_ppn')
                            ->andWhere('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$mbefore.'"')
                            ->asArray()->one();

                            //Piutang
                            $pt = Penjualanv::find()->select('SUM(total_plus_ppn - total_bayar) AS ttl')
                            ->where('DATE_FORMAT(penjualan_tgl, "%Y-%m") = "'.$m.'"')
                            ->andWhere('total_bayar < total_plus_ppn')
                            ->asArray()->one();

                            $compEarn=0;
                            if($earn != null){

                                if($earnb['ttl'] < $earn['ttl'] AND $earn['ttl'] > 0){
                                    $compEarn = ($earn['ttl'] - $earnb['ttl']) / $earn['ttl'] * 100;
                                }elseif($earnb['ttl'] > $earn['ttl'] AND $earn['ttl'] > 0){
                                    $compEarn = ($earn['ttl'] - $earnb['ttl']) / $earn['ttl'] * 100;
                                }elseif($earnb['ttl'] > 0 AND $earn['ttl'] == 0){
                                    $compEarn = 0;
                                }
                                $compEarn = MyFormatter::formatNumberForPrint((int) $compEarn);
                                $ttlearn = MyFormatter::formatNumberForPrint((int) $earn['ttl']);
                                $pt = MyFormatter::formatNumberForPrint((int) $pt['ttl']);
                            }else{
                                $compEarn = 0;
                                $ttlearn = 0;
                            }
                            ?>
                            <h1 class="mt-1 mb-3">Rp. <?php echo $ttlearn; ?></h1>
                            <div class="mb-1">
                                <?php if($compEarn >0){ ?>
                                    <span class="text-success"> <i class="fas fa-angle-double-up"></i> <?php echo $compEarn; ?>% </span>
                                <?php }else{ ?>
                                    <span class="text-danger"> <i class="fas fa-angle-double-down"></i> <?php echo $compEarn; ?>% </span>
                                <?php } ?>
                                <span class="text-muted">Dari Bulan Lalu</span><br>
                                <span class="text-danger">Piutang: Rp.  <?php echo $pt; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Orders</h5>
                            <?php
                                
                            $spends = Dopembelianv::find()->select('SUM(total_plus_ppn) AS ttl')
                            ->where('DATE_FORMAT(do_tgl, "%Y-%m") = "'.$m.'"')->asArray()->one();
                            $earnb = Dopembelianv::find()->select('SUM(total_plus_ppn) AS ttl')
                            ->where('DATE_FORMAT(do_tgl, "%Y-%m") = "'.$mbefore.'"')->asArray()->one();

                            //Hutang
                            $ht = Dopembelianv::find()->select('SUM(total_plus_ppn - total_bayar) AS ttl')
                            ->where('DATE_FORMAT(do_tgl, "%Y-%m") = "'.$m.'"')
                            ->andWhere('total_bayar < total_plus_ppn')
                            ->asArray()->one();

                            $compSpends=0;
                            if($spends != null){

                                if($earnb['ttl'] < $spends['ttl'] AND $spends['ttl'] > 0){
                                    $compSpends = ($spends['ttl'] - $earnb['ttl']) / $spends['ttl'] * 100;
                                }elseif($earnb['ttl'] > $spends['ttl'] AND $spends['ttl'] > 0){
                                    $compSpends = ($spends['ttl'] - $earnb['ttl']) / $spends['ttl'] * 100;
                                }elseif($earnb['ttl'] > 0 AND $spends['ttl'] == 0){
                                    $compSpends = 0;
                                }
                                $compSpends = MyFormatter::formatNumberForPrint((int) $compSpends);
                                $ttlspends = MyFormatter::formatNumberForPrint((int) $spends['ttl']);
                                $ht = MyFormatter::formatNumberForPrint((int) $ht['ttl']);
                            }else{
                                $compSpends = 0;
                                $ttlspends = 0;
                            }
                            ?>
                            <h1 class="mt-1 mb-3">Rp. <?php echo $ttlspends; ?></h1>
                            <div class="mb-1">
                                <?php if($compSpends >0){ ?>
                                    <span class="text-success"> <i class="fas fa-angle-double-up"></i> <?php echo $compSpends; ?>% </span>
                                <?php }else{ ?>
                                    <span class="text-danger"> <i class="fas fa-angle-double-down"></i> <?php echo $compSpends; ?>% </span>
                                <?php } ?>
                                <span class="text-muted">Dari Bulan Lalu</span><br>
                                <span class="text-danger">Invoice: Rp.  <?php echo $ht; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="card-title mb-0">Recent Movement</h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-sm">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="card-title mb-0">10 Top BRANDS Bulan ini</h5>
            </div>
            <div class="card-body d-flex">
                <div class="align-self-center w-100">
                    <div class="py-3">
                        <div class="chart chart-xs">
                            <canvas id="chartjs-dashboard-pie"></canvas>
                        </div>
                    </div>

                    <table class="table mb-0">
                        <tbody>
                            <?php
                                if($modDon != null){
                                    foreach($modDon as $row){
                                    echo '<tr>
                                        <td>'.$row['brand'].'</td>
                                        <td class="text-right">'.(int) $row['jml'].'</td>
                                    </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
        <div class="card flex-fill">
            <div class="card-header">

            <h5 class="card-title mb-0">Calendar</h5>
            </div>
            <div class="card-body d-flex">
                <div class="align-self-center w-100">
                    <div class="chart">
                        <div id="datetimepicker-dashboard"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
        <div class="card flex-fill">
            <div class="card-header">

                <h5 class="card-title mb-0">Penjualan Hari Ini <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d'), 9); ?></h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th class="d-none d-xl-table-cell">No.Penjualan</th>
                        <th class="d-none d-xl-table-cell">Tgl</th>
                        <th>Sales</th>
                        <th class="d-none d-md-table-cell">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $tm = date('Y-m-d');
                        $modLastP = Penjualanv::find()->where('DATE_FORMAT(penjualan_tgl, "%Y-%m-%d") = "'.$tm.'"')->andWhere('total_bayar > 0')->orderBy('penjualan_tgl DESC')->limit(10)->asArray()->all();
                                    //var_dump($modLastP);die;
                        if($modLastP != null){
                            foreach($modLastP as $row){
                                echo '<tr>
                                    <td>'.$row['faktur'].'</td>
                                    <td>'.$row['penjualan_tgl'].'</td>
                                    <td>'.$row['sales'].'</td>
                                    <td>Rp. '.MyFormatter::formatNumberForPrint($row['total_bayar']).'</td>
                                </tr>';
                            }
                        }else{
                            echo '<tr><td colspan="4">Belum Ada transaksi<td></tr>';
                        }
                        
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="card-title mb-0"> Sales Rate</h5>
            </div>
            <div class="card-body d-flex w-100">
                <div class="align-self-center chart chart-lg">
                    <canvas id="chartjs-dashboard-bar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var inst = document.getElementById("datetimepicker-dashboard").flatpickr({
            inline: true,
            prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",
            nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",
            onChange: function (selectedDates, date_str, instance) {
            //console.log('selectedDates::')
            console.log(selectedDates) //valid
            },
            /* onMonthChange: function (selectedDates, date_str, instance) {
                console.log(selectedDates) //valid
            } */
        });
        //$('#datetimepicker-dashboard')on.
    });
</script>
<script>
    //GRAFIK GARIS PENJUALAN
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: <?php echo $dataMoN; ?>,
                datasets: [{
                    label: "Sales (Rp. )",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: <?php echo $dataMoj; ?>
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false,
                    callbacks: {
                        label: function(tooltipItem, chart){
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp ' + Intl.NumberFormat('ID').format(tooltipItem.yLabel, 2);
                        }
                    }
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 200000000,
                            callback: function(value, index, values) {
                                return 'Rp ' + Intl.NumberFormat('ID').format(value);
                            }
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: <?php echo $dataDonutName; ?>,
                datasets: [{
                    data: <?php echo $dataDonutQty; ?>,
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 75
            }
        });
    });
</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: "bar",
				data: {
					labels: <?php echo $dataSRName; ?>,
					datasets: [{
						label: "Bulan ini",
						backgroundColor: [
                            window.theme.primary,
                            window.theme.warning,
                            window.theme.danger,
                            window.theme.info,
                            window.theme.success,
                            window.theme.secondary
                        ],
						borderColor: [
                            window.theme.primary,
                            window.theme.warning,
                            window.theme.danger,
                            window.theme.info,
                            window.theme.success,
                            window.theme.secondary
                        ],
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: <?php echo $dataSRQty; ?>,
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>