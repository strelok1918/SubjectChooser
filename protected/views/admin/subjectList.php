<script type="text/javascript">
    $(document).ready(function () {

        var listContainer = $('#subjectListContainer');
        listContainer.jtable({
            title: 'Список дисциплин',
            sorting: true,
            paging: true,
            pageSize : 20,
            actions: {
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
            },
            toolbar: {
                items: [{
                    text: '<span style="font-size: 13px;"><span class = "glyphicon glyphicon-plus"></span> Добавить</span>',
                    click: function () {
                        location.href = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject'); ?>";
                    }
                }]
            },
        });
        listContainer.jtable('load');
        $('#loadButton').click(function (e) {
            e.preventDefault();
            $('#subjectListContainer').jtable('load', {
                title: $('#title').val()
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
