<?php

preg_match_all('/<([a-zA-Z0-9]+)[^>]*>(.*?)<\/\1>/s', $content, $matches);

$tags = $matches[0];

$totalTags = count($tags);

$firstGroup = array_slice($tags, 0, ceil($totalTags / 2));
$secondGroup = array_slice($tags, ceil($totalTags / 2));

?>



    <div class="row g-sm-5">
        <div class="col-sm-6">
            <?php foreach ($firstGroup as $tag): ?>
                <?= $tag ?>
            <?php endforeach ?>
        </div>
        <div class="col-sm-6">
            <?php foreach ($secondGroup as $tag): ?>
                <?= $tag ?>
            <?php endforeach ?>
        </div>
    </div>