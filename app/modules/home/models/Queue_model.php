<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue_model extends MY_Model {
    
    public function addTask($taskType, $taskData) {
        $this->db->insert('queue', ['task_type' => $taskType, 'task_data' => $taskData]);
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }
        return FALSE;
    }

    public function getPendingTask() {
        return $this->db->get_where('queue', ['status' => 'pending'], 1)->row_array();
    }

    public function markTaskAsProcessing($id) {
        $this->db->where('id', $id)->update('queue', ['status' => 'processing']);
    }

    public function markTaskAsCompleted($id) {
        $this->db->where('id', $id)->update('queue', ['status' => 'completed']);
    }

    public function markTaskAsFailed($id) {
        $this->db->where('id', $id)->update('queue', ['status' => 'failed']);
    }
}
