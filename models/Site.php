<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Usuario;

/**
 * This is the model class for table "is_accion".
 *
 * @property integer $id_accion
 * @property string $descripcion
 * @property boolean $activo
 *
 * @property IsRolAccion[] $isRolAccions
 * @property IsRol[] $idRols
 */
class Site extends model
{
    public $fecha_desde;
    public $fecha_hasta;
    public $asunto;
    public $letra;
    public $CodVend;

    public function rules()
    {
        return [
            [['fecha_desde', 'fecha_hasta','letra'], 'required'],
            [['fecha_desde','fecha_hasta','CodVend', 'letra'], 'string', 'max' => 12],
            [['asunto'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
            'CodVend' => 'Ubicación',
            'asunto' => 'Asunto del correo',
            'letra' => 'Tipo',
        ];
    }
}
