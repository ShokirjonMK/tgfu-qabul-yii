<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use common\models\Student;

/** @var $model */
/** @var Student $student */
/** @var $id */

$model->birthday = $student->birthday;
$model->seria = $student->passport_serial;
$model->number = $student->passport_number;
?>


<div class="step_one_box">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'top40'],
        'fieldConfig' => [
            'template' => '{label}{input}{error}',
        ]
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => Yii::t("app" , "a53")],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label(Yii::t("app" , "a49").' <span>*</span>'); ?>
    </div>

    <div class="form-group mt-4">
        <?= $form->field($model, 'seria')->textInput([
            'maxlength' => true,
            'placeholder' => '__',
            'oninput' => "this.value = this.value.replace(/\\d/, '').toUpperCase()"
        ])->label(Yii::t("app" , "a50").' <span>*</span>') ?>
    </div>

    <div class="form-group mt-4">
        <?= $form->field($model, 'number')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '9999999',
            'options' => [
                'placeholder' => '_______',
            ],
        ])->label(Yii::t("app" , "a51").' <span>*</span>') ?>
    </div>

    <div class="step_btn_block top40">
        <?= Html::submitButton(Yii::t("app" , "a52"), ['class' => 'step_right_btn step_btn', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>




