
<?php 
use kartik\form\ActiveForm;


?>
    <button type="button" class="type-4-btn" data-bs-toggle="modal" data-bs-target="#leave-opinion-ModalCenter">
            <span>
              Donate Now
            </span></button>
            
            <div class="leave-opinion-modal modal rating-form-section fade show" id="leave-opinion-ModalCenter" tabindex="-1" aria-labelledby="leave-opinion-ModalCenterTitle" aria-modal="true" role="dialog" > 
          <div class="modal-dialog   modal-dialog-centered modal-dialog-scrollable">
          
          <?php $form = \kartik\form\ActiveForm::begin([
                                //'action' => ['site/news'],
                                'id' => 'contact-form',
                                'method' => 'post',
                                'options' => [
                                    'class' => 'contact-us-form ',
                                ],
                                //'enableAjaxValidation' => true,
                                //'enableClientValidation' => true,
                            ]);
                            ?>

          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="Dontaion-reminder-ModalCenterTitle"> <?= Yii::t('site', 'LEAVE_US_YOUR_OPINION') ?> </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?= Yii::t('site', 'LEAVE_US_YOUR_OPINION_BRIEF') ?></p>
                  <div>
                      <h4><?= Yii::t('site', 'HOW_WOULD_YOU_RATE_THE_EASE_OF_USING') ?></h4>
                      <div class="payment-method-box">
                      <?php foreach($model->getQuestionOneList() as $key=> $item) : ?>

                        <div>
                            <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="RatingWebform[question_1_id]"
                            value="<?= $key ?>"
                          />
                        </div>
                        <?php endforeach; ?>

                    </div>
                  </div>  
                  <div>
                      <h4> <?= Yii::t('site', 'DID_YOU_ENCOUNTER_ANY_ISSUES') ?> </h4>
                      <div class="payment-method-box">
                      <?php foreach($model->getQuestionTwoList() as $key=> $item) : ?>

                      <div>
                          <label for=""> <?= $item ?> </label>
                        <input
                          type="radio"
                          name="RatingWebform[question_2_id]"
                          value="<?= $key ?>"
                        />
                      </div>
                    <?php endforeach; ?>

                    </div>
                  </div>  
                  <div>
                      <h4> <?= Yii::t('site', 'DID_YOU_ENCOUNTER_ANY_ISSUES_TEXT') ?> </h4>
                      <div class="">

                      <div>
                    
                          <?= $form->field($model, 'question_2_text')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "QUESTION_TWO_TEXT")])->label(); ?>

                      </div>

                    </div>
                  </div>  
                  <div>
                      <h4><?= Yii::t('site', 'HOW_SATISFIED_ARE_YOU') ?></h4>
                      <div class="payment-method-box">
                      <?php foreach($model->getQuestionThreeList() as $key=> $item) : ?>

                        <div>
                            <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="RatingWebform[question_3_id]"
                            value="<?= $key ?>"
                          />
                        </div>
                      <?php endforeach; ?>

                    
                    </div>
                  </div>  

                  <div>
                      <h4> <?= Yii::t('site', 'DID_YOU_ENCOUNTER_ANY_ISSUES_TEXT_FOUR') ?> </h4>
                      <div class="">

                      <div>
                    
                          <?= $form->field($model, 'question_4_text')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "QUESTION_FOUR_TEXT")])->label(); ?>

                      </div>

                    </div>
                  </div> 
        
                  <div>
                  <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS') ?></h4>
                      <div class="payment-method-box">
 
                      <?php foreach($model->getQuestionFiveList() as $key=> $item) : ?>

                        <div>
                            <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="RatingWebform[question_5_id]"
                            value="<?= $key ?>"
                          />
                        </div>
                      <?php endforeach; ?>
                    
                    </div>
                  </div>  
        
                  <div>
                  <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS_2') ?></h4>
                      <div class="payment-method-box">
 
                      <?php foreach($model->getQuestionSixList() as $key=> $item) : ?>

                        <div>
                            <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="RatingWebform[question_6_id]"
                            value="<?= $key ?>"
                          />
                        </div>
                      <?php endforeach; ?>
                    
                    </div>
                  </div>  
        
                  <div>
                  <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS_22') ?></h4>
                      <div class="payment-method-box">
 
                      <?php foreach($model->getQuestionSevenList() as $key=> $item) : ?>

                        <div>
                            <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="RatingWebform[question_7_id]"
                            value="<?= $key ?>"
                          />
                        </div>
                      <?php endforeach; ?>
                    
                    </div>
                  </div>  
        
                  <div>
                  <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS_22_TEXT_AREA') ?></h4>
                      <div class="">
 

                        <div>
                            <?= $form->field($model, 'question_8_text')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                        </div>
                    
                    </div>
                  </div>  
            
            </div>
            <div class="modal-footer justify-content-center">
              <button type="submit" class="ecard-modal-btn type-3-btn">
                <span>
                <?= Yii::t('site', 'SUBMIT') ?>
                  
                </span>
              </button>
            </div>
          </div>
          <?php \kartik\form\ActiveForm::end(); ?>

        </div>
      </div>
