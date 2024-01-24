<?php
/**
 * @var $model \app\models\User
 */
use app\core\form\InputField;
use app\core\form\Form;

/**
 * @var \app\core\View $this 
 */
$this->title = "Register";
?>

<h1>Create an account</h1>

<?php $form = Form::begin('', "post");
echo $form->field($model, 'username', InputField::TYPE_TEXT);
echo $form->field($model, 'email', InputField::TYPE_EMAIL);
echo $form->field($model, 'password', InputField::TYPE_PASSWORD);
echo $form->field($model, 'password_repeat', InputField::TYPE_PASSWORD);
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>