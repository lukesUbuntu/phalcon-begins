<h1>Test database.</h1>
<p>If you did not install database, please create database and import sql file.</p>

<?php echo $this->tag->linkTo('dbt/index/add', 'Add item'); ?> 

<div class="form-result-placeholder">
    <?php if (isset($err_msg)) {echo $err_msg;} ?> 
</div>
<?php 
echo $this->tag->form(array('action' => 'dbt/index/multiple', 'class' => 'form-manage-data'))."\n";
echo $form->render('csrf', array('value' => $this->security->getToken(), 'data-token-name' => $this->security->getTokenKey()))."\n";
?> 
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($page->items) && !empty($page->items)) {
            foreach ($page->items as $item) {
        ?> 
        <tr>
            <td><?php echo $this->tag->checkField(['id[]', 'value' => $item->id]); ?></td>
            <td><?php echo $item->id; ?></td>
            <td><?php echo $item->name; ?></td>
            <td><?php echo $item->address; ?></td>
            <td><?php echo $this->tag->linkTo('dbt/index/edit/'.$item->id, 'Edit'); ?></td>
        </tr>
        <?php 
            }// endforeach;
        } else { 
        ?> 
        <tr>
            <td colspan="5">No data.</td>
        </tr>
        <?php }// endif; ?> 
    </tbody>
</table>
<button type="submit" class="delete-btn">Delete selected</button>
<br><br>
<a href="<?= $this->url->getCurrentUri(); ?>">First</a>
<a href="<?= $this->url->getCurrentUri(); ?>?page=<?= $page->before; ?>">Previous</a>
<a href="<?= $this->url->getCurrentUri(); ?>?page=<?= $page->next; ?>">Next</a>
<a href="<?= $this->url->getCurrentUri(); ?>?page=<?= $page->last; ?>">Last</a>
<?php echo 'There are total '.$page->total_items.' items.<br>'; ?> 
<?php echo "You are in page ", $page->current, " of ", $page->total_pages; ?>


<?php echo $this->tag->endForm(); ?> 

<hr>
<p>This page use PHP template.</p>