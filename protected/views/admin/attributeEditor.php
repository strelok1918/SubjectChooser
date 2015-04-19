<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#attributeListContainer');
		listContainer.jtable({
			title: 'Список атрибутов',
			actions: {
				listAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/attributeList"); ?>',
				createAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveAttribute"); ?>',
				updateAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveAttribute"); ?>',
				deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteAttribute"); ?>'
			},
			fields: {
				id: {
					key: true,
					list: false
				},
				title: {
					title: 'Заголовок',
					width: '80%'
				},
				type: {
					title: 'Тип',
					width: '20%',
					options: '<?php echo Yii::app()->createAbsoluteUrl("admin/getDataTypeList"); ?>'
                },
                is_visible: {
                    title: 'Видимый',
                    width: '20%',
                    options : {'0' : 'No', '1' : 'Yes'}
                }
			},
			formClosed :  function() {
				listContainer.jtable('reload');
			}
		});
		listContainer.jtable('load');
	});

</script>

<div id="attributeListContainer"></div>