<?php

    /**
     * Script responsible for getting the opinions list via an ajax call.
     *
     * Returns HTML code containing the opinions.
     *
     * @package MultilingualOpinions
     * @version 0.1
     * @author Jacek Barecki
     */

    require_once 'lib/Opinion.php';
    $Opinion = new Opinion();
    $opinions = $Opinion->getAll();

    if(!empty($opinions)) :
        foreach($opinions as $value) : ?>
            <div class="panel panel-default opinionPanel" data-id="<?php echo $value['id']; ?>">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span style="font-weight: bold"><?php echo $value['nick']; ?> </span>
                        <span class="pull-right"><?php echo $value['created']; ?></span>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="pull-right opinionMachine" data-id="<?php echo $value['id']; ?>" style="display: none"><a href="http://translate.google.com/"><img src="img/google.PNG"></a></div>
                    <?php for($i=0; $i<count($value['translations']);$i++) : ?>
                        <div class="opinionText"
                             data-id="<?php echo $value['id']; ?>"
                             data-language="<?php echo $value['translations'][$i]['language']; ?>"
                             <?php echo $value['translations'][$i]['machine'] ? ' lang="' . $value['translations'][$i]['language'] . '-x-mtfrom-' . $value['source_language'] . '" ' : ''; ?>
                             <?php echo $i > 0 ? ' style="display:none" ' : ''; ?>>
                            <?php echo nl2br($value['translations'][$i]['text']); ?>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="panel-footer">
                    <div class="btn-group" data-toggle="buttons">
            <?php for($i=0; $i<count($value['translations']);$i++) : ?>
                            <label class="btn btn-primary <?php echo $i == 0 ? ' active' : ''; ?>">
                                <input type="radio"
                                       class="opinionRadio"
                                       name="opinionRadio<?php echo $value['id'];?>"
                                       data-id="<?php echo $value['id']; ?>"
                                       data-language="<?php echo $value['translations'][$i]['language']; ?>"
                                       data-machine="<?php echo $value['translations'][$i]['machine']; ?>"
                                        <?php echo $i == 0 ? ' checked="checked" ' : ''; ?>>
                                <?php echo $value['translations'][$i]['language']; ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>


        <?php endforeach; ?>
    <?php endif; ?>