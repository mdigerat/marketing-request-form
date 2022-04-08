<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require 'PHPMailer/PHPMailerAutoload.php';
    //escape all $_POST vars
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $key2 => $value2) {
                $_POST[$key][$key2] = htmlspecialchars($value2);
            }
        } else {
            $_POST[$key] = htmlspecialchars($value);
        }
    }
    //zip files together
    $fileName = md5(microtime());
    $file = "/var/www/files/marketing/$fileName.zip";
    $zip = new ZipArchive();
    $zip->open($file, ZipArchive::CREATE);
    $files = false;
    $fileError = false;
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        if ($_FILES['file']['error'][$i] == 0 || $_FILES['file']['error'][$i] == 4) {
            if ($_FILES['file']['error'][$i] == 0) {
                $zip->addFile($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]);
                $files = true;
            }
        } else {
            $fileError = true;
        }
    }
    $res = $zip->close();
    $size = filesize($file);
    if ($size > 25000000) {
        $sizeError = true;
    }
    if ($fileError || $sizeError) {
        header("Location: thankyou.php?error=true");
        exit;
    } else {

        $subject = "Marketing Request for" . $_POST['name'];

        $body = "<style>.inset {margin-left:30px;}</style>" .
                "Name: " . $_POST['name'] . "<br>" .

                "Email: " . $_POST['email'] . "<br>" .
                "Extension: " . $_POST['extension'] . "<br>" .
                "Department: " . $_POST['department'] . "<br>" .
                "Campus: " . $_POST['campus'] . "<br>" .
                "<br>" .
                "Project Name: " . $_POST['project-name'] . "<br>" .
                "Printing Needed: " . $_POST['printing'] . "<br>" .
                "Date Needed: " . $_POST['date'] . "<br>" .
                "Job Type: " . $_POST['job'] . "<br>" .
                "Quantity: " . $_POST['quantity'] . "<br>" .
                "<br>" .
                "Project Type: <br>";


        foreach ($_POST['type'] as $type) {
            switch ($type) {
                case "advertising":
                    $body .= "Advertising<br>";

                    if ($_POST['advertising-print']) {
                        $body .= "
                    <div class = 'inset'>Print<div class = 'inset'>" .
                                "Color: " . $_POST['advertising-print-color'] . "<br>" .
                                "Size: " . $_POST['advertising-print-size'] . "<br>" .
                                "Other: " . $_POST['advertising-print-other'] . "<br>" .
                                "Delivery: " . $_POST['advertising-print-delivery'] . "<br>" .
									"Advertising Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['ad-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['ad-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['ad-prospective-students'] . "<br>" .
											"Students: " . $_POST['ad-current-students'] . "<br>" .
											"Alumni: " . $_POST['ad-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['ad-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['ad-donors-friends'] . "<br>" .
											"Other: " . $_POST['ad-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['ad-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['ad-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['ad-project-outcomes'] . "<br>" .
                                "</div></div>";
                    }

                    if ($_POST['advertising-online']) {
                        $body .= "
                    <div class = 'inset'>Online<div class = 'inset'>" .
                                "Color: " . $_POST['advertising-online-color'] . "<br>" .
                                "Size: " . $_POST['advertising-online-size'] . "<br>" .
                                "Other: " . $_POST['advertising-online-other'] . "<br>" .
                                "Delivery: " . $_POST['advertising-online-delivery'] . "<br>" .
									"Advertising Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['ad-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['ad-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['ad-prospective-students'] . "<br>" .
											"Students: " . $_POST['ad-current-students'] . "<br>" .
											"Alumni: " . $_POST['ad-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['ad-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['ad-donors-friends'] . "<br>" .
											"Other: " . $_POST['ad-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['ad-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['ad-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['ad-project-outcomes'] . "<br>" .
                                "</div></div>";
                    }

                    break;
                case "email-graphic":
                    $body .= "
                    <div class = 'inset'>Email graphic<div class = 'inset'>" .
                            "Text: " . $_POST['email-graphic-text'] . "<br>" .
									"Email Graphic Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['eg-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['eg-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['eg-prospective-students'] . "<br>" .
											"Students: " . $_POST['eg-current-students'] . "<br>" .
											"Alumni: " . $_POST['eg-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['eg-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['eg-donors-friends'] . "<br>" .
											"Other: " . $_POST['eg-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['eg-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['eg-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['eg-project-outcomes'] . "<br>" .
                            "</div></div>";
                    break;

                case "popup":
                    $body .= "
                    <div class = 'inset'>Popup<div class = 'inset'>" .
                            "Size: " . $_POST['popup-size'] . "<br>" .
                            "File Type: " . $_POST['popup-text'] . "<br>" .
									"Popup Display Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['pd-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['pd-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['pd-prospective-students'] . "<br>" .
											"Students: " . $_POST['pd-current-students'] . "<br>" .
											"Alumni: " . $_POST['pd-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['pd-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['pd-donors-friends'] . "<br>" .
											"Other: " . $_POST['pd-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['pd-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['pd-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['pd-project-outcomes'] . "<br>" .
                            "</div></div>";
                    break;

                case "brochure":
                    $body .= "
					<div class = 'inset'>Brochure<div class = 'inset'>" .
									"Brochure Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['br-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['br-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['br-prospective-students'] . "<br>" .
											"Students: " . $_POST['br-current-students'] . "<br>" .
											"Alumni: " . $_POST['br-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['br-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['br-donors-friends'] . "<br>" .
											"Other: " . $_POST['br-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['br-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['br-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['br-project-outcomes'] . "<br>" .
							"</div></div>";
                    break;
                case "invitation":
                    $body .= "
					<div class = 'inset'>Invitation<div class = 'inset'>" .
									"Invitation Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['in-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['in-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['in-prospective-students'] . "<br>" .
											"Students: " . $_POST['in-current-students'] . "<br>" .
											"Alumni: " . $_POST['in-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['in-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['in-donors-friends'] . "<br>" .
											"Other: " . $_POST['in-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['in-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['in-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['in-project-outcomes'] . "<br>" .
							"</div></div>";
                    break;
                case "e-postcard":
                    $body .= "
					<div class = 'inset'>E-postcard<div class = 'inset'>" .
									"E-Postcard Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['ep-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['ep-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['ep-prospective-students'] . "<br>" .
											"Students: " . $_POST['ep-current-students'] . "<br>" .
											"Alumni: " . $_POST['ep-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['ep-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['ep-donors-friends'] . "<br>" .
											"Other: " . $_POST['ep-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['ep-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['ep-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['ep-project-outcomes'] . "<br>" .
							"</div></div>";
					break;
                case "program":
                    $body .= "
					<div class = 'inset'>Program<div class = 'inset'>" .
									"Program Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['pr-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['pr-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['pr-prospective-students'] . "<br>" .
											"Students: " . $_POST['pr-current-students'] . "<br>" .
											"Alumni: " . $_POST['pr-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['pr-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['pr-donors-friends'] . "<br>" .
											"Other: " . $_POST['pr-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['pr-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['pr-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['pr-project-outcomes'] . "<br>" .
							"</div></div>";
                    break;
                case "logo":
                    $body .= "
					<div class = 'inset'>Logo<div class = 'inset'>" .
									"Logo Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['lo-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['lo-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['lo-prospective-students'] . "<br>" .
											"Students: " . $_POST['lo-current-students'] . "<br>" .
											"Alumni: " . $_POST['lo-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['lo-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['lo-donors-friends'] . "<br>" .
											"Other: " . $_POST['lo-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['lo-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['lo-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['lo-project-outcomes'] . "<br>" .
							"</div></div>";
                    break;
                case "publicity":
                    $body .= "
                    <div class = 'inset'>Publicity<div class = 'inset'>" .
                            "Reason: " . $_POST['publicity-what'] . "<br>" .
                            "Why newsworthy: " . $_POST['publicity-why'] . "<br>" .
                            "Date/Time: " . $_POST['publicity-date'] . "<br>" .
                            "Photographer: " . $_POST['publicity-photo'] . "<br>" .
									"Publicity Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['pu-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['pu-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['pu-prospective-students'] . "<br>" .
											"Students: " . $_POST['pu-current-students'] . "<br>" .
											"Alumni: " . $_POST['pu-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['pu-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['pu-donors-friends'] . "<br>" .
											"Other: " . $_POST['pu-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['pu-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['pu-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['pu-project-outcomes'] . "<br>" .
                            "</div></div>";
                    break;
                case "project-other":
                    $body .= "
                    <div class = 'inset'>Other<div class = 'inset'>" .
                            "Reason: " . $_POST['project-other-what'] . "<br>" .
                            "Why newsworthy: " . $_POST['project-other-why'] . "<br>" .
                            "Date/Time: " . $_POST['project-other-date'] . "<br>" .
                            "Photographer: " . $_POST['project-other-photo'] . "<br>" .
									"Other Creative Brief" . "<br>" .
										"Background" . "<br>" .
											"College Goal: " . $_POST['ot-goal'] . "<br>" .
										"Objective" . "<br>" .
											"Objective: " . $_POST['ot-objective'] . "<br>" .
										"Audience" . "<br>" .
											"Prospective Students: " . $_POST['ot-prospective-students'] . "<br>" .
											"Students: " . $_POST['ot-current-students'] . "<br>" .
											"Alumni: " . $_POST['ot-alumni'] . "<br>" .
											"Faculty and Staff: " . $_POST['ot-faculty-staff'] . "<br>" .
											"Donors/Friends: " . $_POST['ot-donors-friends'] . "<br>" .
											"Other: " . $_POST['ot-audience-other'] . "<br>" .
										"Key Message" . "<br>" .
											"Recipient Thoughts: " . $_POST['ot-recipient-thoughts'] . "<br>" .
											"Call to Action: " . $_POST['ot-call-to-action'] . "<br>" .
										"Key Message" . "<br>" .
											"Outcomes: " . $_POST['ot-project-outcomes'] . "<br>" .
                            "</div></div>";
                    break;
                case "led":
                    $body .= "
                    LED<div class = 'inset'>" .
                            "Line One: " . $_POST['led-1'] . "<br>" .
                            "Line Two: " . $_POST['led-2'] . "<br>" .
                            "Line Three: " . $_POST['led-3'] . "<br>" .
                            "</div>";
                    break;
                case "banner":
                    $body .= "
                    Banner<div class = 'inset'>" .
                            "Size: " . $_POST['banner-size'] . "<br>" .
                            "File Type: " . $_POST['banner-text'] . "<br>" .
                            "</div>";
                    break;
                case "marketing":
                    $body .= "Marketing<br>";
                    break;
                case "research":
                    $body .= "
                    Research Poster<div class = 'inset'>" .
                            "Size: " . $_POST['research-size'] . "<br>" .
                            "</div>";
                    break;
                case "e-letterhead":
                    $body .= "E-Letterhead<br>";
                    break;
            }
        }

        $body .= "<br>Proof to: " . $_POST['proof-to'] . "<br>" .
                "Proof type: " . $_POST['proof-type'] . "<br>" .
                "Deliver to: " . $_POST['deliver-to'] . "<br>" .
                "Instructions: " . $_POST['specific'] . "<br>";

        $mail = new PHPMailer();
        /*$mail->AddAddress('communications@pcom.edu');*/
        $mail->AddAddress('kelleyco@pcom.edu');
        $mail->From = "no-reply@pcom.edu";
        $mail->FromName = "Marketing Request";
        $mail->Sender = "no-reply@pcom.edu";
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        if ($files) {
            $mail->AddAttachment($file);
        }

        if (!$mail->send()) {
            echo 'An error has occurred.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        } else {
            file_put_contents("/var/www/files/marketing/$fileName.doc", $body);
        }

        $mail = new PHPMailer();
        $mail->AddAddress($_POST['email']);
        $mail->From = "no-reply@pcom.edu";
        $mail->FromName = "Marketing Request";
        $mail->Sender = "no-reply@pcom.edu";
        $mail->Subject = 'Submission Confirmation';
        $mail->Body = 'Thank you for submitting your work request to Marketing and Communications for approval. Your project will be reviewed. Should your project need additional information, we will contact you.
        <br><br>PCOM Office of Marketing and Communications<br>
Philadelphia College of Osteopathic Medicine<br>
4180 City Avenue, Philadelphia PA 19131<br>
215-871-6300 - 215-871-6307 (fax)<br>
<a href="www.pcom.edu">pcom.edu</a>';
        $mail->isHTML(true);

        if (!$mail->send()) {
            echo 'An error has occurred.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        } else {

            header("Location: thankyou.php");
            exit;
        }
    }
}
?>
<?php require ('includes/header.php'); ?>

<!-- BEGIN REQUESTOR SECTION -->
    <div class="row">
    <div class="col-md-12">

		  <div id="formBorder">


			<div class="alert alert-danger" role="alert" style="display: none" id="error-box">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> There are errors on the page. Please review the items in red below.
			</div>



        <div style="margin-bottom: 10px">
		<!-- <legend><strong>Person Requesting Project</strong></legend> -->
		<span class="required">*</span> indicates a required field


		</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <form enctype="multipart/form-data" method="post">

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label" for="name">Name</label> <span class="required">*</span>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label" for="email">Email</label> <span class="required">*</span>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label heading" for="extension">Extension</label> <span class="required">*</span>
                        <input type="text" class="form-control" id="extension" name="extension" pattern=[0-9]{4}>
						<p>(Please enter your 4-digit extension)</p>                        
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label heading" for="department">Department</label> <span class="required">*</span>
                        <input type="text" class="form-control" id="department" name="department">
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label class="control-label heading">Campus</label>
                <div class="radio" style="margin-top:0">
                    <label>
                        <input type="radio" name="campus" value="PCOM">
                        PCOM
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="campus" value="GA-PCOM">
                        GA-PCOM
                    </label>
                </div>
            </div>
		</div>
	</div>
	</div>
<!-- END REQUESTOR SECTION -->

<!-- BEGIN PROJECT INFORMATION SECTION -->
 		<div  id="formBorder">





            <div class="row">
                <div class="col-md-6">
            			<legend><strong>Project Information</strong></legend>

                    <div class="form-group">
                       	<label for="project-name" class="control-label heading">Name of project</label> <span class="required">*</span>
                       	<input type="text" class="form-control" id="project-name" name="project-name">
                    </div>

                </div>
            </div>


            <div class="row">            
                <div class="col-md-3">

                    <div class="form-group">
                        <label class="control-label heading">Is printing needed?</label>  <span class="required">*</span>
                        <div class="radio" style="margin-top:0">
                            <label>
                                <input type="radio" name="printing" value="Yes">
                                Yes
                            </label>
                        </div>

                        <div class="radio" style="margin-bottom: 15px;">
                            <label>
                                <input type="radio" name="printing" value="No">
                                No
                            </label>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="form-group">

                        <label class="control-label heading">Job Type</label>
                        <div class="radio" style="margin-top:0">
                            <label>
                                <input type="radio" name="job" value="New">
                                New Job

                            </label>
                        </div>

                        <div class="radio" style="margin-bottom: 15px;">
                            <label>
                                <input type="radio" name="job" value="Revision">
                                Revision
                            </label>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-2">

                    <div class="form-group date">
                        <label for="date" class="control-label heading">Delivery&nbsp;Date</label><span class="required">&nbsp;*&nbsp;</span>
                        <div class="input-group date">
                            <input type="text" class="form-control form-control-inline" id="date" name="date" readonly="readonly" value="mm/dd/yyy"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-md-offset-1">

                    <div class="form-group">
                        <label for="quantity" class="control-label heading">Quantity</label><span class="required">&nbsp;*</span></br>
                        <input type="number" class="form-control form-control-inline" id="quantity" name="quantity">
                    </div>
                </div>
            </div>
<!-- START TYPES OF PROJECTS-->
    <div class="row">
        <div class="col-md-7">

            <div class="form-group">
                <label class="heading control-label">Type of Project (check all that apply)</label>
				<p><em>Creative Brief Required</em> <span class="required">*</span></p>
				<p>(A Creative Brief provides details on the background, objective, audience, messaging, and other elements of a project.)</p>






                        <div class="checkbox" style="margin-top:0">
                            <label>
                                <input type="checkbox" name="type[]" id="advertising" value="advertising" data-toggle="modal" data-target="#ad-creative-brief">
                                Advertising
                            </label>
						</div>

                        <div class="sub-options">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="advertising-print" id="advertising-print" value="1">
                                        Print Ad

                                    </label>
                                </div>
                                <div class="sub-options" class="col-md-8">

                                    <div class="form-group">
                                        <label class="control-label">Color</label>
                                        <div class="radio" style="margin-top:0">
                                            <label>
                                                <input type="radio" name="advertising-print-color" value="Full-color">
                                                Full-color
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="advertising-print-color" value="Black and white">
                                                Black and white
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="department" class="control-label">Size and file format of ad</label>
                                        <input type="text" class="form-control" id="advertising-print-size" name="advertising-print-size">
                                    </div>
                                    <div class="form-group">
                                        <label for="department" class="control-label">Other ad specifications</label>
                                        <input type="text" class="form-control" id="advertising-print-other" name="advertising-print-other">
                                    </div>


                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="advertising-online" name="advertising-online" value="1">
                                        Online Digital Ad

                                    </label>
                                </div>
                                <div class="sub-options">
                                    <div class="form-group">
                                        <label class="control-label">Color</label>
                                        <div class="radio" style="margin-top:0">
                                            <label>
                                                <input type="radio" name="advertising-online-color" value="Full-color">
                                                Full-color
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="advertising-online-color" value="Black and white">
                                                Black and white
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="department" class="control-label">Size and file format of ad</label>
                                        <input type="text" class="form-control" id="advertising-online-size" name="advertising-online-size">
                                    </div>
                                    <div class="form-group">
                                        <label for="department" class="control-label">Other ad specifications</label>
                                        <input type="text" class="form-control" id="advertising-online-other" name="advertising-online-other">
                                    </div>
                                </div>
                            </div>
<!-- START ADVERTISING CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="ad-creative-brief">
                        <div class="form-group">
								<legend><strong>Advertising Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="ad-goal" name="ad-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="ad-objective" name="ad-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ad-prospective-students" id="ad-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ad-current-students" id="ad-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ad-alumni" id="ad-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ad-faculty-staff" id="ad-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ad-donors-friends" id="ad-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="ad-audience-other" id="ad-audience-other" name="Other">
							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="ad-recipient-thoughts" name="ad-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="ad-call-to-action" name="ad-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>
							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="ad-project-outcomes" name="ad-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>

		</div>
	</div>
	<!-- END ADVERTISING CREATIVE BRIEF -->

                        </div>



                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="popup" value="popup" data-toggle="modal" data-target="#pd-creative-brief">
                                Pop Up Display


                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="popup-size" class="control-label">Size of display needed</label>
                                <input type="text" class="form-control" name="popup-size" id="popup-size">
                            </div>
                            <div class="form-group">
                                <label for="popup-text" class="control-label">Text for popup</label>
                                <input type="text" class="form-control" name="popup-text" id="popup-text">
                            </div>
<!-- START POPUP DISPLAY CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="pd-creative-brief">
                        <div class="form-group">
								<legend><strong>Popup Display Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="pd-goal" name="pd-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="pd-objective" name="pd-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pd-prospective-students" id="pd-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pd-current-students" id="pd-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pd-alumni" id="pd-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pd-faculty-staff" id="pd-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pd-donors-friends" id="pd-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="pd-audience-other" id="pd-audience-other" name="Other">
							</label>

						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="pd-recipient-thoughts" name="pd-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>


							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="pd-call-to-action" name="pd-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>
							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="pd-project-outcomes" name="pd-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END POPUP DISPLAY CREATIVE BRIEF -->
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="brochure" id="brochure" data-toggle="modal" data-target="#br-creative-brief">
                                Brochure
                            </label>
                        </div>
                        <div class="sub-options">
        <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Attach final approved content below
        </div>
<!-- START BROCHURE CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="br-creative-brief">
                        <div class="form-group">
								<legend><strong>Brochure Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="br-goal" name="br-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="br-objective" name="br-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="br-prospective-students" id="br-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="br-current-students" id="br-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="br-alumni" id="br-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="br-faculty-staff" id="br-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="br-donors-friends" id="br-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="br-audience-other" id="br-audience-other" name="Other">
							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="br-recipient-thoughts" name="br-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="br-call-to-action" name="br-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>

							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="br-project-outcomes" name="br-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END BROCHURE CREATIVE BRIEF -->
                        </div>


                        <div class="checkbox" >
                            <label>
                                <input type="checkbox" name="type[]" value="e-postcard" id="e-postcard" data-toggle="modal" data-target="#ep-creative-brief">
                                E-postcard
                            </label>
                        </div>
                        <div class="sub-options">
        <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Attach final approved content below
        </div>
<!-- START ePOSTCARD CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="ep-creative-brief">
                        <div class="form-group">
								<legend><strong>E-Postcard Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="ep-goal" name="ep-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="ep-objective" name="ep-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ep-prospective-students" id="ep-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ep-current-students" id="ep-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ep-alumni" id="ep-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ep-faculty-staff" id="ep-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>

                        </div>



						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ep-donors-friends" id="ep-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="ep-audience-other" id="ep-audience-other" name="Other">


							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="ep-recipient-thoughts" name="ep-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="ep-call-to-action" name="ep-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>


							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="ep-project-outcomes" name="ep-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END ePOSTCARD CREATIVE BRIEF -->
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="email-graphic" value="email-graphic" data-toggle="modal" data-target="#eg-creative-brief">
                                Email Graphic
                            </label>


                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="email-graphic-text" class="control-label">Text for email graphic</label>
                                <input type="text" class="form-control" name="email-graphic-text" id="email-graphic-text">
                            </div>
<!-- START eMAIL GRAPHIC CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="eg-creative-brief">
                        <div class="form-group">
								<legend><strong>E-Mail Graphic Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="eg-goal" name="eg-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="eg-objective" name="eg-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="eg-prospective-students" id="eg-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="eg-current-students" id="eg-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="eg-alumni" id="eg-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="eg-faculty-staff" id="eg-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>



						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="eg-donors-friends" id="eg-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="eg-audience-other" id="eg-audience-other" name="Other">


							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="eg-recipient-thoughts" name="eg-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="eg-call-to-action" name="eg-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>

							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="eg-project-outcomes" name="eg-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END eMAIL GRAPHIC CREATIVE BRIEF -->
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="invitation" id="invitation" data-toggle="modal" data-target="#in-creative-brief">
                                Invitation Package
                            </label>
                        </div>
                        <div class="sub-options">
        <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Attach final approved content below
        </div>
<!-- START INVITATION CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="in-creative-brief">
                        <div class="form-group">
								<legend><strong>Invitation Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="in-goal" name="in-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="in-objective" name="in-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="in-prospective-students" id="in-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="in-current-students" id="in-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="in-alumni" id="in-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="in-faculty-staff" id="in-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="in-donors-friends" id="in-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="in-audience-other" id="in-audience-other" name="Other">
							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="in-recipient-thoughts" name="in-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="in-call-to-action" name="in-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>

							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="in-project-outcomes" name="in-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END INVITATION CREATIVE BRIEF -->
                    	</div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="program" id="program" data-toggle="modal" data-target="#pr-creative-brief">
                                Program


                            </label>
                        </div>
                        <div class="sub-options">
        <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Attach final approved content below
        </div>
<!-- START PROGRAM CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="pr-creative-brief">
                        <div class="form-group">
								<legend><strong>Program Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="pr-goal" name="pr-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="pr-objective" name="pr-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pr-prospective-students" id="pr-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pr-current-students" id="pr-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pr-alumni" id="pr-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pr-faculty-staff" id="pr-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pr-donors-friends" id="pr-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="pr-audience-other" id="pr-audience-other" name="Other">
							</label>


						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="pr-recipient-thoughts" name="pr-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>

							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="pr-call-to-action" name="pr-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>

							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="pr-project-outcomes" name="pr-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END PROGRAM CREATIVE BRIEF -->
                    	</div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="logo" id="logo" data-toggle="modal" data-target="#lo-creative-brief">
                                Logo Request
                            </label>
                        </div>
                        <div class="sub-options">
        <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Attach final approved content below
        </div>
<!-- START LOGO CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="lo-creative-brief">
                        <div class="form-group">
								<legend><strong>Logo Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="lo-goal" name="lo-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="lo-objective" name="lo-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="lo-prospective-students" id="lo-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>



                        </div>


						<div class="checkbox">




                            <label>
                                <input type="checkbox" name="lo-current-students" id="lo-current-students" value="Current Students">
                                Current Students


                            </label>
                        </div>



						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="lo-alumni" id="lo-alumni" value="Alumni">
                                Alumni


                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="lo-faculty-staff" id="lo-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>

                        </div>


						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="lo-donors-friends" id="lo-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="lo-audience-other" id="lo-audience-other" name="Other">


							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="lo-recipient-thoughts" name="lo-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="lo-call-to-action" name="lo-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>

							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="lo-project-outcomes" name="lo-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END LOGO CREATIVE BRIEF -->
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="publicity" id="publicity" data-toggle="modal" data-target="#pu-creative-brief">
                                Publicity
                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="publicity-what" class="control-label">What is the reason for publicizing this?</label>
                                <input type="text" class="form-control" name="publicity-what" id="publicity-what">
                            </div>
                            <div class="form-group">
                                <label for="publicity-why" class="control-label">Why is this newsworthy?</label>
                                <input type="text" class="form-control" name="publicity-why" id="publicity-why">
                            </div>
                            <div class="form-group">
                                <label for="publicity-date" class="control-label">Date and time of event (if applicable)</label>
                                <input type="text" class="form-control" name="publicity-date" id="publicity-date">
                            </div>
                            <label class="control-label">Is a photographer scheduled (if applicable)?</label>
                            <div class="radio" style="margin-top:0">
                                <label>
                                    <input type="radio" name="publicity-photo" value="Yes">
                                    Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="publicity-photo" value="No">
                                    No
                                </label>
                            </div>
                            <div class="sub-options">
                            </div>
<!-- START PUBLICITY CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="pu-creative-brief">
                        <div class="form-group">
								<legend><strong>Publicity Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="pu-goal" name="pu-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="pu-objective" name="pu-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pu-prospective-students" id="pu-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pu-current-students" id="pu-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pu-alumni" id="pu-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pu-faculty-staff" id="pu-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="pu-donors-friends" id="pu-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="pu-audience-other" id="pu-audience-other" name="Other">
							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="pu-recipient-thoughts" name="pu-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="pu-call-to-action" name="pu-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>
							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="pu-project-outcomes" name="pu-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END PUBLICITY CREATIVE BRIEF -->
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="project-other" id="project-other" data-toggle="modal" data-target="#ot-creative-brief">
                                Other
                            </label>
                        </div>
                        <div class="sub-options">
        				<div class="alert alert-info" role="alert">
        					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        					Attach final approved content below
        				</div>
                            <div class="sub-options">
                            </div>
<!-- START OTHER CREATIVE BRIEF -->
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-12">
					<div class="ot-creative-brief">
                        <div class="form-group">
								<legend><strong>Other Creative Brief</strong></legend>
								<label class="heading control-label">Background</label>  <span class="required">*</span>
								<br>
								<em>Which overall College goal will this support?</em>
								<select class="form-control" id="ot-goal" name="ot-goal">
									<option value"">Please select one of the following that best describes which overall College goal this will support</option>
									<option value="Capitalizing on our osteopathic heritage">Capitalizing on our osteopathic heritage</option>
									<option value="Ensuring strength, consistency and quality in clinical training">Ensuring strength, consistency and quality in clinical training</option>
									<option value="Expanding our educational mission and footprint">Expanding our educational mission and footprint</option>
									<option value="Promoting our institutional identity and brand">Promoting our institutional identity and brand</option>
									<option value="Positioning PCOM for growth, stability and reduced tuition dependency">Positioning PCOM for growth, stability and reduced tuition dependency</option>
									<option value="PCOM College mission" data-toggle="modal" data-target="#mission">PCOM College mission</option>
								</select>
								<label class="heading control-label">Objective</label>  <span class="required">*</span><br>
								<em>What should this project achieve? What is the goal?
								<br> Example: We want our monthly donors to consider an increase for next year.</em>
								<textarea class="form-control" id="ot-objective" name="ot-objective"></textarea>
								<label class="heading control-label">Audience</label>  <span class="required">*</span><br>
								<em>Which audience do you want this project to engage?<br></em>
						</div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ot-prospective-students" id="ot-prospective-students" value="Prospective Students">
                                Prospective Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ot-current-students" id="ot-current-students" value="Current Students">
                                Current Students
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ot-alumni" id="ot-alumni" value="Alumni">
                                Alumni
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ot-faculty-staff" id="ot-faculty-staff" value="Faculty and Staff">
                                Faculty and Staff
                            </label>
                        </div>
						<div class="checkbox">
                            <label>
                                <input type="checkbox" name="ot-donors-friends" id="ot-donors-friends" value="Donors/Friends">
                                Donors/Friends
                            </label>
                        </div>
						<div class="form-group">
							<label>
								Other
								<input type="text" class="form-control" name="ot-audience-other" id="ot-audience-other" name="Other">
							</label>
						</div>
							<div class="form-group">
								<label class="heading control-label">Key Message</label><br>
								<strong>Recipient Thoughts</strong>  <span class="required">*</span>
								<textarea class="form-control" id="ot-recipient-thoughts" name="ot-recipient-thoughts"></textarea>
								<em>What should the recipient think and do as a result of reading this?<br></em>
							</div>
							<div class="form-group">
								<strong>Call to Action</strong>  <span class="required">*</span>
								<textarea class="form-control" id="ot-call-to-action" name="ot-call-to-action"></textarea>
								<em>What is the Call to Action?<br></em>
							</div>

							<div class="form-group">
								<label class="heading control-label">Outcomes</label>  <span class="required">*</span><br>
								<strong>How will you measure the success of this project?</strong>
								<textarea class="form-control" id="ot-project-outcomes" name="ot-project-outcomes"></textarea>
								<em>Examples: Attendance, enrollment, donation, analytics, etc.</em><br>
								<em>(Outcomes must be shared with Marketing and Communications to determine further support.)</em>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END OTHER CREATIVE BRIEF -->
                        </div>
		            </div>
                </div>
                    <div class="col-md-5">
            			<div class="form-group">
								<label class="heading control-label">Type of Project (check all that apply)</label>
				 				<p><em>Creative Brief is not required.</em></p>
                        	<div class="checkbox">
                           	 	<label>
                                	<input type="checkbox" name="type[]" id="banner" value="banner">Banner
                            	</label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="banner-size" class="control-label">Size of banner needed</label>
                                <input type="text" class="form-control" name="banner-size" id="banner-size">
                            </div>
                            <div class="form-group">
                                <label for="banner-text" class="control-label">Text for banner</label>
                                <input type="text" class="form-control" name="banner-text" id="banner-text">
                            </div>
                        </div>
                        <div class="checkbox" >
                            <label>
                                <input type="checkbox" name="type[]" value="e-letterhead" id="e-letterhead">
                                E-Letterhead Request
                            </label>
                        </div>
                        <div class="sub-options">
        				<div class="alert alert-info" role="alert">
        					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
       	 					Attach final approved content below
        				</div>
        				</div>
                       <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="led" value="led">
                                LED Electronic Sign (City Avenue)
                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="led-1" class="control-label">Text for sign (limit 14 characters per line)</label>
                                <input type="text" class="form-control" maxlength="14" name="led-1" id="led-1">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" maxlength="14" name="led-2">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" maxlength="14" name="led-3">


                            </div>
                        </div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="research" id="research">
                                Research Poster
                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" id="research-faculty">
                                        Faculty/Staff
                                    </label>
                                </div>
                                <div class="sub-options">
                                    <div class="form-group">
                                        <label for="research-size" class="control-label">Size of poster</label>
                                        <input type="text" class="form-control" name="research-size" id="research-size">
                                    </div>
        							<div class="alert alert-info" role="alert">
        								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        								Attach final approved content below
        							</div>

                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1" id="research-student">
                                            Student/Intern/Resident
                                        </label>
                                    </div>
                                </div>
                                <div class="sub-options">
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Students, interns, and residents MUST download the PDF version of this form and print it out to obtain proper signatures.<br>
                                        <a target="_blank" href="http://www.pcom.edu/Administration/Administrative_Departments/Marketing_and_Communications/MARCOM.request_form..pdf" class="alert-link">PDF Form</a>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="signage" value="signage">
                                Table Top Signs

                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="signage-size" class="control-label">Size of signage needed</label>
                                <input type="text" class="form-control" name="signage-size" id="signage-size">











                            </div>

                            <div class="form-group">
                                <label for="signage-text" class="control-label">Text for signage</label>
                                <input type="text" class="form-control" name="signage-text" id="signage-text">
                            </div>

                        </div>



                    </div>
               </div>

			</div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id="file-group">
                            <label for="file" class="control-label heading">Attach files and photos here <br>(limit 5 MB per file, 20 MB total)</label>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="file[]"></span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="file[]"></span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                            <button type="button" class="btn btn-default" id="add-file" style="margin-bottom: 15px;">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add another file
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="specific" class="heading">Specific instructions</label>
                        <textarea class="form-control" id="specific" name="specific"></textarea>
                    </div>
                </div>
            </div>
		<!--</div>-->

<!-- END TYPES OF PROJECTS -->
<!-- END PROJECT INFORMATION SECTION -->

<!-- START MIISSION POPUP -->
<div class="modal fade" id="mission">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<legend><strong>PCOM College mission</strong></legend>
			</div>
		<!-- Modal Body -->
		<div class="modal-body">
		<div id="formBorder">
            <div class="row">
            	<div  class="col-md-10">
					<div class="mission">
                        <div class="form-group">
								<em>Philadelphia College of Osteopathic Medicine (PCOM) is dedicated to the education of students in medicine, health and behavioral sciences. The College fosters the growth of the osteopathic profession by training physicians through programs of study guided by osteopathic medical tradition, concept and practice. 
								PCOM is committed to the advancement of knowledge and intellectual growth through teaching and research, and to the well-being of the community through leadership and service.</em>
								<br>
						</div>
            </div>
            </div>
			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</div>

	<!-- END MISSION POPUP -->

<!-- BEGIN PROOFING AND DELIVERY SECTION -->
	<!--<div id="formBorder">-->
            <legend><strong>Proofing and Delivery</strong></legend>
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label" for="proof-to">Send proof to</label> <span class="required">*</span>
                        <input type="text" class="form-control" id="proof-to" name="proof-to">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Proof type</label> <span class="required">*</span>
                        <div class="radio" style="margin-top:0">
                            <label>
                                <input type="radio" name="proof-type" value="Printed">
                                Printed proof
                            </label>
                        </div>
                        <div class="radio" style="margin-bottom: 15px;">
                            <label>
                                <input type="radio" name="proof-type" value="PDF">
                                Electronic PDF proof
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="deliver-to"  class="control-label heading">Deliver final product to</label> <span class="required">*</span>
                        <textarea class="form-control" id="deliver-to" name="deliver-to"></textarea>
                    </div>
				</div>
			</div>
            <div class="form-group">
            	<button type="submit" value="Validate!" class="btn btn-primary">Submit</button>
				<p>All questions pertaining to filling out the online work request should be submitted to <a href="mailto:suen@pcom.edu?subject=Marketing and Communications Work Request">Sue Neborak</a> at x6300.</p>
            </div>
		</form>
	</div>
   		<!--</div>-->
<!-- END PROOFING AND DELIVERY SECTION -->
   		<!--</div>-->
   		<!--</div>-->










</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.14/jquery.scrollTo.min.js"></script>
<!--
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
-->
<script>
    $("input[type=checkbox]").click(function () {
        $(this).parents("div").next(".sub-options").toggle("fast");
    });

    $("input[name=printing]").click(function () {
        if ($(this).val() == 'Yes') {
            var date = getFirstAvail(20);
            $("#date").val('');
        } else {
            var date = getFirstAvail(10);
        }

        $('.date').datepicker('setStartDate', date);
    });

    $("#add-file").click(function () {

        var text = '\
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">\
        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>\
        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="file[]"></span>\
        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>\
        </div>';

        $(text).insertBefore($(this));
    });


    function getFirstAvail(days) {

        var date = new Date();

        i = 0;

        while (i < days) {
            date.setDate(date.getDate() + 1);
            if (date.getDay() != 0 && date.getDay() != 6) {
                i++;
            }
        }

        return date;
    }


    $('.date').datepicker({
        startDate: getFirstAvail(10),
        daysOfWeekDisabled: "0,6",
        autoclose: true,
        todayHighlight: true,
        beforeShowDay: function (date) {

        }
    });

    $("form").submit(function () {

        var error = false;


        //clear all errors
        $(".form-group").removeClass('has-error');
        $("#error-box").hide();


        //check text fields
        var fields = ['name', 'email', 'extension', 'department', 'date', 'quantity', 'proof-to', 'deliver-to', 'project-name'];

        for (key in fields) {
            if (!$("#" + fields[key]).val()) {
                $("#" + fields[key]).parents('.form-group').addClass('has-error');
                error = true;
            }
        }


        //check radios and checkboxs
        var nameFields = ['printing', 'type[]', 'proof-type'];

        for (key in nameFields) {
            if (!$("input[name='" + nameFields[key] + "']:checked").val()) {
                $("input[name='" + nameFields[key] + "']").parents('.form-group').addClass('has-error');
                error = true;
            }
        }


        //check fields that require a file
        var fileFields = ['brochure', 'flyer', 'invitation', 'postcard', 'e-postcard', 'program', 'research-faculty'];

        for (key in fileFields) {
            if ($("#" + fileFields[key] + ":checked").val()) {

                var files = false;
                $("input[name='file[]']").each(function () {
                    if ($(this).val()) {
                        files = true;
                    }
                });

                if (!files) {
                    $("#file-group").addClass('has-error');
                    error = true;
                }
            }
        }

        //check fields that require a creative brief
        //advertising creative brief
        if ($("#advertising").prop("checked")) {
            if (!$("#ad-goal").val()) {
                $("#ad-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ad-objective").val()) {
                $("#ad-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#ad-prospective-students").prop("checked") || $("#ad-current-students").prop("checked") || $("#ad-alumni").prop("checked") || $("#ad-faculty-staff").prop("checked") || $("#ad-donors-friends").prop("checked") || $("#ad-donors-friends").prop("checked"))) {
                $("#advertising").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#ad-recipient-thoughts").val()) {
                $("#ad-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ad-call-to-action").val()) {
                $("#ad-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ad-project-outcomes").val()) {
                $("#ad-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //popup creative brief        
        if ($("#popup").prop("checked")) {
            if (!$("#pd-goal").val()) {
                $("#pd-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pd-objective").val()) {
                $("#pd-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#pd-prospective-students").prop("checked") || $("#pd-current-students").prop("checked") || $("#pd-alumni").prop("checked") || $("#pd-faculty-staff").prop("checked") || $("#pd-donors-friends").prop("checked") || $("#pd-donors-friends").prop("checked"))) {
                $("#popup").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#pd-recipient-thoughts").val()) {
                $("#pd-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pd-call-to-action").val()) {
                $("#pd-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pd-project-outcomes").val()) {
                $("#pd-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //brochure creative brief
        if ($("#brochure").prop("checked")) {
            if (!$("#br-description").val()) {
                $("#br-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#br-goal").val()) {
                $("#br-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#br-objective").val()) {
                $("#br-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#br-prospective-students").prop("checked") || $("#br-current-students").prop("checked") || $("#br-alumni").prop("checked") || $("#br-faculty-staff").prop("checked") || $("#br-donors-friends").prop("checked") || $("#br-donors-friends").prop("checked"))) {
                $("#brochure").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#br-recipient-thoughts").val()) {
                $("#br-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#br-call-to-action").val()) {
                $("#br-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#br-project-outcomes").val()) {
                $("#br-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //e-postcard creative brief
        if ($("#e-postcard").prop("checked")) {
            if (!$("#ep-description").val()) {
                $("#ep-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ep-goal").val()) {
                $("#ep-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ep-objective").val()) {
                $("#ep-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#ep-prospective-students").prop("checked") || $("#ep-current-students").prop("checked") || $("#ep-alumni").prop("checked") || $("#ep-faculty-staff").prop("checked") || $("#ep-donors-friends").prop("checked") || $("#ep-donors-friends").prop("checked"))) {
                $("#e-postcard").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#ep-recipient-thoughts").val()) {
                $("#ep-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ep-call-to-action").val()) {
                $("#ep-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ep-project-outcomes").val()) {
                $("#ep-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //email-graphic creative brief
        if ($("#email-graphic").prop("checked")) {
            if (!$("#eg-description").val()) {
                $("#eg-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#eg-goal").val()) {
                $("#eg-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#eg-objective").val()) {
                $("#eg-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#eg-prospective-students").prop("checked") || $("#eg-current-students").prop("checked") || $("#eg-alumni").prop("checked") || $("#eg-faculty-staff").prop("checked") || $("#eg-donors-friends").prop("checked") || $("#eg-donors-friends").prop("checked"))) {
                $("#email-graphic").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#eg-recipient-thoughts").val()) {
                $("#ad-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#eg-call-to-action").val()) {
                $("#ad-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#eg-project-outcomes").val()) {
                $("#eg-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //invitation creative brief
        if ($("#invitation").prop("checked")) {
            if (!$("#in-description").val()) {
                $("#in-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#in-goal").val()) {
                $("#in-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#in-objective").val()) {
                $("#in-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#in-prospective-students").prop("checked") || $("#in-current-students").prop("checked") || $("#in-alumni").prop("checked") || $("#in-faculty-staff").prop("checked") || $("#in-donors-friends").prop("checked") || $("#in-donors-friends").prop("checked"))) {
                $("#invitation").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#in-recipient-thoughts").val()) {
                $("#in-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#in-call-to-action").val()) {
                $("#in-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#in-project-outcomes").val()) {
                $("#in-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //program creative brief
        if ($("#program").prop("checked")) {
            if (!$("#pr-description").val()) {
                $("#pr-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pr-goal").val()) {
                $("#pr-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pr-objective").val()) {
                $("#pr-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#pr-prospective-students").prop("checked") || $("#pr-current-students").prop("checked") || $("#pr-alumni").prop("checked") || $("#pr-faculty-staff").prop("checked") || $("#pr-donors-friends").prop("checked") || $("#pr-donors-friends").prop("checked"))) {
                $("#program").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#pr-recipient-thoughts").val()) {
                $("#pr-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pr-call-to-action").val()) {
                $("#pr-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pr-project-outcomes").val()) {
                $("#pr-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //publicity creative brief
        if ($("#publicity").prop("checked")) {
            if (!$("#pu-description").val()) {
                $("#pu-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pu-goal").val()) {
                $("#pu-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pu-objective").val()) {
                $("#pu-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#pu-prospective-students").prop("checked") || $("#pu-current-students").prop("checked") || $("#pu-alumni").prop("checked") || $("#pu-faculty-staff").prop("checked") || $("#pu-donors-friends").prop("checked") || $("#pu-donors-friends").prop("checked"))) {
                $("#publicity").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#pu-recipient-thoughts").val()) {
                $("#pu-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pu-call-to-action").val()) {
                $("#pu-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#pu-project-outcomes").val()) {
                $("#pu-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //logo creative brief
        if ($("#logo").prop("checked")) {
            if (!$("#lo-description").val()) {
                $("#lo-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#lo-goal").val()) {
                $("#lo-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#lo-objective").val()) {
                $("#lo-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#lo-prospective-students").prop("checked") || $("#lo-current-students").prop("checked") || $("#lo-alumni").prop("checked") || $("#lo-faculty-staff").prop("checked") || $("#lo-donors-friends").prop("checked") || $("#lo-donors-friends").prop("checked"))) {
                $("#logo").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#lo-recipient-thoughts").val()) {
                $("#lo-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#lo-call-to-action").val()) {
                $("#lo-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#lo-project-outcomes").val()) {
                $("#lo-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        }

        //other creative brief
        if ($("#project-other").prop("checked")) {
            if (!$("#ot-description").val()) {
                $("#ot-description").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ot-goal").val()) {
                $("#ot-goal").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ot-objective").val()) {
                $("#ot-objective").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!($("#ot-prospective-students").prop("checked") || $("#ot-current-students").prop("checked") || $("#ot-alumni").prop("checked") || $("#ot-faculty-staff").prop("checked") || $("#ot-donors-friends").prop("checked") || $("#ot-donors-friends").prop("checked"))) {
                $("#project-other").closest('.form-group').addClass('has-error');
                error = true;
            }

            if (!$("#ot-recipient-thoughts").val()) {
                $("#ot-recipient-thoughts").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ot-call-to-action").val()) {
                $("#ot-call-to-action").closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!$("#ot-project-outcomes").val()) {
                $("#ot-project-outcomes").closest('.form-group').addClass('has-error');
                error = true;
            }
        } 





























        //nested fields
        if ($("#advertising").prop("checked")) {
            if (!($("#advertising-print").prop("checked") || $("#advertising-online").prop("checked"))) {
                $("#advertising-print").closest('.form-group').addClass('has-error');
                error = true;
            } else {
                if ($("#advertising-print").prop("checked")) {
                    if (!$("input[name='advertising-print-color']:checked").val()) {
                        $("input[name='advertising-print-color']").closest('.form-group').addClass('has-error');
                        error = true;
                    }
                    if (!$("#advertising-print-size").val()) {
                        $("#advertising-print-size").closest('.form-group').addClass('has-error');
                        error = true;
                    }
                }
                if ($("#advertising-online").prop("checked")) {
                    if (!$("input[name='advertising-online-color']:checked").val()) {
                        $("input[name='advertising-online-color']").closest('.form-group').addClass('has-error');
                        error = true;
                    }
                    if (!$("#advertising-online-size").val()) {
                        $("#advertising-online-size").closest('.form-group').addClass('has-error');
                        error = true;
                    }
                }
            }
        }

        if ($("#email-graphic").prop("checked")) {









            if (!$("#email-graphic-text").val()) {
                $("#email-graphic-size").closest('.form-group').addClass('has-error');
            }

        }

        if ($("#led").prop("checked")) {

            if (!$("#led-1").val()) {
                $("#led-1").closest('.form-group').addClass('has-error');
            }

        }

        if ($("#banner").prop("checked")) {

            if (!$("#banner-size").val()) {
                $("#banner-size").closest('.form-group').addClass('has-error');
            }

            if (!$("#banner-text").val()) {
                $("#banner-text").closest('.form-group').addClass('has-error');
            }

        }

        if ($("#other").prop("checked")) {

            if (!$("#other-text").val()) {
                $("#other-text").closest('.form-group').addClass('has-error');
            }

        }



        if ($("#publicity").prop("checked")) {

            if (!$("#publicity-what").val()) {
                $("#publicity-what").closest('.form-group').addClass('has-error');
            }

            if (!$("#publicity-why").val()) {
                $("#publicity-why").closest('.form-group').addClass('has-error');
            }

        }


        if ($("#research").prop("checked")) {

            if (!$("#research-faculty:checked").val()) {
                $("#research-faculty").closest('.form-group').addClass('has-error');
            } else if (!$("#research-size").val()) {
                $("#research-size").closest('.form-group').addClass('has-error');
            }

            if ($("#research-student:checked").val()) {
                $("#research-student").closest('.form-group').addClass('has-error');
            }

        }

        //check file sizes
        /*$("input[name='file[]']").each(function () {
         if ($(this).val()) {
         alert($(this)[0].files[0].size);
         }
         });*/

        if ($(".form-group").hasClass('has-error')) {
            $("#error-box").show();
            $("body").scrollTo("#error-box");
            return false;
        }
    });

$('select').change(function () {
    if ($(this).val() == "PCOM College mission") {
        $('#mission').modal('show');
    }
});


</script>


<script>
// Validate Creative Brief Fields
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "requestForm" ).validate({
  rules: {
    ad-description: {
      required: "#advertising:checked"
    }
  }
});
</script>



<?php require ('includes/footer.php'); ?>
