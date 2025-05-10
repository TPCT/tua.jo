<?php

use frontend\assets\SlickAsset;
use frontend\assets\WowAsset;
use common\helpers\Utility;
use yii\helpers\Url;

$this->title = Yii::t('site', 'HOME_PAGE');
$this->registerCssFile("/theme/css/ecard-step-1.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/donate-gift-step-1.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

SlickAsset::register($this);
WowAsset::register($this);

$lng = Yii::$app->language;  

?>
    <section class="ecard-main">
        <div class=" container d-flex flex-column align-items-start justify-content-start">
          <div class="container breadcrumb-without-header-section d-flex align-items-center justify-content-between">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active"><a href="#">Donate Your Gift</a></li>
                </ol>
              </nav>
          </div>
    <div class=" ecard-main-container">
        <div class="ecard-header">
            <div class="ecard-header-item e-card-passed-step">
                <div class="ecard-main-icon">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1707_29752)">
                        <path d="M21.4888 3.59599C20.8081 2.9144 19.7028 2.91483 19.0212 3.59599L7.91531 14.7023L2.97922 9.76627C2.29763 9.08468 1.19278 9.08468 0.511193 9.76627C-0.170398 10.4479 -0.170398 11.5527 0.511193 12.2343L6.68104 18.4041C7.02162 18.7447 7.46821 18.9154 7.91484 18.9154C8.36147 18.9154 8.80849 18.7452 9.14907 18.4041L21.4888 6.06398C22.1704 5.38286 22.1704 4.27754 21.4888 3.59599Z" />
                        </g>
                        <defs>
                        <clipPath id="clip0_1707_29752">
                        <rect width="22" height="22" />
                        </clipPath>
                        </defs>
                        </svg>    
                </div>
                <div class="ecard-header-item-content">
                    <h5>Step 1 (Amount)</h5>
                    <p>Select a Card</p>
                </div>
            </div>
            <div class="ecard-header-item e-card-passed-step">
                <div class="ecard-main-icon">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1707_29752)">
                        <path d="M21.4888 3.59599C20.8081 2.9144 19.7028 2.91483 19.0212 3.59599L7.91531 14.7023L2.97922 9.76627C2.29763 9.08468 1.19278 9.08468 0.511193 9.76627C-0.170398 10.4479 -0.170398 11.5527 0.511193 12.2343L6.68104 18.4041C7.02162 18.7447 7.46821 18.9154 7.91484 18.9154C8.36147 18.9154 8.80849 18.7452 9.14907 18.4041L21.4888 6.06398C22.1704 5.38286 22.1704 4.27754 21.4888 3.59599Z" />
                        </g>
                        <defs>
                        <clipPath id="clip0_1707_29752">
                        <rect width="22" height="22" />
                        </clipPath>
                        </defs>
                        </svg>        
                </div>
                <div class="ecard-header-item-content">
                    <h5>Step 2</h5>
                    <p>Required Information</p>
                </div>
            </div>
            <div class="ecard-header-item e-card-recent-step">
                <div class="ecard-main-icon">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g  >
                        <path d="M22.75 4.46875H3.25C2.71128 4.46875 2.19462 4.68276 1.81369 5.06369C1.43276 5.44462 1.21875 5.96128 1.21875 6.5V19.5C1.21875 20.0387 1.43276 20.5554 1.81369 20.9363C2.19462 21.3172 2.71128 21.5312 3.25 21.5312H22.75C23.2887 21.5312 23.8054 21.3172 24.1863 20.9363C24.5672 20.5554 24.7812 20.0387 24.7812 19.5V6.5C24.7812 5.96128 24.5672 5.44462 24.1863 5.06369C23.8054 4.68276 23.2887 4.46875 22.75 4.46875ZM22.3438 6.90625V8.9375H3.65625V6.90625H22.3438ZM3.65625 19.0938V11.375H22.3438V19.0938H3.65625ZM21.125 16.6562C21.125 16.9795 20.9966 17.2895 20.768 17.518C20.5395 17.7466 20.2295 17.875 19.9062 17.875H16.6562C16.333 17.875 16.023 17.7466 15.7945 17.518C15.5659 17.2895 15.4375 16.9795 15.4375 16.6562C15.4375 16.333 15.5659 16.023 15.7945 15.7945C16.023 15.5659 16.333 15.4375 16.6562 15.4375H19.9062C20.2295 15.4375 20.5395 15.5659 20.768 15.7945C20.9966 16.023 21.125 16.333 21.125 16.6562ZM14.2188 16.6562C14.2188 16.9795 14.0903 17.2895 13.8618 17.518C13.6332 17.7466 13.3232 17.875 13 17.875H11.7812C11.458 17.875 11.148 17.7466 10.9195 17.518C10.6909 17.2895 10.5625 16.9795 10.5625 16.6562C10.5625 16.333 10.6909 16.023 10.9195 15.7945C11.148 15.5659 11.458 15.4375 11.7812 15.4375H13C13.3232 15.4375 13.6332 15.5659 13.8618 15.7945C14.0903 16.023 14.2188 16.333 14.2188 16.6562Z"/>
                        </g>
                    </svg>                            
                </div>
                <div class="ecard-header-item-content">
                    <h5>Step 3</h5>
                    <p>Payment</p>
                </div>
            </div>
        </div>
        <div class="payment-method">
            <h3>Choose the payment method</h3>
            <div class="payment-method-box">
                <div>
                    <label for="">Visa/Mastercard</label>
                  <input type="radio" name="payment" value="visa-mastercard"> 
                </div>
                <div>
                    <label for="">PayPal</label>
                  <input type="radio" name="payment" value="paypal"> 
                </div>
                <div>
                    <label for="">EfaWateercom</label>
                  <input type="radio" name="payment" value="efawateercom">
                </div>
                <div>
                    <label for="">EfaWateercom</label>
                  <input type="radio" name="payment" value="efawateercom">
                </div>
            </div>
        </div>
        <div class="ecard-step-content">
          <h4>Pay with Visa / Mastercard</h4>
          <form action="">
            <div class="d-flex flex-column w-100  align-items-start justify-content-start">
              <div class="row w-100 px-0 g-4 pt-3 pb-5">
                
                <div class=" col-lg-6 col-12 d-flex flex-column gap-3">
                  <label for="name">Cardholder Name <span class="red-astrik">*</span> </label>
                  <input type="text" name="name" id="name" placeholder=" Full name ">
                </div>
                <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <label for="card-number">Card Number<span class="red-astrik">*</span> </label>
                  <input type="text" name="card-number" id="card-number" placeholder=" **** **** **** **** ">
                </div>
                <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <label for="date">Expiry date<span class="red-astrik">*</span> </label>
                  <input type="text" name="date" id="date" placeholder=" 00/00 ">
                </div>
                <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <label for="cvv">CVV<span class="red-astrik">*</span> </label>
                  <input type="text" name="cvv" id="cvv" placeholder=" CVV ">
                </div>
                
              </div>
            </div>
          <button type="button" class="type-4-btn" data-bs-toggle="modal" data-bs-target="#leave-opinion-ModalCenter">
            <span>
              Donate Now
            </span></button>
        </form>
        </div>
    </div>
    </div>
    </section>
    <!-- modal  -->
    <div class="leave-opinion-modal modal fade" id="leave-opinion-ModalCenter" tabindex="-1" aria-labelledby="leave-opinion-ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog   modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="Dontaion-reminder-ModalCenterTitle">Leave us your opinion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>We deeply appreciate your support and trust in Tkiyet Um Ali's programs. Your feedback is
                    invaluable in helping us continuously improve our website. This survey  will  take  no  more
                    than two minutes of your time.</p>
                  <div>
                      <h4>1- How would you rate the ease of using the website for donating?</h4>
                      <div class="payment-method-box">
                        <div>
                            <label for="">Very easy</label>
                          <input type="radio" name="payment" value="visa-mastercard"> 
                        </div>
                        <div>
                            <label for="">Easy</label>
                          <input type="radio" name="payment" value="paypal"> 
                        </div>
                        <div>
                            <label for="">Neutral</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                        <div>
                            <label for="">Difficult</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                        <div>
                            <label for="">Very difficult</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                    
                    </div>
                  </div>  
                  <div>
                      <h4>2- Did you encounter any issues during the donation process?</h4>
                      <div class="payment-method-box">
                        <div>
                            <label for="">No, the process was smooth</label>
                          <input type="radio" name="payment" value="visa-mastercard"> 
                        </div>
                        <div>
                            <label for="">Yes, I faced challenge</label>
                          <input type="radio" name="payment" value="paypal"> 
                        </div>                    
                    </div>
                  </div>  
                  <div>
                      <h4>3- How satisfied are you with the information provided on the website
                        about our programs and donation options?</h4>
                      <div class="payment-method-box">
                        <div>
                            <label for="">Very Satisfied</label>
                          <input type="radio" name="payment" value="visa-mastercard"> 
                        </div>
                        <div>
                            <label for="">Satisfied</label>
                          <input type="radio" name="payment" value="paypal"> 
                        </div>
                        <div>
                            <label for="">Neutral</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                        <div>
                            <label for="">Unsatisfied</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                        <div>
                            <label for="">Very Unsatisfied</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                    
                    </div>
                  </div>  
                  <div>
                      <h4>4- Do you have any suggestions for improving the website or enhancing</h4>
                      <div class="payment-method-box">
                        <div>
                            <label for="">Very easy</label>
                          <input type="radio" name="payment" value="visa-mastercard"> 
                        </div>
                        <div>
                            <label for="">Easy</label>
                          <input type="radio" name="payment" value="paypal"> 
                        </div>
                        <div>
                            <label for="">Neutral</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                        <div>
                            <label for="">Difficult</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                        <div>
                            <label for="">Very difficult</label>
                          <input type="radio" name="payment" value="efawateercom">
                        </div>
                    
                    </div>
                  </div>  
            
            </div>
            <div class="modal-footer justify-content-center">
              <button type="button" class="ecard-modal-btn type-3-btn">
                <span>
                  Submit
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>