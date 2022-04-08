<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE = edge">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
        <title>Marketing Request</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <!--Optional theme -->
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

        <link rel = "stylesheet" href = "//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <link rel = "stylesheet" href = "css/datepicker3.css">

        <!--HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>            
            body {
                background: url('http://admissions.pcom.edu/wp-content/uploads/2013/08/members.png') repeat-x;
            }

            .preheader {
                background-color: #153867;
                height:10px;
            }

            .header img {
                height: 100px;
            }

            .footer {
                background-color: #153867;
                margin-top: 50px;
                padding-top: 10px;
                padding-bottom: 10px;
                color: #fff;
                font-size: .8em;
                text-align: center;
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
        </style>
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

        <!--
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1" style="height:20px;">
                       
                    </div>
                </div>
            </div>
        -->

        <div class="preheader"></div>

        <div class="container-fluid">

            <!--
                        <div class="row">
                            <div class="col-md-1 col-md-offset-1 header">
                                <img src="img/pcomlogo.png">
                            </div>
                            <div class="col-md-9">
                                Philadelphia College of Osteopathic Medicine<br>
                                Marketing &amp; Communications Work Request
                            </div>
                        </div>
            -->


            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row" style="margin-top: 15px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee">
                        <div class="col-md-1 header">
                            <img src="img/pcomlogo.png">
                        </div>
                        <div class="col-md-11 header">
                            <h4>Philadelphia College of Osteopathic Medicine</h4>
                            <h2>Marketing &amp; Communications Work Request</h2>
                        </div>
                    </div>
                </div>
            </div>