<?php
	require_once("functions.php");
	require_once("InterestManager.class.php");
	
	if(!isset($_SESSION["user_id"])){
		header("Location: login.php");
        exit();
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
        exit();
	}
    
    //***************
    //** HALDUS *****
    //***************
	
    $InterestManager = new InterestManager($mysqli, $_SESSION["user_id"]);
    
    if(isset($_GET["new_interest"])){
        $add_interest_response = $InterestManager->addInterest($_GET["new_interest"]);
    }
?>

  <?php if(isset($add_interest_response->success)): ?>
  
  <p style="color:green;">
    <?=$add_interest_response->success->message;?>
  </p>
  
  <?php elseif(isset($add_interest_response->error)): ?>
  
  <p style="color:red;">
    <?=$add_interest_response->error->message;?>
  </p>
   
  <?php endif; ?>



<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

</h2>Lisa huviala</h2>
<form> 
    <input name="new_interest"> <br>
    <input type="submit">
</form>

<h2>Minu huvialad</h2>

<?=$InterestManager->createDropdown();?>
<input type="submit" name="lisa" value="lisa">














