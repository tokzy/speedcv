<?php
ob_start();
require_once '../../src/class/apiclass.php';
if(isset($_GET['pid'])):

$api = new Apiclass();	
$pid = $api->cleanInputs($_GET['pid']);
?>
<!DOCTYPE html>
<html>
<head>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
<title>CV Template</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<link href='https://fonts.googleapis.com/css?family=Tahoma' rel='stylesheet'>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
<div class="wrapper">
<div class="resume">
<?php
$pdetails = $api->getpd($pid);
?>
<!-- SMALLER CONTAINER -->
<div class="col-vm container cv7-left l-float">
<?php if(empty($pdetails['profile'])):else:?>
<!-- user image -->
<div class="user-img">
<img src="../images/<?php echo $pdetails['profile'];?>" alt="cv-img">
</div>
<?php endif;?>

<!-- other personal info -->
<div class="opi">
<?php if(empty($pdetails['phone'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/android-b.png"></p>
<p><?php echo $pdetails['phone'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['email'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/secured-letter-b.png"></p>
<p><?php echo $pdetails['email'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['address'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/user-location-b.png"></p>
<p><?php echo $pdetails['address'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['website'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/globe-b.png"></p>
<p><?php echo $pdetails['website'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['dob']) && empty($pdetails['gender']) && empty($pdetails['religion'])): else:?>
<div class="extra-personal-info">
<?php if(empty($pdetails['dob'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title">Date of Birth:</p>
<p><?php echo $pdetails['dob'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['gender'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title">Gender:</p>
<p><?php echo $pdetails['gender'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['religion'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title">Religion</p>
<p><?php echo $pdetails['religion'];?></p>
</div>
<?php endif;?>
</div>
<?php endif;?>

<?php if(empty($pdetails['facebook']) && empty($pdetails['twitter']) && empty($pdetails['instagram']) && empty($pdetails['linkedin'])): else:?>
<div class="social">
<?php if(empty($pdetails['linkedin'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/linkedin-b.png"></p>
<p><?php echo $pdetails['linkedin'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['facebook'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/facebook-b.png"></p>
<p><?php echo $pdetails['facebook'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['twitter'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/twitter-b.png"></p>
<p><?php echo $pdetails['twitter'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['instagram'])):else:?>
<div class="opi-item row-vm">
<p class="opi-item-title"><img src="./img/instagram-b.png"></p>
<p><?php echo $pdetails['instagram'];?></p>
</div>
<?php endif;?>
</div>
<?php endif;?>
</div>
<!-- other personal info end-->
</div>
<!-- SMALLER CONTAINER END -->
<!--(BIGGER CONTAINER) -->
<div class="col-vm cv7-right r-float">
<?php if(empty($pdetails['name'])):else:?>
<!-- user name -->
<div class="user-name">
<h1 class="bold"><?php echo strtoupper($pdetails['name']);?></h1>
</div>
<?php endif;?>


<?php
$title = "Objective";
$obj = $api->getheadersbytitle($title);
$objectives = $api->getAllObjBypid($pid);
if(count($objectives) <= 0):else:
?>
<!-- OBJECTIVE -->
<div class="gi container">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $obj['title'];?></h2>
</div>
<div class="info-text">
<div class="objective-info">
<p>
<?php
foreach($objectives as $objective):
?>
<p><?php echo nl2br($objective['obj']);?></p>
<?php
endforeach;	
?>
</p>
</div>
</div>
</div>
<!-- OBJECTIVE END -->
<?php endif;?>

<?php
$title2 = "Education";
$obj2 = $api->getheadersbytitle($title2);
$edus = $api->getAllEduBypid($pid);
if(count($edus) <= 0):else:
?>
<!--Education -->
<div class="gi">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $obj2['title'];?></h2>
</div>
<div class="info-text education ">
<div class="row" style="padding-left:10px;">
<?php foreach($edus as $edu):?>
<div class="column">
<h2><?php echo $edu['course'];?></h2>
<p><?php echo $edu['school'];?></p>
<p><?php echo $edu['grade'];?></p>
<?php echo $edu['year'];?>
</div>
<?php endforeach;?>
</div>
</div>
</div>
<!--Education end-->
<?php endif;?>

<?php
$title3 = "Skills";
$obj3 = $api->getheadersbytitle($title3);
$skills = $api->getAllSkills($pid);
if(count($skills) <= 0):else:
?>
<!--Skills -->
<div class="gi">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $obj3['title'];?></h2>
</div>
<div class="info-text">
<div class="skills-info cv7-skills-info">
<div class="row" style="padding-left:10px;">
<?php foreach($skills as $skill):?>
<div class="column2">
<div class="skills-info-li">
<p class="skill-name"><?php echo $skill["skills"];?></p>
<div class="sp cv7-sp">
<?php if($skill['level'] == "1"):?>
<div class="sb cv7-sb w-20"></div>
<?php elseif($skill['level'] == "2"):?>
<div class="sb cv7-sb w-40"></div>
<?php elseif($skill['level'] == "3"):?>
<div class="sb cv7-sb w-60"></div>
<?php elseif($skill['level'] == "4"):?>
<div class="sb cv7-sb w-80"></div>
<?php elseif($skill['level'] == "5"):?>
<div class="sb cv7-sb w-100"></div>
<?php endif;?>	
</div>
</div>
</div>
<?php endforeach;?>

</div>
</div>
</div>
</div>
<!--Skills end-->
<?php endif;?>

<?php 
$title4 = "Experience";
$obj4 = $api->getheadersbytitle($title4);
$experiences = $api->getExperience($pid);
if(count($experiences) <= 0):else:
?>
<!--Experience -->
<div class="gi">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $obj4['title'];?></h2>
</div>
<?php foreach($experiences as $exp):?>
<div class="info-text">
<div class="experience-info col-vm">
<p class="small-bold"><?php echo ucwords($exp['companyName']);?></p>
<p><?php echo $exp['jobTitle'];?></p>
<p><?php echo $exp['startDate'];?> - <?php echo ucwords($exp['endDate']);?></p>
<p class="pad-top"><?php echo nl2br($exp['details']);?></p>
</div>
</div>
<?php endforeach;?>
</div>
<!--Experience end-->
<?php endif;?>

<?php 
$title5 = "Project";
$obj5 = $api->getheadersbytitle($title5);
$projects = $api->getAllproject($pid);
if(count($projects) <= 0):else:
?>
<!--Project -->
<div class="gi">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $obj5['title'];?></h2>
</div>
<?php foreach($projects as $project):?>
<div class="info-text">
<div class="project-info col-vm">
<p class="small-bold"><?php echo ucwords($project['title']);?></p>
<p><?php echo nl2br($project['description']);?></p>
</div>
</div>
<?php endforeach;?>
</div>
<!--Project end-->
<?php endif;?>

<?php 
$title6 = "Reference";
$obj6 = $api->getheadersbytitle($title6);
$referes = $api->getAllreference($pid);
if(count($referes) <= 0):else:
?>
<!--Reference -->
<div class="gi">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $obj6['title'];?></h2>
</div>
<?php foreach($referes as $ref):?>
<div class="info-text">
<div class="reference-info col-vm">
<p>
<span style="font-size:20px;"><?php echo $ref['refereeName'];?></span><br/>
<?php echo $ref['jobTitle'];?><br/>
<?php echo $ref['companyName'];?><br/>
<?php echo $ref['email'];?><br/>
<?php echo $ref['phone'];?><br/>
</p>
</div>
</div>
<?php endforeach;?>
</div>
<!--Reference end-->
<?php endif;?>
<?php 
//$title6 = "Reference";
//$obj6 = $api->getheadersbytitle($title6);
$misc = $api->getMisc($pid);
if(count($misc) <= 0):else:
foreach($misc as $miscell):    
$id = $api->getheadersbyheaderId($miscell['headingId']);
?>
<!--miscellaneous -->
<div class="gi">
<div class="info-header">
<h2 class="cv7-h2"><?php echo $id['title'];?></h2>
</div>
<div class="info-text">
<div class="reference-info col-vm">
<?php
$values = $api->getAllValues($miscell['headingId'],$pid);
foreach($values as $value):
?>
<p><?php echo $value['value'];?></p>
<?php endforeach;?>
</div>
</div>
</div><br/>
<!--miscellaneous end-->
<?php endforeach;endif;?>

</div>
<!-- BIGGER CONTAINER END -->

</div>
</div>
</body>
</html>
<?php else:endif;?>