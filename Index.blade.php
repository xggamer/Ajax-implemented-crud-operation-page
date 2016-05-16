This is a child page
        <!--- Name Field --->
<div class="nav-tabs-custom" id="ui">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Create</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Index</a></li>
	//You can add further tabs here.
        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="box-body"id="tabs-1">
                <form action = "your-action" method="post" id= "create" />
                    <hr />
                    <p id="txt1" style="color:red; display:none">Field Required</p>
                    <!--- Name Field --->
                    <div class="form-group">
                        {!! Form::label('Name', 'Name:') !!}
                        {!! Form::text('Name', null, ['class' => 'form-control', 'data-id' => 'txt1']) !!}
                    </div>
                    <p id="txt2"style="color:red; display:none">Field Required</p>
                    <!--- DateOfBirth Field --->
                    <div class="form-group">
                        {!! Form::label('DateOfBirth', 'Date Of Birth:') !!}
                        {!! Form::text('DateOfBirth', null, ['class' => 'form-control', 'id' => 'datemask', 'data-id' => 'txt2','data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask'=> ""]) !!}
                    </div>
                    <div class="box-footer">
                        <input type="button" id="submit" value="Create" class="btn btn-primary" />
                    </div>
		</form>
            </div>
        </div><!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <div class="box-body">
                <h4>Patients</h4>
                <table class="table table-hover" role="grid" aria-describedby="example2_info">
                    <thead>
                    <tr>
                        <th>
                            First Name
                        </th>
                        <th>
                            Date of birth
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <form action = "your-action" method="post" id= "update" style="display:none"/>
                <hr />
                <p id="txt1" style="color:red; display:none">Field Required</p>
                <!--- Name Field --->
                <div class="form-group">
                    {!! Form::label('Name', 'Name:') !!}
                    {!! Form::text('Name', null, ['class' => 'form-control', 'data-id' => 'txt1','id'=>'nametxt']) !!}
                </div>
                <p id="txt2"style="color:red; display:none">Field Required</p>
                <!--- DateOfBirth Field --->
                <div class="form-group">
                    {!! Form::label('DateOfBirth', 'Date Of Birth:') !!}
                    {!! Form::text('DateOfBirth', null, ['class' => 'form-control', 'id' => 'datemask1', 'data-id' => 'txt2','data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask'=> ""]) !!}
                </div>
                <div class="box-footer">
                    <input type="button" id="updbt" value="Update" class="btn btn-primary" />
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.tab-content -->
</div><!-- nav-tabs-custom -->
<div>
</div>

<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/jQueryUI/jquery-ui.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
        $("#datemask1").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
        OnLoad();
        $('#submit').on('click', function () {
            $('#create p').each(function () {
                $(this).fadeOut();
            });
            Submit();
        });

        permit = true;
        function Validate() {
            $("#create :input").each(function () {
                if ($(this).val().length > 0) {
                }
                else {
                    html = $(this).data('id');
                    temp = $('#' + html).val();
                    if (typeof html === 'undefined') {
                    }
                    else {
                        $('#' + html).val()
                        permit = false;
                    }
                    $('#' + html).fadeIn();

                }
            });
        }
        $('#updbt').on('click',function(){
            SubUpdate();
        });
        function SubUpdate(){
            html = $(update).data('id');
            alert(html);
            $.ajax({
                url: '{controller}/{action}/' + {EntityToUpdate},
                type: "POST",
                data: $('#update').serialize(),
                async: true,
                cache: false,
                success: function (data) {
                    tr = $(update).parent().parent();
                },
                error: function (data,XHR,err){
                    alert(err);
                }
            });
        }
        var update ;
        window.Update = function(upd) {	
		$('#update').fadeIn();
		$('#tab_2').fadeOut();
        }
        function Submit() {
            Validate();
            if (permit) {
                $.ajax({
                    url: '{controller}/{action}/',
                    type: "POST",
                    contenttype: "application/json; charset=utf-8",
                    data: ($('#create').serialize()),
                    async: true,
                    cache: false,
                    success: function (data) {
                        alert('Entered Successfully');
                        $(':text').val('');
                        $('#submit').val('Create');
                    },
                    error: function (data, XHR, err) {
                        alert(err);
                    }
                });
            }
        }
        function OnLoad() {
            $.ajax({
                url: '{controller}/{action}/',
                type: 'get',
                contenttype: 'application/json; charset=utf-8',
                datatype: 'json',
                success: function (data) {
                    $.each(data, function (key, item) {
                        AddToTable(item)
                    });
                },
                error: function (data, XHR, err) {
                    alert(err);
                }
            });
        }
        pointer = 1;
        function AddToTable(item) {
            $('<tr>', {id: "data" + pointer}).appendTo('tbody');
            $('<td>', {text: item.Name, id:'name'}).appendTo($('#data' + pointer));
            $('<td>', {text: item.DateOfBirth, id:'dob'}).appendTo($('#data' + pointer));
            $('<td>').html('<input type="button" id="del" onclick= "Delete(this)" class="btn btn-primary" value="Delete" data-id="' + item.id + '"/>').appendTo($('#data' + pointer));
            $('<td>').html('<input type="button" id="del" onclick= "Update(this)" class="btn btn-primary" value="Update" data-id="' + item.id + '"/>').appendTo($('#data' + pointer));
            pointer++
        }

        window.Delete = function(del) {
            html = $(del).data('id');
            $.ajax({
                url: '{controller}/{action}/' + EntityToDelete,
                type: "POST",
                data: $('form').serialize(),
                async: true,
                cache: false,
                success: function (data) {
                    $(del).parent().parent().fadeOut();
                },
                error: function (data,XHR,err){
                    alert(err);
                }
            });
        }
    });
</script>