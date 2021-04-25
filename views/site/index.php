<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\SAVEND;

$this->title = '';
$this->registerCssFile('@web/css/general.css');
$this->registerJsFile('@web/general.js');
$this->registerJsFile('@web/js/jquery.inputmask.js');
$this->registerJsFile('@web/js/inputmask.js');
$this->registerCssFile('@web/css/general.css');
date_default_timezone_set("America/Caracas");
$fecha= time();
$fecha_2=date('d-m-Y',time());
$fecha_inicial = date("Y-m-d",strtotime($fecha_2."- 12 month"));
$fecha_final = date("Y-m-d",strtotime($fecha_2."+ 12 month"));
$fecha=date('Ymd h:m:s',$fecha);

if (Yii::$app->user->isGuest) {
    echo "<div class='central2'>
                <aside class='main-aside2'>
                    <div class='stroke2 titulo_core'>
                        Envio de correos
                    </div>
                </aside>
            </div>";
} else {
    $rol = Yii::$app->user->identity->id_rol;
    $CodVend = Yii::$app->user->identity->CodVend;
?>
<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        table.dataTable thead {
            background-color:#3C8DBC;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php $form = ActiveForm::begin(["id" => "FormIM"]); ?>
    <div class="row">
        <div class='col-sm-3'>
            <label>Ubicación</label><br /><br />
            <?php 
                if ($rol=="3") {
                    echo $form->field($model, 'CodVend')->dropDownList(ArrayHelper::map(SAVEND::find()->where(['activo' => '1'])->OrderBy('Descrip')->all(), 'CodVend', 'CodVend', 'Descrip'), ['class' => 'form-control', 'prompt'=>'Todas'])->label(false);
                } else {
                    echo $form->field($model, 'CodVend')->dropDownList(ArrayHelper::map(SAVEND::find()->where(['activo' => '1', 'CodVend' => $CodVend])->OrderBy('Descrip')->all(), 'CodVend', 'CodVend', 'Descrip'), ['class' => 'form-control'])->label(false);
                }
            ?>
        </div>
        <div class="col-sm-3">
            <label>Fecha desde</label><br /><br />
            <?= $form->field($model, 'fecha_desde')->widget(DatePicker::classname(), [
                'language' => 'es',
                'removeButton'=>false,
                'options' => ['class' => 'form-control fecha', 'onKeyPress' => 'solo_enteros(event)'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-mm-yyyy',
                ]
            ])->label(false);
        ?>
        </div>
        <div class="col-sm-3">
            <label>Fecha hasta</label><br /><br />
            <?= $form->field($model, 'fecha_hasta')->widget(DatePicker::classname(), [
                'language' => 'es',
                'removeButton'=>false,
                'options' => ['class' => 'form-control fecha', 'onKeyPress' => 'solo_enteros(event)'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-mm-yyyy',
                ]
            ])->label(false);
        ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'letra')->dropDownList(['A' => 'FACTURA', 'B' => 'NOTA DE CREDITO', 'C' => 'NOTA DE ENTREGA', 'D' => 'DEV. NOTA ENTREGA', 'E' => 'PEDIDO', 'F' => 'PRESUPUESTO']); ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'asunto')->textInput(['maxlength' => true, 'placeholder' => 'Dejar en blanco para colocar el asunto por defecto']); ?>
        </div>
    </div>
    <div class="row my-2">
        <div class="col-sm-3">
            <label class="btn btn-primary" onclick="buscar_datos()">
                <i class="fa fa-search"></i>
                Vista Previa
            </label>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-success" type="submit">
                <i class="fa fa-cogs"></i>
                Procesar envío de correo
            </button>
        </div>
        <div class="col-sm-5"></div>
        <div class="col-sm-1">
            <img id='img_busqueda' style='visibility: hidden' src='../web/img/preloader.gif' />
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div id="mensaje" class="text-danger"><?php print_r($mensaje) ?></div>
    <br />
    <div class="mt-2" width="98%" id="div_table" style="visibility: hidden">
        <table class="table table-stripd table-bordered" id="tabla"></table>
    </div>
</body>
</html>
<script type="text/javascript">
    $(function () {
        $(".fecha").inputmask('99/99/9999', { numericInput: true });
    });

    function buscar_datos() {
        let fecha_desde = $("#site-fecha_desde").val();
        let fecha_hasta = $("#site-fecha_hasta").val();
        let letra = $("#site-letra").val();
        let codvend = $("#site-codvend").val();
        let img = $('#img_busqueda')[0];
        let div_table = $('#div_table')[0];
        let tabla = $("#tabla")[0];
        tabla.innerHTML = "";

        div_table.style.visibility = "visible";
        img.style.visibility = "visible";
        if ((fecha_desde!="") && (fecha_hasta)) {
            $.getJSON('site/busca-datos',{fecha_desde : fecha_desde, fecha_hasta : fecha_hasta, letra: letra, codvend : codvend},function(data){
                var campos = Array();
                if (data!="") {
                    $("#tabla").html("");
                    $("#tabla").DataTable({
                        destroy: true,
                        data: data,
                        columns: [
                            { data: "NumeroD", title: "Factura" },
                            { data: "CodClie", title: "Rif" },
                            { data: "Descrip", title: "Cliente" },
                            { data: "Email", title: "Correo" },
                            { data: "Fecha_Despacho", title: "Fecha" },
                            { data: "Vendedor", title: "Ubicación" },
                            { data: "Notas1", title: "Concepto" },
                            {
                                render: function (data, type, row) { 
                                    var total = Intl.NumberFormat().format(row.MtoTotal);
                                    return total; 
                                }, title: "Total"
                            },
                            {
                                render: function (data, type, row) { 
                                    return '<a class="btn btn-info" title="Ver" href="#" onclick="abrir_factura('+row.NroUnico+')" ><i class="fa fa-eye"></i></a>'; 
                                }, title: "Sel"
                            },
                        ]
                    });
                }
                img.style.visibility = "hidden";
            });
        }        
    }

    function abrir_factura(nro) {
        window.open("site/imprime-detallado?nro="+nro,'_blank','');
    }
</script>
<?php 
    };
?>