<?php

namespace mhunesi\formio\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "formio_submissions".
 *
 * @property int $id
 * @property int|null $form_id
 * @property array|null $data Submission Data
 * @property int|null $created_at Created Date
 * @property int|null $updated_at Updated Date
 * @property int|null $created_by Created By
 * @property int|null $updated_by Updated By
 * @property int|null $deleted Is Deleted
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Forms $form
 */
class Submissions extends BaseModel
{
    public $metadata;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formio_submissions';
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT,[$this,'createLog']);
        $this->on(self::EVENT_AFTER_INSERT,[$this,'saveReferenceModel']);
        $this->on(self::EVENT_AFTER_UPDATE,[$this,'createLog']);
        $this->on(self::EVENT_AFTER_VALIDATE,[$this,'validateFormModel']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['data','metadata'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('formio')->userModel, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('formio')->userModel, 'targetAttribute' => ['updated_by' => 'id']],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forms::className(), 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('formio', 'ID'),
            'form_id' => Yii::t('formio', 'Form'),
            'data' => Yii::t('formio', 'Submission Data'),
            'created_at' => Yii::t('formio', 'Created Date'),
            'updated_at' => Yii::t('formio', 'Updated Date'),
            'created_by' => Yii::t('formio', 'Created By'),
            'updated_by' => Yii::t('formio', 'Updated By'),
            'deleted' => Yii::t('formio', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Yii::$app->getModule('formio')->userModel, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Yii::$app->getModule('formio')->userModel, ['id' => 'updated_by']);
    }

    /**
     * Create Log Attribute
     */
    public function createLog()
    {
        Yii::info([
            'form_id' => $this->form_id,
            'metadata' =>  $this->metadata,
            'data' => $this->data,
            'old_data' => $this->oldAttributes['data'] ?? null
        ],$this->isNewRecord ? 'formio-submission-insert' : 'formio-submission-update');
    }

    /**
     *
     */
    public function validateFormModel()
    {
        if($this->form && $this->form->model){
            /** @var ActiveRecord $model */
            $model = new $this->form->model();

            if(!($model->load($this->data,'') && $model->validate())){
                $this->addError('data',$model->errors);
            }
        }
    }

    public function saveReferenceModel()
    {
        if($this->form && $this->form->model){
            /** @var ActiveRecord $model */
            $model = new $this->form->model();

            $model->load($this->data,'') && $model->save();
        }
    }

    /**
     * Gets query for [[Form]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Forms::className(), ['id' => 'form_id']);
    }

    /**
     * {@inheritdoc}
     * @return \mhunesi\formio\models\query\SubmissionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \mhunesi\formio\models\query\SubmissionsQuery(get_called_class());
    }
}
