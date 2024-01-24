<?php
/**
 * @var $model \app\models\User
 */
use app\core\form\InputField;
use app\core\form\Form;
/**
 * @var \app\core\View $this 
 */
$this->title = "Custom CMV framework";
?>

<h1>Login</h1>

<?php $form = Form::begin('', "post");
echo $form->field($model, 'username', InputField::TYPE_TEXT);
echo $form->field($model, 'password', InputField::TYPE_PASSWORD);
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>