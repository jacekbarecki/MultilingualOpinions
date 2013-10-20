<?php

    /**
     * Script responsible for adding a user opinion via an ajax call.
     *
     * Required POST data:
     * - nick
     * - text
     * - language.
     *
     * Returned values:
     * - 1 - success,
     * - -1 - missing POST parameters,
     * - error message - when an error occurs.
     *
     * @package MultilingualOpinions
     * @version 0.1
     * @author Jacek Barecki
     */

    require_once 'lib/Opinion.php';

    if(empty($_POST['nick']) || empty($_POST['text']) || empty($_POST['language'])) {
        die('-1');
    }

    $nick = $_POST['nick'];
    $text = $_POST['text'];
    $language = $_POST['language'];


    try {
        $Opinion = new Opinion();
        $Opinion->addOpinionAndTranslate($nick, $text, $language);
    }
    catch(Exception $e) {
        die($e->getMessage());
    }

    echo '1';
