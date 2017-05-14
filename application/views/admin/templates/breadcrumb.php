<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 24/08/2016
 * Time: 9:54 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($page_heading) && strlen($page_heading)>0): ?>
<h1><?php echo html_escape($page_heading); ?></h1>
<?php endif;
if(isset($breadcrumb)): ?>
<ol class="breadcrumb">
    <?php foreach($breadcrumb as $text=>$url):
        if(strlen($url)>0): ?>
        <li><a href="<?php echo $url; ?>"><?php echo html_escape($text); ?></a></li>
        <?php else: ?>
        <li class="active"><?php echo html_escape($text); ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ol>
<?php endif; ?>