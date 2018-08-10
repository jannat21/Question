<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class StudentExamination extends MY_Controller {
    
    function getExaminationInitial(){
        $userID=$this->getUserID();
        $sql="SELECT c.*,p.payeName FROM `cources` c 
        INNER JOIN paye p on p.payeID=c.payeID";
        $data["cource"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `question_tags`";
        $data["questionTags"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `cource-sections`";
        $data["sections"]=$this->db->query($sql)->result();
        
        echo json_encode($data);
    }
    
    function createExam(){
        $obj=json_decode(file_get_contents("php://input"));
        $courceID=$obj->cource->courceID;
        $questionNum=$obj->questionNum;
        $sections=$obj->sections;
        $tags=$obj->tags;
        $levels=$obj->levels;
        
        //$sql="SELECT * FROM `section_questions` WHERE `courceID`=$courceID ORDER BY RAND() LIMIT $questionNum";
        $sql="SELECT * FROM `section_questions` WHERE `courceID`=$courceID";
        if(count($sections)>0){
            $sectionList=[];
            foreach($sections as $section){
                $sectionList[]=$section->sectionID;
            }
            $sectionStr=implode(",",$sectionList);
            $sql.=" AND `sectionID` IN ($sectionStr)";
        }
        if(count($tags)>0){
            $tagList=[];
            foreach($tags as $tag){
                $tagList[]=$tag->tagID;
            }
            $tagStr=implode(",",$tagList);
            $sql.=" AND questionID IN (SELECT questionID FROM `question_tags` WHERE `tagID` IN ($tagStr))";
        }
        /*
        if(count($levels)>0){
            $levelList=[];
            foreach($levels as $level){
                $levelList[]=$level;
            }
            //print_r($levelList);
            $levelStr=implode(",",$levelList);
            $sql.=" AND `questionLevel` IN ($$levelStr)";
        }*/
        $sql.=" ORDER BY RAND() LIMIT $questionNum";
        $questions=$this->db->query($sql)->result_array();
        for($i=0;$i<count($questions);$i++){
            $questionID=$questions[$i]["questionID"];
            $sql="SELECT * FROM `question_items` WHERE `questionID`=$questionID ORDER BY RAND() LIMIT 3";
            $questions[$i]["items"]=$this->db->query($sql)->result_array();
        }
        echo json_encode($questions);
    }
    
    // save examination
    function checkSaveTest(){
        $obj=json_decode(file_get_contents("php://input"));
        $exam=$obj->exam;
        $studentID=$this->getUserID();
        $this->db->insert('student_exam',array('studentID'=>$studentID));
        $insertID=$this->db->insert_id();
        foreach($exam as $examQuestion){
            $examQuestion->examID=$insertID;
            $examQuestion->studentID=$studentID;
        }
        $res=$this->db->insert_batch('student_exam_questions',$exam);
        if($res){
            echo 'success';
        }else{
            echo 'error';
        }
    }
    
    function getExaminationListInitial(){
        $userID=$this->getUserID();
        $sql="SELECT u.userName FROM users u WHERE u.userID=$userID";
        $res=$this->db->query($sql)->result();
        $studentCode=$res[0]->userName;
        $sql="SELECT * FROM student_exam se WHERE se.studentID=$studentCode";
        $data["studentExam"]= $this->db->query($sql)->result();
        $sql="SELECT * FROM student_exam_result_image seri WHERE seri.studentID=$studentCode";
        $data["studentClassExam"]= $this->db->query($sql)->result();
        echo json_encode($data);
    }

}

// End of Home class
