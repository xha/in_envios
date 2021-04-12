<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Conceptos */

$this->title = 'Crear Concepto';
$this->params['breadcrumbs'][] = ['label' => 'Conceptos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conceptos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
