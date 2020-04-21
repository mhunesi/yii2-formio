<?php

namespace mhunesi\formio\models\query;

/**
 * This is the ActiveQuery class for [[\mhunesi\formio\models\Submissions]].
 *
 * @see \mhunesi\formio\models\Submissions
 */
class SubmissionsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    public function notDeleted()
    {
        return $this->andWhere('[[deleted]]=0');
    }

    /**
     * {@inheritdoc}
     * @return \mhunesi\formio\models\Submissions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \mhunesi\formio\models\Submissions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
