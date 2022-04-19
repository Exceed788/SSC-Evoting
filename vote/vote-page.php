<!Doctype html>
<html>
<?php include '../shared/head.php'; ?>
<?php include '../shared/alert.php'; ?>
<?php require '../session.php'; ?>
<?php
require '../process/config.php';
date_default_timezone_set('Asia/Manila');
$config = new Config();
$conn = $config->getConnection();
$sql = "select * from tbl_election_date order by election_date desc";
$query = mysqli_query($conn, $sql);
$response = mysqli_fetch_all($query, MYSQLI_ASSOC);
$latestElection = $response[0]['election_date_id'];
$latestElectionDate = $response[0]['election_date'];
$query->close();
$sql = "select p.*,ed.* from tblparty as p
INNER JOIN tbl_election_date as ed ON p.party_election_date_id = ed.election_date_id
INNER  JOIN tblcandidate as c on p.id = c.partyid
where p.party_election_date_id = ".$latestElection."
group by p.id";
$query = mysqli_query($conn, $sql);
$response = mysqli_fetch_all($query, MYSQLI_ASSOC);
$partyStraight = '';
foreach($response as $p) {
    $partyStraight = $partyStraight.'
    <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
    <div class="partyStraight m-2" onclick="voteStraight('.$p['id'].')">
    '.$p['partyname'].'
    </div>
    </div>';
}
$dd = date('Y-m-d');
$sql = 'select * from tbl_election_date where election_date = "'.$dd.'"';
$qry= mysqli_query($conn, $sql);
$elec_date = mysqli_fetch_all($qry,MYSQLI_ASSOC);
$electionnamee = isset($elec_date[0]['election_name']) ? $elec_date[0]['election_name'] : '<strong> <p style="font-size: 15px;"> No Election Set </p></strong>';
$datee = isset($elec_date[0]['election_date']) ? date('M d, Y', strtotime($elec_date[0]['election_date'])) : 'No Election Date Set';
$cannot_vote = isset($elec_date[0]['election_date']) ? true : false;
?>
<body>
<style>
body{
    background-color: whitesmoke;
    margin:0px;
    padding:0px;
    overflow-x:hidden;
    opacity: 1;
}
.header-card {
    padding:10px;
    background-color: deepskyblue;
    border-radius:25px;
}
.checked {
    display:block;
    color: gray;
}
.radio-wrapper{style="background-color:primary !important"
    width:40px;
}
.radio{
    border-style: solid;
    border-width: 1px;
    border-color: transparent;
    margin-top: 10px;
    border-radius:100%;
    cursor: pointer;
    margin-right:10px;
    box-shadow: -1px 1px 4px black;
}
.radio:hover {
    box-shadow: 0 0 2px dodgerblue;
}
.candidate-name p{
    padding:0px;
    margin: 0px;
}
.candidate {
    border-radius:15px;
    padding:5px;
    padding-bottom:0px;
    margin-top:40px;
    transition: 1s;
    opacity:0;
    will-change: transform;
}
.candidate-img {
    padding:7px;
}
.candidate-img img {
    border-radius:100%;
}
.check{
    margin:5px;
    color:#444444;
    opacity:0;
    transition:0.5s;
    transform:scale(0);
    transition-timing-function: cubic-bezier(0.1, 0.4 , 0.3, 1.8);
}
.check.checked{
    opacity:1;
    transform:scale(1);
    color: dodgerblue;
}

.next-prev {
    position: fixed;
    bottom: 20px;
    right:10px;
    width:100%;
    text-align: right;
    
}
.next-prev button {
    min-width:120px;
    border-radius: 5px;
    height:30px;
    border-style: none;
    box-shadow: -2px 2px 4px gray;
    background-color: white;
    color: dodgerblue;
    transition: 1s;
    margin-left:5px;
    margin-right:5px;
    cursor: pointer;
    height:40px;
    font-weight: bold;
}
.next-prev button:hover {
    background-color:white;
}
.disabled-button{
    pointer-events: none;
    opacity: 0.4;
}
.hide-button{
    display: none;
}
#studentCode{
    width:100%;
    height:100%;
    position: fixed;
    z-index:888;
    background-color:dodgerblue;
    transition: 0.5s;
}
.student-code{
    padding:5px;
}
#studentCode h1 {
    margin-top:40%;
}

.showzz {
    position:fixed;
    top:10px;
    right:10px;
    font-size:25px;
    color:white;
    z-index:9999;
    color:white;
    cursor:pointer;
    text-shadow:0px 0px 9px white;
    box-shadow: 0 0 4px white;
    width:50px;
    height:50px;
    text-align:center;
    border-radius:100%;
    border-style:none;
    background-color:transparent;
}
.showzz:hover {
    background-color:white;
    text-shadow: 0 0 9px gray;
    outline-style:none;
}
.graph {
    right: 70px;
}
#RealTimeChart {
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background-color:white;
    z-index:10000;
    overflow-y:auto;
    transition:1s;
    opacity:0;
    display:none;
}
#RealTimeChart.showw {
    opacity:1;
}
#RealTimeChart .closez{
    position: absolute;
    right:10px;
    top:10px;
    border-radius:8px;
    background-color:transparent;
    color:white;
    width:30px;
    height:30px;
    font-size:20px;
    border-radius:100%;
    border-style:none;
    box-shadow: 0 0 4px crimson;
    text-shadow: 0 0 9px crimson;
    cursor:pointer;
}
#RealTimeChart .closez:hover {
    background-color:crimson;
}
.realtime-content {
}
#voteStraight {
    position:fixed;
    top:5px;
    right:10px;
    font-size:1.1em;
    padding:8px;
    border-radius:5px;
    border-style:none;
    font-weight:bold;
    cursor:pointer;
    background-color:dodgerblue;
    color:#fff;
}
#voteStraight:hover {
    background-color:white;
    color:dodgerblue;
}
.partyStraight {
    padding:10px;
    border-radius:10px;
    cursor: pointer;
    text-align:center;
    padding-top:15px;
    padding-bottom:15px;
    font-weight:bold;
    background-color:white !important;
    box-shadow: -2px 2px 4px gray !important;
}
.partyStraight:hover{
    box-shadow: 0 0 9px dodgerblue;
    color:dodgerblue;
}
#candidatePositionName {
    font-size: 1.5em;
    margin-top:10px;
    color: #fff !important;
}
#candidateWrapper {
    margin-bottom:80px;
}

#electionDate {
    position: fixed;
    bottom:10px;
    left:10px;
    z-index: 999;
    padding: 10px;
    border-radius: 5px;
    border-radius: 5px;
    color: whitesmoke;
    background-color: transparent;
}

#logoutButton {
    position: fixed;
    bottom:10px;
    left:30px;
    padding: 10px;
    border-radius: 5px;
    border-radius: 5px;
    background-color:white !important;
}

.disabled-page {
}
#logo {
    position:fixed;
    top:30px;
    left:30px;
    z-index: 999;
}

</style>
<?php 

if (isset($_SESSION))
echo '<form id="userLogout">
<div class="logout-button"> 
    <button class="btn btn-danger" style="display:none;" type="submit" 
    id="userLogout">Logout</button>
</div>
</form>';

?>  



<h5 id='electionDate' style="margin-bottom: 50px;"> 
<label style="font-size: 15px; margin-right: 5px;">Election Today:</label> 
<small> <label style="font-size: 15px;"> <strong>  <?php echo $electionnamee; ?>  </strong> </label> </br></small>


<p id="demo" style="font-weight: bold; text-align: center; font-size: 15px;"></p>  

</strong>     

<span id="selectedDateHolder"></span>
</div>

<?php
date_default_timezone_set('Asia/Manila');

$script_tz = date_default_timezone_get();

$today = date("M j Y g:i:s", time());
$comparetoday = date("Y-m-j", time());

$config = new Config();
$conn = $config->getConnection();
$sql = "select * from tbl_election_date where election_date = '".$comparetoday."'";
$query = mysqli_query($conn, $sql);
$response = mysqli_fetch_all($query, MYSQLI_ASSOC);
if($response != null){
    foreach($response as $row) {
        $row['election_date'];
    }
    $sample = $row['election_date'];
    $latest = date("M j Y 00:00:00", strtotime($sample));

    print "<p id='electionDay' style='display:none;'> " . $latest . "</p>";
    }
?>

</h5>

<button id='voteStraight' data-toggle="modal" data-target="#voteStraightModal">Vote Straight</button>

<div class="modal fade" id="voteStraightModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
<h4 class="modal-title">Select Party</h4>
<button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
<div class='row justify-content-center' data-dismiss="modal">
<?php echo $partyStraight; ?>
</div>
</div>

<div class="modal-footer">
<button type="submit" class="btn btn-default">Close</button>
</div>
</div>
</div>
</div>



<div id="studentCode" style="background-image: url('../imgs/bl.jpg'); background-repeat: no-repeat;  background-size:cover; background-position: center; margin:auto;">
    <button class="showzz" onclick="window.location='../admin/';"><i class="fa fa-user"></i></button>
    <button class="showzz graph" onclick="graph('show')"><i class="fa fa-bar-chart"></i></button>
    <div class="row justify-content-center">
       
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><br><br><br><br><br><br><br><br><br><br>
       
       

            <div class="card student-code">


            <h4 class="text-center text-black">Voter's Login</h4>



                <div class="d-flex flex-row">
                    Student ID: <?php echo !$cannot_vote ? '<span class="text-warning">(Not Available)</span>' : '' ?>
                </div>
                    <input class="form-control" style="margin-bottom: 10px;" maxlength="7" type="text" placeholder="Input Student ID" id="studentID" <?php echo !$cannot_vote ? 'disabled' : ''; ?>>
                Voting Code: <input class="form-control" maxlength="10" type="text" placeholder="Input Voting Code..." id="votingCodeInput" <?php echo !$cannot_vote ? 'disabled' : ''; ?>>
                    <button class="btn btn-primary btn-block mt-2" onclick="submitVotingCode()">Login</button>
<!------------------------------------------------------------------------------------------------->
					<button type="button" class="btn btn-info btn-xs" style=" margin-top: 10px; " data-toggle="modal" data-target="#myModal">Intruction</button>


              <!----->      
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Guide on how to vote</h4> <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>1.  Enter voter's account using Student ID and Voter's Code.</p>
        <p>2.  Select your desired candidate by clicking the button. </p>
        <p>3.  You can click the vote straight button to select all candidates from the same 	partylist. </p>
        <p>4.  Click the submit button to cast your vote. </p>
        <p>5.  Check the live poll by clicking the bar button at the upper right corner. </p>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div> 
            </div>
            
        </div>
<!--!----------------------------------------------------------------------------------------------->

<div class="p-1  disabled-page">
<h1 id="candidatePositionName" class="text-white"></h1>
</div>
<div class="row justify-content-center ml-1 mr-1"  id='candidateWrapper'>
</div>
<div class='next-prev'>
<button onclick="prev();" id="prev">Previous</button>
<button onclick="next();"  id="next">Next</button>
<button onclick="sumbitVote();" class='hide-button'  id="submitBtn">Submit</button>
</div>



<div id="RealTimeChart">
<button class="closez" onclick="graph('close')"><i class="fa fa-close"></i></button>
<div class="realtime-content">
<?php include('live.php'); ?>
</div>
</div>
<?php include '../shared/foot.php'; ?>
</body>


<!-- logout script -->
<script>
$("userLogout").submit(function(){
    <?php
    session_destroy();
    ?>
    window.location='../vote/';  
});              
</script>

<!-- timer script -->
<script>

var a = document.getElementById("electionDay").innerHTML;

var b  = new Date(a).getTime()+(24*60*60*1000);
var countDownDate = b;
// Update the count down every 1 second
var x = setInterval(function() {
    
    // Get today's date and time
    var now = new Date().getTime();
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = " <label style='font-size: 15px'> Time Remaining: </label> <strong>" + hours + " Hours "
    + minutes + " Minutes " + seconds + " Seconds </strong>";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "ELECTION ALREADY ENDED";
    }
}, 1000);
</script>

<script type="text/javascript">
function graph(req) {
    if(req == 'show') {
        RealTimeChart.style.display= 'block';
        window.setTimeout(()=>{
            RealTimeChart.classList.add('showw');
            timer = true;
            displayz();
        },10);
    } else {
        RealTimeChart.classList.remove('showw');
        timer = false;
        window.setTimeout(()=>{
            RealTimeChart.style.display= 'none';
        },600);
    }
}
let targetPosition = 0;
let candidates = [];
let positionGroup = [];
let votes = [];
let id = "";
function getCandidate() {
    $.ajax({
        method:'GET',
        url:'../process/CandidateRoutes.php',
        data:{candidate:'candidate_vote',election_id:'<?php echo $latestElection; ?>'},
        success: (e)=> {
            studentCode.style.opacity = "0";
            studentCode.style.pointerEvents = "none";
            candidates = JSON.parse(e);
            getPosition(JSON.parse(e));
        }
    })
}
function submitVotingCode() {
    let voteCode = $("#votingCodeInput").val();
    let studentID = $("#studentID").val();
    
    if(voteCode !== "" && studentID !== ""){
        $.ajax({
            method: 'GET',
            url: '../process/vote_process.php',
            data:{checkIfVoted:123,data:voteCode,studentData:studentID, election_id:'<?php echo $latestElection; ?>'},
            success: function(e){
                let data = JSON.parse(e);
                $("#votingCodeInput").val('');
                id = String(data['data']);
                if(data['status']=="success"){
                    alertService.alert({
                        response:data['status'],
                        message: data['message']
                    });
                    voteLogin();
                } else {
                    alertService.alert({
                        response:data['status'],
                        message: data['message']
                    });
                }
            },
            error: function(e){
                alert(e);
            }
        });
    }
}
function voteLogin(){
    getCandidate();
    setTimeout(()=>{
        studentCode.style.pointerEvents = "none";
    },500);
}
function getPosition(_candidate) {
    let curPositionName = '';
    $.each(_candidate, (index, value) => {
        if(curPositionName != value.positionname) {
            curPositionName = value.positionname;
            positionGroup.push({positionName:value.positionname,votesAllowed:value.votesallowed});
        }
    });
    displayCandidate();
    disable_enable_prev_next();
}
function prev(){
    if(targetPosition > 0) {
        targetPosition--;
        displayCandidate();
    }
    disable_enable_prev_next();
}

function next(){
    if(targetPosition < positionGroup.length-1) {
        targetPosition++;
        displayCandidate();
    }
    disable_enable_prev_next();
}

function disable_enable_prev_next() {
    if(targetPosition <= 0) {
        document.getElementById('prev').classList.add('disabled-button');
    } else {
        document.getElementById('prev').classList.remove('disabled-button');
    }
    if(targetPosition >= positionGroup.length-1) {
        document.getElementById('next').classList.add('disabled-button');
        document.getElementById('next').classList.add('hide-button');
        submitBtn.classList.remove('hide-button');
    } else {
        document.getElementById('next').classList.remove('disabled-button');
        document.getElementById('next').classList.remove('hide-button');
        submitBtn.classList.add('hide-button');
    }
    changeHeaderLabel();
}

function votesAllowed_1(element_id, candidate_id) {
    const id = votes.find(vote => {
        if(vote.candidate_id == candidate_id && vote.positionName == positionGroup[targetPosition].positionName) {
            return true;
        }
    });
    if(!id){
        uncheckAllFirst(element_id);
        votes = votes.filter(vote => vote.positionName != positionGroup[targetPosition].positionName);
        votes.push({candidate_id:candidate_id,positionName:positionGroup[targetPosition].positionName});
    } else {
        votes = votes.filter(vote => vote.candidate_id != candidate_id);
    }
    checkRadioButton(element_id);
}

function votesAllowed_more(element_id, candidate_id) {
    const id = votes.find(vote => {
        if(vote.candidate_id == candidate_id && vote.positionName == positionGroup[targetPosition].positionName) {
            return true;
        }
    });
    if(id === undefined){
        const voteSelected = votes.filter(vote => vote.positionName == positionGroup[targetPosition].positionName);
        if( positionGroup[targetPosition].votesAllowed > voteSelected.length){
            votes.push({candidate_id:candidate_id,positionName:positionGroup[targetPosition].positionName});
            checkRadioButton(element_id);
        }else {
            let position_name = positionGroup[targetPosition].positionName;
            
            if (position_name[position_name.length-1].toLowerCase() != 's'){
                position_name = position_name + 's';
            }
            alertService.alert({
                response:'failed',
                message:`You can only select ${positionGroup[targetPosition].votesAllowed} ${position_name}`
            })
        }
    } else {
        votes = votes.filter(vote => vote.candidate_id != candidate_id);
        checkRadioButton(element_id);
    }
}

function checkUncheck(element_id, candidate_id) {
    if(parseInt(positionGroup[targetPosition].votesAllowed) == 1) {
        votesAllowed_1(element_id, candidate_id);
    } else {
        votesAllowed_more(element_id, candidate_id);
    }
}

function uncheckAllFirst(element_id) {
    const elements = document.getElementsByClassName('check');
    $.each(elements, (index, element) => {
        element.classList.remove('checked');
    });
}

function alreadyCheckChecker(element_id, candidate_id) {
    if(votes.find(vote => vote.candidate_id == candidate_id)) {
        checkRadioButton(element_id);
    }
    console.log(candidate_id,votes);
    
}

function checkRadioButton(element_id) {
    document.getElementById(element_id).getElementsByTagName('i')[0].classList.toggle('checked');
}

function sumbitVote() {
    if(votes.length > 0){
        if(confirm('Are you sure you want to submit your vote?')){
            let data = new FormData();
            $.each(votes, (index,vote) => {
                data.append('candidate[]',vote.candidate_id);
            });
            data.append('id', id);
            $.ajax(
                {
                    url: '../process/VoteRoutes.php',
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: (e) => {
                        voteStatusSend();
                        votes = [];
                        targetPosition = 0;
                        positionGroup = [];
                        id="";
                        alertService.alert({
                            response: e,
                            message: 'Your votes has been submitted! Thank you!'
                        });
                        window.setTimeout(function(){
                            studentCode.style.pointerEvents = "all";
                            studentCode.style.opacity = "1";
                        }, 2000)
                    }
                }
                )
            }
        } else {
            alertService.alert({
                response:'failed',
                message:'Cast your vote first before submitting!'
            })
        }
    }
    
    function voteStatusSend(){
        $.ajax({
            method: 'GET',
            url: '../process/vote_process.php',
            data:{submitVote:123,id:id,election_id:'<?php echo $latestElection; ?>'},
            success: function(e){
            },
            error: function(e){
                alert(e);
            }
        });
    }
    
    function changeHeaderLabel() {
        $('#candidatePositionName').html(positionGroup[targetPosition].positionName+' ['+positionGroup[targetPosition].votesAllowed+']');
    }
    
    function displayCandidate() {
        changeHeaderLabel();
        const filteredCandidates = candidates.filter( candidate => candidate.positionname == positionGroup[targetPosition].positionName);
        $('#candidateWrapper').html('');
        $.each(filteredCandidates, (index, candidate) => {
            let image = '../person.png';
            if(candidate.image != '') {
                image = '../imgs/'+candidate.image;
            }
            $('#candidateWrapper').append(
                ` <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class='candidate card'  id="candidate_${candidate.id}">
                <div class="d-flex flex-row">
                <div class="candidate-img"><img src="${image}" width="40" height="40"></div>
                <div class="flex-grow-1 text-center candidate-name">
                <p class="font-weight-bold">${candidate.lastname.toUpperCase()}, ${candidate.firstname.toUpperCase()}</p>
                <p style="color:gray">${candidate.partyname.toLowerCase()}</p>
                </div>
                <div class="radio-wrapper">
                <div class="radio" id="check${candidate.id}" onclick="checkUncheck('check${candidate.id}',${candidate.id})">
                <i class="fa fa-check check"></i>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>`
            );
            alreadyCheckChecker('check'+candidate.id,candidate.id);
            window.setTimeout(() => {
                document.getElementById('candidate_'+candidate.id).style.opacity="1";
                document.getElementById('candidate_'+candidate.id).style.transition= (0.5*(2+index))+'s';
            }, 100);
        });
    }
    function voteStraight(id) {
        if(!confirm('Are you sure you want to Select it?')) {
            return false;
        }
        votes = new Array();
        uncheckAllFirst();
        candidates.forEach(candidate => {
            if(candidate.p_id == id) {
                votes.push({candidate_id:candidate.id,positionName:candidate.positionname});
                if(positionGroup[targetPosition].positionName == candidate.positionname) {
                    alreadyCheckChecker(`check${candidate.id}`,candidate.id)
                }
            }
        });
        sumbitVote();
        $('#voteStraightModal').modal('hide');
    }
    </script>
    </html>
    <?php
    if(isset($_SESSION['status'])){
        $login = $_SESSION['status'];
        $idno = $_SESSION['id'];
        echo "<script>
        id = ".$idno."
        voteLogin();
        </script>";
    }
    ?>
    