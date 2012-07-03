<?php

class Crm_Project_Task_Feedback {
	public function deleteFeedback($feedbackId) {
		$this->class->db->update('projecttaskfeedback', array('deleted' => 1), 'id = '.$feedbackId);
		return true;
	}
}