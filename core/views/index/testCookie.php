<h1>Test cookies</h1>

<p>Choose action:</p>
<p>
    <?php echo $this->tag->linkTo('index/testCookie/set', 'set cookie info'); ?> 
    || 
    <?php echo $this->tag->linkTo('index/testCookie/get', 'get cookie info'); ?> 
    || 
    <?php echo $this->tag->linkTo('index/testCookie/remove', 'remove cookie info'); ?> 
</p>

<?php if (isset($action) && $action == 'set') { ?> 
The cookie was set.
<?php } elseif (isset($action) && $action == 'get') { ?> 
The cookie is already got.<br>
<?php 
if (isset($datetime)) {
    echo $datetime."<br>\n";
} 
if (isset($datetime2)) {
    echo $datetime2."<br>\n";
} 
?> 
<?php } elseif (isset($action) && $action == 'remove') { ?> 
Cookie removed.
<?php } ?> 