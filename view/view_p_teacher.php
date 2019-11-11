
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <!-- ยังไม่ได้แก้ไขส่วนหัวของหน้า -->
      บริหารภาคการศึกษาที่ <?=$semester['semester_term']?>/<?=$semester['semester_academic_year']?> ชั้นปีที่ <?=$semester['semester_classyear']?>
      <!--<small>advanced tables</small>-->
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h4>สถานะ</h4>

            <p>
              <?php
                  if($semester['semester_status'] == "pending") echo "ก่อนเริ่มภาคการศึกษา";
                  else if($semester['semester_status'] == "in_process") echo "ระหว่างภาคการศึกษา";
                  else if($semester['semester_status'] == "complete") echo "สำเร็จภาคการศึกษา";
                  else if($semester['semester_status'] == "cancel") echo "ภาคการศึกษาถูกยกเลิก";
              ?>
            </p>
          </div>
          <div class="icon">
            <i class="ion ion-clock"></i>
          </div>
          <a href="#" class="small-box-footer">แก้ไข <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h4>วันที่เริ่มต้น</h4>

            <p><?=$semester['semester_start_date']?></p>
          </div>
          <div class="icon">
            <i class="ion ion ion-play"></i>
          </div>
          <a href="#" class="small-box-footer">แก้ไข <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h4>วันที่สิ้นสุด</h4>

            <p><?=$semester['semester_end_date']?></p>
          </div>
          <div class="icon">
            <i class="ion ion-pause"></i>
          </div>
          <a href="#" class="small-box-footer">แก้ไข <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h4>วันที่ประมวลผลคะแนน</h4>

            <p><?=$semester['semester_processing_date']?></p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">แสดงคะแนนนักศึกษาฝึกสอน <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <div class="row">
      <div class="col-md-12">
            <div class="box">
              <div class="box-header">
                <!-- <a href="#" class="btn btn-primary">อนุมัติขั้นที่ 2</a> -->
                <h3 class="box-title">รายชื่อนักศึกษา</h3>
                <div class="pull-right">
                  <a href="<?php echo site_url("$controller/step1/$semester_id"); ?>" class="btn btn-primary">แสดงขั้นที่ 1</a>
                  <a href="<?php echo site_url('semester'); ?>" class="btn btn-warning" type="button" name="cancel"><i class="fa fa-arrow-left" aria-hidden="true"></i> กลับ</a>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table id="table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อ-สกุล</th>
                        <th>วิชาเอก</th>
                        <th>สถานศึกษา</th>
                        <th>การนิเทศ</th>
                        <th>ขั้นที่ 1</th>
                        <th>ขั้นที่ 2</th>
                        <th>ขั้นที่ 3-4</th>
                        <th>ขั้นที่ 5</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($studentArr as $key => $st) {
                        echo '<tr>';
                        echo '<td>'.($key+1).'</td>';
                        // echo '<td>'.str_replace("08050","",$st['student_id']).'</td>';
                        echo '<td id="student_id'.$st['practiceteacher_id'].'">'.$st['student_id'].'</td>';
                        echo '<td id="fullname'.$st['practiceteacher_id'].'">'.$st['student_firstname_th']." ".$st['student_lastname_th'].'</td>';
                        echo '<td>'.majorShortNameTH($st['student_major']).'</td>';
                        echo '<td>'.$st['academy_name_th'].'</td>';
                        if($st['samePracticeteacher_total']==0){
                          echo '<td><button class="btn btn-default btn-block"><strong>0</strong></button></td>';
                        }
                        else{
                          echo '<td><button class="btn btn-success btn-block btn_modal_check_teaching" data-pt_id = "'.$st['practiceteacher_id'].'" data-toggle="modal" data-target="#modal_check_teaching"><strong>'.$st['samePracticeteacher_total'].'</strong></button></td>';
                        }

                        // ------- สถานะขั้นที่ 1
                        if($st['student_semester_register_status']=="semesterregister_documentapproving"||$st['student_semester_register_status']=="semesterregister_documentapproving ")
                          echo '<td><a href="'.site_url("$controller/step1/$semester_id").'" class="btn btn-warning"><i class="fa fa-hourglass-start" aria-hidden="true"></i></a></td>';
                        else if($st['student_semester_register_status']=="semesterregister_documentnotapproved"||$st['student_semester_register_status']=="semesterregister_documentnotapproved ")
                          echo '<td><a href="'.site_url("$controller/step1/$semester_id").'" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></a></td>';
                        else if($st['student_semester_register_status']=="semesterregister_documentapproved"||$st['student_semester_register_status']=="semesterregister_documentapproved ")
                          echo '<td><a href="'.site_url("$controller/step1/$semester_id").'" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a></td>';
                        else
                          echo '<td><button class="btn btn-default"><i class="fa fa-exclamation" aria-hidden="true"></i></button></td>';
                          // ------- สถานะขั้นที่ 1

                        if($st['practiceteacher_id']==0) $disabled_btn = "disabled";
                        else $disabled_btn = "";
                        echo '<td><div class="btn-group-vertical">';
                        if($st['advisor_teacher']==0)
                          echo '<button class="btn btn-default btn_modal_advisor" id="btn_modal_advisor'.$st['practiceteacher_id'].'" data-toggle="modal" data-target="#modal_advisor" data-pt_id = "'.$st['practiceteacher_id'].'" '.$disabled_btn.'><i class="fa fa-user" aria-hidden="true"></i> อ.ตรวจแผน</button>';
                        else
                          echo '<button class="btn btn-success btn_modal_advisor" id="btn_modal_advisor'.$st['practiceteacher_id'].'" data-toggle="modal" data-target="#modal_advisor" data-pt_id = "'.$st['practiceteacher_id'].'" '.$disabled_btn.'><i class="fa fa-user" aria-hidden="true"></i> อ.ตรวจแผน</button>';
                        if($st['supervisor_teacher']==0)
                          echo '<button class="btn btn-default btn_modal_supervisor" id="btn_modal_supervisor'.$st['practiceteacher_id'].'" data-toggle="modal" data-target="#modal_supervisor" data-pt_id = "'.$st['practiceteacher_id'].'" '.$disabled_btn.'><i class="fa fa-user" aria-hidden="true"></i> อ.นิเทศก์</button>';
                        else
                          echo '<button class="btn btn-success btn_modal_supervisor" id="btn_modal_supervisor'.$st['practiceteacher_id'].'" data-toggle="modal" data-target="#modal_supervisor" data-pt_id = "'.$st['practiceteacher_id'].'" '.$disabled_btn.'><i class="fa fa-user" aria-hidden="true"></i> อ.นิเทศก์</button>';
                        echo '</div></td>';
                        echo '<td>
                          <button class="btn btn-primary btn_modal_step3_4" onclick="open_window_step3_4('.$st['practiceteacher_id'].');" id="btn_modal_step3_4'.$st['practiceteacher_id'].'" data-pt_id = "'.$st['practiceteacher_id'].'" '.$disabled_btn.'>ขั้น 3-4</button>
                        </td>';
                        echo '<td>
                        <a class="btn btn-primary" href="'.site_url("$controller/view_level5/$st[practiceteacher_id]").'" '.$disabled_btn.'>ขั้น 5</a>
                        </td>';
                        echo '</tr>';
                      }
                      ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
      <!-- /.col -->
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
  echo jsVar(array(
    'url_ltc'=>site_url("$controller/load_check_teaching"),
    'url_s34'=>site_url("step3_4/prepare_semester")
  ));
?>
<script type="text/javascript">
  function open_window_step3_4(pt_id){
    if(pt_id>0){
      var w=1200,h=600;
      var left = (screen.width/2)-(w/2);
      var top = (screen.height/2)-(h/2);
      top = 10;
      window.open(url_s34+'?pt='+pt_id, "popupWindow", "top="+top+", left="+left+",width="+w+",height="+h+",scrollbars=yes");
    }
  }
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $(".btn_modal_check_teaching").click(function() {
      $('#check_teaching_data').addClass('hidden');
      $('#check_teaching_loading').removeClass('hidden');
      var pt_id = $(this).data('pt_id');
      $.post(url_ltc,{pt_id: pt_id},
      function(data, status){
        $("#check_teaching_data").html('');
        var object = JSON.parse(data);
        $.each(object, function(key, value){
          var box = '';
          box+='<div class="row">';
          box+='  <div class="col-md-12">';
          box+='    <div class="box box-widget">';
          box+='      <div class="box-header with-border">';
          box+='        <div class="user-block">';
          box+='          <img class="img-circle" src="'+($("#img_supervisor"+value.teacher_id).attr('src'))+'" alt="Teacher Image">';
          box+='          <span class="username"><a href="#">'+($("#teacher_name"+value.teacher_id).text())+'</a></span>';
          box+='          <span class="description">'+value.check_date+'</span>';
          box+='        </div>';
          box+='      </div>';
          box+='      <div class="box-body">';
          box+='        <img class="img-responsive pad" src="'+value.img+'" alt="Teacher checking photo">';
          box+='        <p>'+value.teacher_comment+'</p>';
          box+='      </div>';
          box+='      <div id="teaching_check_loading"></div>';
          box+='      <div class="box-footer box-comments">';
          box+='        <div class="box-comment">';
          box+='          <div class="comment-text">';
          box+='            <span class="username">'+($("#fullname"+pt_id).text())+'</span>';
          box+=           value.commentback;
          box+='          </div>';
          box+='        </div>';
          box+='      </div>';
          box+='    </div>';
          box+='  </div>';
          box+='</div>';
          $("#check_teaching_data").append(box);
        });
        $('#check_teaching_data').removeClass('hidden');
        $('#check_teaching_loading').addClass('hidden');
      });
    });
  });
</script>
<div class="modal" id="modal_check_teaching">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">การนิเทศนักศึกษา <strong><span class="text-primary" id="check_teaching_student_title"></span></strong> </h4>
      </div>
      <div class="modal-body hidden" id="check_teaching_data"></div>
      <div class="modal-body" id="check_teaching_loading">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">
                  <img class="img-circle" src="" alt="Teacher Image">
                  <span class="username"><a href="#" id="teacher_name"> Name...</a></span>
                  <span class="description" id="date_check"> Date...</span>
                </div>
                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <img class="img-responsive pad" src="" alt="Teacher checking photo">
                <p>Loading...</p>
              </div>
            <div class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
              <div class="box-footer box-comments">
                <div class="box-comment">
                  <div class="comment-text">
                    <span class="username">Student name ...<span class="text-muted pull-right">Date...</span></span>
                    Text...
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<style>
.imgt {
    -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
    filter: grayscale(100%);
}
</style>
<?php
  echo jsVar(array(
    'url_ld'=>site_url("$controller/load_advisor"),
    'url_ls'=>site_url("$controller/load_supervisor"),
    'url_seta'=>site_url("$controller/set_advisor"),
    'url_sets'=>site_url("$controller/set_supervisor"),
    'url_ca'=>site_url("$controller/cancel_advisor"),
    'url_cs'=>site_url("$controller/cancel_supervisor")
  ));
?>
<script type="text/javascript">
  var practiceteacher_id=0;

  $(document).ready(function() {

    $(".btn_modal_supervisor").click(function(){
      $("#supervisor_loading").removeClass('hidden');
      $("#supervisor").addClass('hidden');
      $(".img_supervisor").addClass('imgt');
      var pt_id = $(this).data('pt_id');
      var studetn_id = $('#student_id'+pt_id).text();
      var fullname = $('#fullname'+pt_id).text();
      $("#supervisor_student_title").text(studetn_id+' '+fullname);
      practiceteacher_id = pt_id;
      $(".btn_supervisor_set").prop('disabled',false);
      $(".btn_supervisor_cancel").prop('disabled',true);
      $("#supervisor_pt_id").val(pt_id);

      $.post(url_ls,{pt_id: pt_id},
      function(data, status){
        $("#supervisor_loading").addClass('hidden');
        $("#supervisor").removeClass('hidden');
        var object = JSON.parse(data);
        $.each(object, function(key, value){
          $("#img_supervisor"+value.teacher_id).removeClass('imgt');
          $("#btn_supervisor_set"+value.teacher_id).prop('disabled',true);
          $("#btn_supervisor_cancel"+value.teacher_id).prop('disabled',false);
        });
      });

    });
    $(".btn_supervisor_set").click(function(){
      var t_id = $(this).data("teacher_id");
      $.post(url_sets,{pt_id: practiceteacher_id,t_id:t_id},
      function(data, status){
        if(data==1){
          $("#img_supervisor"+t_id).removeClass('imgt');
          $("#btn_supervisor_set"+t_id).prop('disabled',true);
          $("#btn_supervisor_cancel"+t_id).prop('disabled',false);
          $("#btn_modal_supervisor"+practiceteacher_id).removeClass('btn-default');
          $("#btn_modal_supervisor"+practiceteacher_id).addClass('btn-success');
        }
      });
    });
    $(".btn_supervisor_cancel").click(function(){
      var t_id = $(this).data("teacher_id");
      $.post(url_cs,{pt_id: practiceteacher_id,t_id:t_id},
      function(data, status){
        if(data==1){
          $("#img_supervisor"+t_id).addClass('imgt');
          $("#btn_supervisor_set"+t_id).prop('disabled',false);
          $("#btn_supervisor_cancel"+t_id).prop('disabled',true);
        }
        else{
          $("#img_supervisor"+t_id).addClass('imgt');
          $("#btn_supervisor_set"+t_id).prop('disabled',false);
          $("#btn_supervisor_cancel"+t_id).prop('disabled',true);
          $("#btn_modal_supervisor"+practiceteacher_id).removeClass('btn-success');
          $("#btn_modal_supervisor"+practiceteacher_id).addClass('btn-default');
        }
      });
    });

    $(".btn_modal_advisor").click(function(){
      $("#advisor_loading").removeClass('hidden');
      $("#advisor").addClass('hidden');
      $(".img_advisor").addClass('imgt');
      var pt_id = $(this).data('pt_id');
      var studetn_id = $('#student_id'+pt_id).text();
      var fullname = $('#fullname'+pt_id).text();
      $("#advisor_student_title").text(studetn_id+' '+fullname);
      practiceteacher_id = pt_id;
      $(".btn_advisor_set").prop('disabled',false);
      $(".btn_advisor_cancel").prop('disabled',true);
      $("#advisor_pt_id").val(pt_id);

      $.post(url_ld,{pt_id: pt_id},
      function(data, status){
        $("#advisor_loading").addClass('hidden');
        $("#advisor").removeClass('hidden');
        var object = JSON.parse(data);
        $.each(object, function(key, value){
          $("#img_advisor"+value.teacher_id).removeClass('imgt');
          $("#btn_advisor_set"+value.teacher_id).prop('disabled',true);
          $("#btn_advisor_cancel"+value.teacher_id).prop('disabled',false);
        });
      });

    });
    $(".btn_advisor_set").click(function(){
      var t_id = $(this).data("teacher_id");
      $.post(url_seta,{pt_id: practiceteacher_id,t_id:t_id},
      function(data, status){
        if(data==1){
          $("#img_advisor"+t_id).removeClass('imgt');
          $("#btn_advisor_set"+t_id).prop('disabled',true);
          $("#btn_advisor_cancel"+t_id).prop('disabled',false);
          $("#btn_modal_advisor"+practiceteacher_id).removeClass('btn-default');
          $("#btn_modal_advisor"+practiceteacher_id).addClass('btn-success');
        }
      });
    });
    $(".btn_advisor_cancel").click(function(){
      var t_id = $(this).data("teacher_id");
      $.post(url_ca,{pt_id: practiceteacher_id,t_id:t_id},
      function(data, status){
        if(data==1){
          $("#img_advisor"+t_id).addClass('imgt');
          $("#btn_advisor_set"+t_id).prop('disabled',false);
          $("#btn_advisor_cancel"+t_id).prop('disabled',true);
        }
        else{
          $("#img_advisor"+t_id).addClass('imgt');
          $("#btn_advisor_set"+t_id).prop('disabled',false);
          $("#btn_advisor_cancel"+t_id).prop('disabled',true);
          $("#btn_modal_advisor"+practiceteacher_id).removeClass('btn-success');
          $("#btn_modal_advisor"+practiceteacher_id).addClass('btn-default');
        }
      });
    });
  });
</script>

<!-- Modal -->
<div id="modal_supervisor" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">แต่งตั้งอาจารย์นิเทศก์ <strong><span class="text-primary" id="supervisor_student_title"></span></strong> </h4>
      </div>
      <div class="modal-body" id="supervisor_loading">
        <p>กำลังโหลด...</p>
      </div>
      <div class="modal-body hidden" id="supervisor">
        <div class="row">
          <input type="hidden" name="supervisor_pt_id" id="supervisor_pt_id" value="">
          <?php
            foreach ($teacherArr as $key => $teacher) {
              if(($key+1)%3==0) echo '<div class="row">';
              echo '
              <div class="col-md-4">
                <div class="box">
                  <div class="box-body box-profile">
                    <img id="img_supervisor'.$teacher['teacher_id'].'" class="img-thumbnail img_supervisor" src="'.getPrivateImage('/teacher/private_upload/avatar/'.$teacher['upload_pic_id'].$teacher['upload_pic_type']).'" alt="Teacher Image">
                    <h3 class="profile-username text-center" id="teacher_name'.$teacher['teacher_id'].'">'.$teacher['teacher_firstname_th'].' '.$teacher['teacher_lastname_th'].'</h3>
                    <button class="btn btn-primary btn-block btn_supervisor_set" id="btn_supervisor_set'.$teacher['teacher_id'].'" data-teacher_id="'.$teacher['teacher_id'].'"><b>แต่งตั้งเป็นอาจารย์นิเทศก์</b></button>
                    <button class="btn btn-danger btn-block btn_supervisor_cancel" id="btn_supervisor_cancel'.$teacher['teacher_id'].'" data-teacher_id="'.$teacher['teacher_id'].'" disabled><b>ยกเลิก</b></button>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              ';
              if(($key+1)%3==0) echo '</div>';
            }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="modal_advisor" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">แต่งตั้งอาจารย์แผนการสอน <strong><span class="text-primary" id="advisor_student_title"></span></strong> </h4>
      </div>
      <div class="modal-body" id="advisor_loading">
        <p>กำลังโหลด...</p>
      </div>
      <div class="modal-body hidden" id="advisor">
        <div class="row">
          <input type="hidden" name="advisor_pt_id" id="advisor_pt_id" value="">
          <?php
            foreach ($teacherArr as $key => $teacher) {
              if(($key+1)%3==0) echo '<div class="row">';
              echo '
              <div class="col-md-4">
                <div class="box">
                  <div class="box-body box-profile">
                    <img id="img_advisor'.$teacher['teacher_id'].'" class="img-thumbnail img_advisor" src="'.getPrivateImage('/teacher/private_upload/avatar/'.$teacher['upload_pic_id'].$teacher['upload_pic_type']).'" alt="Teacher Image">
                    <h3 class="profile-username text-center">'.$teacher['teacher_firstname_th'].' '.$teacher['teacher_lastname_th'].'</h3>
                    <button class="btn btn-primary btn-block btn_advisor_set" id="btn_advisor_set'.$teacher['teacher_id'].'" data-teacher_id="'.$teacher['teacher_id'].'"><b>แต่งตั้งเป็นอาจารย์ตรวจแผน</b></button>
                    <button class="btn btn-danger btn-block btn_advisor_cancel" id="btn_advisor_cancel'.$teacher['teacher_id'].'" data-teacher_id="'.$teacher['teacher_id'].'" disabled><b>ยกเลิก</b></button>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              ';
              if(($key+1)%3==0) echo '</div>';
            }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
      </div>
    </div>

  </div>
</div>

<script>
  $(function () {
    $('#table').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
