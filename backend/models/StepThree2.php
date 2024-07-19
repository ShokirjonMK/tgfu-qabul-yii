<?php

namespace backend\models;

use common\models\AuthAssignment;
use common\models\Direction;
use common\models\DirectionCourse;
use common\models\DirectionForm;
use common\models\DirectionLanguage;
use common\models\DirectionSubject;
use common\models\EduYear;
use common\models\EduYearForm;
use common\models\EduYearType;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Filial;
use common\models\Languages;
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
class StepThree2 extends Model
{
    public $language_id;
    public $edu_year_form_id;
    public $direction_id;
    public $direction_course_id;
    public $edu_name;
    public $edu_direction;
    public $filial_id;

    public function rules()
    {
        return [
            [['language_id', 'edu_year_form_id', 'direction_id', 'direction_course_id' , 'edu_name' , 'edu_direction' , 'filial_id'], 'required'],
            [['language_id', 'edu_year_form_id', 'direction_id', 'direction_course_id' , 'filial_id'], 'integer'],
            [['language_id', 'edu_year_form_id', 'direction_id', 'edu_name' , 'edu_direction'], 'string' , 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['edu_year_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearForm::class, 'targetAttribute' => ['edu_year_form_id' => 'id']],
            [['direction_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => DirectionCourse::class, 'targetAttribute' => ['direction_course_id' => 'id']],
            [['filial_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filial::class, 'targetAttribute' => ['filial_id' => 'id']],
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

        $direction = Direction::findOne([
            'id' => (int)$this->direction_id,
            'edu_year_type_id' => $student->edu_year_type_id,
            'edu_year_form_id' => (int)$this->edu_year_form_id,
            'language_id' => (int)$this->language_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if (!$direction) {
            $errors[] = ['Yo\'nalish noto\'g\'ri tanlandi.'];
        } else {
            $student->direction_course_id = (int)$this->direction_course_id;
            $student->course_id = $student->directionCourse->course_id;
            $student->edu_name = $this->edu_name;
            $student->edu_direction = $this->edu_direction;
            $student->filial_id = $this->filial_id;
            if ($direction->id != $student->direction_id) {

                Exam::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamSubject::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamStudentQuestions::updateAll(['status' => 0 , 'is_deleted' => 2] , ['user_id' => $student->user_id]);
                StudentOferta::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentPerevot::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentDtm::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentMagistr::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);

                $student->direction_id = (int)$this->direction_id;
                $student->edu_year_form_id = (int)$this->edu_year_form_id;
                $student->edu_form_id = $student->eduYearForm->edu_form_id;
                $student->language_id = (int)$this->language_id;

                $directionCourse = DirectionCourse::findOne([
                    'id' => $student->direction_course_id,
                    'direction_id' => $student->direction_id,
                    'status' => 1,
                    'is_deleted' => 0
                ]);
                if (!$directionCourse) {
                    $errors[] = ['Boshqich ma\'lumoti noto\'g\'ri yuborildi.'];
                } else {
                    if ($direction->oferta == 1) {
                        $oferta = new StudentOferta();
                        $oferta->user_id = $user->id;
                        $oferta->student_id = $student->id;
                        $oferta->direction_id = $student->direction_id;
                        $oferta->save(false);
                    }
                    if ($student->edu_type_id == 2) {
                        $perevot = new StudentPerevot();
                        $perevot->user_id = $user->id;
                        $perevot->student_id = $student->id;
                        $perevot->direction_id = $student->direction_id;
                        $perevot->direction_course_id = $student->direction_course_id;
                        $perevot->course_id = $student->course_id;
                        $perevot->edu_name = $student->edu_name;
                        $perevot->edu_direction = $student->edu_direction;
                        $perevot->save(false);
                    } else {
                        $errors[] = ['Xatolik!!!'];
                    }
                }
            } else {
                $perevotGet = StudentPerevot::findOne([
                    'student_id' => $student->id,
                    'direction_id' => $student->direction_id,
                    'status' => 1,
                    'is_deleted' => 0
                ]);
                if ($perevotGet) {
                    $perevotGet->direction_course_id = $student->direction_course_id;
                    $perevotGet->course_id = $student->course_id;
                    $perevotGet->edu_name = $student->edu_name;
                    $perevotGet->edu_direction = $student->edu_direction;
                    $perevotGet->save(false);
                }
            }

            $student->save(false);
            $user->step = 5;
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
