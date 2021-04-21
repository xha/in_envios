<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Usuario;
use app\models\Rol;
use app\models\SAVEND;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */

$this->title = 'Activar usuario';

$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/general.js');
$this->registerCssFile('@web/css/general.css');
?>

<h3 id="msj_principal"><?= $msg ?></h3>

<div class="activar-form">

	<?php $form = ActiveForm::begin(); ?>

    <label>Usuario</label><br /><br />
    <?= $form->field($model, 'usuario')->label(false)->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => $data,
                'minLength'=>'3', 
            ],
            'class'=>'form-control',
        ]) 
    ?>

    <?= $form->field($model, 'id_rol')->dropDownList(ArrayHelper::map(Rol::find()->where(['activo' => '1'])->OrderBy('descripcion')->all(), 'id_rol', 'descripcion')); ?>
    
    <?= $form->field($model, 'CodVend')->dropDownList(ArrayHelper::map(SAVEND::find()->where(['activo' => '1'])->OrderBy('Descrip')->all(), 'CodVend', 'CodVend', 'Descrip'), ['class' => 'form-control']) ?>

    <?= $form->field($model, 'activado')->dropDownList(['1' => 'SI', '0' => 'NO']); ?>

    <?= $form->field($model, 'reseteo')->checkbox(); ?><br /><br />

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Actualizar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>    

    <?php ActiveForm::end(); ?>
    
    <table class="tablas inicial00" id="listado_detalle"></table>
</div>
<script type="text/javascript">
    $(function() {
        buscar_usuarios();
        var msj_principal = $('#msj_principal')[0].innerHTML;
        if (msj_principal!="") {
            if (msj_principal!="Registro Actualizado") {
                oculta_mensaje('msj_principal',msj_principal,-1);
            } else {
                oculta_mensaje('msj_principal',msj_principal,1);
            }
        }        
    });
    function titulo_usuario() {
        var arreglo = new Array();
            arreglo[0] = 'Usuario';
            arreglo[1] = 'Cédula';
            arreglo[2] = 'Nombre';
            arreglo[3] = 'Vendedor';
            arreglo[4] = 'Rol';
            arreglo[5] = 'Estatus';

        var tabla = document.getElementById('listado_detalle');
            tabla.innerHTML = "";

        tabla.appendChild(add_filas(arreglo, 'th','','',5));
    }
    
    function buscar_usuarios() {
        var tabla = trae('listado_detalle');
        var i;
        
        tabla.innerHTML = "";
        $.getJSON('busca-usuarios',{},function(data){
            var campos = Array();

            if (data!="") {
                titulo_usuario();
                for (i = 0; i < data.length; i++) {
                    campos.length = 0;
                    campos.push(data[i].usuario);
                    campos.push(data[i].cedula);
                    campos.push(data[i].nombre);
                    campos.push(data[i].ubicacion);
                    campos.push(data[i].rol);
                    campos.push(data[i].activo);

                    tabla.appendChild(add_filas(campos, 'td','','',5));
                }
            }
        });
    }
</script>