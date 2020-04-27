<?php

namespace mhunesi\formio\models;

use mhunesi\formio\widgets\FormioWidget;
use Yii;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "formio_forms".
 *
 * @property int $id
 * @property int|null $status Status
 * @property int|null $type
 * @property string|null $name Name
 * @property string|null $token Token
 * @property string|null $model Model Class Name
 * @property string|null $data Form Data
 * @property int|null $created_at Created Date
 * @property int|null $updated_at Updated Date
 * @property int|null $created_by Created By
 * @property int|null $updated_by Updated By
 * @property int|null $deleted Is Deleted
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Submissions[] $submissions
 */
class Forms extends BaseModel
{
    public $type;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUS = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active'
    ];

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT,[$this,'generateToken']);
        $this->on(self::EVENT_BEFORE_INSERT,[$this,'jsonField']);
        $this->on(self::EVENT_BEFORE_UPDATE,[$this,'jsonField']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formio_forms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['data'], 'safe'],
            [['token'], 'unique'],
            [['model'], 'validateClass', 'params' => ['extends' => BaseActiveRecord::className()]],
            [['status','data','name'], 'required'],
            [['name', 'token', 'model'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('formio')->userModel, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('formio')->userModel, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('formio', 'ID'),
            'type' => Yii::t('formio', 'Form Type'),
            'status' => Yii::t('formio', 'Status'),
            'name' => Yii::t('formio', 'Form Name'),
            'token' => Yii::t('formio', 'Token'),
            'model' => Yii::t('formio', 'Model Class Name'),
            'data' => Yii::t('formio', 'Form Data'),
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
     * Gets query for [[Submissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubmissions()
    {
        return $this->hasMany(Submissions::className(), ['form_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \mhunesi\formio\models\query\FormsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \mhunesi\formio\models\query\FormsQuery(get_called_class());
    }

    public function validateClass($attribute, $params)
    {
        $class = $this->$attribute;
        try {
            if (class_exists($class)) {
                if (isset($params['extends'])) {
                    if (ltrim($class, '\\') !== ltrim($params['extends'], '\\') && !is_subclass_of($class, $params['extends'])) {
                        $this->addError($attribute, "'$class' must extend from {$params['extends']} or its child class.");
                    }
                }
            } else {
                $this->addError($attribute, "Class '$class' does not exist or has syntax error.");
            }
        } catch (\Exception $e) {
            $this->addError($attribute, "Class '$class' does not exist or has syntax error.");
        }
    }

    public function render($options = [])
    {
        echo FormioWidget::widget(ArrayHelper::merge([
            'query' => $this->data,
            'action' => \yii\helpers\Url::to(['/formio/submissions/create','id' => $this->id]),
            'clientOptions' => [
                'readOnly' => false,
                'noAlerts' => true,
            ]
        ],$options));
    }

    protected function generateToken()
    {
        $this->token = md5(uniqid('', true));
    }

    public function jsonField()
    {
        if(!is_array($this->data)){
            try{
                $this->data = Json::decode($this->data);
            }catch (\JsonException $e){
                $this->addError('data',$e->getMessage());
            }
        }
    }
}
