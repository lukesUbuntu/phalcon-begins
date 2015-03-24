<h1>Test cache.</h1>
<p>Test Phalcon's cache functions.</p>

<hr>
<?php if (isset($content) && $content != null) { ?> 
<p>This content is just generated and cached.</p>
<p><strong><?php echo $content; ?></strong></p>
<p>
    Please reload the page to see cached content.
</p>
<?php } elseif (isset($cached_content) && $cached_content != null) { ?> 
<p>This content was cached.</p>
<p><strong><?php echo $cached_content; ?></strong></p>
<p><?php echo $this->tag->linkTo('index/testCache/remove', 'Remove cache'); ?></p>
<?php } elseif (isset($cache_remove) && $cache_remove === true) { ?>
<p>Cache was removed.</p>
<?php } ?> 

<hr>
<p>This page use PHP template.</p>