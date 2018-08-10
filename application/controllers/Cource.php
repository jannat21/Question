<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Cource extends MY_Controller {

    function getCourceSections(){
        $md5ID=file_get_contents("php://input");
        $sql="SELECT * FROM `cources` c INNER JOIN paye p on p.payeID=c.`payeID` WHERE md5(`courceID`)='$md5ID'";
        $data["CourceInfo"]=$this->db->query($sql)->result();
        $sql="SELECT cs.*,MD5(cs.courceID) md5courceID,MD5(cs.sectionID) md5sectionID, IFNULL(count_questions.count_question,0) count_question FROM `cource-sections` cs"
                . " LEFT JOIN ("
                . "SELECT COUNT(sq.questionID) count_question,sq.sectionID count_sectionID "
                . "FROM section_questions sq WHERE MD5(sq.courceID)='$md5ID' GROUP BY sq.sectionID) count_questions "
                . "ON count_questions.count_sectionID= cs.sectionID "
                . "WHERE md5(cs.courceID)='$md5ID'";
        $data["CourceSections"]=$this->db->query($sql)->result();
        echo json_encode($data);
    }
    
    function saveNewCourceSection(){
        $obj=json_decode(file_get_contents("php://input"));
        $courceID=$obj->cource->courceID;
        $sectionTitle=$obj->newSection;
        $data_array=array('courceID'=>$courceID,'sectionTitle'=>$sectionTitle,'userID'=>$this->getUserID());
        $this->db->insert('cource-sections',$data_array);
        
        $sql="SELECT * FROM `cource-sections` WHERE `courceID`='$courceID'";
        $data["CourceSections"]=$this->db->query($sql)->result();
        echo json_encode($data);
    }
    
    function savetofile(){
        print_r($_FILES);
        move_uploaded_file($_FILES['myFile']['tmp_name'], "uploads/" . $_FILES['myFile']['name']);
        echo 'successful';
    }
    

}

// End of Home class
