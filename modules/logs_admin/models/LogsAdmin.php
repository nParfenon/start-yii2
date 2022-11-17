<?php

namespace app\modules\logs_admin\models;

use Yii;
use app\models\CustomModel;
use app\modules\user\models\User;
use yii\helpers\Json;

/**
 * This is the model class for table "logs_admin".
 *
 * @property int $id
 * @property int $user_id
 * @property string $place
 * @property int $action
 * @property string|null $details
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class LogsAdmin extends CustomModel
{

    const _CREATE = 1;
    const _UPDATE = 2;
    const _DELETE = 3;

    const _ACTIONS = [
        self::_CREATE => 'Создание',
        self::_UPDATE => 'Обновление',
        self::_DELETE => 'Удаление',
    ];

    public $date_from;
    public $date_to;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%logs_admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $array = [
            [['user_id', 'action'], 'required'],
            [['user_id', 'action'], 'integer'],
            [['details'], 'string'],
            ['place', 'string', 'max' => 255]
        ];

        return array_merge(parent::rules(), $array);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $array = [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'place' => 'Место',
            'action' => 'Действие',
            'details' => 'Подробности',
        ];

        return array_merge(parent::attributeLabels(), $array);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function saveLog(object $event) : bool
    {
        $_this = $event->data['this'];

        $ignoreAttributeLog = $_this->ignoreAttributeLog();

        $attributes = $this->sortField($ignoreAttributeLog, $_this->attributes);

        if (isset($event->data['insert'])) {

            if ($event->data['insert']){

                $action = self::_CREATE;

                $details = $attributes;

            }else{

                $oldAttributes = $this->sortField($ignoreAttributeLog, $event->data['changedAttributes']);

                if (!$oldAttributes){
                    return true;
                }

                $details['id'] = $attributes['id'];

                foreach ($oldAttributes as $item => $value) {

                    if ($value != $attributes[$item]){
                        $details[$item][$value] = $attributes[$item];
                    }

                }

                if (count($details) <= 1){
                    return true;
                }

                $action = self::_UPDATE;
            }

        }else{

            $action = self::_DELETE;

            $details = $attributes;
        }

        $details = Json::encode($details);

        $place = basename(str_replace('\\', '/', $_this::className()));

        return $this->tryLog($place, $action, $details);
    }

    private function tryLog(string $place, int $action, string $details) : bool
    {
        $model = new self();
        $model->user_id = Yii::$app->user->id;
        $model->place = $place;
        $model->action = $action;
        $model->details = $details;

        if ($model->validate() && $model->save()){
            return true;
        }

        return false;
    }

    public static function decodeDetails(string $details) : string
    {
        $details = Json::decode($details);

        $result = '';

        foreach ($details as $item => $value){

            if (!is_array($value)){

                $result .= '<b>'. $item .': </b> ' .$value. '<br>';

            }else{

                $ak = array_keys($value);

                $old = $ak[0] ? $ak[0] : "<i>(empty)</i>";

                $new = $value[$ak[0]] ? $value[$ak[0]] : "<i>(empty)</i>";

                $result .='<b>'. $item .':</b> '. $old .' --> '. $new .'<br>';

            }

        }

        return $result;
    }

    private function sortField(array $ignored, array $attributes) : array
    {
        foreach ($ignored as $item) {
            unset($attributes[$item]);
        }

        return $attributes;
    }

}
