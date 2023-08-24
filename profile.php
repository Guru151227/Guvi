<?php 

session_start();
$USERID = $_SESSION["USERID"];

if($USERID == '')
{
    session_destroy();

    header('location:index.php');
}

// Fetch User All data using USERID

include('config.php');

$query = "SELECT USERNAME,EMAIL,PASSWORD,AGE,GENDER,DOB,CONTACT FROM users WHERE USER_ID = '$USERID'";

$result = mysqli_query($conn,$query);

if($result)
{

   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

   $USERNAME = $row["USERNAME"];
   $EMAIL = $row["EMAIL"];
   $PASSWORD = $row["PASSWORD"];
   $AGE = $row["AGE"];
   $GENDER = $row["GENDER"];
   $DOB = $row["DOB"];
   $CONTACT = $row["CONTACT"];
}
else
{
    echo "<script> alert('Unexpected Error'); </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="design.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body style="background: rgba(0, 128, 0, 0.3);">


    <div class="Nav">
    <h1>Welcome <?php echo $USERNAME ?></h1>
    <div class="navi_1">
    <!-- <button type="button" class="btn btn-link"><a href="Home.php">Home</a></button> -->
    <!-- <button type="button" class="btn btn-link"><a href="About.php">About</a></button> -->
    <!-- <button type="button" class="btn btn-link"><a href="profile.php"><strong>Profile</strong></a></button> -->
    <button type="button" class="btn btn-link"><a href="logout.php"><strong>Logout</strong></a></button>
    <!-- <button type="button" class="btn btn-link">Logout</button> -->
    </div>
    </div>

    <div class="profile_div"><h1 id="subtitle">Profile<h1></div>


   
    <div class="center" style="border-width:9px; border-style:solid;height: 700px;width: 500px;margin:40px 520px;">
    <div class="update_form">
        <div class="partition">
        <div class="mb-3">
            <label for="FullName" class="form-label"><b>Full Name</b></label>
            <input type="text" class="form-control" value="<?php echo $USERNAME ?>" id="exampleFormControlInput1" name="FullName" placeholder="Ex: Raja" style="width: 400px;">
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label"><b>Email</b></label>
            <input type="email" class="form-control" value="<?php echo $EMAIL ?>" id="exampleFormControlInput1" name="Email" placeholder="name@example.com" style="width: 400px;">
        </div>
        <div class="mb-3">
            <label for="Password" class="form-label"><b>Password</b></label>
            <input type="password" class="form-control" value="<?php echo $PASSWORD ?>" id="exampleFormControlInput1" name="Password" placeholder="password" style="width: 400px;">
        </div>
        <div class="mb-3">
            <label for="Age" class="form-label"><b>Age</b></label>
            <input type="number" class="form-control" value="<?php echo $AGE ?>" id="exampleFormControlInput1" name="Age" placeholder="Age"  style="width: 400px;">
        </div>
        <div class="mb-3">
            <label for="Dob" class="form-label"><b>Date Of birth</b></label>
            <input type="date" class="form-control" value="<?php echo $DOB ?>" id="exampleFormControlInput1" name="Dob" style="width: 400px;">
        </div>
        <div class="mb-3">
            <label for="Gender" class="form-label"><b>Gender</b></label>
            <input type="text" class="form-control"  value="<?php echo $GENDER ?>" id="exampleFormControlInput1" name="Gender" placeholder="Gender" style="width: 400px;">
        </div>
        <div class="mb-3">
            <label for="Contact" class="form-label"><b>Contact</b></label>
            <input type="number" class="form-control" value="<?php echo $CONTACT ?>" id="exampleFormControlInput1" name="Contact" placeholder="Mobile Number" style="width: 400px;">
        </div>
        <button type="submit" class="btn btn-primary" onclick="Update()">Update</button>
</div>
    </div>
</div>




<script>
    function Update(){

        var FullName = $("input[name=FullName]").val();
        var Email = $("input[name=Email]").val();
        var Password = $("input[name=Password]").val();
        var Age = $("input[name=Age]").val();
        var Dob = $("input[name=Dob]").val();
        var Gender = $("input[name=Gender]").val();
        var Contact = $("input[name=Contact]").val();

        var user_info = {
            FullName : FullName,
            Email:Email,
            Password:Password,
            Age:Age,
            Dob:Dob,
            Gender:Gender,
            Contact:Contact,
            UserId:<?php echo  $USERID; ?>
        }

        $.ajax({
                type: "POST",
                url: 'update.php',
                data: user_info,
                success: function(response)
                {
                    var response = JSON.parse(response);
                    if(response)
                    {
                        console.log(response.status);

                        if(response.status == 'success')
                        {
                                alert('The Record has been Updated.....');
                                location.reload();
                        }
                        else if(response.status == 'failed')
                        {
                                alert(response.error);
                        }
                    }
                    else
                    {
                        console.log('Error');
                    }
                }
        });
    }
</script>
    
</body>
</html>