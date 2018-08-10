<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Examination extends MY_Controller {

    function getExaminationInitial() {
        $userID = $this->getUserID();
        $sql = "SELECT c.*,p.payeName FROM `cources` c 
        INNER JOIN paye p on p.payeID=c.payeID WHERE `userID`=$userID";
        $data["cource"] = $this->db->query($sql)->result();

        $sql = "SELECT * FROM `question_tags` WHERE `userID`=$userID";
        $data["questionTags"] = $this->db->query($sql)->result();

        $sql = "SELECT * FROM `cource-sections` WHERE `userID`=$userID";
        $data["sections"] = $this->db->query($sql)->result();

        echo json_encode($data);
    }

    function createExam() {
        $obj = json_decode(file_get_contents("php://input"));
        $courceID = $obj->cource->courceID;
        $questionNum = $obj->questionNum;
        $sections = $obj->sections;
        $tags = $obj->tags;
        $levels = $obj->levels;

        $filter_array = array('courceID' => $courceID, 'sectionsIDList' => '', 'questionLevelIDList' => '', 'tagsIDList' => '');

        //$sql="SELECT * FROM `section_questions` WHERE `courceID`=$courceID ORDER BY RAND() LIMIT $questionNum";
        $sql = "SELECT * FROM `section_questions` WHERE `courceID`=$courceID";
        if (count($sections) > 0) {
            $sectionList = [];
            foreach ($sections as $section) {
                $sectionList[] = $section->sectionID;
            }
            $sectionStr = implode(",", $sectionList);
            $sql .= " AND `sectionID` IN ($sectionStr)";
            $filter_array["sectionsIDList"] = $sectionStr;
        }
        if (count($tags) > 0) {
            $tagList = [];
            foreach ($tags as $tag) {
                $tagList[] = $tag->tagID;
            }
            $tagStr = implode(",", $tagList);
            $sql .= " AND questionID IN (SELECT questionID FROM `question_tags` WHERE `tagID` IN ($tagStr))";
            $filter_array["tagsIDList"] = $tagStr;
        }

        if (count($levels) > 0) {
            $levelList = [];
            foreach ($levels as $level) {
                $levelList[] = $level->id;
            }
            $levelStr = implode(",", $levelList);
            $sql .= " AND `questionLevelID` IN ($levelStr)";
            $filter_array["questionLevelIDList"] = $levelStr;
        }

        $sql .= " ORDER BY RAND() LIMIT $questionNum";
        $questions = $this->db->query($sql)->result_array();
        for ($i = 0; $i < count($questions); $i++) {
            $questionID = $questions[$i]["questionID"];
            $sql = "SELECT * FROM `question_items` WHERE `questionID`=$questionID ORDER BY RAND() LIMIT 3";
            $questions[$i]["items"] = $this->db->query($sql)->result_array();
        }
        $data["questions"] = $questions;
        $data["filter"] = $filter_array;
        echo json_encode($data);
    }

    function saveExam() {
        $obj = json_decode(file_get_contents("php://input"));
        $exam = $obj->exam;
        $title = $obj->title;
        $filter = $obj->filter;
        $serial = $obj->serial;
        $data_array = array(
            'title' => $title,
            'questionLevelIDList' => $filter->questionLevelIDList,
            'sectionsIDList' => $filter->sectionsIDList,
            'tagsIDList' => $filter->tagsIDList,
            'courceID' => $filter->courceID,
            'userID' => $this->getUserID(),
            'serialNum' => $serial
        );
        $this->db->insert('examination', $data_array);
        $insertID = $this->db->insert_id();
        foreach ($exam as $question) {
            $question->examID = $insertID;
        }
        echo "<pre>";
        print_r($exam);
        echo "</pre>";
        $this->db->insert_batch('examinationQuestions', $exam);
        echo md5($insertID);
    }

    function getExamList() {
        $sql = "SELECT *,md5(`id`) md5ID,DATE_FORMAT(pdate(`regdate`),'%Y/%m/%d') pdate,DATE_FORMAT(pdate(`regdate`),'%H:%i:%s') clock FROM `examination`";
        echo json_encode($this->db->query($sql)->result());
        /*
          $sql="SELECT id,e.`tagsIDList`,
          CASE WHEN e.tagsIDList!='' THEN
          (SELECT GROUP_CONCAT(qt.tag) FROM question_tags qt
          WHERE qt.tagID IN ( e.`tagsIDList`))
          END x
          FROM examination e ";
          $res=$this->db->query($sql)->result();
         */
        /*
          $sql="SELECT e.id,e.`tagsIDList` FROM examination e";
          $res=$this->db->query($sql)->result();

          foreach($res as $r){
          if($r->tagsIDList!=''){
          $sql="select GROUP_CONCAT(qt.tag) from question_tags qt where qt.tagID in ($r->tagsIDList)";
          echo $sql ."<br>";
          $res=$this->db->query($sql)->result();
          echo "<pre>";
          print_r($res);
          echo "</pre>";
          }

          }
         */
    }

    function getSchoolList() {
        $userID = $this->getUserID();
        $sql = "SELECT sc.*,s.title school FROM school_class sc 
            INNER JOIN school s ON s.id=sc.schoolID WHERE sc.userID=$userID";
//        $sql = "SELECT * FROM `school` s WHERE s.userID=$userID";
//        $data["school"] = $this->db->query($sql)->result();
//        $sql = "SELECT * FROM `school_class` sc WHERE sc.userID=$userID";
//        $data["school_class"] = $this->db->query($sql)->result();
        echo json_encode($this->db->query($sql)->result());
    }

    function getStudentList() {
        $obj = json_decode(file_get_contents("php://input"));
        $classID = $obj;
        $sql = "SELECT * FROM class_student cs WHERE cs.classID=$classID";
        echo json_encode($this->db->query($sql)->result());
    }

    function getExamAnswerSheet() {
        $obj = json_decode(file_get_contents("php://input"));
        $md5ID = $obj->md5ID;
        $sql = "SELECT eq.examID,eq.questionID,eq.questionIndex,eq.answer,0 checkedItem,0 checkedCount,'' checkedList,0 isCorrect FROM examinationquestions eq WHERE md5(eq.examID)='$md5ID'";
        echo json_encode($this->db->query($sql)->result());
    }

    function saveExamResult() {
        $obj = json_decode(file_get_contents("php://input"));
        $student = $obj->student;
        $answerSheet = $obj->answerSheet;
        $answerSheetImage = $obj->answerSheetImage;
        $markAz20 = $obj->markAz20;

        $userID = $this->getUserID();
        $studentID = $student->studentID;
        $ip = $this->input->ip_address();

        $answerSheetArray = array();
        foreach ($answerSheet as $answer) {
            $examID = $answer->examID;
            $answerSheetArray[] = array(
                'examID' => $answer->examID,
                'questionID' => $answer->questionID,
                'studentID' => $studentID,
                'questionIndex' => $answer->questionIndex,
                'checkedList' => $answer->checkedList,
                'ip' => $ip,
                'checkedCount' => $answer->checkedCount,
                'userID' => $userID,
                'isCorrect' => $answer->isCorrect,
                'answer' => $answer->answer
            );
        }

        $mark_result_image = array(
            'studentID' => $studentID,
            'examID' => $examID,
            'examImage' => $answerSheetImage,
            'userID' => $userID,
            'correctCount' => 0,
            'errorCount' => 0,
            'noneCount' => 0,
            'byNegative' => 0,
            'nomreAz20Neg' => 0,
            'nomreAz20' => $markAz20,
            'nomreAz100Neg' => 0,
            'nomreAz100' => 0
        );

        $this->db->insert_batch('exam_student_mark', $answerSheetArray);
        $this->db->insert('student_exam_result_image', $mark_result_image);
    }

    function export2Word($examMD5ID) {

        $sql = "SELECT eq.*,sq.questionTitle,sq.questionAnswer,qi1.itemTitle item1,qi2.itemTitle item2,qi3.itemTitle item3,qi4.itemTitle item4  
        FROM examinationQuestions eq 
        INNER JOIN section_questions sq ON sq.questionID= eq.questionID 
        LEFT JOIN question_items qi1 ON qi1.itemID=eq.item1ID 
        LEFT JOIN question_items qi2 ON qi2.itemID=eq.item2ID 
        LEFT JOIN question_items qi3 ON qi3.itemID=eq.item3ID 
        LEFT JOIN question_items qi4 ON qi4.itemID=eq.item4ID 
        WHERE md5(eq.examID)='$examMD5ID'";
        $res = $this->db->query($sql)->result();

        $columnHeader = '';
        $setData = '';
        $counter = 0;


        foreach ($res as $r) {
            $counter += 1;
            $rowData = $counter . "-" . $r->questionTitle . "\n";
            if ($r->item1ID > 0) {
                $rowData .= 'الف-' . $r->item1 . "\n";
            } else {
                $rowData .= 'الف-' . $r->questionAnswer . "\n";
            }

            if ($r->item2ID > 0) {
                $rowData .= 'ب-' . $r->item2 . "\n";
            } else {
                $rowData .= 'ب-' . $r->questionAnswer . "\n";
            }
            if ($r->item3ID > 0) {
                $rowData .= 'ج-' . $r->item3 . "\n";
            } else {
                $rowData .= 'ج-' . $r->questionAnswer . "\n";
            }
            if ($r->Item4ID > 0) {
                $rowData .= 'د-' . $r->item4 . "\n";
            } else {
                $rowData .= 'د-' . $r->questionAnswer . "\n";
            }
            //
            //$rowData .= '"' . $r->questionAnswer . '"' . "\t";
            $setData .= trim($rowData) . "\n\n";
        }

        //header("Content-type: application/octet-stream");
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=exam.doc");
        header('Content-Transfer-Encoding: binary');
        header("Pragma: no-cache");
        header("Expires: 0");

        echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");
    }

    function export2Excel($examMD5ID) {

        $sql = "SELECT eq.* FROM examinationQuestions eq WHERE md5(eq.examID)='$examMD5ID'";
        $res = $this->db->query($sql)->result();

        $columnHeader = "" . "\t" . "الف" . "\t" . "ب" . "\t" . "ج" . "\t" . "د" . "\t";
        $setData = '';
        $counter = 0;

        foreach ($res as $r) {
            $counter += 1;
            $rowData = $counter . "\t";

            if ($r->item1ID > 0) {
                $rowData .= "" . "\t";
            } else {
                $rowData .= "X" . "\t";
            }

            if ($r->item2ID > 0) {
                $rowData .= "" . "\t";
            } else {
                $rowData .= "X" . "\t";
            }

            if ($r->item3ID > 0) {
                $rowData .= "" . "\t";
            } else {
                $rowData .= "X" . "\t";
            }

            if ($r->Item4ID > 0) {
                $rowData .= "" . "\t";
            } else {
                $rowData .= "X" . "\t";
            }
            $setData .= trim($rowData) . "\n";
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=User_Detail_Reoprt.xls");
        header('Content-Transfer-Encoding: binary');
        header("Pragma: no-cache");
        header("Expires: 0");

        echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");
    }

    function testExcel() {

        $columnHeader = '';
        $columnHeader = "Sr NO" . "\t" . "User Name" . "\t" . "Password" . "\t";

        $setData = '';

        $res = $this->db->get('section_questions')->result();

        foreach ($res as $r) {
            $rowData = '"' . "tags" . '"' . "\t";
            $rowData .= '"' . "Level" . '"' . "\t";
            $rowData .= '"' . $r->questionAnswer . '"' . "\t";
            $setData .= trim($rowData) . "\n";
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=User_Detail_Reoprt.xls");
        header('Content-Transfer-Encoding: binary');
        header("Pragma: no-cache");
        header("Expires: 0");

        echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");
    }

    function testWord() {

        $res = $this->db->get('section_questions')->result();

        $columnHeader = '';
        $setData = '';

        foreach ($res as $r) {
            $rowData = '"' . $r->questionTags . '"' . "\t";
            $rowData .= '"' . $r->questionLevel . '"' . "\t";
            $rowData .= '"' . $r->questionAnswer . '"' . "\t";
            $setData .= trim($rowData) . "\n";
        }

        //header("Content-type: application/octet-stream");
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=User-2.doc");
        header('Content-Transfer-Encoding: binary');
        header("Pragma: no-cache");
        header("Expires: 0");

        echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");

        exit();
    }

}

// End of Home class
