<?php
class InterestManager {
    
    private $connection;
    private $user_id;
    
    function __construct($mysqli, $user_id){
        
        $this->connection = $mysqli;
        $this->user_id = $user_id;
        
    }
    
    function addInterest($name){
        
		$response = new StdClass();
		//kas selline interest olemas
		$stmt = $this->connection->prepare("SELECT id FROM Interests WHERE name = ?");
        echo $this->connection->error;
		$stmt->bind_param("s", $name);
        echo $stmt->error;
		$stmt->execute();
		
		//kas oli 1 rida andmeid
		if($stmt->fetch()){
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Huviala '".$name."' on juba olemas!";
			$response->error = $error;
			return $response;
		}
	
		//*************************
		//******* OLULINE *********
		//*************************
		//panen eelmise käsu kinni
		$stmt->close();
	
		$stmt = $this->connection->prepare("INSERT INTO Interests (name) VALUES (?)");
		$stmt->bind_param("s", $name);
		
		if($stmt->execute()){
			// edukalt salvestas
			$success = new StdClass();
			$success->message = "Huviala edukalt salvestatud";
			$response->success = $success;
			
		}else{
			// midagi läks katki
			$error = new StdClass();
			
			$error->id =1;
			echo $stmt->error;
			$error->message = "Midagi läks katki!";
			$response->error = $error;
		}
		
		$stmt->close();
		
		return $response;
    }
    
    function createDropdown(){
        
        $html = '';
        
        //liidan eelmisele juurde
        $html .= '<select name="dropdown_interest">';
        
        $stmt = $this->connection->prepare("SELECT id, name FROM Interests");
        $stmt->bind_result($id, $name);
        $stmt->execute();
        
        //iga rea kohta
        while($stmt->fetch()){
            
            $html .= '<option value="'.$id.'">'.$name.'</option>';
            
        }
        
        $stmt->close();
        
        //$html .= '<option selected >Test 2</option>';
        
        $html .= '</select>';
        
        return $html;
        
    }
  
} ?>