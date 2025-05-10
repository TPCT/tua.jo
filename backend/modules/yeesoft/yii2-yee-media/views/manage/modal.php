<div role="media-modal" class="modal" tabindex="-1" style="z-index:9999999"
     data-frame-id="<?= $frameId ?>"
     data-frame-src="<?= $frameSrc ?>"
     data-btn-id="<?= $btnId ?>"
     data-input-id="<?= $inputId ?>"
     data-image-container="<?= isset($imageContainer) ? $imageContainer : '' ?>"
     data-paste-data="<?= isset($pasteData) ? $pasteData : '' ?>"
     data-thumb="<?= $thumb ?>"
     data-multiple ="<?= isset($is_multiple)? $is_multiple:'0' ?>" >
    <div class="modal-dialog modal-xl modal-lg <?= isset($is_multiple)? $is_multiple:'single' ?>">
        <div class="modal-content">
            <div class="modal-body"></div> 
        </div>
    </div>
</div>