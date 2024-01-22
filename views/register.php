<?php

use app\core\form\Field;
use app\core\form\Form;
?>

<h1>Create an account</h1>

<?php $form = Form::begin('', "post");
echo $form->field($model, 'username', Field::TYPE_TEXT, 'Username');
echo $form->field($model, 'email', Field::TYPE_EMAIL, 'Email address');
echo $form->field($model, 'password', Field::TYPE_PASSWORD, 'Password');
echo $form->field($model, 'password_repeat', Field::TYPE_PASSWORD, 'Confirm password');
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>