<?php

use common\models\CrmPush;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CrmPushSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Crm Pushes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-push-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'student_id',
            'type',
            'lead_id',
            'lead_status',
            'status',
            [
                'attribute' => 'data_save_time',
                'contentOptions' => ['date-label' => 'data_save_time'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->push_time != null) {
                        return date("Y-m-d H:i:s" , $model->data_save_time);
                    }
                    return null;
                },
            ],
            [
                'attribute' => 'push_time',
                'contentOptions' => ['date-label' => 'push_time'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->push_time != null) {
                        return date("Y-m-d H:i:s" , $model->push_time);
                    }
                    return null;
                },
            ],
        ],
    ]); ?>


</div>
