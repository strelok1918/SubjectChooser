<script type="text/javascript">
    $(document).ready(function () {

        var listContainer = $('#subjectListContainer');
        listContainer.jtable({
            title: 'Список дисциплин',
            sorting: true,
            actions: {
                createAction : function(data) {
                    console.log("create");
                    return false;
                },
                listAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/fullSubjectList"); ?>',
                deleteAction: '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteSubject"); ?>'
            },
            fields: {
                id: {
                    key: true,
                    list: false
                },
                title: {
                    title: 'Название',
                    width: '97%'
                },
                editColumn: {
                    title: '',
                    edit: false,
                    sorting: false,
//                    width: '1%',
                    display: function (data) {
                        var editPageLink = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject', array('id' => '')); ?>" + data.record.id;
                        return '<a href= "' + editPageLink + '"><img src="/plugins/jtable/themes/lightcolor/edit.png" /></a>';
                    }
                }

            },
            formClosed :  function() {
                listContainer.jtable('reload');
            }
        });
        listContainer.jtable('load');
        $(".jtable-toolbar-item-add-record").on("click",
            function(event){
                //$(".ui-dialog-content").dialog('close');
                console.log(event);
                event.preventDefault();
                event.stopPropagation();

                //location.href = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject'); ?>";
                return false;
            }
        );
    });

</script>

<div id="subjectListContainer"></div>

<!--script>
	$(document).ready(function(){
		SubjectMenuPageProcessor.fillData(<?php echo $subjects; ?>);
	});
</script>

<ul class="list-group" id = "subjectMenu"></ul>

<a type="button" class="btn btn-info pull-right col-md-2" href = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject'); ?>">Добавить дисциплину</a>
-->