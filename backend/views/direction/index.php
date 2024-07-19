<?php

use common\models\Direction;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Languages;
use common\models\EduYearForm;
use common\models\EduYearType;
use common\models\EduYear;
use kartik\select2\Select2;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\DirectionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Yo\'nalishlar');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$eduYear = EduYear::findOne(['status' => 1, 'is_deleted' => 0]);
$eduYearTypes = EduYearType::getEduTypeName($eduYear);
$eduYearForms = EduYearForm::getEduFormName($eduYear);
?>
<div class="direction-index">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php
            foreach ($breadcrumbs['item'] as $item) {
                echo "<li class='breadcrumb-item'><a href='". Url::to($item['url']) ."'>". $item['label'] ."</a></li>";
            }
            ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <div class="mb-3 mt-4">
        <?= Html::a(Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name_uz',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->code. ' - ' .$model->name_uz;
                },
                'contentOptions' => ['class' => 'wid250'],
            ],
            'edu_duration',
            [
                'attribute' => 'contract',
                'format' => 'raw',
                'value' => function ($model) {
                    return number_format($model->contract  ,0,'.',' ');
                },
            ],
            [
                'attribute' => 'language_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->language->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'language_id',
                    ArrayHelper::map(Languages::find()->where(['status' => 1, 'is_deleted' => 0])->all(), 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Til ...']),
            ],
            [
                'attribute' => 'edu_year_type_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->eduType->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_year_type_id',
                    $eduYearTypes,
                    ['class'=>'form-control','prompt' => 'Tur ...']),
            ],
            [
                'attribute' => 'edu_year_form_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->eduForm->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_year_form_id',
                    $eduYearForms,
                    ['class'=>'form-control','prompt' => 'Shakl ...']),
            ],
            [
                'attribute' => 'status',
                'contentOptions' => ['date-label' => 'adress'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->status == 1) {
                        return "<div class='badge-table-div active'><span>Faol</span></div>";
                    } elseif ($model->status == 0) {
                        return "<div class='badge-table-div inactive'><span>No faol</span></div>";
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    Status::accessStatus(),
                    ['class'=>'form-control','prompt' => 'Status ...']),
            ],
            [
                'attribute' => '',
                'contentOptions' => ['date-label' => 'adress'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->edu_type_id == 1) {
                        return "<div class='badge-table-div active'><a href='". Url::to(['direction-subject/index' , 'id' => $model->id]) ."'><span>Fanlar</span></a></div>";
                    } elseif ($model->edu_type_id == 2) {
                        return "<div class='badge-table-div active'><a href='". Url::to(['direction-course/index' , 'id' => $model->id]) ."'><span>Kurslar</span></a></div>";
                    } else {
                        return false;
                    }
                }
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'gridActionColumn'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'view',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title'        => 'delete',
                            'class' => 'tableIcon',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
