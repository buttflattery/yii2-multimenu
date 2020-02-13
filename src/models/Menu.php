<?php

namespace buttflattery\multimenu\models;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $label
 * @property string $link
 * @property int $parent_id
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['link'], 'string'],
            [['parent_id'], 'integer'],
            [['label'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'link' => 'Link',
            'parent_id' => 'Parent ID',
        ];
    }
}
