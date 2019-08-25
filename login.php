
<?php
    include 'Connection.php';
    session_start();
    if(isset($_POST['submit']))
{
        // keep track validation errors
        $nameError = null;
        $passwordError = null;
        
        $email=$_POST['email'];
	$user_password=$_POST['password'];
        // validate input
        $valid = true;
        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
        if (empty($user_password)) 
         {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
         }
        // update data
        if ($valid) {
            $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql ="select * from customer where email='$email' AND password='$user_password'";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        foreach ($pdo->query($sql) as $row) 
	{	
			if($row>0)
			{
                            $_SESSION['Firstname'] = $data['firstname'];
                            $_SESSION['Lastnmae']  = $data['lastname'];
                            $_SESSION['id']        = $data['customer_id'];
				header('location:dashboard.php');	
			}
			else
			{
				echo '<div class="alert alert-info"> <strong>Info!</strong> Indicates a neutral informative change or action </div>';
                                header('location: index.html');
				 Database::disconnect();
			}
	}
        Database::disconnect();

        }
    } 
?>
 
