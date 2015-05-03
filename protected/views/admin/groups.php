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
        $('#loadButton').click(function (e) {
            e.preventDefault();
            $('#groupListContainer').jtable('load', {
                title: $('#group_name').val()
            });
        });
	});

</script>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" onsubmit = "return false;">
            <div class="form-group col-xs-12">
                <label for="semesterFilter" class="col-xs-1">Группа</label>
                <div class = "col-xs-11">
                    <input type = "text" class="form-control input-sm" id = "group_name">
                </div>
            </div>
            <div class = "form-group col-xs-12">
                <div class ="pull-right" style = "padding-right: 15px;">
                    <button type="button" class="btn btn-primary" id = "loadButton">Выбрать</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="groupListContainer"></div>