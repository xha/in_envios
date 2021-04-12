<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\AccessHelpers;
use app\models\Usuario;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\RecuperarClaveForm;
use app\models\ActivarForm;
use app\models\CambiarClaveForm;
use app\models\Site;
use app\models\CorreosProcesados;
use app\models\CuentasBancarias;
use app\models\Bancos;
use app\models\Conceptos;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\Json;
Use app\itbz\fpdf\src\fpdf\fpdf;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['site-index'],
                'rules' => [
                    [
                        'actions' => ['site-index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['site-logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        return AccessHelpers::chequeo();
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Site;
        $mensaje = "";
        $connection = \Yii::$app->db;

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate()) {
                date_default_timezone_set('America/Caracas');
                $c_correo = 'xhambler84@gmail.com';
                $correo = array();
                $extra = "";
                if ($model->CodVend!="") $extra = " and f.CodVend='".$model->CodVend."'";
                $arr1 = explode("/",$model->fecha_desde);
                $arr2 = explode("/",$model->fecha_hasta);
                $fecha_desde = $arr1[2].$arr1[1].$arr1[0]. " 00:00:00";
                $fecha_hasta = $arr2[2].$arr2[1].$arr2[0]. " 23:59:00";
                $falsos = "";
                $correos_errados = "";
                $contador = 0;
                
                $query = "SELECT *,i.Email,CONVERT(VARCHAR(10), f.FechaE, 105) as Fecha_Despacho,CONVERT(VARCHAR(10), f.FechaV, 105) as Fecha_Vencimiento, v.Descrip as Vendedor
                        from SAFACT f, SACLIE i, SAVEND v
                        WHERE f.TipoFac='".$model->letra."' and i.CodClie=f.CodClie and f.FechaE Between '$fecha_desde' and '$fecha_hasta' and f.CodVend=v.CodVend $extra
                        and F.NumeroD Not in (select NumeroD From ISAL_CorreosProcesados WHERE fecha between '$fecha_desde' and '$fecha_hasta' and TipoFac='".$model->letra."')";
                $safact = $connection->createCommand($query)->queryAll();
                $total_correos = count($safact);

                $query2 = "SELECT Descrip,Direc1,Direc2,RIF,Telef,Email,Factor from SACONF";
                $emp = $connection->createCommand($query2)->queryOne();

                for ($i=0;$i < $total_correos;$i++) {
                    $model_correos = new CorreosProcesados();
                    $total_faltante = $total_correos - $contador;
                
                    if (strlen($safact[$i]['Email']) > 1) {
                        $queryc = "SELECT * from ISAL_Conceptos WHERE letra='".$model->letra."'";
                        $concepto = $connection->createCommand($queryc)->queryOne();
                        if (trim($model->asunto)!=="") {
                            $titulo = $model->asunto;
                        } else {
                            $titulo = $concepto["descripcion"];
                        }                        

                        $tipo_factura = "";
                        switch($model->letra) {
                            case "A":
                                $titulo = "FACTURA";
                            break;
                            case "B":
                                $titulo = "DEV. DE FACTURA";
                            break;
                            case "C":
                                $titulo = "NOTA DE ENTREGA";
                            break;
                            case "D":
                                $titulo = "DEV. NOTA ENTREGA";
                            break;
                            case "E":
                                $titulo = "PEDIDO";
                            break;
                            case "F":
                                $titulo = "PRESUPUESTO";
                            break;
                        }

                        if ($model->letra=='A') {
                            $pdf = new \fpdf\FPDF('L','mm','Letter');
                            $pdf->SetAutoPageBreak(false,35);
                            $pdf->AddPage();
                            $logo = "img/logo.jpg";
                            $pdf->Image($logo,15,5,26,15);
                            $yactual = $pdf->getY();
                            $pdf->SetX(50);
                            /****************************************** ENCABEZADO ***********************************************************************/
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(180,6,utf8_decode($emp["Direc1"]),0,0,'C');
                            $pdf->Cell(40,6,'RIF: '.$emp["RIF"],0,1,'L');
                            $pdf->SetX(50);
                            $pdf->Cell(180,6,utf8_decode($emp["Direc2"]),0,0,'C');
                            $pdf->Cell(40,6,'FORMA LIBRE',0,1,'L');
                            $pdf->SetX(50);
                            $pdf->Cell(180,6,$emp["Email"],0,0,'C');
                            $pdf->Cell(40,6,'No. DE CONTROL:',0,1,'L');
                            $pdf->SetX(180);
                            $pdf->Cell(40,6,$safact[$i]['NroCtrol'],0,1,'L');
                            
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,"Fecha:",0,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(80,6,$safact[$i]["Fecha_Despacho"],0,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(90,6,"No. FACTURA",0,0,'R');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(40,6,$safact[$i]["NumeroD"],0,1,'L');

                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,"Cliente:",0,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(80,6,utf8_decode($safact[$i]["Descrip"]),0,0,'L');
                            if ($safact[$i]["CancelA"] > 0) {
                                $cond = "CONTADO";
                            } else {                
                                $cond = "CRÉDITO";
                            }
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(90,6,utf8_decode("Condición de pago:"),0,0,'R');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(40,6,utf8_decode($cond),0,1,'L');

                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,"R.I.F.:",0,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(80,6,$safact[$i]["ID3"],0,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(90,6,"Fecha de Vencimiento",0,0,'R');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(40,6,$safact[$i]["Fecha_Vencimiento"],0,1,'L');

                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,utf8_decode("Dirección:"),0,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(80,6,utf8_decode($safact[$i]["Direc1"]),0,1,'L');
                            $pdf->Cell(40,6,"",0,0,'C');
                            $pdf->Cell(80,6,utf8_decode($safact[$i]["Direc2"]),0,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(90,6,"Forma de Pago:",0,0,'R');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(40,6,"",0,1,'L');

                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,utf8_decode("Teléfono:"),0,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(80,6,utf8_decode($safact[$i]["Telef"]),0,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(90,6,"Vendedor:",0,0,'R');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(40,6,$safact[$i]["Vendedor"],0,1,'L');

                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,utf8_decode("Contacto:"),0,0,'C');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(80,6,"",0,1,'L');
                            
                            $pdf->SetFillColor(192,192,192); //Gris
                            $pdf->Cell(25,6,utf8_decode('Código'),1,0,'C');
                            $pdf->Cell(70,6,utf8_decode('Descripción'),1,0,'C');
                            $pdf->Cell(25,6,'Marca',1,0,'C');
                            $pdf->Cell(25,6,'Unidad',1,0,'C');
                            $pdf->Cell(30,6,'Cantidad',1,0,'C');
                            $pdf->Cell(30,6,'Precio Unit.',1,0,'C');
                            $pdf->Cell(15,6,'% Alic.',1,0,'C');
                            $pdf->Cell(35,6,'Total',1,1,'C');
                            $pdf->SetFillColor(255,255,255);

                            /****************************************** DETALLE ***********************************************************************/
                            $query_rep = "select * FROM SAITEMFAC i, SAPROD p WHERE i.TipoFac='".$safact[$i]["TipoFac"]."' and i.NumeroD='".$safact[$i]["NumeroD"]."' and i.CodItem=p.CodProd";
                            $repuesto = $connection->createCommand($query_rep)->queryAll();
                            $conteo= count($repuesto);
                            $y=0;
                            while ($y<$conteo) {
                                $pdf->Cell(25,6,$repuesto[$y]['CodItem'],0,0,'C');
                                $descrip = substr(utf8_decode($repuesto[$y]['Descrip1']).utf8_decode($repuesto[$y]['Descrip2']).utf8_decode($repuesto[$y]['Descrip3']), 0, 60);
                                $pdf->Cell(70,6,$descrip,0,0,'L');
                                $pdf->Cell(25,6,$repuesto[$y]['Marca'],0,0,'C');
                                $pdf->Cell(25,6,$repuesto[$y]['Unidad'],0,0,'C');
                                $pdf->Cell(30,6,number_format($repuesto[$y]['Cantidad'], 2, '.', ','),0,0,'R');
                                $pdf->Cell(30,6,number_format($repuesto[$y]['Precio'], 2, '.', ','),0,0,'R');
                                if ($repuesto[$y]['MtoTax'] > 0) {
                                    $yva = "16";
                                } else {
                                    $yva = "";
                                }
                                $pdf->Cell(15,6,$yva,0,0,'R');
                                $pdf->Cell(35,6,number_format($repuesto[$y]['TotalItem'], 2, '.', ','),0,1,'R');
                                $y++;
                            }

                            $pdf->setY(170);
                            $pdf->Cell(160,6,utf8_decode("Observación: Para ser pagado según el tipo de cambio publicado por BCV"),1,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,"",0,0,'L');
                            $pdf->Cell(20,6,utf8_decode("B. Imponible"),0,0,'L');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(30,6,number_format($safact[$i]['TGravable'], 2, '.', ','),0,1,'R');

                            $pdf->Cell(160,6,"Tipo de Cambio: Bs/USD ".$safact[$i]["Factor"]."    Fecha Valor: ".$safact[$i]["Fecha_Despacho"],1,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,"",0,0,'L');
                            $pdf->Cell(20,6,utf8_decode("Descuento"),0,0,'L');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(30,6,number_format($safact[$i]['DesctoP'], 2, '.', ','),0,1,'R');

                            if ($safact[$i]["Factor"]==0) $safact[$i]["Factor"] = 1;
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,utf8_decode("B. Imponible $"),1,0,'C');
                            $pdf->Cell(40,6,utf8_decode("Exento $"),1,0,'C');
                            $pdf->Cell(40,6,utf8_decode("I.V.A. 16% $"),1,0,'C');
                            $pdf->Cell(40,6,utf8_decode("Total a Pagar $"),1,0,'C');
                            $pdf->Cell(40,6,"",0,0,'L');
                            $pdf->Cell(20,6,utf8_decode("Exento"),0,0,'L');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(30,6,number_format($safact[$i]['TExento'], 2, '.', ','),0,1,'R');

                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,number_format($safact[$i]['TGravable']/$safact[$i]["Factor"], 2, '.', ','),1,0,'R');
                            $pdf->Cell(40,6,number_format($safact[$i]['TExento']/$safact[$i]["Factor"], 2, '.', ','),1,0,'R');
                            $pdf->Cell(40,6,number_format($safact[$i]['MtoTax']/$safact[$i]["Factor"], 2, '.', ','),1,0,'R');
                            $pdf->Cell(40,6,number_format($safact[$i]['MtoTotal']/$safact[$i]["Factor"], 2, '.', ','),1,0,'R');
                            $pdf->Cell(40,6,"",0,0,'L');
                            $pdf->Cell(20,6,utf8_decode("I.V.A. 16%"),0,0,'L');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(30,6,number_format($safact[$i]['MtoTax'], 2, '.', ','),0,1,'R');

                            $pdf->Cell(160,6,"",0,0,'L');
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(40,6,"",0,0,'L');
                            $pdf->Cell(20,6,utf8_decode("Total a Pagar"),0,0,'L');
                            $pdf->SetFont('Arial','',9);
                            $pdf->Cell(30,6,number_format($safact[$i]['MtoTotal'], 2, '.', ','),0,1,'R');

                            $pdf->Footer(200);
                            $filename="assets/".date('His',time()).".pdf";
                            $pdf->Output($filename,'F');
                            exit;
                        }
                        
                        $content = $concepto["texto"];
                        $content = str_replace("#NUMERO#", "<b>".$safact[$i]['NumeroD']."</b>", $content);
                        $content = str_replace("#NROCONTROL#", "<b>".$safact[$i]['NroCtrol']."</b>", $content);
                        $content = str_replace("#TIPO#", "<b>".$tipo_factura."</b>", $content);
                        $content = str_replace("#TOTAL#", "<b>".number_format($safact[$i]['MtoTotal'], 2, '.', ',')."</b>", $content);
                        $content = str_replace("#EXENTO#", "<b>".number_format($safact[$i]['TExento'], 2, '.', ',')."</b>", $content);
                        $content = str_replace("#GRAVABLE#", "<b>".number_format($safact[$i]['TGravable'], 2, '.', ',')."</b>", $content);
                        $content = str_replace("#IMPUESTO#", "<b>".number_format($safact[$i]['MtoTax'], 2, '.', ',')."</b>", $content);
                        $pos = strpos($content, "#ITEMS#");
                        $content = str_replace("#ITEMS#", "", $content);
                        if ($pos) {
                            $query2 = "SELECT i.CodItem,i.Precio,i.Descrip1,i.Descrip2,i.TotalItem,t.MtoTax as Tasa, i.MtoTax as Impuesto
                                from SAITEMFAC i 
                                left join SATAXITF t on i.NumeroD=t.NumeroD and i.TipoFac=t.TipoFac and i.NroLinea=t.NroLinea
                                WHERE i.TipoFac='".$model->letra."' and i.NumeroD='".$safact[$i]['NumeroD']."'";
                            $saitemfac = $connection->createCommand($query2)->queryAll();
                            $content.="
                                    <table border='1' width='100%' cellpadding='0' cellspacing='0'>
                                      <thead>
                                        <tr style='font-weight: bold'>
                                            <td width='13%' align='center'>Código</td>
                                            <td colspan='3' align='center'>Descripción</td>
                                            <td width='13%' align='center'>Precio</td>
                                            <td width='13%' align='center'>IVA %</td>
                                            <td width='13%' align='center'>Monto</td>
                                        </tr>
                                      <thead>
                                    <tbody>";
                            for ($y=0;$y < count($saitemfac);$y++) {
                                $content.="
                                    <tr>
                                        <td>".$saitemfac[$y]['CodItem']."</td>
                                        <td colspan='3'>".$saitemfac[$y]['Descrip1'].$saitemfac[$y]['Descrip2']."</td>
                                        <td align='right'>".number_format($saitemfac[$y]['Precio'], 2, '.', ',')."</td>
                                        <td align='right'>".number_format($saitemfac[$y]['Tasa'], 2, '.', ',')."</td>
                                        <td align='right'>".number_format($saitemfac[$y]['TotalItem'], 2, '.', ',')."</td>
                                    </tr>";
                            }
                            $content.= "</tbody>
                                        <tfoot>
                                        <tr style='font-weight: bold'>
                                            <td align='center'>Sub-Total</td>
                                            <td align='center'>B. Imponible</td>
                                            <td align='center'>Exento</td>
                                            <td align='center'>IVA</td>
                                            <td align='center'>Monto Factura</td>
                                            <td align='center'>Total a Pagar</td>
                                            <td align='center'>Cancelado</td>
                                        </tr>
                                        <tr>
                                            <td align='right'>".number_format($safact[$i]['Monto'], 2, '.', ',')."</td>
                                            <td align='right'>".number_format($safact[$i]['TGravable'], 2, '.', ',')."</td>
                                            <td align='right'>".number_format($safact[$i]['TExento'], 2, '.', ',')."</td>
                                            <td align='right'>".number_format($safact[$i]['MtoTax'], 2, '.', ',')."</td>
                                            <td align='right'>".number_format($safact[$i]['MtoTotal'], 2, '.', ',')."</td>
                                            <td align='right'>".number_format($safact[$i]['MtoTotal'], 2, '.', ',')."</td>
                                            <td align='right'>".number_format($safact[$i]['CancelA'], 2, '.', ',')."</td>
                                        </tr>
                                        </tfoot>
                                        </table>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td colspan='4'>
                                                Observación<br />

                                            </td>
                                        </tr>
                                    </table>";
                        }

                        $transaction = $connection->beginTransaction();
                        try {
                            if ($model->letra=='A') {
                                Yii::$app -> mailer -> compose()
                                -> setFrom($c_correo)
                                -> setTo($safact[$i]['Email'])
                                -> setAttachment($filename)
                                -> setSubject($titulo)
                                -> setHtmlBody($content)
                                -> send();
                            } else {
                                Yii::$app -> mailer -> compose()
                                -> setFrom($c_correo)
                                -> setTo($safact[$i]['Email'])
                                -> setSubject($titulo)
                                -> setHtmlBody($content)
                                -> send();    
                            }                            

                            $transaction->commit();
                            @unlink($filename);
                        } catch (\Exception $msg) {
                            $transaction->rollBack();
                            $mensaje = "<p><h3 class='text-danger'>Error: El correo cerró la conexion.</h3></br />
                                        Documentos en Total: <b>$total_correos</b>
                                        <br />Cliente con correos vacios: <b>$falsos</b>
                                        <br />Correos Enviados: <b>$contador</b>
                                        <br />Documentos Faltantes: <b>$total_faltante</b></p><br /><br />
                                        <h4>Favor volver a ejecutar el proceso</h4>";
                            //$mensaje = $msg;
                            goto salto;
                        }

                        $content = "";
                        $model_correos->id_usuario = Yii::$app->user->identity->id_usuario;
                        $model_correos->fecha = $model->fecha_desde;
                        $model_correos->TipoFac = $safact[$i]['TipoFac'];
                        $model_correos->NumeroD = $safact[$i]['NumeroD'];
                        $model_correos->correo = $safact[$i]['Email'];
                        $model_correos->CodClie = $safact[$i]['CodClie'];

                        $model_correos->save();
                        $contador++;
                    } else {
                        $falsos.= $safact[$i]['CodClie'].", ";
                    }                        
                }

                $mensaje = "<p><h3>Proceso Concluido, se enviaron: $contador correos</h3> <br /><br />Cliente con correos vacios: $falsos</p>";
            } else {
                $mensaje = "<h3>Error en los campos</h3>";
            }
        }

    salto:
        return $this->render('index', [
            'model' => $model,
            'mensaje' => $mensaje,
        ]);  
    }
    
    public function actionPermiso()
    {
        return $this->render('permiso');
    }

    public function actionReporteEnviados()
    {
        $model = new Site;

        return $this->render('reporteEnviados', [
            'model' => $model,
        ]);  
    }

    public function actionReporteCorreos()
    {
        $model = new Site;

        return $this->render('reporteCorreos');  
    }

    public function actionImprimeDetallado($nro)
    {
        $connection = \Yii::$app->db;
        $query = "SELECT *,i.Email,CONVERT(VARCHAR(10), f.FechaE, 105) as Fecha_Despacho,f.CodVend as Vendedor
                from SAFACT f, SACLIE i WHERE i.CodClie=f.CodClie and NroUnico=".$nro;
        $safact = $connection->createCommand($query)->queryOne();

        $query2 = "SELECT Descrip from SACONF";
        $emp = $connection->createCommand($query2)->queryOne();

        $content = "<h3><b>".$emp["Descrip"]."</b></h3>
                <table border='0' class='table table-striped table-bordered' class='font-size: 32px'>
                    <tr>
                        <td width='7%' align='left'><b>Cliente: </b></td>
                        <td align='left' width='60%'>".$safact['Descrip']."</td>
                        <td align='right'><b>No. : </b></td>
                        <td align='left' width='7%'>".$safact['NumeroD']."</td>
                    </tr>
                    <tr>
                        <td align='left'><b>R.I.F. </b></td>
                        <td align='left' colspan='3'>".$safact['CodClie']."</td>
                    </tr>
                    <tr>
                        <td><b>Dirección: </b></td>
                        <td>".$safact['Direc1'].$safact['Direc2']."</td>
                        <td align='right'><b>Emisión: </b></td>
                        <td>".$safact['Fecha_Despacho']."</td>
                    </tr>
                    <tr>
                        <td colspan='4'>
                            <table border='1' width='100%' cellpadding='0' cellspacing='0'>
                              <thead>
                                <tr style='font-weight: bold'>
                                    <td width='13%' align='center'>Código</td>
                                    <td colspan='3' align='center'>Descripción</td>
                                    <td width='13%' align='center'>Precio</td>
                                    <td width='13%' align='center'>IVA %</td>
                                    <td width='13%' align='center'>Monto</td>
                                </tr>
                              <thead>
                              <tbody>";

        $query2 = "SELECT i.CodItem,i.Precio,i.Descrip1,i.Descrip2,i.TotalItem,t.MtoTax as Tasa, i.MtoTax as Impuesto
            from SAITEMFAC i 
            left join SATAXITF t on i.NumeroD=t.NumeroD and i.TipoFac=t.TipoFac and i.NroLinea=t.NroLinea
            WHERE i.TipoFac='".$safact['TipoFac']."' and i.NumeroD='".$safact['NumeroD']."'";
        $saitemfac = $connection->createCommand($query2)->queryAll();
        for ($y=0;$y < count($saitemfac);$y++) {
            $content.="<tr>
                    <td>".$saitemfac[$y]['CodItem']."</td>
                    <td colspan='3'>".$saitemfac[$y]['Descrip1'].$saitemfac[$y]['Descrip2']."</td>
                    <td align='right'>".number_format($saitemfac[$y]['Precio'], 2, '.', ',')."</td>
                    <td align='right'>".number_format($saitemfac[$y]['Tasa'], 2, '.', ',')."</td>
                    <td align='right'>".number_format($saitemfac[$y]['TotalItem'], 2, '.', ',')."</td>
                </tr>";
        }
        $content.= "</tbody>
                    <tfoot>
                    <tr style='font-weight: bold'>
                        <td align='center'>Sub-Total</td>
                        <td align='center'>B. Imponible</td>
                        <td align='center'>Exento</td>
                        <td align='center'>IVA</td>
                        <td align='center'>Monto Factura</td>
                        <td align='center'>Total a Pagar</td>
                        <td align='center'>Cancelado</td>
                    </tr>
                    <tr>
                        <td align='right'>".number_format($safact['Monto'], 2, '.', ',')."</td>
                        <td align='right'>".number_format($safact['TGravable'], 2, '.', ',')."</td>
                        <td align='right'>".number_format($safact['TExento'], 2, '.', ',')."</td>
                        <td align='right'>".number_format($safact['MtoTax'], 2, '.', ',')."</td>
                        <td align='right'>".number_format($safact['MtoTotal'], 2, '.', ',')."</td>
                        <td align='right'>".number_format($safact['MtoTotal'], 2, '.', ',')."</td>
                        <td align='right'>".number_format($safact['CancelA'], 2, '.', ',')."</td>
                    </tr>
                    </tfoot>
                    </table>
                    </td>
                    </tr>
                    <tr>
                        <td colspan='4'>
                            Observación<br />

                        </td>
                    </tr>
                </table>";

        return $content;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegister() {
        $model = new RegisterForm;
           
        $msg = null;
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate()) {
                //Preparamos la consulta para guardar el usuario
                $table = new Usuario;
                $table->usuario = $model->usuario;
                $table->correo = $model->correo;
                $table->cedula = $model->cedula;
                $table->nombre = $model->nombre;
                $table->apellido = $model->apellido;
                $table->sexo = $model->sexo;
                $table->telefono = $model->telefono;
                $table->id_rol = 1;
                $table->id_pregunta = $model->id_pregunta;
                $table->respuesta_seguridad = $model->respuesta_seguridad;
                $table->CodUbic = $model->CodUbic;
                $table->activo = 0;
                $table->clave = md5("is".$model->clave);
                
                //Si el registro es guardado correctamente
                //print_r($table->getErrors());die;
                if ($table->insert(false))
                {
                    $msg = "Registro Guardado, Debe esperar que un administrador active su cuenta";
                }
                else
                {
                    $msg = "Error al guardar";
                }
            } else {
                $model->getErrors();
            }
          }

        return $this->render('register', [
            'model' => $model,
            'msg' => $msg
        ]);  
    }
    
    public function actionCambiar() {
        $model = new CambiarClaveForm;
           
        $msg = null;
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate()) {
                //Preparamos la consulta para guardar el usuario
                $table = new Usuario;
                $table->id_usuario = $model->id_usuario;
                $table->clave = md5("is".$model->clave);
                $table->clave_actual = md5("is".$model->clave_actual);
                
                $connection = \Yii::$app->db;

                $query = "UPDATE ISAL_usuario
                SET clave='".$table->clave."'
                OUTPUT INSERTED.clave
                where id_usuario='".$table->id_usuario."' and clave='".$table->clave_actual."'";
                $salida = $connection->createCommand($query)->queryOne();
        
                if ($salida['clave']!="") {
                    $msg = "Registro Actualizado";
                } else {
                    $msg = "Error al actualizar la clave";
                }
                
            } else {
                $model->getErrors();
            }
          }

        return $this->render('cambiar', [
            'model' => $model,
            'msg' => $msg
        ]);  
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRecuperar()
    {
        $model = new RecuperarClaveForm;
           
        $msg = null;
        
        if ($model->load(Yii::$app->request->post()))
        {
            $clave = md5("is".$model->clave);
            $connection = \Yii::$app->db;

            $query = "UPDATE ISAL_usuario
            SET clave='$clave'
            where usuario='".$model->usuario."' and id_pregunta=".$model->id_pregunta." and respuesta_seguridad='".$model->respuesta_seguridad."' and correo='".$model->correo."'";
            $msg = $connection->createCommand($query)->execute();
            
            if ($msg > 0) {
                $msg = "Registro Actualizado";
            } else {
                $msg = "Error al Actualizar";
            };
        }

        return $this->render('recuperar', [
            'model' => $model,
            'msg' => $msg
        ]);
    }

    public function actionActivar()
    {
        $model = new ActivarForm;
        $connection = \Yii::$app->db;
        $msg = null;
        $data = array();
        
        $query = "SELECT usuario FROM ISAL_USUARIO";
        $data1 = $connection->createCommand($query)->queryAll();

        for($i=0;$i<count($data1);$i++) {
            $data[]= $data1[$i]['usuario'];
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $extra="";
            if ($model->reseteo==1) {
                $extra = md5("is123456");
                $extra = ",clave='".$extra."'";
            }

            $query = "UPDATE ISAL_USUARIO
            SET id_rol=".$model->id_rol.", CodUbic='".$model->CodUbic."', activo=".$model->activado." $extra
            where usuario='".$model->usuario."'";
            
            $msg = $connection->createCommand($query)->execute();
            
            if ($msg > 0) {
                $msg = "Registro Actualizado";
            } else {
                $msg = "Error al Actualizar";
            };
        }
        
        return $this->render('activar', [
            'model' => $model,
            'msg' => $msg,
            'data' => $data
        ]);
    }
    
    public function actionBuscaUsuarios() {
        $connection = \Yii::$app->db;
        
        $query = "select u.usuario, u.cedula, CONCAT(u.apellido,', ',u.nombre) as nombre,d.Descrip as ubicacion, r.descripcion as rol, u.activo
            from ISAL_Usuario u, SAVEND d, ISAL_Rol r
            WHERE u.CodVend=d.CodVend and r.id_rol=u.id_rol
            ORDER BY ubicacion,nombre";

        $pendientes = $connection->createCommand($query)->queryAll();
        //$pendientes = $comand->readAll();
        return Json::encode($pendientes);
    }

    public function actionBuscaCuentas($codigo) {
        $connection = \Yii::$app->db;
        
        $query = "SELECT NoCuenta FROM SBBANC 
            WHERE NoCuenta like '%".$codigo."%'
            ORDER BY NoCuenta";

        $pendientes = $connection->createCommand($query)->queryAll();
        //$pendientes = $comand->readAll();
        return Json::encode($pendientes);
    }

    function actionBuscaDatos($fecha_desde,$fecha_hasta,$letra,$codvend = "") {
        $connection = \Yii::$app->db;
        $extra = "";
        if ($codvend!="") $extra = " and f.CodVend='".$codvend."'";
        $arr1 = explode("/",$fecha_desde);
        $arr2 = explode("/",$fecha_hasta);
        $fecha_desde = $arr1[2].$arr1[1].$arr1[0]. " 00:00:00";
        $fecha_hasta = $arr2[2].$arr2[1].$arr2[0]. " 23:59:00";
        $falsos = "";
        $correos_errados = "";
        $contador = 0;
        
        $query = "SELECT *,i.Email,CONVERT(VARCHAR(10), f.FechaE, 105) as Fecha_Despacho,f.CodVend as Vendedor
                from SAFACT f, SACLIE i WHERE f.TipoFac='$letra' and i.CodClie=f.CodClie and f.FechaE Between '$fecha_desde' and '$fecha_hasta' $extra
                and F.NumeroD Not in (select NumeroD From ISAL_CorreosProcesados WHERE fecha between '$fecha_desde' and '$fecha_hasta')";
        $safact = $connection->createCommand($query)->queryAll();
        
        return Json::encode($safact);
    }   

    function actionBuscaEnviados($fecha_desde,$fecha_hasta,$tipo) {
        $connection = \Yii::$app->db;
        $extra = "";

        $arr1 = explode("/",$fecha_desde);
        $arr2 = explode("/",$fecha_hasta);
        $fecha_desde = $arr1[2].$arr1[1].$arr1[0];
        $fecha_hasta = $arr2[2].$arr2[1].$arr2[0];
        $falsos = "";
        $correos_errados = "";
        $contador = 0;
        
        $query = "SELECT *
                from ISAL_CorreosProcesados 
                WHERE TipoFac='$tipo' and fecha Between '$fecha_desde' and '$fecha_hasta'";
        $safact = $connection->createCommand($query)->queryAll();
        
        return Json::encode($safact);
    }

    function actionBuscaNocorreos() {
        $connection = \Yii::$app->db;

        $query = "SELECT *
                from SACLIE 
                WHERE Email is null OR Email=''";
        $safact = $connection->createCommand($query)->queryAll();
        
        return Json::encode($safact);
    }
}
