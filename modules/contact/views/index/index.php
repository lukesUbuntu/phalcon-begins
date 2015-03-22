<h1><?php echo $t->_('contact'); ?></h1>

<p><?php echo $t->_('index_hello_X', array('name' => 'User')); ?></p>

<?php echo $t->_('contact_from'); ?>: <input type="text">

<br><br>

<?php echo $this->tag->linkTo('contact/index/page2', 'Link contact page 2.'); ?><br>
<?php echo $this->tag->linkTo('not-found-page', 'Link to not found page.'); ?><br>
<?php echo $this->tag->linkTo('contact/index/not-found-action', 'Link to not found action on this controller.'); ?><br>