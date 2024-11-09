<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Workers extends MX_Controller {

    public function processQueue() {

        $this->load->model('Queue_model');

        while (true) {
            $task = $this->Queue_model->getPendingTask();

            if (!empty($task)) {
                $task_id = $task['id'];

                $this->Queue_model->markTaskAsProcessing($task_id);

                switch ($task['task_type']) {
                    case 'send_email':
                        $emailData = json_decode($task['task_data'], true);

                        $this->sendEmail($emailData['to'], $emailData['subject'], $emailData['message']);
                        break;

                    default:
                        break;
                }

                $this->Queue_model->markTaskAsCompleted($task_id);
            } else {
                sleep(5); 
            }
        }
    }

    private function sendEmail($to, $subject, $message) {
        $mail_params = [
            'template' => [
                'subject' => $subject,
                'message' => $message,
                'type' => 'default',
            ],
        ];
        $this->Queue_model->send_mail_template($mail_params['template'], $to);
    }
}
