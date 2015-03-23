<h1><?php echo $t->_('contact'); ?></h1>

<p><?php echo $t->_('index_hello_X', array('name' => 'User')); ?></p>

<?php echo $t->_('contact_from'); ?>: <input type="text">

<p>This contact/index page use php template.</p>

<?php echo $this->tag->linkTo('contact/index/page2', 'Link contact page 2.'); ?><br><br>
<?php echo $this->tag->linkTo('not-found-page', 'Link to not found module.'); ?><br>
<?php echo $this->tag->linkTo('contact/not-found-controller', 'Link to not found controller in this module.'); ?><br>
<?php echo $this->tag->linkTo('contact/not-found-controller/not-found-action', 'Link to not found controller and action in this module.'); ?><br>
<?php echo $this->tag->linkTo('contact/index/not-found-action', 'Link to not found action on this controller.'); ?><br>