<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

 Modal::begin([
    "header" => "<h3><i class='fa fa-check'></i> Leyenda para Asunto o Cuerpo</h3>",
    'id' => 'modal_leyenda',
]);

echo "<div class='row' style='max-height: 600px; overflow: auto; width: 100%'>
        <div class='col-sm-12'>
			<p>Estos deben estar entre # ya sea dentro del asunto o el cuerpo del correo, menos ITEMS ya que despliega una tabla de los item del Documento<br />Ej: <b>#NUMERO#</b></p>
        </div>
        <div class='col-sm-12'>
			<table class='table table-bordered table-striped'>
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Descripción</th>
					</tr>
				</thead>	
				<tbody>
					<tr>
						<td>NUMERO</td>
						<td>Imprime el Número de Documento</td>
					</tr>
					<tr>
						<td>NROCONTROL</td>
						<td>Imprime el Número de Control (si lo tiene)</td>
					</tr>
					<tr>
						<td>TIPO</td>
						<td>Imprime el Tipo de Documento</td>
					</tr>
					<tr>
						<td>TOTAL</td>
						<td>Imprime el Monto total del documento</td>
					</tr>
					<tr>
						<td>EXENTO</td>
						<td>Imprime el Exento</td>
					</tr>
					<tr>
						<td>GRAVABLE</td>
						<td>Imprime el Gravable</td>
					</tr>
					<tr>
						<td>IMPUESTO</td>
						<td>Imprime el Impuesto Global</td>
					</tr>
					<tr>
						<td>RIFCLIENTE</td>
						<td>Imprime el Rif del Cliente</td>
					</tr>
					<tr>
						<td>NOMBRECLIENTE</td>
						<td>Imprime la razón social del cliente</td>
					</tr>
					<tr>
						<td>ITEMS</td>
						<td>Imprime una tabla con todos los items del documento</td>
					</tr>
				</tbody>				
			</table>
        </div>
        <div class='col-sm-12 text-right'>
            <a onclick=\"$('#modal_leyenda').modal('hide');\" href='javascript:void(0)' class='btn btn-default'>
                <i class='fa fa-undo'></i>
                Salir
            </a>
        </div>
    </div>";

Modal::end();
?>

<div class="conceptos-form">

    <?php $form = ActiveForm::begin(); ?>

    <center>
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Crear' : '<i class="fa fa-save"></i> Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </center>

    <div class="row">
    	<div class="col-sm-12">
	    	<?= $form->field($model, 'descripcion')->textInput(['maxlength' => 200]) ?>
	    </div>
	    <div class="col-sm-4">
	    	<?= $form->field($model, 'letra')->dropDownList(['A' => 'FACTURA', 'B' => 'DEV. DE FACTURA', 'C' => 'NOTA DE ENTREGA', 'D' => 'DEV. NOTA ENTREGA', 'E' => 'PEDIDO', 'F' => 'PRESUPUESTO']); ?>
	    </div>
	    <div class="col-sm-4">
	    	<?= $form->field($model, 'activo')->dropDownList(['1' => 'SI', '0' => 'NO']); ?>		
	    </div>
	    <div class="col-sm-4 text-center">
	    	<label>&nbsp;</label><br />
            <label class='btn btn-primary' data-toggle="modal" data-target="#modal_leyenda">
                <i class='fa fa-check'></i>
                Leyenda
            </label >
	    </div>
	    <div class="col-sm-12">
	    	<?= $form->field($model, 'texto')->widget(\yii\redactor\widgets\Redactor::className(),
			[
			   'clientOptions' => [
			       'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
			   ],
			]
			); ?>		
	    </div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
