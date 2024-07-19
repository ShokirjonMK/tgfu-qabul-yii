<?php

namespace frontend\models;

use common\models\AuthAssignment;
use common\models\EduYear;
use common\models\EduYearType;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Message;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentMagistr;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\httpclient\Client;

/**
 * Signup form
 */
class StepSecond extends Model
{
    public $check;

    public function rules()
    {
        return [
            [['check'], 'safe'],
        ];
    }

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
            foreach ($lev1 as $key => $error) {
                $result[] = $error;
            }
        }
        return array_unique($result);
    }

    public function ikStep($user, $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$this->validate()) {
            $errors[] = $this->simple_errors($this->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        $activeYear = EduYear::findOne([
            'status' => 1,
            'is_deleted' => 0
        ]);
        $eduYearType = EduYearType::findOne([
            'edu_year_id' => $activeYear->id,
            'id' => $this->check,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if (!$eduYearType) {
            $errors[] = ['Qabul turi noto\'g\'ri tanlandi.'];
        } else {
            if ($student->edu_year_type_id != $eduYearType->id) {

                Exam::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamSubject::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamStudentQuestions::updateAll(['status' => 0 , 'is_deleted' => 2] , ['user_id' => $student->user_id]);
                StudentOferta::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentPerevot::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentDtm::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentMagistr::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);

                $student->edu_year_type_id = $eduYearType->id;
                $student->edu_type_id = $eduYearType->eduType->id;
                $student->direction_id = null;
                $student->language_id = null;
                $student->edu_year_form_id = null;
                $student->edu_form_id = null;
                $student->direction_course_id = null;
                $student->course_id = null;
                $student->exam_type = null;
                $student->edu_name = null;
                $student->edu_direction = null;
                $student->save(false);
            }
            $user->step = 3;
            $user->save(false);
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }
        $transaction->rollBack();
        return ['is_ok' => false, 'errors' => $errors];
    }

}
