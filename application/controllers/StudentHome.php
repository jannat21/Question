<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class StudentHome extends MY_Controller {

    function getHomeInitial() {
        $userID = $this->getUserID();
        $sql = "SELECT u.userName FROM users u WHERE u.userID=$userID";
        $res = $this->db->query($sql)->result();
        $studentCode = $res[0]->userName;
        $sql = "SELECT cs.studentID FROM class_student cs WHERE cs.studentCode=$studentCode";
        $res = $this->db->query($sql)->result();
        $studentID = $res[0]->studentID;

        $sql = "SELECT seri.id examResultID, seri.*,e.*,c.*,p.*,DATE_FORMAT(pdate(seri.regDate),'%Y/%m/%d') fadate FROM student_exam_result_image seri "
                . "INNER JOIN examination e ON e.id=seri.examID "
                . "INNER JOIN cources c ON c.courceID=e.courceID "
                . "INNER JOIN paye p ON p.payeID=c.payeID "
                . "WHERE seri.studentID=$studentID ORDER BY seri.regDate";
        $data["examResuls"] = $this->db->query($sql)->result();

        $sql = "SELECT COUNT(esm.id) count, sq.courceID,esm.examID,esm.isCorrect,sq.questionLevelID,sq.questionLevel FROM exam_student_mark esm "
                . "INNER JOIN section_questions sq ON sq.questionID=esm.questionID "
                . "WHERE esm.examID IN (SELECT seri.examID FROM student_exam_result_image seri WHERE seri.studentID=$studentID) "
                . "GROUP BY sq.courceID,esm.isCorrect,sq.questionLevel";
        $data["countQuestionLevel"] = $this->db->query($sql)->result();

        $sql="SELECT COUNT(esm.id) count, sq.courceID,esm.examID,esm.isCorrect,sq.muzu FROM exam_student_mark esm "
                . "INNER JOIN section_questions sq ON sq.questionID=esm.questionID "
                . "WHERE esm.examID IN (SELECT seri.examID FROM student_exam_result_image seri WHERE seri.studentID=$studentID) "
                . "GROUP BY sq.courceID,sq.muzu,esm.isCorrect ORDER BY sq.muzu,esm.isCorrect";
        $data["countQuestionMuzu"] = $this->db->query($sql)->result();




        $sql = "SELECT esm.examID,esm.questionID,esm.isCorrect,qt.tag FROM exam_student_mark esm "
                . "INNER JOIN question_tags qt ON esm.questionID = qt.questionID "
                . "WHERE esm.examID IN (SELECT seri.examID FROM student_exam_result_image seri WHERE seri.studentID=$studentID)";
        $data["examQuestionTag"] = $this->db->query($sql)->result();
        $sql = "SELECT esm.questionID,esm.examID,esm.isCorrect,sq.sectionID,c.sectionTitle FROM exam_student_mark esm "
                . "INNER JOIN section_questions sq ON sq.questionID=esm.questionID "
                . "INNER JOIN `cource-sections` c ON c.sectionID=sq.sectionID "
                . "WHERE esm.examID IN (SELECT seri.examID FROM student_exam_result_image seri WHERE seri.studentID=$studentID)";
        $data["examQuestionSection"] = $this->db->query($sql)->result();

        echo json_encode($data);
    }

}

// End of Home class
