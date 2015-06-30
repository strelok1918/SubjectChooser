<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#attributeListContainer');
		listContainer.jtable({
			title: 'Список атрибутов',
            sorting: true,
            paging: true,
            pageSize : 20,
			actions: {
				listAction: '<?php echo Yii::app()->createAbsoluteUrl("list/attributeList"); ?>',
				createAction: '<?php echo Yii::app()->createAbsoluteUrl("ajax/saveAttribute"); ?>',
				updateAction: '<?php echo Yii::app()->createAbsoluteUrl("ajax/saveAttribute"); ?>',
				deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("ajax/deleteAttribute"); ?>'
			},
			fields: {
				id: {
					key: true,
					list: false
				},
				title: {
					title: 'Заголовок',
                    sorting: true,
					width: '80%'
				},
				type: {
					title: 'Тип',
					width: '20%',
                    sorting: false,
                    options : {'text' : 'Текст'}
                },
                is_visible: {
                    title: 'Видимый',
                    width: '20%',
                    sorting: false,
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