<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Question extends MY_Controller {
    
    
    function getQuestionViewInitial(){
        $obj=json_decode(file_get_contents("php://input"));
        
        $md5CourceID=$obj->md5CourceID;
        $md5SectionID=$obj->md5SectionID;
        
        $sql="SELECT  cs.*,c.title courceTitle,p.payeName payeTitle FROM `cource-sections` cs ".
            "INNER JOIN cources c ON c.courceID=cs.`courceID` ".
            "INNER JOIN paye p ON p.payeID=c.payeID ".
            "WHERE md5(`sectionID`)='$md5SectionID'";
        $data["sectionInfo"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `section_questions` WHERE md5(`sectionID`)='$md5SectionID'";
        $data["sectionQuestions"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `question_items` WHERE md5(`sectionID`)='$md5SectionID'";
        $data["questionItems"]=$this->db->query($sql)->result();
        
        $sql="SELECT DISTINCT(`tag`) FROM `question_tags`";
        $data["tags"]=$this->db->query($sql)->result();
        
        echo json_encode($data);
        
    }
    
    function saveQuestion(){
        $obj=json_decode(file_get_contents("php://input"));
        $question=$obj->question;
        $sectionInfo=$obj->sectionInfo[0];
        
        $tags=$question->tags;
        $strTags=implode(",",$tags);

        $items=$question->gozineha;
        
        $data_array=array(
            'sectionID'=>$sectionInfo->sectionID,
            'userID'=>$this->getUserID(),
            'courceID'=>$sectionInfo->courceID,
            'questionTitle'=>$question->questionTitle,
            'questionAnswer'=>$question->questionAnswer,
            'questionLevel'=>$question->questionLevel,
            'questionTags'=>$strTags,
            'ip'=>$this->input->ip_address()
            );
        $this->db->insert('section_questions',$data_array);
        $insertID=$this->db->insert_id();
        
        $data_arrayItems=[];
        foreach($items as $item){
            $data_arrayItems[]=array(
            'questionID'=>$insertID,
            'userID'=>$this->getUserID(),
            'courceID'=>$sectionInfo->courceID,
            'sectionID'=>$sectionInfo->sectionID,
            'itemTitle'=>$item
            );
        }
        $this->db->insert_batch('question_items',$data_arrayItems);
        
        $data_arrayTags=[];
        foreach($tags as $tag){
            $data_arrayTags[]=array(
                'tag'=>$tag,
                'questionID'=>$insertID,
                'userID'=>$this->getUserID(),
                'courceID'=>$sectionInfo->courceID,
                'sectionID'=>$sectionInfo->sectionID
            );
        }
        
        $this->db->insert_batch('question_tags',$data_arrayTags);
        
        $sectionID=$sectionInfo->sectionID;
        $sql="SELECT * FROM `section_questions` WHERE `sectionID`='$sectionID'";
        $data["sectionQuestions"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `question_items` WHERE `sectionID`='$sectionID'";
        $data["questionItems"]=$this->db->query($sql)->result();
        
        $sql="SELECT DISTINCT(`tag`) FROM `question_tags`";
        $data["tags"]=$this->db->query($sql)->result();
        
        echo json_encode($data);
        
    }

    /*function getCourceSectionQuestions(){
        $obj=file_get_contents("php://input");
        print_r($obj);
        exit();
        
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
    }*/
    

}

// End of Home class
