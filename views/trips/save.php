<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal', 'role' => 'form'),
)); ?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<?= Yii::$app->session->getFlash('success') ?>
	</div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
	<div class="alert alert-danger alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<?= Yii::$app->session->getFlash('error') ?>
	</div>
<?php endif; ?>
<div class="form-group">
	<?php echo $form->field($model, 'title')->textInput(array('class' => 'form-control')); ?>
</div>
<div class="form-group">
	<?php echo $form->field($model, 'content')->textarea(array('class' => 'form-control')); ?>
</div>
<div class="form-group">
	<?php echo $form->field($model, 'services')->checkboxList(ArrayHelper::map($services, 'id', 'name')); ?>
	<?php foreach ($businesTripsServices as $businesTripsService): ?>
		<div id="service_<?php echo $businesTripsService->service_id ?>" <?php if ($model->countBusinesTripsServiceServices($businesTripsService->service_id) == 0) : ?>
			style="display:none"
		<?php endif; ?>>
			<label>
				<?php echo "Услуга: " . $businesTripsService->service->name; ?>
			</label>
			<div class="form-group">
				<?php echo $form->field($businesTripsService, 'choosen[' . $businesTripsService->service_id . ']')
					->textInput(array('class' => 'form-control', 'value' => $businesTripsService->choosen)); ?>
			</div>
			<div class="form-group">
				<?php echo $form->field($businesTripsService, 'begin_at[' . $businesTripsService->service_id . ']')
					->textInput(array('class' => 'form-control', 'value' => $businesTripsService->begin_at)); ?>
			</div>
			<div class="form-group">
				<?php echo $form->field($businesTripsService, 'end_at[' . $businesTripsService->service_id . ']')
					->textInput(array('class' => 'form-control', 'value' => $businesTripsService->end_at)); ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<div class="form-group">
	<?php echo($model->isNewRecord
		? $form->field($model, 'users')->checkboxList(ArrayHelper::map($users, 'id', 'username'))
		: "Users: " . implode(', ', $model->users)); ?>
</div>
<?php echo Html::submitButton('Submit', array('class' => 'btn btn-primary pull-right')); ?>
<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
    $('#businesstrips-services').find(':checkbox').each(function(){
        console.log($(this));
        $(this).click(function(){
            $('#service_'+$(this).val()).toggle(this.checked);
		}); 
    });
JS;
$this->registerJs($script);
?>
