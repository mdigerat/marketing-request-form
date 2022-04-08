<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
        <title></title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <!--Optional theme -->
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

        <link rel = "stylesheet" href = "//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <link rel = "stylesheet" href = "css/datepicker3.css" />
		
		<link rel = "stylesheet" type = "text/css" href = "css/formsTest.css" />

        <!--HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

<!--         <style>            
            .preheader {
                background-color: #153867;
                height:10px;
            }

            .header img {
			/*	height: 100%; */
				width: 75%;  
            /*	width: 100vw;   */
            /*		width: vmax    */
            /*   display: block; 
                margin-left: auto; 
                margin-right: auto */
            }

            .footer {
                width: 75%;
                background-color: #062b48;
                margin-top: 50px;
                padding-top: 10px;
                padding-bottom: 10px;
                color: #fff;
                font-size: .8em;
                text-align: center;
                border: #000000 3px groove;
                margin: auto;
                border-radius: 0em;
                padding: .5em;
                /* box-shadow: 7px 7px 7px #6e6e6e; */
            }
            .sub-options {
                margin-left: 40px;
                margin-top: -5px;
                display:none;
            }

            .sub-options+.checkbox {
                margin-top: -5px;
            }

            legend {
                margin-top: 40px;
            }

            #date {
                cursor: inherit;
                background-color:inherit;
                opacity: inherit;
            }

            .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
                color: #ccc;
            }

            .required {
                color: red;
            }
            
            label.heading {
                margin-top: 10px;
            } 
          
            .fileinput-filename {
                width: 80%;
                height: 100%;
            }

            .creative-brief {
                width: 95%;
                height: 100%;
                padding: 1.5em;
            }
            
            #border {
                width: 75%;
                background-color: #062b48;
                color: #000000;
                border: #000000 3px groove;
                margin: auto;
                text-align: left;
                border-radius: 0em;
                padding: 1.5em;
                /* box-shadow: 7px 7px 7px #6e6e6e; */
            }
            #formBorder {
                width: 75%;
                background-color: #efefef;
                color: #000000;
                border: #000000 3px groove;
                margin: auto;
                text-align: left;
                border-radius: 0em;
                padding: 1.5em;
                /* box-shadow: 7px 7px 7px #6e6e6e; */
            }
            .textarea {
                width: 50em;
                height: 4em;
            }
        </style>
-->
    </head>
    <body>

        <?php
        $contentMessage = '
        <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Attach final approved content below
        </div>
        ';
        ?>

<div class="row">
        <!-- <div class="preheader"></div> -->
        <div class="container-fluid">

