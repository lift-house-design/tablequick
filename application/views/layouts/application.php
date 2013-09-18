<?php echo doctype('html5') ?>
<head>
	<title><?php echo $title ?></title>
	<?php echo meta(array(
		array('name'=>'Content-type','content'=>'text/html; charset=utf-8','type'=>'equiv'),
		array('name'=>'X-UA-Compatible','content'=>'IE=edge,chrome=1','type'=>'equiv'),
		array('name'=>'viewport','content'=>'width=device-width'),
		array('name'=>'title','content'=>$meta['title']),
		array('name'=>'description','content'=>$meta['description']),
		array('name'=>'copyright','content'=>$meta['copyright']),
		array('name'=>'author','content'=>'Nick Niebaum (nickniebaum@gmail.com)'),
	)) ?>
	<?php echo css($css) ?>
	<?php echo js($js) ?>
</head>
<body>
<div id="account">
	<div class="wrapper">
	<?php if($logged_in): ?>

		Welcome, <?php echo anchor('#',trim($user['first_name'].' '.$user['last_name'])) ?> |
		<?php echo anchor('dashboard','Dashboard') ?> |
		<?php echo anchor('log-out','Log Out') ?>
	<?php else: ?>
		<?php echo form_open('log-in') ?>
			<?php echo form_input(array(
				'name'=>'email',
				'id'=>'email',
				'placeholder'=>'E-mail',
				'value'=>set_value('value'),
				'class'=>'small',
			)) ?>
			<?php echo form_password(array(
				'name'=>'password',
				'id'=>'password',
				'placeholder'=>'Password',
				'class'=>'small',
			)) ?>
			<div class="buttons">
				<?php echo form_submit('login', 'Log In') ?>
				<?php echo anchor('sign-up','Sign Up') ?> |
				<?php echo anchor('forgot-password','Forgot Password?') ?>
			</div>
		<?php echo form_close() ?>
	<?php endif; ?>
	</div>
</div>
<div class="wrapper">
	<div id="contents">
		<?php if(!empty($notifications)): ?>
			<div class="notifications">
				<ul>
					<li><?php echo implode('</li><li>',$notifications) ?></li>
				</ul>
			</div>
		<?php endif; ?>
		<?php if(!empty($errors)): ?>
			<div class="errors">
				<ul><?php echo $errors ?></ul>
			</div>
		<?php endif; ?>
		<?php echo $yield ?>
	</div>
</div>
<?php if($ga_code!==false): ?>
<script>
	var _gaq=[['_setAccount','<?php echo $ga_code ?>'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src='//www.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>
</body>
</html>