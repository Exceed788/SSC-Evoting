<?php    
            require '../process/config.php';
            $config = new Config();
            $conn = $config->getConnection();

            $sql = "select * from tbl_election_date order by election_date desc";
            $query = mysqli_query($conn, $sql);
            $response = mysqli_fetch_all($query, MYSQLI_ASSOC);
            $yearOpt = '';
            
            foreach($response as $row) {
                $i = false;
                $yearOpt = date('Y-m-j',strtotime($row['election_date']));
                $comparetoday = date("Y-m-j", time());  
                if($yearOpt == $comparetoday){
                    $i = true;
                }
            }
            if($i)
            echo '<form action="../process/reset-voting-code.php" method="POST">
            <h5 style="font-size: 15px;"><strong>ELECTION IS ON GOING!</strong></h5>
            <input class="btn btn-danger text-white" type="submit" disabled="true" name="resetCode" value="Generate Voting Codes"/>
            </form>';

            else
            echo '<form action="../process/reset-voting-code.php" method="POST">
            <input class="btn btn-danger text-white" type="submit"  name="resetCode" value="Generate Voting Codes"/>
            </form>';
      
            
            ?>