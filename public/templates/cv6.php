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
<!-- TOP CONTAINER-->
<div class= "container cv5-top">
<!-- user image and name-->
<div class=" cv5-user">
<?php if(empty($pdetails['profile'])):else:?>
<!-- user image -->
<div class="user-img">
<img src="../images/<?php echo $pdetails['profile'];?>" alt="cv-img">
</div>
<?php endif;?>

<?php if(empty($pdetails['name'])):else:?>
<!-- user name -->
<div class="user-name">
<h1 class="bold"><?php echo strtoupper($pdetails['name']);?></h1>
</div>
<?php endif;?>
</div>
<!-- user image and name end-->

<!-- other personal info -->
<div class="cv5-opi ">
<div class="cv5-personal-info ">
<?php if(empty($pdetails['phone'])):else:?>
<div class="opi-item cv5-opi-item cv5-p-i">
<p class="opi-item-title m-r"><img src="./img/android-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['phone'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['email'])):else:?>
<div class="opi-item cv5-opi-item cv5-p-i">
<p class="opi-item-title m-r"><img src="./img/secured-letter-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['email'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['address'])):else:?>
<div class="opi-item cv5-opi-item cv5-p-i">
<p class="opi-item-title m-r"><img src="./img/user-location-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['address'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['website'])):else:?>
<div class="opi-item cv5-opi-item cv5-p-i">
<p class="opi-item-title m-r"><img src="./img/globe-b.png"></p>
<p class="disp-i-b"><?php echo $pdetails['website'];?></p>
</div>
<?php endif;?>
</div>
</div>
<!-- other personal info end-->
</div>
<!-- TOP CONTAINER END -->

<!--Bigger container for Other details -->
<div class="container cv6-right general-info">
<!--Personal Info -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Personal Information</h2>
</div>
<div class="info-text">
<div class="objective-info">
<div class="cv6-extra-personal-info ">

<div class="opi-item cv6-opi-item disp-i-b">
<p class="cv6-opi-item-title disp-i-b">Date of Birth:</p>
<p class="disp-i-b">01-01-0001</p>
</div>

<div class="opi-item cv6-opi-item disp-i-b">
<p class="cv6-opi-item-title disp-i-b">Gender:</p>
<p class="disp-i-b">Unknown</p>
</div>

<div class="opi-item cv6-opi-item disp-i-b">
<p class="cv6-opi-item-title disp-i-b">Religion</p>
<p class="disp-i-b">Still thinking</p>
</div>

<div class="opi-item cv6-opi-item disp-i-b">
<p class="cv6-opi-item-title disp-i-b">Marital Status:</p>
<p class="disp-i-b">Confused</p>
</div>
</div>
</div>
</div>
</div>
<!--Personal Info ends-->
<!--Objective -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Objective</h2>
</div>
<div class="info-text">
<div class="objective-info">
<p>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur.
</p>
</div>
</div>
</div>
<!--Objective ends-->
<!--Education -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Education</h2>
</div>
<div class="info-text education ">
<table>
<tr class="small-bold">
<th>Course/Degree</th>
<th>Course/Degree</th>
<th>Course/Degree</th>
</tr>
<tr>
<td>School/university name</td>
<td>School/university name</td>
<td>School/university name</td>
</tr>
<tr>
<td>Grade/Score</td>
<td>Grade/Score</td>
<td>Grade/Score</td>
</tr>
<tr>
<td>Year</td>
<td>Year</td>
<td>Year</td>
</tr>
</table>
</div>
</div>
<!--Education end-->
<!--Skills -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Skills</h2>
</div>
<div class="info-text">
<div class="skills-info cv6-skills-info">
<table>
<tr>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
</tr>
<tr>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
</tr>
<tr>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
<td class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv6-sp">
<div class="sb cv6-sb w-80"></div>
</div>
</td>
</tr>
</table>
</div>
</div>
</div>
<!--Skills end-->
<!--Experience -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Experience</h2>
</div>
<div class="info-text">
<div class="experience-info">
<p class="small-bold">Company/Name</p>
<p>Job/Title</p>
<p>Start date - End date</p>
<p class="pad-top">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
</div>
</div>
<!--Experience end-->
<!--Project -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Pojects</h2>
</div>
<div class="info-text">
<div class="project-info">
<p class="small-bold">Title</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat.</p>
</div>
</div>
</div>
<!--Project end-->
<!--Reference -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Reference</h2>
</div>
<div class="info-text">
<div class="reference-info">
<p>Lorem ipsum dolor sit amet.</p>
</div>
</div>
</div>
<!--Reference end-->
<!--Social -->
<div class="gi">
<div class="info-header">
<h2 class="cv6-h2">Social</h2>
</div>
<div class="info-text">
<div class="cv6-social ">
<div class="opi-item al">
<p class="opi-item-title"><img src="./img/linkedin-b.png"></p>
<p>Account link</p>
</div>

<div class="opi-item al">
<p class="opi-item-title"><img src="./img/facebook-b.png"></p>
<p>Account link</p>
</div>
<div class="opi-item al">
<p class="opi-item-title"><img src="./img/twitter-b.png"></p>
<p>Account link</p>
</div>
<div class="opi-item al">
<p class="opi-item-title"><img src="./img/instagram-b.png"></p>
<p>Account link</p>
</div>
</div>
</div>
</div>
<!--Social end-->

</div>
<!--Bigger container for Other details end-->
</div>
</div>
</body>
</html>
<?php else:endif;?>