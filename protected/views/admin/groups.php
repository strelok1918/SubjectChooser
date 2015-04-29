<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#groupListContainer');
		listContainer.jtable({
			title: 'Список групп',
            sorting: true,
            paging: true,
            pageSize : 20,
			actions: {
				listAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/groupList"); ?>',
				createAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveGroupData"); ?>',
				updateAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveGroupData"); ?>',
				deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteGroup"); ?>'
			},
			fields: {
				id: {
					key: true,
					list: false
				},
				title: {
					title: 'Название',
				}

			},
			formClosed :  function() {
				listContainer.jtable('reload');
			}
		});
		listContainer.jtable('load');
	});

</script>

<div id="groupListContainer"></div>