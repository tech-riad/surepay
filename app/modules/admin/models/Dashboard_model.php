<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends MY_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_by_date($table_date)
    {
        $dates = $this->input->post('dates');
        
        if($dates=='Today'){
            $this->db->where("DATE($table_date)",date("Y-m-d"));
        }
        if($dates=='Weekly'){
            $this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)");
        }
        if($dates=='Monthly'){
            $this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)");
        }
        if($dates=='Yearly'){
            $this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)");
        }
    }
    public function breadboard_values()
    {   
        $dates = $this->input->post('dates');
        $info=array();
        
        //users        
        $info['tot_users'] = $this->count_results('id', USERS);
        $info['tot_in_users'] = $this->count_results('id', USERS,['status'=>0]);
        $this->get_by_date('created_at');
        $info['s_users'] = $this->count_results('id', USERS).' '.$dates.' users';

        $this->get_by_date('created_at');
        $info['s_in_users'] = $this->count_results('id', USERS,['status'=>0]);


        //transactions
        $info['tot_trx'] = $this->count_results('id', TRANSACTION_LOGS);
        $info['tot_in_trx'] = $this->count_results('id', TRANSACTION_LOGS,['status'=>0]);
        $this->get_by_date('created');
        $info['s_trx'] = $this->count_results('id', TRANSACTION_LOGS).' '.$dates.' Trx';

        $this->get_by_date('created');
        $info['s_in_trx'] = $this->count_results('id', TRANSACTION_LOGS,['status'=>0]);


        //invoice
        $info['tot_invoice'] = $this->count_results('id', INVOICE);
        $info['tot_in_invoice'] = $this->count_results('id', INVOICE,['status'=>0]);
        $this->get_by_date('created');
        $info['s_invoice'] = $this->count_results('id', INVOICE).' '.$dates.' invoice';

        $this->get_by_date('created');
        $info['s_in_invoice'] = $this->count_results('id', INVOICE,['status'=>0]);


        //tickets
        $info['tot_tickets'] = $this->count_results('id', TICKETS);
        
        $this->get_by_date('created');
        $info['s_tickets'] = $this->count_results('id', TICKETS).' '.$dates.' tickets';

        $info['ans_tickets'] = $this->count_results('id', TICKETS,['status'=>'answered']);

        $this->get_by_date('created');
        $info['s_ans_tickets'] = $this->count_results('id', TICKETS,['status'=>'answered']);




        return $info;
    }

    public function lineChart2()
    {
        $line_chart=[];


        for ($i=11; $i >= 0; $i--) { 

              //Date
              $line_charts['date'][$i] = date("Y-m-d",strtotime("-".$i." months"));
              $period = date("M,y",strtotime($line_charts['date'][$i]));

              
              $this->db->select("COALESCE(SUM(amount),0) AS amount");
              $this->db->from(TRANSACTION_LOGS);
              $this->db->where("status",1);
              $this->db->where("month(created)",date("m",strtotime($line_charts['date'][$i])));
              $this->db->where("year(created)",date("Y",strtotime($line_charts['date'][$i])));
              $q1=$this->db->get()->row();
              $this->db->get_compiled_select();
              $success_trx=$q1->amount;


              $this->db->select("COALESCE(SUM(amount),0) AS amount");
              $this->db->from(TRANSACTION_LOGS);
              $this->db->where("status",0);
              $this->db->where("month(created)",date("m",strtotime($line_charts['date'][$i])));
              $this->db->where("year(created)",date("Y",strtotime($line_charts['date'][$i])));
              $q1=$this->db->get()->row();
              $this->db->get_compiled_select();
              $failed_trx=$q1->amount;

              $line_chart[]=[
                'period'     =>$period,
                'success_trx'=>$success_trx,
                'failed_trx'=>$failed_trx,
              ];             

          }

        

        return $line_chart;
    }

    public function barChart()
    {
        $bar_chart = [];

        for ($i = 0; $i <=30; $i++) {
            $bkash = 0;
            $nagad = 0;
            $rocket = 0;
            $other = 0;

            // Date
            $bar_charts['date'][$i] = date("Y-m-d", strtotime("-" . $i . " days"));
            $period = date("M, d", strtotime($bar_charts['date'][$i]));

            $this->db->select("amount, type");
            $this->db->from(TRANSACTION_LOGS);
            $this->db->where("status", 1);
            $this->db->where("DATE(created)", date("Y-m-d", strtotime($bar_charts['date'][$i])));
            $q1 = $this->db->get()->result_array();
            
            foreach ($q1 as $q) {
                if ($q['type'] == 'bkash') {
                    $bkash += $q['amount'];
                } elseif ($q['type'] == 'nagad') {
                    $nagad += $q['amount'];
                } elseif ($q['type'] == 'rocket') {
                    $rocket += $q['amount'];
                } else {
                    $other += $q['amount'];
                }
            }

            $bar_chart[] = [
                'period' => $period,
                'bkash' => $bkash,
                'nagad' => $nagad,
                'rocket' => $rocket,
                'other' => $other,
            ];
        }

        return $bar_chart;
    }
}
