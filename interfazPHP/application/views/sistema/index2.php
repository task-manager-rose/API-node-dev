<?php echo $head;?>
<body class="hold-transition skin-green sidebar-mini">
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
                <thead><tr><th>Decription</th><th>Status</th><th>Options</th></tr></thead>
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
        <form id="userData">
          <div class="row">
              <div class="col-md-5 form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" id="uName">
              </div>
              <div class="col-md-2 form-group">
                <label>Age</label>
                <input type="text" name="age" class="form-control" id="uAge">
              </div>
              <div class="col-md-5 form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" id="uEmail">
              </div>
            </div>
            <div class="row">
              <div class="col-md-5 form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" id="uPass">
                </div>
            </div>
            </form>
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
            <input type="radio" name="completed" id="completedTrue" value="true"> Done <br>
            <input type="radio" name="completed" id="completedFalse" value="false"> To do
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
        data: {},
      }).done(function( msg ){
          r3 = JSON.parse( msg );
          if( r3.code == 400 ){ alert('Unable to get User information') }
          d3 = JSON.parse( r3.result );
          $("#uName").val(d3.name);
          $("#uAge").val(d3.age);
          $("#uEmail").val(d3.email);
          $("#savePerilUsuario").click(function(){
            $.ajax({
                method: "POST",
                url: "<?php echo site_url('ajax_process/updateUser')?>",
                data: $("#userData").serialize(),
                beforeSend : function(){$("#saveUserProfile_loader").fadeIn();}
              }).done(function( msg4 ){
                $("#saveUserProfile_loader").fadeOut();
                r4 = JSON.parse( msg4 );
                if( r4.code == 400 ){ alert('Unable to get User information') }
                $("#success_save_user").fadeIn();
                d4 = JSON.parse( r4.result );
                $("#uName").val(d4.name);
                $("#uAge").val(d4.age);
                $("#uEmail").val(d4.email);
                setTimeout(() => { $("#success_save_user").fadeOut();}, 3000 );
              })
          })
         /*
         setTimeout(() => { $("#success_save_new_task").fadeOut();$("#newTaskDescription").val('');}, 1000 );
         setTimeout(() => { $("#createTaskMdodal").modal('hide');}, 1500 );
         setTimeout(() => { loadTasks();}, 1600 );*/
      });
    });
  });
  function deleteTask(task){
    var ensure = confirm('Desea eliminar esta tarea?');
    if(ensure){
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('ajax_process/deleteTask')?>",
          data: {task},
        }).done(function( msg5 ){
          r5 = JSON.parse( msg5 );
          if( r5.code == 404 ){
            return alert('Unable to delete task');
          }
          alert('Task deleted');
          loadTasks();
        });
    }
  }
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
        data: {},
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
