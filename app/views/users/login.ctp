<h2><?php __("Login"); ?></h2>
<p class='info'><?php __("You can log into the Grid here. If you do not have an account, you can register one by clicking on the Register button below."); ?></p>
<?php
	echo $session->flash('auth');
	echo $form->create('User', array('action' => 'login'));
	echo $form->input('username', array('div' => false, "label" => "Username: "))."&nbsp;".$form->input('password', array('div' => false, "label" => "Password: "));
	?><br /><button class='button navy medium' type='submit'><?php __('Login'); ?></button><?php
	echo $html->link(__("Register", true), "/users/register", array("class" => "button blue medium"));
	echo $form->end();
?>