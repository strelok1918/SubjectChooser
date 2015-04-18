<script>
		var button;
		$(document).ready(function(){
            AjaxController.init("<?php echo Yii::app()->createAbsoluteURL('user/saveChoose'); ?>", "<?php echo Yii::app()->createAbsoluteURL('user/dismissChoose'); ?>");
            button = _.template($('#dismissButton').html());
            SubjectListPageProcessor.init(<?php echo json_encode($subjects); ?>);
            SubjectListPageProcessor.fillSubjectList(button);
            $("#yearFilter").select2();
            $("#yearFilter").on("select2:select", function (e) { SubjectStatistics.selectYear(e.params.data.id); });
            $("#yearFilter").on("select2:unselect", function (e) { SubjectStatistics.selectYear(e.params.data.id); });

            $("#subjectFilter").select2();
            $("#subjectFilter").on("select2:select", function (e) { SubjectStatistics.selectSubject(e.params.data.id); });
            $("#subjectFilter").on("select2:unselect", function (e) { SubjectStatistics.selectSubject(e.params.data.id); });
	    });
</script>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" onsubmit = "return false;">
            <div class="form-group col-xs-12">
                <label for="yearFilter" class="col-xs-1">Год</label>
                <div class = "col-xs-8">
                    <select class="form-control input-sm" id = "yearFilter" multiple="multiple">
                    </select>
                </div>

                <div class="btn-group col-xs-3" data-toggle="buttons">
                    <label class="btn btn-default col-xs-6 active">
                        <input type="checkbox" autocomplete="off" id = "1semester" checked> 1 семестр
                    </label>
                    <label class="btn btn-default col-xs-6 active">
                        <input type="checkbox" autocomplete="off" id = "2semester" checked> 2 семестр
                    </label>
                </div>
            </div>

            <div class="form-group col-xs-12">
                <label for="semesterFilter" class="col-xs-1">Предмет</label>
                <div class = "col-xs-11">
                    <select class="form-control input-sm" id = "subjectFilter" multiple="multiple">
                    </select>
                </div>
            </div>
            <div class = "clearfix"></div>

            <div class = "form-group col-xs-12">
                <div class ="pull-right" style = "padding-right: 15px;">
                    <button type="button" class="btn btn-primary" onclick = "SubjectStatistics.filterSubjects()">Выбрать</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="list-group" id = "subjectList"></div>