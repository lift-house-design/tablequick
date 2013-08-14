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
</head>
<body>
<div id="account">
	<div class="wrapper">
	<?php if($logged_in): ?>
		<?php if($this->uri->rsegment(1) != 'dashboard'): ?>
			<?php echo anchor('dashboard','Go to Dashboard',array('class'=>'float-left')) ?>
		<?php endif; ?>

		Welcome, <?php echo anchor('#',trim($user['first_name'].' '.$user['last_name'])) ?> |
		<?php echo anchor('dashboard','Dashboard') ?> |
		<?php echo anchor('log-out','Log Out') ?>
	<?php else: ?>
		<?php echo form_open('log-in') ?>
			<?php echo form_input(array(
				'name'=>'email',
				'id'=>'email',
				'placeholder'=>'E-mail',
				'valie'=>set_value('value'),
			)) ?>
			<?php echo form_password(array(
				'name'=>'password',
				'id'=>'password',
				'placeholder'=>'Password',
			)) ?>
			<?php echo form_submit('login', 'Log In') ?>
		<?php echo form_close() ?>
	<?php endif; ?>
	</div>
</div>
<div class="wrapper">
	<header>
		<?php echo anchor(($logged_in && $this->uri->rsegment(1)!='dashboard' ? 'dashboard' : '/'),'TableQuick') ?>
	</header>
	<div id="contents">
		<?php echo $yield ?>
	</div>
</div>
<?php echo js($js) ?>
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