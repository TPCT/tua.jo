<div class="currency-selector-wrapper">
  <a class="currency-selector" id="currency-selector">
    <span class="icon-container"></span>
    <div>
      <span class="selected-coin"><?=$selected_currency->title?></span>
      <i class="fa-solid fa-chevron-down"></i>
    </div>
  </a>

  <!-- Dropdown Menu -->
  <ul class="currency-dropdown" id="currency-dropdown">
    <?php foreach($currencies as $currency) : ?>
      <li> <a href="<?=\yii\helpers\Url::to(['/account/settings/currency-switch/', 'slug' => $currency->slug])?>"> <?=$currency->title?> </a> </li>
    <?php endforeach; ?>
  </ul>
</div>
