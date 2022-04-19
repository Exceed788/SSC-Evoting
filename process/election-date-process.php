<?php
    require 'config.php';
    $config = new Config();
    $conn = $config->getConnection();
    $election_id = mysqli_real_escape_string($conn, isset($_GET['election_id']) ? $_GET['election_id'] : '' );
    $election_name = mysqli_real_escape_string($conn, isset($_GET['election_name']) ? $_GET['election_name'] : '' );
    $election_date = mysqli_real_escape_string($conn, isset($_GET['election_date']) ? $_GET['election_date'] : '' );
    
    if(isset($_GET['get'])) {
        $sql = "select * from tbl_election_date order by election_date ASC";
		$query = mysqli_query($conn, $sql);
		$response = mysqli_fetch_all($query, MYSQLI_ASSOC);
		echo json_encode($response);

    } else if(isset($_GET['add'])) {
        $sql='insert into tbl_election_date VALUES(?,?,?)';
        $qry = $conn->prepare($sql);
        $id='';
        $qry->bind_param('iss', $id, $election_name , $election_date);
        if($qry->execute()) {

            echo 'success';
        } else {
            echo 'failed';
        }
    } else if(isset($_GET['update'])) {
        $sql='update tbl_election_date SET election_name = ? election_date = ? where election_date_id = ?';
        $qry = $conn->prepare($sql);
        $qry->bind_param('ssi', $election_name, $election_date, $election_id);
        if($qry->execute()) {
            echo 'success';
        } else {
            echo 'failed';
        }
    } else if(isset($_GET['delete'])) {
        $sql="delete from tbl_election_date where election_date_id = ?";
        $qry=$conn->prepare($sql);
        $qry->bind_param('i', $election_id);
        if($qry->execute()) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

?>