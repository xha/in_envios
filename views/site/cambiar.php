<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Usuario;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */

$this->title = 'Cambiar Clave';

$this->params['breadcrumbs'][] = $this->title;
$id_usuario = Yii::$app->user->identity->id_usuario;
$this->registerJsFile('../../../frontend/web/general.js');
$this->registerCssFile('../../../frontend/web/css/general.css');
?>
<?= ercling\pace\PaceWidget::widget(); ?>
<div id="msj_principal"><h3><?= $msg ?></h3></div>

<div class="cambiar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->hiddenInput(['value' => $id_usuario])->label(false) ?>
    
    <?= $form->field($model, 'clave_actual')->textInput(['maxlength' => true, 'type' => 'password']) ?>
    
    <?= $form->field($model, 'clave')->textInput(['maxlength' => true, 'type' => 'password']) ?>

    <?= $form->field($model, 'repetir_clave')->textInput(['maxlength' => true, 'type' => 'password']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Actualizar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>    

    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    window.onload = function() {
        var msj_principal = trae('msj_principal').innerHTML;
        if (msj_principal!="Registro Actualizado") {
            oculta_mensaje('msj_principal',msj_principal,-1);
        } else {
            oculta_mensaje('msj_principal',msj_principal,1);
        }
    };
</script>