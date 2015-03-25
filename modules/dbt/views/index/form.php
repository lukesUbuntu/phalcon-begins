<h1>Add/Edit data.</h1>

<div class="form-result-placeholder">
    <?php if (isset($err_msg)) {echo $err_msg;} ?> 
</div>

<?php 
echo $this->tag->form(); 
echo $form->render('csrf', array('value' => $this->security->getToken(), 'data-token-name' => $this->security->getTokenKey()));
?> 
ID: <?php 
echo $form->render('id');
if (isset($id)) {echo $id;} 
?><br>
Name: <?php echo $form->render('name', array('maxlength' => 50)); ?><br>
Address: <?php echo $form->render("address", array('maxlength' => 255)) ?><br>
<button type="submit">Save</button>
<?php echo $this->tag->endForm(); ?> 
