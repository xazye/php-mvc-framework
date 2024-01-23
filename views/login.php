<?php
/**
 * @var $model \app\models\User
 */
use app\core\form\Field;
use app\core\form\Form;
?>

<h1>Login</h1>

<?php $form = Form::begin('', "post");
echo $form->field($model, 'username', Field::TYPE_TEXT);
echo $form->field($model, 'password', Field::TYPE_PASSWORD);
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>