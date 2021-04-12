<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CuentasBancarias */

$this->title = 'Crear Cuenta Bancaria';
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Bancarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuentas-bancarias-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
