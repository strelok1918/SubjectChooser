<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#studentListContainer');
		listContainer.jtable({
			title: 'Список пользователей',
            sorting: true,
            paging: true,
            pageSize : 20,
            actions: {
				listAction: '<?php echo Yii::app()->createAbsoluteUrl("list/userList"); ?>',
				createAction: '<?php echo Yii::app()->createAbsoluteUrl("ajax/saveUserData"); ?>',
				updateAction: '<?php echo Yii::app()->createAbsoluteUrl("ajax/saveUserData"); ?>',
				deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("ajax/deleteUser"); ?>'
			},
			fields: {
				id: {
					key: true,
					list: false
				},
				Exams: {
					title: '',
					width: '5%',
					sorting: false,
					edit: false,
					create: false,
					display: function (studentData) {
						var $img = $('<span class = "glyphicon glyphicon-th-list"></span>');
						$img.click(function () {
							listContainer.jtable('openChildTable',
								$img.closest('tr'),
								{
									title: 'Список предметов',
                                    sorting: true,
									actions: {
										listAction: '<?php echo Yii::app()->createAbsoluteUrl("list/userSubjectList", array('userId' => '')); ?>' + studentData.record.id,
										deleteAction: "<?php echo Yii::app()->createAbsoluteURL('ajax/dismissChoose', array('userId' => '')); ?>" + studentData.record.id,
										updateAction: "<?php echo Yii::app()->createAbsoluteURL('ajax/saveChoose', array('userId' => '')); ?>" + studentData.record.id,
										createAction: "<?php echo Yii::app()->createAbsoluteURL('ajax/saveChoose', array('userId' => '')); ?>" + studentData.record.id
									},
									fields: {
										id: {
											key: true,
											list: false
										},
										object_id: {
											title: 'Название предмета',
											options : '<?php echo Yii::app()->createAbsoluteUrl("list/subjectListOptions"); ?>'
										},
										year: {
											title: 'Год'
										},
										semester: {
											title: 'Семестр',
											options : ['1', '2']
										},
										student_id: {
											type: 'hidden'
										}
									}
								}, function (data) { //opened handler
									data.childTable.jtable('load');
								});
						});
						return $img;
					}
				},
				login: {
					title: 'Логин'
				},
				first_name: {
					title: 'Имя'
				},
				second_name: {
					title: 'Фамилия'
				},
				mail: {
					title: 'E-Mail'
				},
				group: {
					title: 'Группа',
					options: '<?php echo Yii::app()->createAbsoluteUrl("list/groupListOptions"); ?>',
                    sorting: false
				},
                role: {
                    title: 'Роль',
                    options : {'User' : 'Студент', 'Admin' : 'Администратор', 'Moderator' : 'Преподаватель'},
                    sorting: false
                },
				password: {
					title : 'Пароль',
					list: false
				}
			},
			formClosed :  function() {
				listContainer.jtable('reload');
			}
		});
		listContainer.jtable('load');
        $('#loadButton').click(function (e) {
            e.preventDefault();
            $('#studentListContainer').jtable('load', {
                first_name: $('#first_name').val(),
                second_name: $('#second_name').val(),
                login: $('#login').val(),
                mail: $('#mail').val(),

            });
        });
        $('#expandFilter').click(function(){
            $('#filterBlock').toggle(200, null);
            $('#expandFilter').toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
        });
        $('#filterBlock').hide();
	});

</script>

<div class="panel panel-default">
    <div class="panel-heading">Фильтр<span id = "expandFilter" class="glyphicon glyphicon-chevron-down pull-right" style = "margin-top:5px;cursor: pointer;"></span></div>
    <div class="panel-body" id = "filterBlock">
        <form class="form-horizontal" onsubmit = "return false;">


            <div class="form-group col-xs-12">
                <label for="semesterFilter" class="col-xs-1">Имя</label>
                <div class = "col-xs-11">
                    <input type = "text" class="form-control input-sm" id = "first_name">
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label for="semesterFilter" class="col-xs-1">Фамилия</label>
                <div class = "col-xs-11">
                    <input type = "text"  class="form-control input-sm" id = "second_name">
                </div>
            </div>
            <div class = "clearfix"></div>
            <div class="form-group col-xs-12">
                <label for="groupFilter" class="col-xs-1">Логин</label>
                <div class = "col-xs-11">
                    <input type = "text" class="form-control input-sm" id = "login">
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label for="groupFilter" class="col-xs-1">E-Mail</label>
                <div class = "col-xs-11">
                    <input type = "text" class="form-control input-sm" id = "mail">
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
<div id="studentListContainer"></div>