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
<title>CV Template</title>
<link href='https://fonts.googleapis.com/css?family=Tahoma' rel='stylesheet'>
<style>
:root{
    --cv9Default:#173171;
    --cv10Default:#0e597d;
    --cv11Default:#526f1c;
    --cv12Default:#526f1c;
    --cv13Default:#526f1c;
    --cv14Default:#526f1c;
    --cv15Default:#526f1c;
}

*{
	margin: 0;
	padding: 0;
	/*box-sizing: border-box;*/
}
body{
    line-height: 23px;
    font-family: "Tahoma";
    background-color: #585c68;
    color: #333;
    font-size: 13px;
}
/*----------------general styling----------------*/
ul{
	list-style: none;
}
img{
	width: 100%;
}
.row-vm{
	display: flex;
	flex-direction: row;
}
.col-vm{
	display: flex;
	flex-direction: column;
}
.fl-w{
	flex-wrap: wrap;
}
.width-76{
	width: 76%
}
.jus-bet{
	justify-content: space-between;
}
.al{
	align-items: center;
}
.bold{
	font-weight: bold;
	font-size: 21px;
}
.bl{
	border-bottom: 1px solid #333;
}
.small-bold{
	font-weight: bold;
	text-transform: uppercase;
}
h1,h2{
	margin: 10px 0;
	text-transform: uppercase;
}
h2{
	font-weight: bold;
	font-size: 14px;
	padding-bottom: 5px;
}
.container{
	padding: 20px;
}
.disp-i-b{
	display: inline-block;
}
.m-r{
	margin-right: 20px;
}
.m-l{
	margin-left: 20px;
}
.txt-al-l{
	text-align: left;
}
.wrapper{
	justify-content: center;
	width: 100%;
	display: flex;
}
.resume{
	width: 800px;
	background-color: #fff;
	position: absolute;
}
.fw{
	width: 100%;
}
.in{
	border-bottom: 1px solid #fff;
}
.user-img{
	width: 150px;
	height: 150px;
	display: inline-block;
}
.user-img img{
	border-radius: 80px;
	height: 100%;
}
.opi-item {
	padding: 10px 0 0;
	text-align: center;
}
.opi-item-title{
	/*background-color: #fff;*/
    /*color: #585c68;
    height: 25px;
    width: 25px;*/
    font-weight: bold;
    text-align: center;
    /*border-radius: 50px;*/
    display: inline-block;
    font-size: 14px;
}
.opi-item-title img{
	width: 18px;
	height: 18px;
}
.extra-info{
	background-color: transparent;
	color: #fff;
	width: 100%;
	font-weight: bold;
	height: auto;
}
.social,.extra-personal-info{
	border-top: 1px solid #fff;
	padding: 10px 0 0;
    margin: 15px 0 0;
}
.education-info{
	display: inline-block;
}
.objective-info,.skills-info,.education-info,.experience-info,.project-info,.reference-info{
	padding-bottom: 13px;
}
.info-text{
	padding: 0 15px;
}
/*.info-text > div,*/.info-text-div{
	position: relative;
}
.points:before{
	content: "";
	position: absolute;
	top: 6px;
	left: -18px;
	width: 6px;
	height: 6px;
	border-radius: 50px;
}
.points:after{
	content: "";
	position: absolute;
	top: 16px;
    left: -14px;
    width: 2px;
    height: 195px;
}
.education{
	/*display: table;*/
	width: 100%;
	padding: 0;
}
.edu-wrap{
	width: 100%;
	display: table;
}
table {
  /*border-collapse: collapse;*/
  width: 100%;
}
td, th {
  text-align: left;
  padding:0px 8px;
}
.education-info {
	width: 50%;
}
/*.skills-info > ul li,*/.skills-info-li{
	/*margin: 10px 0;*/
	margin: 10px 25px 10px 0;
    list-style: none;
    width: 200px;
	display: inline-block;
}
.sp{
	width: 100%;
    background-color:rgb(216 216 216);
    border-radius: 5px;
}
.sb{
    background-color: rgb(116, 194, 92);
    color: white;
    padding: 1.5%;
    text-align: right;
    font-size: 20px;
    border-radius: 5px;
}
.w-20{
	width: 20%;
}
.w-40{
	width: 40%;
}
.w-60{
	width: 60%;
}
.w-80{
	width: 80%;
}
.w-100{
	width: 100%;
}
.pad-top{
	padding-top: 10px;
}
.header-line{
	height: 4px;
    width: 43px;
    margin: -10px 0 10px 10px;
}
.mid-sec-line{
	width: 8px;
	height: auto;
	margin: 20px 5px;
	border-radius: 20px;
	background-color: #fff;
}
.education-info .points:before,.project-info .points:before{
	border: 2px solid #4b4879;
}
.education-info .points:after,.project-info .points:after{
	background-color: #4b4879;
	height: 70px;
}

.experience-info .points:before{
	border: 2px solid #fff;
}
.experience-info .points:after{
	background-color: #fff;
}


/*---------------------combines styling---------------------*/
.cv2-h2,.cv7-h2{
	color: #fff;
	border-radius: 15px 0 0 15px;
	padding-bottom: 0;
	padding:3px 10px;
}
.cv3-opi-item,.cv4-opi-item,.cv11-opi-item,.cv12-opi-item{
	text-align: end;
	justify-content: space-between;
	border-bottom: 1px solid #cacacaeb;
	padding: 15px 0;
}
.cv3-opi-item-title,.cv4-opi-item-title,.cv11-opi-item-title,.cv12-opi-item-title{
    text-align: left;
    font-size: 14px;
	color: #fff;
	font-weight: bold;
}
.cv3-social,.cv4-social,.cv11-social,.cv12-social{
	padding-top: 30px;
}
.cv4-skills-info > ul > li,.cv7-skills-info > ul > li,.cv11-skills-info > ul > li,
.cv12-skills-info > ul > li{
	width: 200px;
}
.cv4-sp,.cv5-sp,.cv6-sp,.cv7-sp,.cv8-sp,.cv9-sp,.cv10-sp,.cv11-sp,.cv12-sp,.cv13-sp{
    /*height: 10px;*/
    border-radius: 10px;
}
.cv4-sb,.cv5-sb,.cv6-sb,.cv7-sb,.cv8-sb,.cv9-sb,.cv10-sb,.cv11-sb,.cv12-sb,.cv13-sb{
	border-radius: 10px;
	 padding: 2%;
}
.cv8-info-header,.cv9-info-header,.cv10-info-header,
.cv11-info-header,.cv12-info-header,.cv13-info-header{
	display: flex;
	align-items: center;
}
.cv4-info-header img,.cv8-info-header i,.cv9-info-header i,.cv10-info-header i,
.cv11-info-header i,.cv13-info-header i{
	color: #fff;
	height: 30px;
    width: 30px;
    text-align: center;
    border-radius: 50px;
    /*display: flex;
    align-items: center;
    justify-content: center;*/
    font-size: 14px;
    margin-right: 10px;
}
.cv5-extra-p-i-div,.cv9-extra-personal-info > div,
.cv13-extra-personal-info > div {
    width: 320px;
    border-bottom: none;
    justify-content: space-between;
}
.cv5-social,.cv6-social,.cv8-social,.cv10-social{
    flex-wrap: wrap;
}
.cv5-social .opi-item .opi-item-title,.cv6-social .opi-item .opi-item-title,
.cv8-social .opi-item .opi-item-title,.cv9-social .opi-item .opi-item-title,
.cv13-social .opi-item .opi-item-title{
    color: #fff;
    margin-right: 13px;
}
.cv9-skills-info > ul > li,
.cv13-skills-info > ul > li {
    width: 100%;
    display: flex;
}
.cv9-skills-info > ul > li > span,
.cv13-skills-info > ul > li > span{
    width: 85%;
}
.cv5-opi-item-title,.cv6-opi-item-title,.cv7-opi-item-title,
.cv8-opi-item-title,.cv9-opi-item-title,.cv10-opi-item-title,
.cv13-opi-item-title{
    display: flex;
    align-items: center;
    text-align: left;
    font-size: 14px;
	font-weight: bold;
}
.cv5-top,.cv6-top,.cv8-top{
	padding-bottom: 0;
	justify-content: space-around;
	align-items: center;
}
.cv5-user,.cv6-user,.cv13-user{
    width: 455px;
    display: inline-block;
}
.cv5-user .user-name,.cv6-user .user-name{
	margin-left: 20px;
}
.cv5-opi-item,.cv6-opi-item{
	text-align: end;
	padding: 5px 0;
}
.cv6-opi-icon{
	margin-left: 20px;
}
.cv5-p-i,.cv6-personal-info > div{
	width: 100%;
	flex-direction: row-reverse;
}
.cv6-skills-info > ul > li,.cv8-skills-info > ul > li,.cv10-skills-info > ul > li{
	width: 180px;
}
.cv6-social > div,.cv8-social > div,.cv9-social > div,.cv10-social > div,.cv13-social > div{
	width: 25%;
}
.cv6-opi,.cv8-opi,.cv9-opi,.cv10-opi{
	width: 330px;
}
.cv7-extra-personal-info > div,.cv6-extra-personal-info > div,
.cv8-extra-personal-info > div,.cv10-extra-personal-info > div{
	width: 45%;
	border-bottom: none;
	margin: 0 15px;
	justify-content: space-between;
}
.cv7-extra-personal-info,.cv6-extra-personal-info,.cv8-extra-personal-info,.cv10-extra-personal-info{
	flex-wrap: wrap;
}
.cv8-personal-info > div,.cv9-personal-info > div,.cv10-personal-info > div,
.cv13-personal-info > div{
	flex-direction: row;
	width: 100%;
	    padding: 5px 0;
}
.cv13-top{
	flex-direction: row-reverse;
    padding: 10px 20px;
}
.cv9-user,.cv13-user{
	flex-direction: row-reverse;
}
.cv9-user .user-name,.cv13-user .user-name{
	margin-right: 20px;
}

/*------------individual styling------------*/
/*--------------------CV1---------------*/
.cv1-left{
	width: 200px;
	background-color:#5f9ea0;
	color: #fff;
	text-align: center;
	float: left;
}
.cv1-left-div{
	padding: 13px 0;
	align-items: center;
}
.cv1-right{
	width: 520px;
	float: right;
	background-color: #fff;
}
.cv1-sb{
    background-color:#5f9ea0;
}
.cv1-skills-bar::-webkit-progress-value {
	background-color:#5f9ea0;
}
/*---------------CV2------------*/
.cv2-h2{
	background-color:#8b0000;
}
.cv2-col{
	background-color: #fff;
}
.cv2-left{
	width: 557px;
}
.cv2-sb{
	background-color:#8b0000;
}
.cv2-right{
	width: 150px;
    border-radius: 95px;
    margin: 5px 7px 5px 5px;
    background-color:#8b0000;
    color: #fff;
    text-align: center;
}
.cv2-right > div{
	padding: 10px 0;
}
.cv2-right .user-img{
	padding: 0;
}

/*---------------CV3------------*/
.cv3-h2{
	background-color: transparent;
	color: #4b4879;
	padding-bottom: 0;
	padding:3px 0;
}
.cv3-header-line{
	background-color: #4b4879;
	margin: -10px 0 10px 0px;
}
.cv3-h2-edu,.cv3-exp h2{
	color: #fff;
}
.cv3-exp .info-text{
	padding: 0;
}
.cv3-header-line-exp{
	background-color: #fff;
	margin: -10px 0 10px 0px;
}
.cv3-col{
	background-color: #fff;
}
.cv3-left{
	width: 180px;
    background-color: #4b4879;
    color: #fff;
    text-align: center;
    align-items: center;
    padding: 20px 30px;
}
.cv3-sb{
	background-color: #4b4879;
}
.cv3-right{
	width: 520px;
	background-color: #f3f3f3;
}
.cv3-user,.cv3-opi{
	padding: 10px 0;
}
.cv3-exp{
	background-color: #4b4879;
    color: #fff;
    margin: 0 -20px 0 -22px;
    padding: 20px;
}
.cv3-edu{
	padding-bottom: 15px;
}
/*--------------------CV4---------------*/
.cv4-right {
    width: 180px;
    background-color:#1c6f67;
    color: #fff;
    text-align: center;
    align-items: center;
}
.cv4-left{
	width: 580px;
}
.cv4-left .user-name{
	border: 3px solid#1c6f67;
    margin: 15px 20px 10px -5px;
}
.cv4-left .user-name h1{
	padding:12px 25px;
}
.cv4-opi-item {
    text-align: end;
    justify-content: space-between;
    border-bottom: 2px solid #fff;
    padding: 15px 0;
}
.cv4-left .gi{
	padding: 0 20px;
}
.cv4-sb{
    background-color:#1c6f67;
}
.cv4-info-header img{
	background-color:#1c6f67;
	padding: 3px;
    width: 20px;
    height: 20px;
    vertical-align: middle;
}
/*------------CV5------------*/
.cv5-right {
	width: 350px;
}
.cv5-left{
	width: 370px;
	background: #e8e8e87d;
}
.cv5-header-line {
    background-color: #0e597d;
    margin: -10px 0 10px 0px;
}
.cv5-extra-p-i-div{
	padding: 0;
}
.cv5-opi {
    width: 300px;
    display: inline-block;
    vertical-align: top;
}
.cv5-opi-icon{
	margin-right: 20px;
	color: #0e597d;
}
.cv5-social .opi-item .opi-item-title{
    color: #0e597d;
}
.cv5-s-opi-item{
    width: 45%;
    margin: 0 5px;
    display: inline-block;
}
.cv5-info-text{
	padding: 0;
}
.cv5-education{
	margin-left: 20px;
}
.cv5-sb{
	background-color: #0e597d;
}
/*---------------CV6---------------*/
.cv6-right{
	/*width:100%;*/
	padding-top:0;
}
.cv6-h2 {
    background-color: #3e7777;
    color: #fff;
    border-radius: 15px 0 0 15px;
    padding-bottom: 0;
    padding: 3px 10px;
}
.cv6-sb{
	background-color: #3e7777;
}
/*.cv6-social .opi-item .opi-item-title{
    background-color: #3e7777;
}
*/.cv6-opi-icon{
	background-color: #3e7777;
}
/*-------------cv7-------------*/
.cv7-h2{
	background-color: #610116;
	border-radius: 0;
}
.cv7-left {
    width: 200px;
    background-color: #e8e8e8;
    color: #610116;
    text-align: center;
    align-items: center;
    margin: 0 11px;
    z-index: 99;
}
.cv7-left .user-img img{
	border: 5px solid #610116;
}
.cv7-left .opi{
    text-align: right;
}
.cv7-left .opi .opi-item{
    justify-content: space-between;
}
.cv7-opi-item-title{
	font-size: 18px;
	text-align: left;
}
.cv7-left .social,.cv7-left .extra-personal-info{
	border-top: 1px solid #610116;
}
.extra-personal-info .opi-item .cv7-opi-item-title,.extra-personal-info .opi-item .cv10-opi-item-title{
	font-size: 14px;
}
.cv7-right{
	width: 600px;
}
.cv7-right .user-name {
    margin: 0px 0px 0px -217px;
    text-align: center;
    background-color:#610116;
    color: #fff;
    display: flex;
    justify-content: flex-end;
}
.cv7-right .user-name h1 {
    padding: 12px 25px;
    width: 72%;
    border: 3px solid #fff;
    margin: 0px 10px;
}
.cv7-right >div{
	padding: 13px 0;
}
.cv7-right .gi{
	padding:0 11px 0 0;
}
.cv7-sb{
    background-color: #610116;
}
/*-------------cv8-------------*/
.cv8-top{
	flex-direction: row-reverse;
	padding: 10px 20px;
	justify-content: space-between;
	background-color: #3e774f;
	color: #fff;
}
/*.cv8-right{
	width: 100%;
}*/
/*.cv8-user{
	flex-direction: row-reverse;
}
*/.cv8-user .user-name{
	margin-right: 20px;
}
.cv8-opi-icon{
	background-color: #3e774f;
	padding: 7px 8px 2px;
    border-radius: 51px;
}
.cv8-info-header img{
	background-color: #3e774f;
}
.cv8-sb{
	border-radius: 10px;
    background-color: #3e774f;
}
/*--------------cv9--------------*/
.cv9-top{
	justify-content: space-between;
	flex-direction: row-reverse;
}
.cv9-left,.cv13-left{
	width: 480px;
	text-align: right;
	border-right: 2px solid var(--cv9Default);
	padding-top: 0;
	padding-bottom: 0;
}
.cv9-left .gi,.cv9-right .gi{
    margin-top: -11px;
    padding-bottom: 20px;
}
.cv9-left .cv9-info-header{
	justify-content: flex-end;
}

.cv9-right{
	width: 320px;
	border-left: 2px solid var(--cv9Default);
	border-right: 0;
	padding-top: 0;
}
.cv9-right .cv9-info-header{
	justify-content:flex-start;
}
.cv9-info-header img{
	background-color: var(--cv9Default);
}
.cv9-opi-item{
	text-align: left;
}
.cv9-opi-icon{
	background-color: var(--cv9Default);}
.cv9-sb{
	background-color: var(--cv9Default);
}
.cv9-social .opi-item .opi-item-title{
    background-color: var(--cv9Default);
}
/*-------cv10----------*/
.cv10{
	border-left: 20px solid var(--cv10Default);
}
.cv10-top {
    flex-direction: row-reverse;
    justify-content: space-between;
    padding: 10px 20px;
    border-bottom: 2px solid var(--cv10Default);
}
/*.cv10-right{
	width: 100%;
}*/
.cv10-personal-info .cv10-opi-item-title,.cv10-social .cv10-opi-item-title{
	color: var(--cv10Default);
	font-size: 18px;
	margin-right: 20px;
}
.cv10-info-header img{
	background-color: var(--cv10Default);
}
.cv10-sb{
	border-radius: 10px;
    background-color: var(--cv10Default);
}
.cv10-opi-icon{
	background-color: var(--cv10Default);
}
/*-------------cv11-------------*/
.cv11-right{
	background-color: transparent;
	margin-top: 10px;
	width: 220px;
    color: #fff;
    text-align: center;
    align-items: center;
}
.cv11-right .user-img img {
    border: 5px solid var(--cv11Default);
}
.cv11-right .opi{
	background-color: var(--cv11Default);
	margin-top: 20px;
	border-radius: 0 70px 70px 0;
}
.cv11-opi-item {
    text-align: end;
    justify-content: space-between;
    border-bottom: 2px solid #fff;
    padding: 15px 0;
}
.cv11-left {
	width: 580px;
}
.cv11-left .user-name {
    border: none;
    margin: 15px 0px 10px;
}
.cv11-left .user-name h1 {
    padding: 12px 25px;
    text-align: center;
}
.cv11-info-header i{
	background-color: var(--cv11Default);
}
.cv11-sb{
    background-color: var(--cv11Default);
}
.cv11-h2 {
    background-color: var(--cv11Default);
    color: #fff;
    border-radius: 0 15px 15px 0;
    padding-bottom: 0;
   padding: 3px 20px;
    margin-left: 15px;
}
.cv11-header-line {
    background-color: var(--cv11Default);
    width: 80px;
    margin: -14px 0 0 252px;
}

/*-------------cv12-------------*/
.cv12-right{
	background-color: transparent;
	margin-top: 10px;
	width: 210px;
	color: #fff;
    color: var(--cv12Default);
    text-align: center;
    align-items: center;
}
.cv12-right .user-img img {
    border: 5px solid var(--cv11Default);
}
.cv12-right .opi{
	background-color: var(--cv12Default);
	border-radius: 100px;
	color:  #fff;
	padding: 40px 15px 20px;
	margin: 0 0 10px 0px;
}
.cv12-opi-item {
    text-align: end;
    justify-content: space-between;
    border-bottom: 2px solid #fff;
    padding: 15px 0;
}
.cv12-left {
	width: 580px;
	padding:15px;
}
.cv12-h2 {
    background-color: var(--cv12Default);
    color: #fff;
    border-radius: 15px 0 0 15px;
   	padding: 3px 20px;
}
.cv12-sb{
    background-color: var(--cv12Default);
}

/*cv13*/
.cv13-left,.cv13-right{
	width: 400px;
	text-align: right;
	border-right: 2px solid var(--cv9Default);
	padding-top: 0;
	padding-bottom: 0
}
.cv13-left .gi,.cv13-right .gi{
    margin-top: -11px;
    padding-bottom: 20px;
}
.cv13-left .cv13-info-header{
	justify-content: flex-end;
}
.cv13-right{
	width: 400px;
	border-left: 2px solid var(--cv9Default);
	border-right: 0;
}
.cv13-user{
	flex-direction: row;
    width: 100%;
    justify-content: center;
    align-items: center;
}
.cv13-user .user-img{
	margin-right: 30px;
}
.cv13-sb{
	background-color: var(--cv9Default);
}
.cv13-social .opi-item .opi-item-title{
    background-color: var(--cv9Default);
}
.cv13-opi-icon{
	background-color: var(--cv9Default);
	color: #fff;
	margin-right: 20px;
}
/*============cv14============*/
.cv14-info-text{
	padding: 0;
}
.cv14-left{
	background-color: transparent;
}


/*cv15*/
.cv15-right{
	width: 250px;
}
.cv15-left{
	width: 550px;
	padding: 20px 0;
}
.cv15-right .user-img{
	background-color: white;
    padding: 4px;
}
.cv15-right .user-img img {
    border-radius: 0;
    height: 100%;
    border: 5px solid#1c6f67;
}
.cv15-right .user-name{
	    padding: 0 0px 15px;
}
.cv15-right .opi{
	margin:0 10px;
}
.cv15-right .opi .opi-item{
	justify-content: space-between;
    text-align: right;
}
.cv7-opi-item-title{
	padding-right: 6px;
}
.cv15-right .opi .social, .cv15-right .opi .extra-personal-info{
	border: none;
}
.cv15-info-header{
    border: 2px solid #fff;
    margin: 0 -33px 10px 0;
    padding: 6px 10px;
    display: block;
}
.cv15-info-header h2{
	    margin: 0;
    padding: 0;
}
/*cv16*/
.cv16-top{
	justify-content: space-around;
    align-items: center;
    background-color: #0e597d;
    color: #fff;
}
.cv16-personal-info > div {
    width: 100%;
    flex-direction: row;
}
.cv16-opi-icon {
    color: #0e597d;
    margin:0 10px;
    background-color:#fff; ;
    padding: 10px;
}
.cv16-personal-info > div > span:last-child {
    width: 100%;
}
/*cv17*/
.cv17-top > div {
    padding: 0 10px;
    width: 100%;
}
.cv17-personal-info > div{
	padding: 5px 0;

}
.cv17-personal-info > div .opi-item-title{
	    margin: 0 15px;
}

/*cv-18*/
.cv18-right{
	width: 575px;
}
.cv18-left{
	background: #545454f5;
    color: #fff;
    border-left: 1px solid #333;
    width: 225px;
}
.cv18-left > div .opi .extra-personal-info{

}
.cv18-left > div .opi-item .opi-item-title {
    background-color: #fff;
    color: #333333;
    padding: 10px;
    margin-right: 11px;
}
.cv18-left > div .opi-item .extra-info {
    background-color: transparent;
    color: #fff;
    width:auto;
    padding: 0;
}
.cv18-sb{
	background-color: #333;
}

/*cv19*/
.cv19-top{
	flex-direction: column;
	padding: 0;
    background-color: #173171;
    color: #fff;
    margin-bottom: 20px;
}
.cv19-user{
	padding: 10px;
}
.cv19-opi-icon {
    background-color: #fff;
    color: #173171;
    margin-right: 15px;
    padding: 10px;
}
.social-con{
	background-color: #657fbf;
    padding: 5px;
}
.cv19-right{
	    padding-top: 12px;
}
</style>
</head>
<body>
<div class="wrapper">
<div class="resume row-vm">
<!--Smaller container for Personal details -->
<div class="container cv1-left personal-info">
<!-- user image and name-->
<div class="in cv1-left-div">
<?php
$pdetails = $api->getpd($pid);
?>
<!-- user image -->
<?php if(empty($pdetails['profile'])):else:?>
<div class="user-img">
<img src="../images/<?php echo $pdetails['profile'];?>" alt="cv-img">
</div>
<?php endif;?>

<?php if(empty($pdetails['name'])):else:?>
<!-- user name -->
<div class="user-name">
<h1 class="bold">
<?php echo strtoupper($pdetails['name']);?>
</h1>
</div>
<?php endif;?>
</div>
<!-- user image and name end-->

<!-- other personal info -->
<div class="opi">

<?php if(empty($pdetails['phone'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">Phone Number:</p>
<p><?php echo $pdetails['phone'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['email'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">Email:</p>
<p><?php echo $pdetails['email'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['address'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">Address:</p>
<p><?php echo $pdetails['address'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['website'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">	Website:</p>
<p><?php echo $pdetails['website'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['dob']) && empty($pdetails['gender']) && empty($pdetails['religion'])): else:?>
<div class="extra-personal-info">
<?php if(empty($pdetails['dob'])):else:?>
<div class="opi-item ">
<p class="opi-item-title extra-info">Date of Birth:</p>
<p><?php echo $pdetails['dob'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['gender'])):else:?>
<div class="opi-item ">
<p class="opi-item-title extra-info">Gender:</p>
<p><?php echo $pdetails['gender'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['religion'])):else:?>
<div class="opi-item ">
<p class="opi-item-title extra-info">Religion</p>
<p><?php echo $pdetails['religion'];?></p>
</div>
<?php endif;?>
</div>
<?php endif;?>

<?php if(empty($pdetails['facebook']) && empty($pdetails['twitter']) && empty($pdetails['instagram']) && empty($pdetails['linkedin'])): else:?>
<div class="social">

<?php if(empty($pdetails['linkedin'])):else:?>
<div class="opi-item">
<p class="opi-item-title">	Linkedin-in:</p>
<p><?php echo $pdetails['linkedin'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['facebook'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">Facebook:</p>
<p><?php echo $pdetails['facebook'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['twitter'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">	Twitter:</p>
<p><?php echo $pdetails['twitter'];?></p>
</div>
<?php endif;?>

<?php if(empty($pdetails['instagram'])):else:?>
<div class="opi-item ">
<p class="opi-item-title">	Instagram:</p>
<p><?php echo $pdetails['instagram'];?></p>
</div>
<?php endif;?>

</div>
<?php endif;?>
</div>
<!-- other personal info end-->
</div>
<!--Smaller container for Personal details end -->

<!--Bigger container for Other details -->
<div class="container cv1-right general-info ">
<!--Objective -->
<div class="gi">
<div class="info-header">
<h2 class="bl">
<?php
$title = "Objective";
$obj = $api->getheadersbytitle($title);
echo $obj['title'];
?>
</h2>
</div>
<div class="info-text">
<div class="objective-info">
<?php
$objectives = $api->getAllObjBypid($pid);
foreach($objectives as $objective):
?>
<p><?php echo nl2br($objective['obj']);?></p>
<?php
endforeach;	
?>
</div>
</div>
</div>
<!--Objective ends-->
<!--Education -->
<div class="gi">
<div class="info-header">
<h2 class="bl">
<?php
$title2 = "Education";
$obj2 = $api->getheadersbytitle($title2);
echo $obj2['title'];
?>
</h2>
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
<h2 class="bl">Skills</h2>
</div>
<div class="info-text">
<div class="skills-info">
<table>
<tr>
<td>
<li class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv1-sp">
<div class="sb cv1-sb w-20"></div>
</div>
</li>
</td>
<td>
<li class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv1-sp">
<div class="sb cv1-sb w-80"></div>
</div>
</li>
</td>
</tr>

<tr>
<td>
<li class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv1-sp">
<div class="sb cv1-sb w-60"></div>
</div>
</li>
</td>
<td>
<li class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv1-sp">
<div class="sb cv1-sb w-80"></div>
</div>
</li>
</td>
</tr>
<tr>
<td>
<li class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv1-sp">
<div class="sb cv1-sb w-80"></div>
</div>
</li>
</td>
<td>
<li class="skills-info-li">
<p class="skill-name">Lorem ipsum dolor</p>
<div class="sp cv1-sp">
<div class="sb cv1-sb w-80"></div>
</div>
</li>
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
<h2 class="bl">Experience</h2>
</div>
<div class="info-text">
<div class="experience-info ">
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
<h2 class="bl">Pojects</h2>
</div>
<div class="info-text">
<div class="project-info ">
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
<h2 class="bl">Reference</h2>
</div>
<div class="info-text">
<div class="reference-info ">
<p>Lorem ipsum dolor sit amet.</p>
</div>
</div>
</div>
<!--Reference end-->
</div>
<!--Bigger container for Other details end-->
</div>
</div>
</body>
</html>
<?php
endif;
?>