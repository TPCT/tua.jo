<?php


$this->registerCssFile("/theme/css/child-donation.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = Yii::t('site', 'CHILD_DONATION_TITLE');
$this->description = Yii::t('site', 'CHILD_DONATION_DESCRIPTION');

$lng = Yii::$app->language;
?>

<?= \frontend\widgets\breadcrumbs\BreadCrumbs::widget([]) ?>

    <section class="child-donation">
        <form action="<?=Url::to(['/cart/add'])?>" method="POST">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                   value="<?= Yii::$app->request->csrfToken ?>"/>
            <input type="hidden" name="items[0][type]" value="1"/>
            <input type="hidden" name="items[0][donation]"
                   value="<?= \common\components\TuaClient::PUBLIC_DONATIONS_TYPE_ID ?>"/>
            <input type="hidden" name="items[0][campaign]"
                   value=""/>
            <input type="hidden" name="items[0][guid]" value="<?= uniqid('cart-item-') ?>"/>
            <input type="hidden" name="items[0][recurrence]" value="once" id="payment-recurrence-type"/>
            <input type="hidden" name="items[0][quantity]" value="1"/>
            <input type="hidden" name="items[0][currency]" value="jod"/>
            <input type="hidden" name="items[0][amount]" class="amount"/>
            <input type="hidden" name="items[0][receipt]" value="<?=\common\components\TuaClient::CHILD_GIFTS_RECEIPT_TYPE?>" />

            <div class="container child-dontaion-container ">
                <div class="child-dontaion-container-wrapper">
                    <div class="center-child">
                        <picture>
                            <img src="/theme/assets/Images/New-pages/child.svg" alt="Child" class="child-image l-screen">
                        </picture>
                        <picture>
                            <img src="/theme/assets/Images/New-pages/child.png" alt="Child" class="child-image sm-screen">
                        </picture>
                    </div>
                    <div class="item clothes inactive">
                        <div>
                            <button type="button" class="minus">-</button>
                            <picture>
                                <img src="/theme/assets/Images/New-pages/shirt 1.png" alt="Clothes">
                            </picture>
                            <button type="button" class="plus">+</button>
                        </div>
                        <h4><?=Yii::t('site', 'Clothes')?></h4>
                        <div class="quantity-price-box">
                            <h4>1 <?=Yii::t('site', 'JOD')?> X 0</h4>
                        </div>
                    </div>
                    <div class="item toys inactive">
                        <div>
                            <button type="button" class="minus">-</button>
                            <img src="/theme/assets/Images/New-pages/toys.png" alt="Toys">
                            <button type="button" class="plus">+</button>
                        </div>
                        <h4><?=Yii::t('site', 'Toys')?></h4>
                        <div class="quantity-price-box">
                            <h4>1 <?=Yii::t('site', 'JOD')?> X 0</h4>
                        </div>
                    </div>
                    <div class="item school-books inactive">
                        <div>
                            <button type="button" class="minus">-</button>
                            <img src="/theme/assets/Images/New-pages/books.png" alt="School Books">
                            <button type="button" class="plus">+</button>
                        </div>
                        <h4><?=Yii::t('site', 'School Books')?></h4>
                        <div class="quantity-price-box">
                            <h4>1 <?=Yii::t('site', 'JOD')?> X 0</h4>
                        </div>
                    </div>
                    <div class="item school-bag inactive">
                        <div>
                            <button type="button" class="minus">-</button>
                            <img src="/theme/assets/Images/New-pages/bag.png" alt="School Bag">
                            <button type="button" class="plus">+</button>
                        </div>
                        <h4><?=Yii::t('site', 'School Bag')?></h4>
                        <div class="quantity-price-box">
                            <h4>1 <?=Yii::t('site', 'JOD')?> X 0</h4>
                        </div>
                    </div>
                    <div class="item food-parcel inactive">
                        <div>
                            <button type="button" class="minus">-</button>
                            <img src="/theme/assets/Images/New-pages/carton.png" alt="Food Parcel">
                            <button type="button" class="plus">+</button>
                        </div>
                        <h4><?=Yii::t('site', 'Food Parcel')?></h4>
                        <div class="quantity-price-box">
                            <h4>1 <?=Yii::t('site', 'JOD')?> X 0</h4>
                        </div>
                    </div>
                    <div class="item medical-assistance inactive">
                        <div>
                            <button type="button" class="minus">-</button>
                            <img src="/theme/assets/Images/New-pages/heart_shaped_stethoscope_listening_to_heart 1.png" alt="Medical Assistance">
                            <button type="button" class="plus">+</button>
                        </div>
                        <h4><?=Yii::t('site', 'Medical Assistance')?></h4>
                        <div class="quantity-price-box">
                            <h4>1 <?=Yii::t('site', 'JOD')?> X 0</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container total-box-btns">
                <button type="submit" class="type-3-btn donate-now d-none">
                    <span><?=Yii::t('site', 'Donate Securely')?></span>
                </button>
                <div>
                    <h4><?=Yii::t('site', 'Total')?></h4>
                    <h2>0 <?=Yii::t('site', 'JOD')?></h2>
                </div>
                <a class="type-5-btn" href="<?=Url::to(['/site/index#homepage-donation-section'])?>">
                    <span><?=Yii::t('site', 'Keep giving')?></span>
                </a>
            </div>
        </form>
    </section>
    <audio id="child-audio" src="/theme/assets/children-joy-100078.mp3"></audio>

<?php

$this->registerJsVar('language', Yii::$app->language);
$this->registerJsVar('currency', Yii::t('site', 'JOD'));
$js = <<<JS
const items = document.querySelectorAll('.item');
  const totalElement = document.querySelector('.total-box-btns h2'); // Total box
  const totalInput = document.querySelector('.child-donation input.amount');
  const childAudio = document.getElementById('child-audio'); // Audio element
  const donationButtons = $(".child-donation .donate-now");
  // Initialize total
  let total = 0;

  // Function to update the total
  function updateTotal() {
    totalElement.textContent = total + " " + currency;
    totalInput.value = total;
    if (total > 0){
        donationButtons.removeClass('d-none');
    }else{
        donationButtons.addClass('d-none')
    }
  }

  // Add event listeners to all items
  items.forEach(item => {
    const plusButton = item.querySelector('.plus');
    const minusButton = item.querySelector('.minus');
    const quantityPriceBox = item.querySelector('.quantity-price-box h4');
    const pricePerItem = 1; // 1 JOD per item

    // Plus button click
    plusButton.addEventListener('click', function () {
      // Remove inactive class
      item.classList.remove('inactive');

      // Get the current quantity
      const quantityText = quantityPriceBox.textContent;
      const quantity = parseInt(quantityText.split('X')[1], 10);

      // Increase the quantity
      const newQuantity = quantity + 1;
      quantityPriceBox.textContent = "1 " + currency + " X " + newQuantity;

      // Update the total
      total += pricePerItem;
      updateTotal();
      childAudio.play();
    });

    // Minus button click
    minusButton.addEventListener('click', function () {
      // Get the current quantity
      const quantityText = quantityPriceBox.textContent;
      let quantity = parseInt(quantityText.split('X')[1], 10);

      // Decrease the quantity (minimum 0)
      if (quantity > 0) {
        quantity -= 1;
      quantityPriceBox.textContent = "1 " + currency + " X " + quantity;

        // Update the total
        total -= pricePerItem;
        updateTotal();

        // If quantity is 0, add inactive class back
        if (quantity === 0) {
          item.classList.add('inactive');
        }
      }
    });
  });
JS;

$this->registerJs($js);