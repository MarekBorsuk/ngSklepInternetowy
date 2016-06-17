<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends CI_Controller {

	
	public function upload($id){

		if ( !empty( $_FILES ) ) {
		    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];

		    $basePath = FCPATH.'..'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
		    $basePath = $basePath.$id.DIRECTORY_SEPARATOR;
		    mkdir($basePath, 0700);
		    		    
		    $uploadPath = $basePath.$_FILES[ 'file' ][ 'name' ];
		    move_uploaded_file( $tempPath, $uploadPath );

		    $answer = array( 'answer' => 'File transfer completed' );

		    $json = json_encode( $answer );

		    echo $json;
		} 
		else{
		    echo 'No files';
		}
	}

	public function get($id){

		$basePath = FCPATH.'..'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
		$basePath = $basePath.$id.DIRECTORY_SEPARATOR;

		if(!is_dir($basePath)){
			return;
		}

		$files = scandir($basePath);
		$files = array_diff($files, array('.','..'));

		$newFiles = array();
		foreach($files as $file){
			$newFiles[] .= $file;			
		}

		echo json_encode($newFiles);

	}

	public function delete(){
		$post = file_get_contents('php://input');
		$_POST = json_decode($post, true); //true po to aby zwróciła tablicę a nie obiekt
		
		$id = $this->input->post('id');
		$image = $this->input->post('image');

		$imagePath = FCPATH.'..'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
		$imagePath = $imagePath.$id.DIRECTORY_SEPARATOR;
		$imagePath = $imagePath.$image;

		unlink($imagePath);
	}
}
