<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MyGuests</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/inout.css">

</head>

<body>

        <div class= "container">
          <div class = "row">
            <div class = "col-md-12">

            <h1 class="text-center" style="border:1px solid black;font-size:32px;background-color:#e68a00;color:black;padding: 10px 0px;">My Guests</h1>

            <br>

            <?php

/*********************************************
| Database Credentials
*********************************************/

$servername = "localhost";
$username = "jaxcode83";
$password = "Ducks0up";
$dbname = "jaxcode83";




/*********************************************
| INSERT a Guest 
*********************************************/
          
        if (isset($_POST["addguest"])) {

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO myguests (firstname, lastname, email) VALUES ('{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['email']}')";

          if(mysqli_query($conn, $sql)){
          echo '<div class="alert alert-success">
          <strong>Success!</strong> Guest Added.
        </div>';
          } else {
          echo "Error:" .$sql. "<br>" .mysqli_error($conn);
          }

        mysqli_close($conn);
        }
        // end



/*********************************************
| UPDATE a Guest 
*********************************************/

        if (isset($_POST["updateguest"])) {

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE myguests SET firstname='{$_POST['firstname']}', lastname='{$_POST['lastname']}', email='{$_POST['email']}' WHERE id='{$_POST['id']}'";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-info">
          <strong>Success!</strong> Guest Updated.
        </div>';
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

        mysqli_close($conn);

        }



/*********************************************
| DELETE a Guest  
*********************************************/
          
        if(isset($_POST['delete'])) {

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "DELETE FROM myguests WHERE id='{$_POST['id']}'";

          if (mysqli_query($conn, $sql)) {
          echo '<div class="alert alert-warning">
          <strong>Warning!</strong> Guest Deleted.
        </div>';
          } else {
          echo "Error deleting record: " . mysqli_error($conn);
          }

        mysqli_close($conn);
        }
        // end

        ?>


<!-- ADD GUEST FORM -->

        <form action="index.php" method="POST">
          <div class="form-group">
            <label for="firstname">First Name:</label>
             <input type="text" name="firstname" class="form-control" id="firstname" required <? if(isset($_POST['edit'])) { echo 'value="'.$_POST['firstname'].'"'; } ?>>
           </div>
          <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" class="form-control" id="lastname" required <? if(isset($_POST['edit'])) { echo 'value="'.$_POST['lastname'].'"'; } ?>>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" required <? if(isset($_POST['edit'])) { echo 'value="'.$_POST['email'].'"'; } ?>>
          </div>

        <? if(isset($_POST['edit'])) { ?>
        <input type="hidden" name="id" value="<?=$_POST['id']?>">
        <button type="submit" name="updateguest" class="btn btn-default">Update Guest</button>

        <? } else { ?>
          <button type="submit" name="addguest" class="btn btn-default">Add Guest</button>
        <? } ?>
        </form>
<!-- END ADD GUEST FORM -->

        <br><br>

<!-- GUEST LIST -->
        <div class="table-responsive"><table class="table table-striped table-hover">
          <caption class="text-center" style="font-size:26px;">Guest List</caption>
            <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Registration Date</th>
            <th>Edit</th>
            <th>Delete</th>
            </tr>
          <?

/*********************************************
| SELECT all Guests 
*********************************************/

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM myguests ORDER BY lastname";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
            <td><?=$row['firstname']?></td>
            <td><?=$row['lastname']?></td>
            <td><?=$row['email']?></td>
            <td><?=$row['reg_date']?></td>
            <td>
                <form action="index.php" method="POST">
                  <input type="hidden" name="id" value="<?=$row['id']?>">
                  <input type="hidden" name="firstname" value="<?=$row['firstname']?>">
                  <input type="hidden" name="lastname" value="<?=$row['lastname']?>">
                  <input type="hidden" name="email" value="<?=$row['email']?>">
                  <input type="hidden" name="edit" value="yes">
                  <button type="submit" class="btn btn-success btn-xs">Edit</button>
                </form>
            </td>
            <td>
                <form action="index.php" method="POST">
                  <input type="hidden" name="id" value="<?=$row['id']?>">
                  <input type="hidden" name="delete" value="yes">
                  <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                </form>
            </td>
            </tr>
        <?
            }
        } else {
            echo "0 results";
        }

        mysqli_close($conn);

        ?>
        </table>
      </div>

<!-- END GUEST LIST -->

</body>

</html>