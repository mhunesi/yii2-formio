<?php

namespace mhunesi\formio\models\query;

/**
 * This is the ActiveQuery class for [[\mhunesi\formio\models\Forms]].
 *
 * @see \mhunesi\formio\models\Forms
 */
class FormsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    public function notDeleted()
    {
        return $this->andWhere('[[deleted]]=0');
    }

    public function token($token)
    {
        return $this->active()->notDeleted()->andWhere(['token' => $token]);
    }

    /**
     * {@inheritdoc}
     * @return \mhunesi\formio\models\Forms[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \mhunesi\formio\models\Forms|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
