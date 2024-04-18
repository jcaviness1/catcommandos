<?php 
    include('config.php');
    
    //Check the Task ID in URL
    
    if(isset($_GET['task_id']))
    {
        //Get the Values from DAtabase
        $task_id = $_GET['task_id'];
        
        //Connect Database
        $conn = mysqli_connect(LOCALHOST, DBUSER, DBPASS) or die("Couldn't connect");
        
        //Select Database
        $db_select = mysqli_select_db($conn, DB_NAME) or die("Couldn't connect");
        
        //SQL Query to Get the detail of selected task
        $sql = "SELECT * FROM tasktbl WHERE task_id=$task_id";
        
        //Execute Query
        $res = mysqli_query($conn, $sql);
        
        //Check if the query executed successfully or not
        if($res==true)
        {
            //Query <br />Executed
            $row = mysqli_fetch_assoc($res);
            
            //Get the Individual Value
            $task_name = $row['task_name'];
            $task_description = $row['task_description'];
            $listid = $row['listid'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];
        }
    }
    else
    {
        //Redirect to Homepage
        header('location:'.SITEURL);
    }
?>

<html>
    <head>
        <title>To Do List</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>style.css" />
    </head>
    
    <body>
        
        <div class="wrapper">
        
        <h1>To Do List</h1>
        
        <p>
            <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
        </p>
        
        <h3>Update Task Page</h3>
        
        <p>
            <?php 
                if(isset($_SESSION['update_fail']))
                {
                    echo $_SESSION['update_fail'];
                    unset($_SESSION['update_fail']);
                }
            ?>
        </p>
        
        <form method="POST" action="">
        
            <table class="tbl-half">
                <tr>
                    <td>Task Name: </td>
                    <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required" /></td>
                </tr>
                
                <tr>
                    <td>Task Description: </td>
                    <td>
                        <textarea name="task_description">
                        <?php echo $task_description; ?>
                        </textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>Select List: </td>
                    <td>
                        <select name="listid">
                            
                            <?php 
                                //Connect Database
                                $conn2 = mysqli_connect(LOCALHOST, DBUSER, DBPASS) or die("Couldn't connect");
                                
                                //SElect Database
                                $db_select2 = mysqli_select_db($conn2, DB_NAME) or die("Couldn't connect");
                                
                                //SQL Query to GET Lists
                                $sql2 = "SELECT * FROM listtbls";
                                
                                //Execute Query
                                $res2 = mysqli_query($conn2, $sql2);
                                
                                //Check if executed successfully or not
                                if($res2==true)
                                {
                                    //Display the Lists
                                    //Count Rows
                                    $count_rows2 = mysqli_num_rows($res2);
                                    
                                    //Check whether list is added or not
                                    if($count_rows2>0)
                                    {
                                        //Lists are Added
                                        while($row2=mysqli_fetch_assoc($res2))
                                        {
                                            //Get individual value
                                            $listid_db = $row2['listid'];
                                            $listname = $row2['listname'];
                                            ?>
                                            
                                            <option <?php if($listid_db==$listid){echo "selected='selected'";} ?> value="<?php echo $listid_db; ?>"><?php echo $listname; ?></option>
                                            
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //No List Added
                                        //Display None as option
                                        ?>
                                        <option <?php if($listid=0){echo "selected='selected'";} ?> value="0">None</option>p
                                        <?php
                                    }
                                }
                            ?>
                            
                            
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Priority: </td>
                    <td>
                        <select name="priority">
                            <option <?php if($priority=="High"){echo "selected='selected'";} ?> value="High">High</option>
                            <option <?php if($priority=="Medium"){echo "selected='selected'";} ?> value="Medium">Medium</option>
                            <option <?php if($priority=="Low"){echo "selected='selected'";} ?> value="Low">Low</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Deadline: </td>
                    <td><input type="date" name="deadline" value="<?php echo $deadline; ?>" /></td>
                </tr>
                
                <tr>
                    <td><input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE" /></td>
                </tr>
                
            </table>
        
        </form>
        </div>
    </body>
</html>


<?php 

    //Check if the button is clicked
    if(isset($_POST['submit']))
    {
        //echo "Clicked";
        
        //Get the CAlues from Form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $listid = $_POST['listid'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];
        
        //Connect Database
        $conn3 = mysqli_connect(LOCALHOST, DBUSER, DBPASS) or die("Couldn't connect");
        
        //SElect Database
        $db_select3 = mysqli_select_db($conn3, DB_NAME) or die("Couldn't connect");
        
        //CREATE SQL QUery to Update TAsk
        $sql3 = "UPDATE tasktbl SET 
        task_name = '$task_name',
        task_description = '$task_description',
        listid = '$listid',
        priority = '$priority',
        deadline = '$deadline'
        WHERE 
        task_id = $task_id
        ";
        
        //Execute Query
        $res3 = mysqli_query($conn3, $sql3);
        
        //CHeck whether the Query Executed of Not
        if($res3==true)
        {
            //Query Executed and Task Updated
            $_SESSION['update'] = "Task Updated Successfully.";
            
            //Redirect to Home Page
            header('location:'.SITEURL);
        }
        else
        {
            //FAiled to Update Task
            $_SESSION['update_fail'] = "Failed to Update Task";
            
            //Redirect to this Page
            header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
        }
        
        
    }

?>








































