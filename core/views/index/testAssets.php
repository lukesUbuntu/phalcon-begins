<h1>Test assets</h1>
<p>Please view the source code.</p>
<?php
if ($this->assets->collection('header')->count()) {
    $this->assets->outputCss('header');
}

$this->assets->outputJs('footer');
?>
<p>This page use PHP template.</p>