<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

	<?php use yii\helpers\Html; ?>

	<?php echo Html::a('Create New Business Trip', array('trips/save'), array('class' => 'btn btn-primary pull-right')); ?>
	<div class="clearfix"></div>
	<hr/>
	<table class="table table-striped table-hover">
		<tr>
			<td>#</td>
			<td>Title</td>
			<td>Content</td>
			<td>Begin At</td>
			<td>End At</td>
			<td>Created</td>
			<td>Updated</td>
			<td>Options</td>
		</tr>
		<?php foreach ($models as $businessTrip): ?>
			<tr>
				<td>
					<?php echo Html::a($businessTrip->id, array('trips/save', 'id' => $businessTrip->id)); ?>
				</td>
				<td><?php echo Html::a($businessTrip->title, array('trips/save', 'id' => $businessTrip->id)); ?></td>
				<td><?php echo Html::a($businessTrip->content, array('trips/save', 'id' => $businessTrip->id)); ?></td>
				<td><?php echo $businessTrip->begin_at ? date('m/d/Y H:i', strtotime($businessTrip->begin_at)) : ''; ?></td>
				<td><?php echo $businessTrip->end_at ? date('m/d/Y H:i', strtotime($businessTrip->end_at)) : ''; ?></td>
				<td><?php echo date('m/d/Y H:i', strtotime($businessTrip->created_at)); ?></td>
				<td><?php echo $businessTrip->updated_at ? date('m/d/Y H:i', strtotime($businessTrip->updated_at)) : ''; ?></td>
				<td>
					<?php echo Html::a('update', array('trips/save', 'id' => $businessTrip->id)); ?>
					<?php echo Html::a('delete', array('trips/delete', 'id' => $businessTrip->id)); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

</div>
