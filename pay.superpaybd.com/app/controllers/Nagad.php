<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nagad extends CI_Controller {

	public function index()
	{
		

		$this->load->library("firebase");
		$this->firebase_lib = new firebase(FIREBASE_URL);


		// Define the data you want to insert (as an associative array)
		$dataToInsert = array(
		    'name' => 'John Doe',
		    'email' => 'john@example.com',
		    'age' => 30
		);

		// Call the insert function to add data to the Firebase database
		$response = $this->firebase_lib->insert("users", json_encode($dataToInsert));

		// Handle the response as needed
		if ($response === false) {
		    echo 'Insertion failed.';
		} else {
		    echo 'Data inserted successfully.';
		}
	}

}

/* End of file Nagad.php */
/* Location: .//E/laragon/www/payment/app/controllers/Nagad.php */