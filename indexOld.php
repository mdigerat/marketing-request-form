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

        $subject = "Marketing Request for " . $_POST['name'];

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
                                "</div></div>";
                    }

                    if ($_POST['advertising-online']) {
                        $body .= "
                    <div class = 'inset'>Online<div class = 'inset'>" .
                                "Color: " . $_POST['advertising-online-color'] . "<br>" .
                                "Size: " . $_POST['advertising-online-size'] . "<br>" .
                                "Other: " . $_POST['advertising-online-other'] . "<br>" .
                                "Delivery: " . $_POST['advertising-online-delivery'] . "<br>" .
                                "</div></div>";
                    }

                    break;
                case "email-graphic":
                    $body .= "
                    Email graphic<div class = 'inset'>" .
                            "Size: " . $_POST['email-graphic-size'] . "<br>" .
                            "File Type: " . $_POST['email-graphic-type'] . "<br>" .
                            "Text: " . $_POST['email-graphic-text'] . "<br>" .
                            "</div>";
                    break;
                case "led":
                    $body .= "
                    LED<div class = 'inset'>" .
                            "Line One: " . $_POST['led-1'] . "<br>" .
                            "Line Two: " . $_POST['led-2'] . "<br>" .
                            "Line Three: " . $_POST['led-3'] . "<br>" .
                            "</div>";
                    break;
                case "web-graphic":
                    $body .= "Web graphic<br>";
                    break;
                case "banner":
                    $body .= "
                    Banner<div class = 'inset'>" .
                            "Size: " . $_POST['banner-size'] . "<br>" .
                            "File Type: " . $_POST['banner-text'] . "<br>" .
                            "</div>";
                    break;
                case "brochure":
                    $body .= "Brochure<br>";
                    break;
                case "flyer":
                    $body .= "Flyer<br>";
                    break;
                case "invitation":
                    $body .= "Invitation<br>";
                    break;
                case "logo":
                    $body .= "Logo<br>";
                    break;
                case "postcard":
                    $body .= "Postcard<br>";
                    break;
                case "e-postcard":
                    $body .= "E-postcard<br>";
                    break;
                case "program":
                    $body .= "Program<br>";
                    break;
                case "other":
                    $body .= "
                    Other<div class = 'inset'>" .
                            "Description: " . $_POST['other-text'] . "<br>" .
                            "</div>";
                    break;
                case "publicity":
                    $body .= "
                    Publicity<div class = 'inset'>" .
                            "Reason: " . $_POST['publicity-what'] . "<br>" .
                            "Why newsworthy: " . $_POST['publicity-why'] . "<br>" .
                            "Date/Time: " . $_POST['publicity-date'] . "<br>" .
                            "Photographer: " . $_POST['publicity-photo'] . "<br>" .
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
            }
        }

        $body .= "<br>Proof to: " . $_POST['proof-to'] . "<br>" .
                "Proof type: " . $_POST['proof-type'] . "<br>" .
                "Deliver to: " . $_POST['deliver-to'] . "<br>" .
                "Instructions: " . $_POST['specific'] . "<br>";

        $mail = new PHPMailer();
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
            file_put_contents("/var/www/files/marketing/$fileName.txt", $body);
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




<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert" style="display: none" id="error-box">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> There are errors on the page. Please review the items in red below.
                </div>
            </div>
        </div>

        <div style="margin-bottom: 10px"><span class="required">*</span> indicates a required field</div>

    </div>
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
                        <input type="text" class="form-control" id="extension" name="extension">
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



            <legend>Project Information</legend>


            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="project-name" class="control-label heading">Name of project</label> <span class="required">*</span>
                        <input type="text" class="form-control" id="project-name" name="project-name">
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label heading">Is printing needed</label>  <span class="required">*</span>
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

                <div class="col-md-6">

                    <div class="form-group">

                        <label class="control-label heading">Job Type</label>
                        <div class="radio" style="margin-top:0">
                            <label>
                                <input type="radio" name="job" value="New">
                                New job
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
                <div class="col-md-6">

                    <div class="form-group date">
                        <label for="date" class="control-label heading">Date final project needed</label> <span class="required">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control" id="date" name="date" readonly="readonly"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="quantity" class="control-label heading">Quantity needed</label> <span class="required">*</span>
                        <input type="number" class="form-control" id="quantity" name="quantity">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="heading control-label">Type of Project (check all that apply)</label>  <span class="required">*</span>
                <div class="row">
                    <div class="col-md-6">



                        <div class="checkbox" style="margin-top:0">
                            <label>
                                <input type="checkbox" name="type[]" id="advertising" value="advertising">
                                Advertising
                            </label>
                        </div>

                        <div class="sub-options">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="advertising-print" id="advertising-print" value="1">
                                        Print ad
                                    </label>
                                </div>
                                <div class="sub-options">
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
                                        Online digital ad
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

                        </div>



                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="banner" value="banner">
                                Banner or Pop Up Display
                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="banner-size" class="control-label">Size of display needed</label>
                                <input type="text" class="form-control" name="banner-size" id="banner-size">
                            </div>
                            <div class="form-group">
                                <label for="banner-text" class="control-label">Text for banner</label>
                                <input type="text" class="form-control" name="banner-text" id="banner-text">
                            </div>
                        </div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="brochure" id="brochure">
                                Brochure
                            </label>
                        </div>
                        <div class="sub-options">
                            <?php echo $contentMessage; ?>
                        </div>



                        <div class="checkbox" >
                            <label>
                                <input type="checkbox" name="type[]" value="e-postcard" id="e-postcard">
                                E-postcard
                            </label>
                        </div>
                        <div class="sub-options">
                            <?php echo $contentMessage; ?>
                        </div>



                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="email-graphic" value="email-graphic">
                                Email graphic
                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="email-graphic-size" class="control-label">Size of email graphic</label>
                                <input type="text" class="form-control" name="email-graphic-size" id="email-graphic-size">
                            </div>
                            <div class="form-group">
                                <label for="email-graphic-type" class="control-label">File type needed</label>
                                <input type="text" class="form-control" name="email-graphic-type" id="email-graphic-type">
                            </div>
                            <div class="form-group">
                                <label for="email-graphic-text" class="control-label">Text for email graphic</label>
                                <input type="text" class="form-control" name="email-graphic-text" id="email-graphic-text">
                            </div>
                        </div>



                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="flyer" id="flyer">
                                Flyer
                            </label>
                        </div>
                        <div class="sub-options">
                            <?php echo $contentMessage; ?>
                        </div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="invitation" id="invitation">
                                Invitation Package
                            </label>
                        </div>
                        <div class="sub-options">
                            <?php echo $contentMessage; ?>
                        </div>



                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" id="led" value="led">
                                LED electronic sign (City Avenue)
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



                    </div>


                    <div class="col-md-6">



                        <div class="checkbox" style="margin-top:0">
                            <label>
                                <input type="checkbox" name="type[]" value="marketing">
                                Marketing
                            </label>
                        </div>



                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="postcard" id="postcard">
                                Postcard
                            </label>
                        </div>
                        <div class="sub-options">
                            <?php echo $contentMessage; ?>
                        </div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="program" id="program">
                                Program
                            </label>
                        </div>
                        <div class="sub-options">
                            <?php echo $contentMessage; ?>
                        </div>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="publicity" id="publicity">
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
                                    <?php echo $contentMessage; ?>
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
                                <input type="checkbox" name="type[]" id="web-graphic" value="web-graphic">
                                Web or social media graphic
                            </label>
                        </div>






                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="type[]" value="other" id="other">
                                Other
                            </label>
                        </div>
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="other-text" class="control-label">Please describe</label>
                                <input type="text" class="form-control" name="other-text" id="other-text">
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


            <legend>Proofing and Delivery</legend>


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
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>


    <!--
    <div class="col-md-3 ">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Note</h3>
            </div>
            <div class="panel-body">
                All STUDENTS, INTERNS and RESIDENTS must obtain the signature of the Dean and the Assistant Dean of Students Affairs and therefore MUST download the PDF version of this form and print it out to obtain proper signatures.
            </div>
        </div>
    </div>
    -->
</div>












<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

<script src="js/bootstrap-datepicker.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.14/jquery.scrollTo.min.js"></script>

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

            if (!$("#email-graphic-size").val()) {
                $("#email-graphic-size").closest('.form-group').addClass('has-error');
            }

            if (!$("#email-graphic-type").val()) {
                $("#email-graphic-type").closest('.form-group').addClass('has-error');
            }

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

</script>


<?php require ('includes/footer.php'); ?>
