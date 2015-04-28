<script type="text/javascript">
	$(document).ready(function () {
		var listContainer = $('#attributeListContainer');
		listContainer.jtable({
			title: 'Список пользователей',
            sorting: true,

            actions: {
				listAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/userList"); ?>',
				createAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveUserData"); ?>',
				updateAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/saveUserData"); ?>',
				deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteUser"); ?>'
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
									actions: {
										listAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/userSubjectList", array('userId' => '')); ?>' + studentData.record.id,
										deleteAction: "<?php echo Yii::app()->createAbsoluteURL('admin/dismissChoose', array('userId' => '')); ?>" + studentData.record.id,
										updateAction: "<?php echo Yii::app()->createAbsoluteURL('admin/saveChoose', array('userId' => '')); ?>" + studentData.record.id,
										createAction: "<?php echo Yii::app()->createAbsoluteURL('admin/saveChoose', array('userId' => '')); ?>" + studentData.record.id
									},
									fields: {
										id: {
											key: true,
											list: false
										},
										object_id: {
											title: 'Название предмета',
											options : '<?php echo Yii::app()->createAbsoluteUrl("admin/subjectListOptions"); ?>'
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
					options: '<?php echo Yii::app()->createAbsoluteUrl("admin/getGroupList"); ?>',
                    sorting: false
				},
				acquisition_year: {
					title: 'Год поступления',
					list: false
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
	});

</script>

<div id="attributeListContainer"></div>