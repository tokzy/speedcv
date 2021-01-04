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
<div class="wrapper ">
<div class="resume">
<?php
$pdetails = $api->getpd($pid);
?>
<!-- TOP CONTAINER-->
<div class="container cv9-top cv19-top">
<div class="container">
<!-- user image and name-->
<div class="m-r disp-i-b">
<?php if(empty($pdetails['profile'])):else:?>
<!-- user image -->
<div class="user-img">
<img src="../images/<?php echo $pdetails['profile'];?>" alt="cv-img">
</div>
<?php endif;?>
</div>
<!-- user image and name end-->
<!--Objective -->
<div class="gi disp-i-b" style="width: 500px">
<div>
<!-- user name -->
<?php if(empty($pdetails['name'])):else:?>
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
<div class="objective-info">
<span>
<?php
foreach($objectives as $objective):
?>
<p><?php echo nl2br($objective['obj']);?></p>
<?php
endforeach;	
?>
</span>
</div>
<?php endif;?>
</div>
</div>
<!--Objective ends-->
</div>

<?php if(empty($pdetails['facebook']) && empty($pdetails['twitter']) && empty($pdetails['instagram']) && empty($pdetails['linkedin'])): else:?>
<!--Social -->
<div class="gi social-con">
<div class="info-text">
<div class="cv9-social cv19-social ">
<?php if(empty($pdetails['linkedin'])):else:?>
<div class="opi-item">
<p class="opi-item-title cv8-opi-icon cv9-opi-icon disp-i-b"><img src="./img/linkedin-w.png"></p>
<p class="disp-i-b"><?php echo $pdetails['linkedin'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['facebook'])):else:?>
<div class="opi-item">
<p class="opi-item-title cv8-opi-icon cv9-opi-icon disp-i-b"><img src="./img/facebook-w.png"></p>
<p class="disp-i-b"><?php echo $pdetails['facebook'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['twitter'])):else:?>
<div class="opi-item">
<p class="opi-item-title cv8-opi-icon cv9-opi-icon disp-i-b"><img src="./img/twitter-w.png"></p>
<p class="disp-i-b"><?php echo $pdetails['twitter'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['instagram'])):else:?>
<div class="opi-item">
<p class="opi-item-title cv8-opi-icon cv9-opi-icon disp-i-b"><img src="./img/instagram-w.png"></p>
<p class="disp-i-b"><?php echo $pdetails['instagram'];?></p>
</div>
<?php endif;?>
</div>
</div>
</div>
<!--Social end-->
<?php endif;?>
</div>
<!-- TOP CONTAINER END -->
<!--Bigger container for Other details -->
<div class="cv19-content">
<!-- Bigger container at the left -->
<div class="container cv13-left general-info l-float">
<?php 
$title4 = "Experience";
$obj4 = $api->getheadersbytitle($title4);
$experiences = $api->getExperience($pid);
if(count($experiences) <= 0):else:
?>
<!--Experience -->
<div class="gi">
<div class="info-header cv13-info-header cv13-info-header-right">
<h2><?php echo $obj4['title'];?></h2>
</div>
<?php foreach($experiences as $exp):?>
<div>
<div class="experience-info ">
<p class="small-bold"><?php echo ucwords($exp['companyName']);?></p>
<p><?php echo $exp['jobTitle'];?></p>
<p><?php echo $exp['startDate'];?> - <?php echo $exp['endDate'];?></p>
<p class="pad-top">
<?php echo nl2br($exp['details']);?>
</p>
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
<div class="info-header cv13-info-header cv13-info-header-right">
<h2><?php echo $obj5['title'];?></h2>
</div>
<?php foreach($projects as $project):?>
<div>
<div class="project-info ">
<p class="small-bold"><?php echo ucwords($project['title']);?></p>
<p>
<?php echo nl2br($project['description']);?>
</p>
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
<div class="info-header cv13-info-header cv13-info-header-right">
<h2><?php echo $obj6['title'];?></h2>
</div>
<?php foreach($referes as $ref):?>
<div>
<div class="reference-info ">
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
<div class="gi">
<div class="info-header cv13-info-header cv13-info-header-right">
<h2><?php echo $id['title'];?></h2>
</div>
<div>
<div class="reference-info ">
<?php
$values = $api->getAllValues($miscell['headingId'],$pid);
foreach($values as $value):
?>
<p><?php echo $value['value'];?></p>
<?php endforeach;?>
</div>
</div>
</div>
<?php endforeach;endif;?>
</div>
<!-- Bigger container at the left end-->

<!-- Bigger container at the right -->
<div class="container cv13-right general-info r-float">
<div class="gi">
<!-- other personal info -->
<div class="objective-info">
<div class="">
<div class="cv9-personal-info ">
<?php if(empty($pdetails['phone'])):else:?>
<div class="opi-item cv9-opi-item">
<p class="opi-item-title m-r"><img src="./img/android-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['phone'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['email'])):else:?>
<div class="opi-item cv9-opi-item">
<p class="opi-item-title m-r"><img src="./img/secured-letter-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['email'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['address'])):else:?>
<div class="opi-item cv9-opi-item">
<p class="opi-item-title m-r"><img src="./img/user-location-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['address'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['website'])):else:?>
<div class="opi-item cv9-opi-item">
<p class="opi-item-title m-r"><img src="./img/globe-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['website'];?></p>
</div>
<?php endif;?>


</div>
</div>
</div>
</div>
<!--Personal Info -->
<div class="gi">
<div class="info-header cv13-info-header">
<h2>Personal Information</h2>
</div>
<div>

<!-- other personal info end-->
<div class="objective-info">
<div class="cv5-extra-personal-info cv19-extra-personal-info">
<?php if(empty($pdetails['dob'])):else:?>
<div class="opi-item cv5-opi-item">
<p class="cv5-opi-item-title disp-i-b">Date of Birth:</p>
<p class="disp-i-b"><?php echo $pdetails['dob'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['gender'])):else:?>
<div class="opi-item cv5-opi-item">
<p class="cv5-opi-item-title disp-i-b">Gender:</p>
<p class="disp-i-b"><?php echo $pdetails['gender'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['religion'])):else:?>
<div class="opi-item cv5-opi-item">
<p class="cv5-opi-item-title disp-i-b">Religion</p>
<p class="disp-i-b"><?php echo $pdetails['religion'];?></p>
</div>
<?php endif;?>
</div>
</div>
</div>
</div>
<!--Personal Info ends-->
<?php
$title2 = "Education";
$obj2 = $api->getheadersbytitle($title2);
$edus = $api->getAllEduBypid($pid);
if(count($edus) <= 0):else:
?>
<!--Education -->
<div class="gi cv13-g1">
<div class="info-header cv13-info-header">
<h2>Education</h2>
</div>
<div class="row" style="padding-left:10px;">
<?php foreach($edus as $edu):?>
<div class="column2">
<h2><?php echo $edu['course'];?></h2>
<p><?php echo $edu['school'];?></p>
<p><?php echo $edu['grade'];?></p>
<?php echo $edu['year'];?>
</div>
<?php endforeach;?>
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
<div class="gi cv13-g1">
<div class="info-header cv13-info-header">
<h2>Skills</h2>
</div>
<div>
<div class="skills-info cv13-skills-info">
<div class="row" style="padding-left:10px;">
<?php foreach($skills as $skill):?>
<div>
<div class="skills-info-li">
<p class="skill-name"><?php echo $skill["skills"];?></p>
<div class="sp cv9-sp">
<?php if($skill['level'] == "1"):?>
<div class="sb cv9-sb w-20"></div>
<?php elseif($skill['level'] == "2"):?>
<div class="sb cv9-sb w-40"></div>
<?php elseif($skill['level'] == "3"):?>
<div class="sb cv9-sb w-60"></div>
<?php elseif($skill['level'] == "4"):?>
<div class="sb cv9-sb w-80"></div>
<?php elseif($skill['level'] == "5"):?>
<div class="sb cv9-sb w-100"></div>
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
</div>
<!-- Bigger container at the right end -->
</div>
<!--Bigger container for Other details end-->
</div>
</div>
</body>
</html>
<?php else:endif;?>