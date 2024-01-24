<?php
/**
 * @var $model \app\models\User
 */

/**
 * @var \app\core\View $this 
 */
$this->title = "Contact Us";

use app\core\form\InputField;
use app\core\form\Form;
use app\core\form\TextAreaField;

?>

<h1>Contact us</h1>

<?php $form = Form::begin('', "post");
echo $form->field($model, 'email', InputField::TYPE_EMAIL);
echo $form->field($model, 'subject', InputField::TYPE_TEXT);
echo $form->field($model, 'body', TextAreaField::TYPE_TEXTAREA);
echo $form->field($model, 'checkbox', InputField::TYPE_CHECKBOX);
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>