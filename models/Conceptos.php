<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ISAL_Conceptos".
 *
 * @property integer $id_concepto
 * @property string $descripcion
 * @property integer $activo
 *
 * @property ISALCuentasBancarias[] $iSALCuentasBancarias
 */
class Conceptos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ISAL_Conceptos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion','letra'], 'required'],
            [['descripcion','letra','texto'], 'string'],
            [['activo'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_concepto' => 'Id',
            'descripcion' => 'Asunto',
            'letra' => 'Tipo',
            'texto' => 'Cuerpo',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentasBancarias()
    {
        return $this->hasMany(CuentasBancarias::className(), ['id_concepto' => 'id_concepto']);
    }
}
