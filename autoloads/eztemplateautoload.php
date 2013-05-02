<?php

// Operator autoloading
$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'extension/wrapoperator/autoloads/WrapOperator.php',
                                    'class' => 'WrapOperator',
                                    'operator_names' => array( 'wrap_php_func', 'wrap_user_func' ) );

?>