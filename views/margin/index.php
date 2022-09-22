<?php
/* @var $this yii\web\View */

use kartik\date\DatePicker;
$this->title = 'Margin';

$thisday = date('Y-m-d');

if(isset($_GET['start']) && isset($_GET['end'])){
    $thismonth = $_GET['end'];
    $monthbefore =  $_GET['start'];
}else{
    $start = date('Y-m') . '-26';
    if($thisday > $start){
        $monthbefore =  date('Y-m') . '-26';
        $thismonth = date('Y-m', strtotime('+1 month')) . '-26';
    }else{
        $monthbefore =  date('Y-m', strtotime('-1 month')) . '-26';
        $thismonth = date('Y-m') . '-26';
    }
}
?>
<div class="row p-2 bg-light">
<div class="col-md-6">
    <?php
    echo DatePicker::widget([
        //'options' => ['id' => 'datestart'],
        'name' => 'start',
        'value' => $monthbefore,
        'type' => DatePicker::TYPE_RANGE,
        //'options2' => ['id' => 'dateend'],
        'name2' => 'end',
        'value2' => $thismonth,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
</div>
<div class="col-md-6">
    <button id="startend" class="btn btn-sm btn-success"> Cari</button>
</div>
</div>

<div class="col-md-12">
    <div class="row">
        <h1><?php echo $this->title; ?></h1>
<?php
if(isset($_GET['start']) && isset($_GET['end'])){ ?>
        <table id="neraca" data-show-export="true" data-search="false" data-show-footer="true" data-show-columns="true" data-pagination="false" data-show-refresh="true" data-mobile-responsive="true" class="table table-striped table-sm table-hover" width="100%">
            <thead>
                <tr>
                    <th data-sortable="true" data-align="left" data-width="40" data-width-unit="%">Akun</th>
                    <th data-sortable="true" data-align="right" data-width="30" data-width-unit="%" data-formatter="priceFormatter" data-footer-formatter="num_ttl">Debit</th>
                    <th data-sortable="true" data-align="right" data-width="30" data-width-unit="%" data-formatter="priceFormatter" data-footer-formatter="num_ttl">Kredit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-weight-bold text-primary">
                        PENJUALAN
                    </td>
                    <td class="font-weight-bold text-primary">
                        <?php echo $akunPenjualan['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        STOK PEMBELIAN BERKURANG
                    </td>
                    <td>
                    </td>
                    <td>
                        <?php echo $akunPenjualanModal['subtotal']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        DISKON PENJUALAN
                    </td>
                    <td>
                    </td>
                    <td>
                        <?php echo $akunPenjualanDiskon['subtotal']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        ONGKIR PENJUALAN
                    </td>
                    <td>
                    </td>
                    <td>
                        <?php echo $akunPenjualanOngkir['subtotal']; ?>
                    </td>
                </tr>
                <!-- <tr>
                    <td>
                        FEE PENJUALAN
                    </td>
                    <td>
                        <?php //echo $akunPenjualanFee['subtotal']; ?>
                    </td>
                    <td>
                    </td>
                </tr> -->
                <tr>
                    <td>
                        GAJI KARYAWAN
                    </td>
                    <td>
                    </td>
                    <td>
                        <?php echo $Gaji; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        BEBAN OPERASIONAL
                    </td>
                    <td>
                    </td>
                    <td>
                        <?php echo $akunBeban['subtotal']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        PIUTANG
                    </td>
                    <td>
                        <?php echo $piutang; ?>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-success">
                        LABA PENJUALAN
                    </td>
                    <td>
                    </td>
                    <td class="font-weight-bold text-success">
                        <?php echo $pendapatan; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<script type="text/javascript">

	function priceFormatter(value) {
		var formatter = new Intl.NumberFormat('id-ID', {
		style: 'currency',
		currency: 'IDR',
		minimumFractionDigits: 0,
		});
		var num = formatter.format(value);
		return num;
	}
		
    function rupiah(value) {
        var	number_string = value.toString(),
        split	= number_string.split('.'),
        sisa 	= split[0].length % 3,
        rupiah 	= split[0].substr(0, sisa),
        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        
        return rupiah;
    }

    function num_ttl(data) {
        var total = 0;

        if (data.length > 0) {

            var field = this.field;

            total = data.reduce(function(sum, row) {
                return sum + (+row[field]);
            }, 0);

            var num = rupiah(total);

            return num;
        }

        return '';
    }

    $(document).ready(function() {
        $('#neraca').bootstrapTable({
            sortable: true,
            exportDataType: $(this).val(),
            exportTypes: [
                'csv',
                'excel',
                'pdf'
            ],
            formatLoadingMessage: function() {
                return '<div class="col" style="min-heigth:200px"><button class="font-italic btn btn-success" style="margin:2em auto;">Loading</button></div>';
            }
        });
        $('#startend').on('click', function(){
            var start = $("[name=start]").val();
            var end = $("[name=end]").val();

            location.replace('index.php?r=margin&start=' + start + '&end=' + end + '');
        });
    });
</script>