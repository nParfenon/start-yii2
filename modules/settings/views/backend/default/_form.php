<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

extract($model);

?>

<div class="col-md-12 col-lg-8">

    <div class="box">

        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <div class="<?= Html::encode($name['field']) ?> ">

                <div class="form-group">
                    <?= Html::label( Html::encode($name['label'])) ?>
                    <?= Html::input('text',Html::encode($name['field'])."[value]", Html::encode($name['value']),['class' => 'form-control']) ?>
                </div>

            </div>

            <div class="<?= Html::encode($description['field']) ?> ">

                <div class="form-group">
                    <?= Html::label( Html::encode($description['label'])) ?>
                    <?= Html::textarea(Html::encode($description['field'])."[value]", Html::encode($description['value']),['class' => 'form-control']) ?>
                </div>

            </div>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>

<div class="col-md-12 col-lg-4">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Информация</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div class="box-body">
            <div>
                <b>Техническое обслуживание:</b><br>
                включить - <code>php yii maintenance/enable</code><br>
                отключить - <code>php yii maintenance/disable</code>
            </div>

        </div>
    </div>

</div>



