<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

	<?php use yii\helpers\Html; ?>

	<?php echo Html::a('Create New User', array('site/save'), array('class' => 'btn btn-primary pull-right')); ?>
	<div class="clearfix"></div>
	<hr/>
	<table class="table table-striped table-hover">
		<tr>
			<td>#</td>
			<td>Username</td>
			<td>Created</td>
			<td>Updated</td>
			<td>Options</td>
		</tr>
		<?php foreach ($models as $user): ?>
			<tr>
				<td>
					<?php echo Html::a($user->id, array('site/save', 'id' => $user->id)); ?>
				</td>
				<td><?php echo Html::a($user->username, array('site/save', 'id' => $user->id)); ?></td>
				<td><?php echo date('m/d/Y H:i', strtotime($user->created_at)); ?></td>
				<td><?php echo $user->updated_at ? date('m/d/Y H:i', strtotime($user->updated_at)) : ''; ?></td>
				<td>
					<?php echo Html::a('update', array('site/save', 'id' => $user->id)); ?>
					<?php echo Html::a('delete', array('site/delete', 'id' => $user->id)); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

</div>
