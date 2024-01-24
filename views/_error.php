<?php 
/**
 * @var $exception \Exception
 */
/**
 * @var \app\core\View $this 
 */
$this->title = $exception->getCode();
?>
<h1><?= $exception->getCode() ?></h1>
<h2><?= $exception->getMessage(); ?></h2>