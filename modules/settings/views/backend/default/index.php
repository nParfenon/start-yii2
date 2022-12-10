<?php

use yii\helpers\Html;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="col-md-12 col-lg-8">

    <div class="box">

        <div class="box-body">

            <?= Html::beginForm('/admin/settings/default/update'); ?>

            <?php $i = 0; foreach ($data as $item): ?>

                <div class="<?= Html::encode($item['field']) ?> ">

                    <div class="form-group">

                        <?= Html::label( Html::encode($item['label'])) ?>

                        <?= Html::input('text','SettingForm['.$i.'][value]', Html::encode($item['value']),['class' => 'form-control']) ?>

                    </div>

                </div>

            <?php $i++; endforeach; ?>

            <div class="form-group">

                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

            </div>

            <?php Html::endForm(); ?>

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
