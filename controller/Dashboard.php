<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function get_data(){
		$data['method'] = $this->router->method;
		$data['controller'] = $this->router->class;
	 	return $data;
 	}

	public function index(){
    $data = $this->get_data();
    $this->view_p_teacher();
	}
	public function semester($semester_id = null){
		if(!empty($semester_id)){
			$data = $this->get_data();
			$this->load->view("header/header",$data);
			$this->load->view("header/sidebar",$data);

			$this->load->view("footer/footer",$data);
		}
	}
	public function step3_4($practiceteacher_id=null){
		$data = $this->get_data();
		$this->load->model(array('Practiceteacher_model'));
		$data['practiceteacher'] = $this->Practiceteacher_model->getPracticeteacherFull($practiceteacher_id);
		// pr($data);
		$this->load->view('header/header_no_menu', $data);
		$this->load->view('dashboard/step3_4/prepare_semester', $data);
		$this->load->view('footer/footer_no_menu', $data);
	}
	public function semester_dashboard($semester_id = null){

		if(!empty($semester_id)){
			$data = $this->get_data();
			$data['semester_id'] = $semester_id;
			//หน้ารวม
			$this->load->model(array('Semester_dashboard_model','Semester_model'));
			$data['semester'] = $this->Semester_model->getSemesterWhereSemesterID($semester_id);
			$data['studentArr'] = $this->Semester_model->getStudentSemesterRegisterWhereSemesterID($semester_id);
			$data['teacherArr'] = $this->Semester_model->getTeacherProfile();
			$this->load->view("header/header",$data);
			$this->load->view("header/sidebar",$data);
			$this->load->view('dashboard/view_p_teacher',$data);
			$this->load->view("footer/footer",$data);
		}
	}

	public function step1($semester_id = null){
	if(!empty($semester_id)){
		$data = $this->get_data();
		$this->load->model(array('Semester_dashboard_model','Semester_model'));
		$data['semester'] = $this->Semester_model->getSemesterWhereSemesterID($semester_id);
		$data['step1'] = $this->Semester_dashboard_model->getStep1Table($semester_id);
		$this->load->view("header/header",$data);
		$this->load->view("header/sidebar",$data);
		$this->load->view('dashboard/view_step1',$data);
		$this->load->view("footer/footer",$data);
	}
}
	public function load_check_teaching(){
		if(_post("pt_id")!=NULL){
			$this->load->model(array('Teacher_model'));
			$teaching_checkArr = $this->Teacher_model->get_check_teaching_history(_post("pt_id"));
			echo json_encode($teaching_checkArr);
		}
	}
	public function load_advisor(){
		if(_post("pt_id")!==NULL){
			$this->load->model(array('Teacher_model'));
			$advisor = $this->Teacher_model->get_pt_advisor(_post("pt_id"));
			echo json_encode($advisor);
		}
	}
	public function set_advisor(){
		if(_post("pt_id")!==NULL&&_post("t_id")!==NULL){
			$this->load->model(array('Teacher_model'));
			echo $this->Teacher_model->set_pt_advisor(array(
				'pt_id'=>_post("pt_id"),
				't_id'=>_post("t_id")
			));
		}
	}
	public function cancel_advisor(){
		if(_post("pt_id")!==NULL&&_post("t_id")!==NULL){
			$this->load->model(array('Teacher_model'));
			echo $this->Teacher_model->cancel_pt_advisor(array(
				'pt_id'=>_post("pt_id"),
				't_id'=>_post("t_id")
			));
		}
	}

	public function load_supervisor(){
		if(_post("pt_id")!==NULL){
			$this->load->model(array('Teacher_model'));
			$supervisor = $this->Teacher_model->get_pt_supervisor(_post("pt_id"));
			echo json_encode($supervisor);
		}
	}
	public function set_supervisor(){
		if(_post("pt_id")!==NULL&&_post("t_id")!==NULL){
			$this->load->model(array('Teacher_model'));
			echo $this->Teacher_model->set_pt_supervisor(array(
				'pt_id'=>_post("pt_id"),
				't_id'=>_post("t_id")
			));
		}
	}
	public function cancel_supervisor(){
		if(_post("pt_id")!==NULL&&_post("t_id")!==NULL){
			$this->load->model(array('Teacher_model'));
			echo $this->Teacher_model->cancel_pt_supervisor(array(
				'pt_id'=>_post("pt_id"),
				't_id'=>_post("t_id")
			));
		}
	}

	public function save_step_1($semester_id = null){
		if(!empty($semester_id)){
			if(_post("id_clicked")!=""&&_post("id_clicked")!==NULL){
				$id_clicked = _post("id_clicked");
				$idArr = explode(",",$id_clicked);
				$data_update = array();
				foreach ($idArr as $key => $id) {
					array_push($data_update,array(
						'id'=>$id,
						'value'=>_post("accept_status".$id)[0]
					));
				}
				$this->load->model('Semester_dashboard_model');
				echo $this->Semester_dashboard_model->updateStep1($data_update,$semester_id);
			}
			else echo "empty";
		}
		else echo "empty";
	}
	public function view_p_teacher($semester_id){
        $this->load->model("Practiceteacher_model");
        $this->load->model("Teacher_model");
				$this->load->model("Semester_model");

        $data = $this->get_data();

        $dr = array(
            'semester_id' => $semester_id,
            'advisor_teacher_id' => getSession("teacher_id")
        );

				$data['semester'] = $this->Semester_model->getSemesterWhereSemesterID($semester_id);
        $data["getStudentPracticeteacher"] = $this->Practiceteacher_model->getStudentPracticeteacher($dr);
        $data["SupervisorWorkload"] = $this->Teacher_model->getSupervisorWorkload($dr);

        //$this->load->model("Semester_model");
        //$data['semesterArr'] = $this->Semester_model->getSemester(array(
        //  'type'=>"check_member",
            //	'student_systemid'=>getSession("student_systemid")
        //));
            //print_r($data['semesterArr']);exit();
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
        $this->load->view('dashboard/view_p_teacher',$data);
        $this->load->view("footer/footer",$data);
	}

	public function score_from_mentor(){
    $data = $this->get_data();
    $this->load->view("header/header",$data);
    $this->load->view("header/sidebar",$data);
		$this->load->view('dashboard/score_from_mentor',$data);
    $this->load->view("footer/footer",$data);
	}

	public function score_from_advisor(){
    $data = $this->get_data();
    $this->load->view("header/header",$data);
    $this->load->view("header/sidebar",$data);
		$this->load->view('dashboard/score_from_advisor',$data);
    $this->load->view("footer/footer",$data);
	}

	public function view_p_teacher_score(){
    $data = $this->get_data();
    $this->load->view("header/header",$data);
    $this->load->view("header/sidebar",$data);
		$this->load->view('dashboard/view_p_teacher_score',$data);
    $this->load->view("footer/footer",$data);
	}

    public function during_semester($practiceteacher_id){
        $data = $this->get_data();
        $this->load->model("Practiceteacher_model");
        $this->load->model("Semester_model");

        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($practiceteacher_id);
        $data['SubjectArr'] = $this->Practiceteacher_model->getPracticeteacher_Subject($practiceteacher_id);
        $data['RountineArr'] = $this->Practiceteacher_model->getPracticeteacher_Routine($practiceteacher_id);
        $data['WeeklyPlanArr'] = $this->Practiceteacher_model->getPracticeteacher_Weeklyplan($practiceteacher_id);
        $data['SubjectAssessmentArr'] = $this->Practiceteacher_model->getPracticeteacher_SubjectAssessment($practiceteacher_id);
        $data['AcademyscheduleArr'] = $this->Practiceteacher_model->getPracticeteacher_Academyschedule($practiceteacher_id);
        $data['academy_location'] = $this->Practiceteacher_model->getAcademylocation($data['studentArr'][0]['academy_name_th']);
        $data['data_dayArr'] = $this->Practiceteacher_model->getWorkloadByDay($practiceteacher_id);
        // $data['level3Arr'] = $this->Semester_model->level3_4_model($practiceteacher_id);

        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
				$this->load->view('dashboard/view_level3_4',$data);
        $this->load->view("footer/footer",$data);
    }

    public function during_semester_project($practiceteacher_id){
        $data = $this->get_data();

        $this->load->model("Semester_model");
        $data['rsprjArr'] = $this->Semester_model->level3_4_project_research_model($practiceteacher_id);
        //print_r($data);exit();
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($practiceteacher_id);
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
				$this->load->view('dashboard/view_level3_4_project',$data);
        $this->load->view("footer/footer",$data);
    }

    public function during_semester_unitplan($practiceteacher_id){
        $data = $this->get_data();

        $this->load->model("Semester_model");
				$data['unitplan'] = $this->Semester_model->level3_4_unitplan_model($practiceteacher_id);
        //print_r($data); exit();
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($practiceteacher_id);
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
		    $this->load->view('dashboard/view_level3_4_unitplan',$data);
        $this->load->view("footer/footer",$data);
    }

    public function during_semester_portfolio($practiceteacher_id){
        $data = $this->get_data();

				$this->load->model("Semester_model");
				$data['portfolioArr'] = $this->Semester_model->level3_4_portfolio_model($practiceteacher_id);
				//print_r($data);exit();
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($practiceteacher_id);
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
		 		$this->load->view('dashboard/view_level3_4_portfolio',$data);
        $this->load->view("footer/footer",$data);
    }

		public function during_semester_research($practiceteacher_id){
        $data = $this->get_data();
        $this->load->model("Practiceteacher_model");

				$data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($practiceteacher_id);
				$data['SubjectArr'] = $this->Practiceteacher_model->getPracticeteacher_Subject($practiceteacher_id);
				$data['RountineArr'] = $this->Practiceteacher_model->getPracticeteacher_Routine($practiceteacher_id);
				$data['WeeklyPlanArr'] = $this->Practiceteacher_model->getPracticeteacher_Weeklyplan($practiceteacher_id);
				$data['SubjectAssessmentArr'] = $this->Practiceteacher_model->getPracticeteacher_SubjectAssessment($practiceteacher_id);
				$data['AcademyscheduleArr'] = $this->Practiceteacher_model->getPracticeteacher_Academyschedule($practiceteacher_id);
				$data['academy_location'] = $this->Practiceteacher_model->getAcademylocation($data['studentArr'][0]['academy_name_th']);
				$data['data_dayArr'] = $this->Practiceteacher_model->getWorkloadByDay($practiceteacher_id);
				$data['research_proposal'] = $this->Practiceteacher_model->getResearch_proposal($practiceteacher_id);
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($practiceteacher_id);

				$data['research'] = $this->Practiceteacher_model->getResearch($practiceteacher_id, $data['research_proposal']['research_proposal_id']);

        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
				$this->load->view('dashboard/view_level3_4_research',$data);
        $this->load->view("footer/footer",$data);
    }

	public function view_level5_supervisiondetail(){
        $data = $this->get_data();
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
        $this->load->view('dashboard/view_level5_supervisiondetail',$data);
        $this->load->view("footer/footer",$data);
    }

		public function view_level5($pid){
			$data = $this->get_data();
			$this->load->model("Student_model");

			$data['practiceteacher_detail'] = $this->Student_model->getStudentProfileBYpid($pid);
			$data['detail_student'] = $this->Student_model->getStudentProfile($data['practiceteacher_detail']['student_systemid']);
			$data['practicehistory'] = $this->Student_model->getDetailStudent($data['practiceteacher_detail']['student_systemid']);
			$data['score'] = $this->Student_model->getscoreforLV5($pid);
			$data['status'] = $this->Student_model->getStatusEndofsemester($pid);
			$data['learnerscore'] = $this->Student_model->avgLearnerScore($pid);
			$data['advisorscore'] = $this->Student_model->Advisorscore($pid);
			// print_r($data);
			// exit();


			$this->load->view("header/header",$data);
			$this->load->view("header/sidebar",$data);
			$this->load->view('dashboard/view_level5',$data);
			$this->load->view("footer/footer",$data);
    }

		public function approveStatus(){
		$check =	_post("status");
		$pid = _post("pid");
			if($check=="Approved"){
				$this->load->model("Practiceteacher_model");
				echo	$this->Practiceteacher_model->ApprovedLV5($pid);
			} else if($check=="NotApproved"){
				$this->load->model("Practiceteacher_model");
				echo	$this->Practiceteacher_model->NotApprovedLV5($pid);
			}
		}

    // public function ajax_edit($id)
	// {
	//     $data = $this->Practiceteacher_model->get_by_id($id);
	// 	echo json_encode($data);
    // }

    public function detail_student($pid){
        $data = $this->get_data();
        $this->load->model("Student_model");

        $data['detail_student'] = $this->Student_model->getDetail_student($pid);
        $student_systemid = $this->Student_model->getStudent_systemid_by_student_id($pid);
        $data['practicehistory'] = $this->Student_model->getDetail_student_practicehistory($student_systemid['student_systemid']);

        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
        $this->load->view('student/detail_student',$data);
        $this->load->view("footer/footer",$data);
    }

    public function teacher_evaluate($pid){
        $data = $this->get_data();
        $this->load->model('Practiceteacher_model');
        $this->load->model('Evaluation_model');
        $this->load->model('Filemanager_model');
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($pid);
        //print_r($data['studentArr']); exit();
        $data['SubjectArr'] = $this->Practiceteacher_model->getPracticeteacher_Subject($pid);
        $data['RountineArr'] = $this->Practiceteacher_model->getPracticeteacher_Routine($pid);
        $dr = array(
            "practiceteacher_id" => $pid,
            "student_systemid" => $data['studentArr'][0]['student_systemid'],
        );
        $data['evaluationArr'] = $this->Evaluation_model->getTeaching_Result($dr);
				// print_r($data['evaluationArr']);
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
        $this->load->view('evaluation/teacher_evaluate',$data);
        $this->load->view("footer/footer",$data);
    }

    public function do_evaluate($pid){
        $data = $this->get_data();
        $this->load->model('Practiceteacher_model');
        $this->load->model('Evaluation_model');
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($pid);
        $data['SubjectArr'] = $this->Practiceteacher_model->getPracticeteacher_Subject($pid);
        $data['RountineArr'] = $this->Practiceteacher_model->getPracticeteacher_Routine($pid);

        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
        $this->load->view('evaluation/do_evaluate',$data);
        $this->load->view("footer/footer",$data);
    }

    public function evaluate_data_submited(){
        $this->load->model('Evaluation_model');
        $this->load->model('Practiceteacher_model');
        $this->load->library("Filemanager");

        // $data = array(
        //     "practiceteacher_id" => $this->input->post('practiceteacher_id'),
        //     // "semester_id" => $this->input->post('semester_id'),
        //     "advisor_id" => getSession("advisor_id"),
        //     "result_teaching_check_byadvisor_date" => date('Y-m-d'),
        //     "result_teaching_check_byadvisor_comment" => $this->input->post('result_teaching_check_byadvisor_comment'),
        //     //"upload_id" =>
        // );
        $semester_id = $this->input->post('semester_id');

        $upload_f = $this->filemanager->uploadPic(array(
            'upload_pic_id'=> 0,
            'upload_type' => "teaching_check_picture",
            'upload_pic_name' => cutFileType($_FILES['new_file']['name'],4),
            'upload_pic_owner_type' => "advisor",
            'upload_pic_owner_id' => getSession("advisor_id"),
            'upload_pic_semester_id' => $semester_id,
            'fileaccessibility' => "private",
            'file' => $_FILES['new_file'],
            'target' => "/advisor/private_upload/teaching_check_picture/"
        ));
        // echo $upload_f;

        // if (is_numeric($upload_f)) {
        //     $this->do_evaluate();
        // }
        $practiceteacher_id = $this->input->post('practiceteacher_id');
        $advisor_id = getSession("advisor_id");
        $data = array(
            "practiceteacher_id" => $practiceteacher_id,
            //"semester_id" => $this->input->post('semester_id'),
            "advisor_id" => $advisor_id,
            "result_teaching_check_no" => (($this->Practiceteacher_model->getLastresult_teaching_check_no($practiceteacher_id, $advisor_id))+1),
            "result_teaching_check_byadvisor_date" => date('Y-m-d'),
            "result_teaching_check_byadvisor_comment" => $this->input->post('result_teaching_check_byadvisor_comment'),
            "upload_id" => $upload_f
        );
        $save = $this->Evaluation_model->Save_data($data);

        if ($save == 1) {
            $this->advisor_evaluate($data['practiceteacher_id']);
        }

        // if ($save == 1) {
        //     $notify = 1;
        //     $this->advisor_evaluate($this->input->post('practiceteacher_id'), $notify);
        // } else {
        //     $notify = 0;
        //     $this->advisor_evaluate($this->input->post('practiceteacher_id'), $notify);
        // }
    }

    public function advisor_final_evaluate($pid){
        $data = $this->get_data();
        $this->load->model('Practiceteacher_model');
        $this->load->model('Evaluation_model');
        $data['studentArr'] = $this->Practiceteacher_model->getPracticeteacher_Information($pid);
        $data['SubjectArr'] = $this->Practiceteacher_model->getPracticeteacher_Subject($pid);
        $data['RountineArr'] = $this->Practiceteacher_model->getPracticeteacher_Routine($pid);
        $data['evaluationformArr'] = $this->Evaluation_model->getEvaluationform(3);
        $data['evaluationformTopicArr'] = $this->Evaluation_model->getEvaluationformtopic($data['evaluationformArr']['evaluation_form_id']);


        //print_r($data['evaluationformTopicArr']);
        // exit();
        //print_r($data);exit();
        $this->load->view("header/header",$data);
        $this->load->view("header/sidebar",$data);
        $this->load->view('evaluation/advisor_final_evaluate',$data);
        $this->load->view("footer/footer",$data);
    }

    public function final_evaluate_data_submited($pid){
        $total_score = 0;
        $this->load->model('Evaluation_model');
        $finalEvaluateData = array(
            "numOfTopic" => $this->input->post('numOfTopic'),
            "practiceteacher_id" => $pid,
            "advisor_id" => getSession('advisor_id'),
            'result_endofsemester_byadvisor_datetime' => date('Y-m-d'),
            "evaluation_form_id" => $this->input->post('evaluation_form_id'),
            "result_endofsemester_byadvisor_note" => $this->input->post('result_endofsemester_byadvisor_note'),
        );

        // echo $finalEvaluateData['practiceteacher_id']. ' + '.$finalEvaluateData['advisor_id'];

        $this->Evaluation_model->saveEndofsemester_byadvisor($finalEvaluateData);
        $result_id_by_advisor = $this->Evaluation_model->getResult_endofsemester_byadvisor_id($finalEvaluateData['practiceteacher_id'], $finalEvaluateData['advisor_id']);

        $i = $finalEvaluateData['evaluation_form_id'];

        for($x=1; $x<=$i; $x++){
            $topic_id = $this->Evaluation_model->getEvaluation_form_topic_id($finalEvaluateData['evaluation_form_id'], $x);
            $topic_data = array(
                "result_endofsemester_byadvisor_id" => $result_id_by_advisor->result_endofsemester_byadvisor_id,
                "evaluation_form_topic_id" => $topic_id->evaluation_form_topic_id,
                "result_endofsemester_byadvisor_topic_no" => $x,
                "result_endofsemester_byadvisor_topic_score" => $this->input->post('inputScore_'.$x)
            );
            $total_score = $total_score + $topic_data['result_endofsemester_byadvisor_topic_score'];
            /// echo "data ======".$topic_id.' <> '.$x.' '.$this->input->post('inputScore_'.$x);
            // if($this->Evaluation_model->saveEndofsemester_byadvisor_Topic($topic_data)){
            //     echo "insert success";
            // } else {
            //     echo "insert fail";
            // }
            // echo "<br>";
            $this->Evaluation_model->saveEndofsemester_byadvisor_Topic($topic_data);
        }

        $this->Evaluation_model->updateEndofsemester_ByadvisorScore($result_id_by_advisor->result_endofsemester_byadvisor_id, $total_score);

        if ($this->Evaluation_model->updateEndofsemester_ByadvisorScore($result_id_by_advisor->result_endofsemester_byadvisor_id, $total_score)) {
            $this->view_p_teacher($pid);
        }

        // if ($this->Evaluation_model->updateEndofsemester_ByadvisorScore($result_id_by_advisor->result_endofsemester_byadvisor_id, $total_score)) {
        //     echo "Update Okay";
        // } else {
        //     echo "Update Fail";
        // }
        // print_r($topic_data);
    }

    /*
    public function save(){
        if(isset($_FILES['new_file'])){

        }
        $this->load->library("Filemanager");
        echo $this->filemanager->uploadPic(array(
            'upload_pic_id'=>0,
            'upload_type' => "teaching_check_picture",
            'upload_pic_name' => cutFileType($_FILES['new_file']['name'],4),
            'upload_pic_owner_type' => "advisor",
            'upload_pic_owner_id' => getSession("advisor_id"),
            'upload_pic_semester_id' => 1,
            'fileaccessibility' => "private",
            'file' => $_FILES['new_file'],
            'target' => "/advisor/private_upload/teaching_check_picture/"
        ));
      }
      */
			public function research_confirm(){
				$this->load->model('Practiceteacher_model');
				$updateData = array(
						'practiceteacher_id' => $this->input->post('practiceteacher_id'),
						'research_proposal_status' => $this->input->post('research_proposal_status')
				);
				print_r($updateData);

				$this->Practiceteacher_model->updateResearchP_status($updateData);
			}
}
