<?php


    require 'config.php';
    
    $config = new Config();
    $conn = $config->getConnection();

    if(isset($_POST['resetCode'])){
       
            $sql = "select id,idno from tblstudent";
            $query = mysqli_query($conn, $sql);
            $response = mysqli_fetch_all($query, MYSQLI_ASSOC);
            
            foreach($response as $row) {
                $prefix = md5($row['idno'].date('Y-m-d h:i:s a'));
                $uni = uniqid(substr($prefix, 4, 6),true);
                $suffix = str_shuffle('abcdefghijklmnopqrstuvwxyz');
                $votingcode = strtoupper(substr($suffix , 0 ,3).'-'. substr(str_shuffle(strrev(str_replace(".","",$uni))),0 ,6));
                $sql = 'update tblstudent set votingcode = ? where id = ?';
                $qry= $conn->prepare($sql);
                $qry->bind_param('si',$votingcode, $row['id']);
                $qry->execute();
            }
        }

        echo '
        <script>      
        alert("A new list of STUDENT VOTING CODES have been generated !")
            window.history.back(); // Simulates a back button click
        </script>';
 ?>
   

  



