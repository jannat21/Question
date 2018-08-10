<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Examination extends MY_Controller {
    
    function getExaminationInitial(){
        $userID=$this->getUserID();
        $sql="SELECT c.*,p.payeName FROM `cources` c 
        INNER JOIN paye p on p.payeID=c.payeID WHERE `userID`=$userID";
        $data["cource"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `question_tags` WHERE `userID`=$userID";
        $data["questionTags"]=$this->db->query($sql)->result();
        
        $sql="SELECT * FROM `cource-sections` WHERE `userID`=$userID";
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
    
    function export2Word(){
        
        redirect('testWord', 'refresh');
        
        
        
        /*
        $obj=json_decode(file_get_contents("php://input"));
         $res=$this->db->get('section_questions')->result();
        
        $columnHeader = '';
        $setData = '';
        
        foreach($res as $r){
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
         
        echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");
         */
        //print_r($obj);
    }
    
    function testWord(){
        
        $res=$this->db->get('section_questions')->result();
        
        $columnHeader = '';
        $setData = '';
        
        foreach($res as $r){
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
         
        echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $columnHeader . "\n" . $setData . "\n");
         
        exit();
       /* 
        header("Content-type: application/vnd.ms-word"); 
        header("Content-Disposition: attachment;Filename=Wordfile.doc");
        header("Pragma: no-cache");
        header("Expires: 0");
        $current_date = date('d-m-Y');
        $heading ="Hello";
        $content = "Content";
        echo "<div style='font-size: 1em; line-height: 1.6em; color: #4E6CA3; padding:10px;' align='right'>Report Date: $current_date</div>";
        echo "<div style='font-size: 1em; line-height: 1.6em; color: #4E6CA3; padding:10px;' align='left'>$heading</div>";
        echo "<div style='font-size: 1em; line-height: 1.6em; color: #4E6CA3; padding:10px;' align='left'>$content</div>";
        */
        
       
    }

}

// End of Home class
