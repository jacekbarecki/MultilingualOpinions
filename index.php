<?php
    /**
     * Multilingual opinions index page
     *
     * A sample site for gathering user opinions and displaying
     * them in different languages, basing on the translations provided
     * by the Google Translate API.
     *
     * @package MultilingualOpinions
     * @version 0.1
     * @author Jacek Barecki
     */
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow" />
<head>
    <title>Opinions</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

</head>
<body>
<div class="container" id="content">
    <h1>Opinions</h1>

    <h4>Add your opinion!</h4>
    <div class="well addOpinion">
        <form class="form-horizontal addOpinionForm" role="form" type="post">
        <input type="hidden" name="language" id="inputLanguage" value="en">
            <div class="form-group">
                <label for="inputName" class="col-lg-2 control-label">Your name</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="inputName" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="inputText" class="col-lg-2 control-label">Your opinion</label>
                <div class="col-lg-3">
                    <textarea class="form-control" id="inputText" required="required" rows="5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-3">
                    <button type="submit" data-loading-text="Please wait..." class="btn btn-primary submitButton">Submit</button>
                </div>
            </div>
        </form>
    </div>


    <h4>What the others are saying:</h4>

</div>
<div class="container" id="footer">
    <div class="alert alert-info">
        THIS SERVICE MAY CONTAIN TRANSLATIONS POWERED BY GOOGLE. GOOGLE DISCLAIMS ALL WARRANTIES RELATED TO THE TRANSLATIONS, EXPRESS OR IMPLIED, INCLUDING ANY WARRANTIES OF ACCURACY, RELIABILITY, AND ANY IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    </div>
</div>
</body>
</html>
