

<?php
    $objectFit = $item->object_fit?: 'contain';
    $css = <<<CSS
        .object-image-from-cms-$item->id{
            object-fit: $objectFit !important;
            object-position: $item->object_position !important;
        }
    CSS;
    $this->registerCss($css);
?>