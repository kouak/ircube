<?php
echo $ircube->image($medium->webroot('filter' . DS . 's' . DS . $attachment['Attachment']['dirname'] . DS . $attachment['Attachment']['basename']), array('alt' => $attachment['Attachment']['id']));
?>