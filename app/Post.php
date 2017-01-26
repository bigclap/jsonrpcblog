<?php
/**
 * Created by PhpStorm.
 * User: resation
 * Date: 26.01.17
 * Time: 16:20
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Post
 *
 * @property int $item_id
 * @property int $user_id
 * @property int $order_id
 * @property bool $is_development_mode
 * @property string $class
 * @property string $props_json
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereIsDevelopmentMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post wherePropsJson($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use SoftDeletes;
    public $table = 'items';
    public $primaryKey = 'item_id';
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $hidden = ['deleted_at', 'user_id', 'order_id', 'class', 'props_json', 'is_development_mode'];

    public function prepareJsonData()
    {
        $props = json_decode($this->props_json);
        $this->content = $props->content;
        $this->title = $props->title;
        return $this;
    }

}