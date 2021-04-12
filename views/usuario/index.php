<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <center>
        <?= Html::a('<i class="fa fa-plus"></i> Crear Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </center>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model->activo == 0) return ['style' => 'background-color: #FADCAC'];
        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id_usuario',
            'usuario',
            'correo',
            'cedula',
            //'clave',
            'nombre',
            'apellido',
            // 'sexo',
            // 'respuesta_seguridad',
            // 'fecha_registro',
            // 'telefono',
            'activo:boolean',
            // 'id_rol',
            // 'id_pregunta',
            // 'id_cliente',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
