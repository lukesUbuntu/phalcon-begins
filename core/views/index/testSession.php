<h1>Test session</h1>

<p>Choose action:</p>
<p>
    <?php echo $this->tag->linkTo('index/testSession/set', 'set session info'); ?> 
    || 
    <?php echo $this->tag->linkTo('index/testSession/get', 'get session info'); ?> 
    || 
    <?php echo $this->tag->linkTo('index/testSession/remove', 'remove session info'); ?> 
    || 
    <?php echo $this->tag->linkTo('index/testSession/destroy', 'destroy session info'); ?> 
</p>

<p>
    <?php if (isset($action) && $action == 'set') { ?> 
    You have been set the session.
    <?php } elseif (isset($action) && $action == 'get') { ?> 
    You got the session.
    <br>
    <?php
    if (isset($session_datetime)) {
        echo $session_datetime."<br>\n";
    }
    if (isset($session_test)) {
        echo $session_test."<br>\n";
    }
    ?> 
    <?php } elseif (isset($action) && $action == 'remove') { ?> 
    You have been removed the session.
    <?php } elseif (isset($action) && $action == 'destroy') { ?> 
    You have been destroyed the session.
    <?php } ?> 
</p>