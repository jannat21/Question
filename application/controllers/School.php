<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class School extends MY_Controller {

    function addNewSchool() {
        $obj = json_decode(file_get_contents("php://input"));
        $schoolName = $obj->schoolName;
        $this->db->insert('school', array('title' => $schoolName, 'userID' => $this->getUserID()));

        echo json_encode($this->getSchoolClass());
    }

    function addNewClass() {
        $obj = json_decode(file_get_contents("php://input"));
        $className = $obj->className;
        $schoolID = $obj->schoolID;
        $this->db->insert('school_class', array('title' => $className, 'schoolID' => $schoolID, 'userID' => $this->getUserID()));

        echo json_encode($this->getSchoolClass());
    }

    function getInitialData() {
        echo json_encode($this->getSchoolClass());
    }

    function getSchoolClass() {
        $userID = $this->getUserID();
        $sql = "SELECT * FROM `school` s WHERE s.userID=$userID";
        $data["school"] = $this->db->query($sql)->result();
        $sql = "SELECT sc.*,md5(sc.id) md5ClassID FROM `school_class` sc WHERE sc.userID=$userID";
        $data["school_class"] = $this->db->query($sql)->result();
        return $data;
    }

    function saveNewStudent() {
        $obj = json_decode(file_get_contents("php://input"));
        $selectedClass = $obj->selectedClass;
        $newStudent = $obj->newStudent;

        $studentCod = $newStudent->code;
        $sql = "SELECT * FROM class_student WHERE studentCode=$studentCod";
        $res = $this->db->query($sql)->result();
        if (count($res) > 0) {
            $data["result"] = "repeated";
        } else {
            $data_array = array(
                'studentCode' => $studentCod,
                'studentName' => $newStudent->name,
                'studentFamily' => $newStudent->family,
                'classID' => $selectedClass->id,
                'schoolID' => $selectedClass->schoolID,
                'userID' => $this->getUserID()
            );
            $this->db->insert('class_student', $data_array);
            $this->db->insert('users', array('userName' => $studentCod, 'password' => md5($studentCod), 'active' => 1, 'userType' => 'student', 'name' => $newStudent->name, 'family' => $newStudent->family));
            $data["result"] = "success";
            $data["data"] = $this->getClassStudentList($selectedClass->id, $selectedClass->schoolID);
        }
        echo json_encode($data);
    }

    function getClassStudents() {
        $obj = json_decode(file_get_contents("php://input"));
        $selectedClass = $obj->selectedClass;
        echo json_encode($this->getClassStudentList($selectedClass->id, $selectedClass->schoolID));
    }

    private function getClassStudentList($ClassID, $schoolID) {
        $sql = "SELECT * FROM class_student WHERE classID=$ClassID AND schoolID=$schoolID";
        return $this->db->query($sql)->result();
    }

    function exportClassStudent2Excel($md5ClassID) {

        
        $sql = "SELECT * FROM class_student WHERE md5(classID)='$md5ClassID'";
        $res = $this->db->query($sql)->result();
        $columnHeader = "" . "\t" . "#" . "\t" . "کد دانش آموزی" . "\t" . "نام" . "\t" . "نام خانوادگی" . "\t";
        $setData = '';
        $counter = 0;
        print_r($res[0]->studentCode);

        foreach ($res as $r) {
            $counter += 1;
            $rowData = $counter . "\t";

            $rowData .= $r->studentCode . "\t";
            $rowData .= $r->studentName . "\t";
            $rowData .= $r->studentFamily . "\t";
            $setData .= trim($rowData) . "\n";
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=User_Detail_Reoprt.xls");
        header('Content-Transfer-Encoding: binary');
        header("Pragma: no-cache");
        header("Expires: 0");

        echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");
    }

}

// End of Home class
