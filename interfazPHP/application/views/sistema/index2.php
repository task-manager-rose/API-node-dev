<?php echo $head;?>
<body class="hold-transition skin-green sidebar-mini">
<style>
	body {padding: 0;font-family: 'Oxygen', Arial, Helvetica, 'Nimbus Sans L', sans-serif;font-size: 14px;}#calendar {max-width: 900px;margin: 0 auto;}#cargador{position: absolute;height: 100px;width: 100px;top: 50%;left: 50%;margin-left: -50px;margin-top: -50px;}#cargador_holder{width: 100%;min-height: 100vh;position: absolute;background-color: rgba(136, 131, 131, 0.4196078431372549);z-index: 1000;}
</style>
<div class="wrapper">
  <?php echo $header;?>
  <div class="content-wrapper">
			  <section class="content-header">
					<h1>Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard Tasks</a></li>
					</ol>
				</section>
    <!-- Main content -->
    <style>
      .loader{ width: 100%; position: absolute;height: 100%;background-color: rgba(180,180,180,0.4);z-index: 10;}
      .loaderic {margin: 10% 48%;position: relative;}
      .fa-pencil-square-o{cursor:pointer;}
    </style>
    <section class="content">
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-primary"> 
            <div class="loader" id="loader_task" style="display:none;">
              <div class="loaderic">
              <i id="login_loader"  class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
              </div>
            </div>
            <div class="box-header">
              <i class="fa fa-calendar"></i>
              <h3 class="box-title">Tasks</h3>
              <button id="crearTareaButton" class="btn btn-success pull-right"> Crear Tarea </button>
            </div>
            <div class="box-body calendarHolder">
              
              <table class="table">
                <thead><tr><th>Decription</th><th>Completed</th><th>Options</th></tr></thead>
                <tbody id="tableBody"> 
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </section>
  </div>
  <footer class="main-footer"></footer>
  <div class="control-sidebar-bg"></div>
</div>
<!-- Modal -->
<div class="modal modal-md fade" id="createTaskMdodal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Create Task&nbsp;&nbsp;<i id="success_save_new_task" class='fa fa-check-circle-o' style='color:green; display:none;' aria-hidden='true'></i></h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12 form-group">
            <input type="text" class="form-control" name="descriptionNew" id="newTaskDescription" >
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="saveNewTask" ><span style="padding-right:15px;"> Save </span> <div style="margin-left:-15px;display:inline-block;"><i id="saveNewTask_loader" style="display:none;"  class="fa fa-spinner fa-pulse fa-fw"></i></div></button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal modal-md fade" id="infoUsuario" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;User information&nbsp;&nbsp;<i id="success_save_user" class='fa fa-check-circle-o' style='color:green; display:none;' aria-hidden='true'></i></h4>
        </div>
        <div class="modal-body">
          <div class="col-md-6 form-group">
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="savePerilUsuario" ><span style="padding-right:15px;"> Save </span> <div style="margin-left:-15px;display:inline-block;"><i id="saveUserProfile_loader" style="display:none;"  class="fa fa-spinner fa-pulse fa-fw"></i></div></button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
  <div class="modal fade" id="taskModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;Task Information&nbsp;&nbsp;<i id="success_save" class='fa fa-check-circle-o' style='color:green; display:none;' aria-hidden='true'></i></h4>
        </div>
        <div class="modal-body">
          <div class="col-md-6 form-group">
            <input type="text" class="form-control" name="description" id="descriptionTask" >
            <input type="hidden" id="taskId">
          </div>
          <div class="col-md-6 form-group">
            <input type="radio" name="completed" id="completedTrue" value="true"> COMPLETED <br>
            <input type="radio" name="completed" id="completedFalse" value="false"> PENDING
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="saveEdit" ><span style="padding-right:15px;"> Save </span> <div style="margin-left:-15px;display:inline-block;"><i id="save_loader" style="display:none;"  class="fa fa-spinner fa-pulse fa-fw"></i></div></button>
        </div>
      </div>
    </div>
  </div>

<script src="<?php echo base_url('resources/');?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('resources/');?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url('resources/');?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script> $.widget.bridge('uibutton', $.ui.button); </script>
<script src="<?php echo base_url('resources/');?>dist/js/adminlte.min.js"></script>
<script>
  $(document).ready(function(){
    $("#crearTareaButton").click(function(){
      $("#newTaskDescription")
      $("#createTaskMdodal").modal();
    })
    $("#saveNewTask").click(function(){
      crearNewTask();
    })
    loadTasks();
    $("#showPerfil").click(function(){
      $("#infoUsuario").modal();
      $.ajax({
        method: "POST",
        url: "<?php echo site_url('ajax_process/getUserInfo')?>",
        data: {description},
      }).done(function( msg ){
          console.log(msg);
          r = JSON.parse( msg );
          if( r.code == 400 ){
            alert('Unable to get User information')
          }
         /*$("#success_save_new_task").fadeIn();
         setTimeout(() => { $("#success_save_new_task").fadeOut();$("#newTaskDescription").val('');}, 1000 );
         setTimeout(() => { $("#createTaskMdodal").modal('hide');}, 1500 );
         setTimeout(() => { loadTasks();}, 1600 );*/
      });
    });
  });
  function crearNewTask(){
    var description = $("#newTaskDescription").val();
      $.ajax({
        method: "POST",
        url: "<?php echo site_url('ajax_process/setNewTask')?>",
        data: {description},
        beforeSend : function(){$("#saveNewTask_loader").fadeIn();}
      }).done(function( msg ){
         $("#saveNewTask_loader").fadeOut();
         r = JSON.parse( msg );
         if( r.code == 400 ){
            alert('Unable to create new task')
         }
         $("#success_save_new_task").fadeIn();
         setTimeout(() => { $("#success_save_new_task").fadeOut();$("#newTaskDescription").val('');}, 1000 );
         setTimeout(() => { $("#createTaskMdodal").modal('hide');}, 1500 );
         setTimeout(() => { loadTasks();}, 1600 );
      });
  }
  function loadTasks(){
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('ajax_process/getTasks')?>",
        data: $("#login_form").serialize(),
        beforeSend : function(){$("#loader_task").fadeIn();}
      }).done(function( msg ){
         $("#loader_task").fadeOut();
         r = JSON.parse( msg );
         if( r.code == 400 ){
            showMessage('Datos incorrectos');
         }else{
            $("#tableBody").html(r.result)
         }
      });
  }
  function editTask(id){
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('ajax_process/getTask')?>",
        data: {idTask:id}
      }).done(function( msg ){
         r = JSON.parse( msg );
         if( r.code != 400 ){
          d =  JSON.parse( r.result );
          $("#taskModal").modal();
          $("#descriptionTask").val(d.description)
          $("#taskId").val(d._id)
          if(d.completed == true){
            $("#completedTrue").attr('checked', true);
          }else{
            $("#completedFalse").attr('checked', true);
          }
          $("#saveEdit").click(function(){
            var description = $("#descriptionTask").val();
            var completed = $("input[name='completed']:checked").val();
            var task = $("#taskId").val();
            $.ajax({
                method: "POST",
                url: "<?php echo site_url('ajax_process/updateTask')?>",
                data: {idTask:task, description, completed},
                beforeSend : function(){ $("#save_loader").fadeIn() }
              }).done(function( msg2 ){
                $("#save_loader").fadeOut()
                r2 =  JSON.parse(msg2);
                if( r2.code != 200 ){
                  return alert('Unable to update Task')
                }
                d2 =  JSON.parse( r2.result );
                $("#descriptionTask").val(d2.description)
                $("#taskId").val(d2._id)
                if(d2.completed == true){
                  $("#completedTrue").attr('checked', true);
                }else{
                  $("#completedFalse").attr('checked', true);
                }
                $("#success_save").fadeIn();
                setTimeout(() => { $("#success_save").fadeOut();}, 2000 );
                setTimeout(() => { $("#taskModal").modal('hide');}, 3000 );
                setTimeout(() => { loadTasks();}, 4000 );
              })
          })
         }else{
          alert('Unable to get Task information');
        }
      });
  }
</script>
</body>
</html>
