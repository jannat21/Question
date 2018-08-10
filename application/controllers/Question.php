<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Question extends MY_Controller {

    function getQuestionViewInitial() {
        $obj = json_decode(file_get_contents("php://input"));

        $md5CourceID = $obj->md5CourceID;
        $md5SectionID = $obj->md5SectionID;

        $sql = "SELECT  cs.*,c.title courceTitle,p.payeName payeTitle FROM `cource-sections` cs " .
                "INNER JOIN cources c ON c.courceID=cs.`courceID` " .
                "INNER JOIN paye p ON p.payeID=c.payeID " .
                "WHERE md5(`sectionID`)='$md5SectionID'";
        $data["sectionInfo"] = $this->db->query($sql)->result();

        $sql = "SELECT * FROM `section_questions` WHERE md5(`sectionID`)='$md5SectionID'";
        $data["sectionQuestions"] = $this->db->query($sql)->result();

        $sql = "SELECT * FROM `question_items` WHERE md5(`sectionID`)='$md5SectionID'";
        $data["questionItems"] = $this->db->query($sql)->result();

        $sql = "SELECT DISTINCT(`tag`) FROM `question_tags`";
        $data["tags"] = $this->db->query($sql)->result();

        $sql = "SELECT `sectionID`,`sectionTitle` FROM `cource-sections` WHERE md5(`courceID`)='$md5CourceID'";
        $data["sections"] = $this->db->query($sql)->result();

        $sql = "SELECT DISTINCT(sq.muzu) FROM section_questions sq";
        $data["muzuList"] = $this->db->query($sql)->result();

        echo json_encode($data);
    }

    function saveQuestion() {
        $obj = json_decode(file_get_contents("php://input"));

        $question = $obj->question;
        $sectionInfo = $obj->sectionInfo[0];

        $tags = $question->tags;
        $strTags = implode(",", $tags);

        $muzu = $question->muzu[0];

        $items = $question->gozineha;

        $data_array = array(
            'sectionID' => $question->section->sectionID,
            'userID' => $this->getUserID(),
            'courceID' => $sectionInfo->courceID,
            'questionTitle' => $question->questionTitle,
            'questionAnswer' => $question->questionAnswer,
            'questionLevel' => $question->questionLevel->title,
            'questionLevelID' => $question->questionLevel->id,
            'questionTags' => $strTags,
            'muzu' => $muzu,
            'ip' => $this->input->ip_address()
        );

        if ($question->id == 0) {
            $this->db->insert('section_questions', $data_array);
            $insertID = $this->db->insert_id();

            $data_arrayItems = [];
            foreach ($items as $item) {
                $data_arrayItems[] = array(
                    'questionID' => $insertID,
                    'userID' => $this->getUserID(),
                    'courceID' => $sectionInfo->courceID,
                    'sectionID' => $sectionInfo->sectionID,
                    'itemTitle' => $item
                );
            }
            $this->db->insert_batch('question_items', $data_arrayItems);

            if (count($tags) > 0) {
                $data_arrayTags = [];
                foreach ($tags as $tag) {
                    $data_arrayTags[] = array(
                        'tag' => $tag,
                        'questionID' => $insertID,
                        'userID' => $this->getUserID(),
                        'courceID' => $sectionInfo->courceID,
                        'sectionID' => $sectionInfo->sectionID
                    );
                }
                $this->db->insert_batch('question_tags', $data_arrayTags);
            }
        } else if ($question->id > 0) {

            $this->db->where('questionID', $question->id);
            $this->db->update('section_questions', $data_array);

            $sql = "DELETE FROM `question_items` WHERE `questionID`=$question->id";
            $this->db->query($sql);

            $data_arrayItems = [];
            foreach ($items as $item) {
                $data_arrayItems[] = array(
                    'questionID' => $question->id,
                    'userID' => $this->getUserID(),
                    'courceID' => $sectionInfo->courceID,
                    'sectionID' => $question->section->sectionID,
                    'itemTitle' => $item
                );
            }
            $this->db->insert_batch('question_items', $data_arrayItems);

            $sql = "DELETE FROM `question_tags` WHERE `questionID`=$question->id";
            $this->db->query($sql);

            if (count($tags) > 0) {
                $data_arrayTags = [];
                foreach ($tags as $tag) {
                    $data_arrayTags[] = array(
                        'tag' => $tag,
                        'questionID' => $question->id,
                        'userID' => $this->getUserID(),
                        'courceID' => $sectionInfo->courceID,
                        'sectionID' => $sectionInfo->sectionID
                    );
                }
                $this->db->insert_batch('question_tags', $data_arrayTags);
            }
        }

        //get view information
        $sectionID = $sectionInfo->sectionID;
        $sql = "SELECT * FROM `section_questions` WHERE `sectionID`='$sectionID'";
        $data["sectionQuestions"] = $this->db->query($sql)->result();

        $sql = "SELECT * FROM `question_items` WHERE `sectionID`='$sectionID'";
        $data["questionItems"] = $this->db->query($sql)->result();

        $sql = "SELECT DISTINCT(`tag`) FROM `question_tags`";
        $data["tags"] = $this->db->query($sql)->result();

        echo json_encode($data);
    }

    function changeQuestionStatus() {
        $obj = json_decode(file_get_contents("php://input"));
        $questionID = $obj->questionID;
        $newStatus = $obj->newStatus;
        $this->db->where('questionID', $questionID);
        $this->db->update('section_questions', array('status' => $newStatus));
    }

}

// End of Home class
