<?php

namespace app\controllers;

use app\models\AkunSaldoT;
use yii;
use app\models\BackendUser;
use app\models\Dopembelianv;
use app\models\DoProdukT;
use app\models\Penjualanv;
use app\models\SBackendUser;
use app\models\Stokterjualv;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\widgets\ActiveForm;

/**
 * NeracaController implements the CRUD actions for NeracaController model.
 */
class NeracaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    public function actionIndex()
    {
        $this->layout = 'kosong';
        if(isset($_GET['start']) && isset($_GET['end'])){

            //D KAS
            $akunsaldomasuk = AkunSaldoT::find()->select('SUM(jml) AS total_saldo_add')->where(['aktiva' => 1])
            ->andWhere("datetime BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
    
            //D PRIVE
            $akunsaldokeluar = AkunSaldoT::find()->select('SUM(jml) AS total_saldo_keluar')->where(['aktiva' => 2])
            ->andWhere("datetime BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
    
            //D GAJI
            $akunGaji = AkunSaldoT::find()->select('SUM(jml) AS subtotal')->where(['beban' => 33])
            ->andWhere("datetime BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->groupBy('beban')
            ->asArray()->one();
            //var_dump($akunGaji);die;
            if($akunGaji != NULL){
                $Gaji = (int) $akunGaji['subtotal'];
            }else{
                $Gaji = 0;
            }
    
            //D STOK PEMBELIAN BERKURANG
            $akunPenjualanModal = Stokterjualv::find()
            ->select('SUM(penjualan_jml*do_harga) AS subtotal')
            ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
            /* $akunPenjualanModal = PenjualanProdukStepT::find()
            ->select('SUM(penjualan_produk_step.bahan_gudang_jml_out*pembelian_bahan.pembelian_harga) AS subtotal')
            ->join('LEFT JOIN', 'pembelian_bahan', 'penjualan_produk_step.pembelian_bahan = pembelian_bahan.pembelian_bahan')
            ->where('gudang_date LIKE "%'.$m.'%"')
            ->asArray()->one(); */
    
            //D BEBAN
            $akunBeban = AkunSaldoT::find()->select('SUM(jml) AS subtotal')->where(['aktiva' => 13])
            ->andWhere("beban <> 33 AND datetime BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
    
            //K PEMBELIAN
            $akunPembelian = Dopembelianv::find()
            ->select('SUM(total_plus_ppn) AS subtotal')
            ->where("do_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();

            //PERSEDIAAN
            $akunPersediaan = DoProdukT::find()
            ->select('SUM(jml_now*do_harga) AS subtotal')
            ->where('jml_now > 0 AND do_produk_status <> 2')
            ->asArray()->one();

            /* $akunPembelian = PembelianBahan::find()
            ->select('SUM(pembelian_bahan.pembelian_jml*pembelian_bahan.pembelian_harga) AS subtotal')
            ->join('LEFT JOIN', 'pembelian', 'pembelian_bahan.pembelian = pembelian.pembelian')
            ->where('pembelian.pembelian_status = "Lunas" AND pembelian_bahan.pembelian_bahan_date LIKE "%'.$m.'%"')
            ->asArray()->one(); */
    
            //K PEMBELIAN FOR HUTANG
            $akunPembelianfh = Dopembelianv::find()
            ->select('SUM(total_plus_ppn) AS subtotal')
            ->where("do_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
            /* $akunPembelianfh = PembelianBahan::find()
            ->select('SUM(pembelian_bahan.pembelian_jml*pembelian_bahan.pembelian_harga) AS subtotal')
            ->where('pembelian_bahan.pembelian_bahan_date LIKE "%'.$m.'%"')
            ->asArray()->one(); */
    
            //D HUTANG
            $akunBayarH = AkunSaldoT::find()->select('SUM(jml) AS subtotal')->where(['aktiva' => 12])
            ->andWhere("datetime BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
            /* $akunBayarH = AkunLog::find()
            ->select('SUM(akun_log.jml) AS subtotal')
            ->where('akun_log.inorout IN ("Cicil", "Pembelian") AND akun_log.tgl LIKE "%'.$m.'%"')
            ->asArray()->one(); */
            if((int) $akunPembelianfh['subtotal'] > 0){
                $hutang = (int) $akunPembelianfh['subtotal'] - (int) $akunBayarH['subtotal'];
            }else{
                $hutang = (int) $akunPembelianfh['subtotal'];
            }
            
    
            //K PENJUALAN
            $akunPenjualan = Penjualanv::find()
            ->select('SUM(total_plus_ppn) AS subtotal')
            ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
            /* $akunPenjualan = PenjualanProduk::find()
            ->select('SUM(penjualan_produk.penjualan_jml*penjualan_produk.penjualan_harga) AS subtotal')
            ->where('penjualan_produk.timestamp LIKE "%'.$m.'%"')
            ->asArray()->one(); */
    
            //K DISKON PENJUALAN
            $akunPenjualanDiskon = Penjualanv::find()
            ->select('SUM(penjualan_diskon) AS subtotal')
            ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
    
            //K ONGKIR PENJUALAN
            $akunPenjualanOngkir = Penjualanv::find()
            ->select('SUM(penjualan_ongkir) AS subtotal')
            ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
    
            //K FEE PENJUALAN
            /* $akunPenjualanFee = Penjualan::find()
            ->select('SUM(fee) AS subtotal')
            ->where('penjualan_tgl LIKE "%'.$m.'%"')
            ->asArray()->one(); */
    
            //K Piutang
            $akunBayar = Penjualanv::find()
            ->select('SUM(total_bayar) AS subtotal')
            ->where("penjualan_tgl BETWEEN '".$_GET['start']."' AND '".$_GET['end']."'")
            ->asArray()->one();
            $piutang = $akunPenjualan['subtotal']-$akunBayar['subtotal'];
    
            //K PIUTANG PENJUALAN
            /* $modPiutang = (new \yii\db\Query())
            ->select([
                'SUM(akun_log.jml) AS subtotal'
                ])
            ->from('akun_log')
            ->join('LEFT JOIN', 'produk', 'penjualan_produk.produk = produk.produk')
            ->join('LEFT JOIN', 'penjualan', 'penjualan_produk.penjualan = penjualan.penjualan')
            ->join('LEFT JOIN', 'akun_log', 'penjualan.akun = akun_log.akun')
            ->where('WHERE akun_log.inorout IN ("dp", "penjualan") AND akun_log.tgl LIKE "%'.$m.'%"')
            ->all(); */
    
            $x = $akunPenjualan['subtotal'] - $akunPenjualanModal['subtotal'];
            $pendapatan = $x;

            //KREDIT
            $total_kredit =  
            //Diskon penjualan
            $akunPenjualanDiskon['subtotal'] + 
            //ongkir penjualan
            $akunPenjualanOngkir['subtotal'] +
            //penjualan
            //$akunPenjualanModal['subtotal'] +
            //hutang
            $hutang +
            //pendapatan penjualan
            $pendapatan +
            //bayar hurang pembelian
            $akunBayarH['subtotal'];
    
            //DEBIT
            $total_debit = 
            //kas
            $akunsaldomasuk['total_saldo_add'] +
            //piutang
            $piutang + 
            //prive
            $akunsaldokeluar['total_saldo_keluar'] +
            //persediaan
            $akunPersediaan['subtotal'] +
            //beban
            $akunBeban['subtotal'] +
            //beban gaji
            $Gaji +
            //penjualan
            $akunPenjualan['subtotal'];

            //MODAL ON KREDIT PART
            $res = $total_debit - $total_kredit;
    
            if($res > 0){
                $modal = $res;
            }else{
                $modal = 0;
            }


            return $this->render('index',[
                'akunPersediaan' => $akunPersediaan,
                'akunsaldomasuk' => $akunsaldomasuk,
                'akunsaldokeluar' => $akunsaldokeluar,
                'akunPenjualan' => $akunPenjualan,
                'akunBayarH' => $akunBayarH,
                'akunPembelian' => $akunPembelian,
                'akunPenjualanModal' => $akunPenjualanModal,
                'Gaji' => $Gaji,
                'akunBeban' => $akunBeban,
                'modal' => $modal,
                'pendapatan' => $pendapatan,
                'piutang' => $piutang,
                'hutang' => $hutang,
                'akunPenjualanDiskon' => $akunPenjualanDiskon,
                'akunPenjualanOngkir' => $akunPenjualanOngkir,
                //'akunPenjualanFee' => $akunPenjualanFee
            ]);
        }
        return $this->render('index');
        //echo json_encode($akunPenjualan);die;
    }

}
