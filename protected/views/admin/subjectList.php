<script type="text/javascript">
    $(document).ready(function () {

        var listContainer = $('#subjectListContainer');
        listContainer.jtable({
            title: 'Список дисциплин',
            sorting: true,
            paging: true,
            pageSize : 20,
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
        $('#loadButton').click(function (e) {
            e.preventDefault();
            $('#subjectListContainer').jtable('load', {
                title: $('#title').val()
            });
        });
    });

</script>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" onsubmit = "return false;">
            <div class="form-group col-xs-12">
                <label for="semesterFilter" class="col-xs-1">Название</label>
                <div class = "col-xs-11">
                    <input type = "text" class="form-control input-sm" id = "title">
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
<div id="subjectListContainer"></div>

<!--script>
	$(document).ready(function(){
		SubjectMenuPageProcessor.fillData(<?php echo $subjects; ?>);
	});
</script>

<ul class="list-group" id = "subjectMenu"></ul>

<a type="button" class="btn btn-info pull-right col-md-2" href = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject'); ?>">Добавить дисциплину</a>
-->