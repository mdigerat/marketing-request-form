<?php require ('includes/header.php'); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1" style="text-align: center; margin-top:20px;">
        <h3>
            <?php if ($_GET['error'] == 'true') { ?>
            <p style="color: red">There was an error with your submission. A file may be corrupt or your files may be too big. Please contact webteam@pcom.edu for more information or try your submission again.</p>
        <?php } else { ?>
            Thank you for your submission.
        <?php } ?>
        </h3>
    </div>
</div>

<?php require ('includes/footer.php'); ?>