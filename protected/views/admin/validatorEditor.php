<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#validatorListContainer');
		listContainer.jtable({
			title: 'Список валидаторов',
            sorting: true,
            paging: true,
            pageSize : 20,
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
					width: '25%',
                    sorting: true
				},
				attribute_id: {
					title: 'Зависимый атрибут',
					width: '20%',
                    sorting: true,
					options: '<?php echo Yii::app()->createAbsoluteUrl("admin/getAttributeListInValidatorEditor"); ?>'
				},
                user_state: {
                    title: 'User state',
                    width: '25%',
                    options : ["course", "role"]
                },
                message: {
                    title: 'Сообщение',
                    width: '30%'
                }
			},
			formClosed :  function() {
				listContainer.jtable('reload');
			}
		});
		listContainer.jtable('load');
	});

</script>
<?php
    //echo  Yii::app()->user->course;

?>
<div id="validatorListContainer"></div>