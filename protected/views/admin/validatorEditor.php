<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#validatorListContainer');
		listContainer.jtable({
			title: 'Список валидаторов',
			jqueryuiTheme: true,
			actions: {
				listAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/validatorList"); ?>',
				createAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveValidator"); ?>',
				updateAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveValidator"); ?>',
				deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteValidator"); ?>'
			},
			fields: {
				id: {
					key: true,
					list: false
				},
				title: {
					title: 'Заголовок',
					width: '70%'
				},
				attribute_id: {
					title: 'Зависимый атрибут',
					width: '30%',
					options: '<?php echo Yii::app()->createAbsoluteUrl("admin/getAttributeListInValidatorEditor"); ?>'
				}
			},
			formClosed :  function() {
				listContainer.jtable('reload');
			}
		});
		listContainer.jtable('load');
	});

</script>

<div id="validatorListContainer"></div>