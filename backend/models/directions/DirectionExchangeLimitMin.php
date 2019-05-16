<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.10.17
 * Time: 2:06
 */

namespace backend\models\directions;


use common\models\Directions;
use yii\base\Model;

/**
 * Class DirectionExchangeLimitMin
 * @package backend\models\directions
 */
class DirectionExchangeLimitMin extends Model
{
    /**
     * @var Directions
     */
    public $model;

    public $limit;


    public function rules()
    {
        return [
            [['limit', 'model'], 'required'],
            
            [['limit'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '.', $value);
            }],
            
            [['limit'], 'number'],
        ];
    }

    public function save()
    {
        $this->model->exchange_limit_min = $this->limit;
        $this->model->save(false, ['exchange_limit_min']);
    }
}