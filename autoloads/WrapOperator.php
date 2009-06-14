<?php
/*!
  \class   WrapOperator WrapOperator.php
  \ingroup eZTemplateOperators
  \brief   Wrapper to enable calling (almost) any available builtin or userdefined function directly from template
  \version 2006.11.20
  \date    2006.11.20
  \author  Zurgutt (zurgutt@gg.ee)
  \licence GPL version 2.

*/

include_once( "lib/ezutils/classes/ezini.php" );
include_once( "lib/ezutils/classes/ezdebug.php" );

class WrapOperator
{
    // Controls display of eZ publish Debug Notices and Warnings (per instance)
    var $Debug = false;

    /*!
      Constructor, does nothing by default.
    */
    function WrapOperator()
    {
    }

    /*!
    Return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'wrap_php_func', 'wrap_user_func' );
    }

    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 'wrap_php_func' => array( 'callback_function' => array( 'type' => 'string',
                                                                                   'required' => true ),
                                                     'param_array' =>       array( 'type' => 'array',
                                                                                   'required' => true ),
                                                     'return_output' =>     array( 'type' => 'boolean',
                                                                                   'default' => false,
                                                                                   'required' => false ) ),
                      'wrap_user_func' => array( 'callback_function' => array( 'type' => 'string',
                                                                                   'required' => true ),
                                                     'param_array' =>       array( 'type' => 'array',
                                                                                   'required' => true ),
                                                     'return_output' =>     array( 'type' => 'boolean',
                                                                                   'default' => false,
                                                                                   'required' => false ) )
            );
    }

    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters, $debug = true )
    {
        $this->debug = $debug;
        $callbackFunction = $namedParameters['callback_function'];
        $paramArray = $namedParameters['param_array'];
        $returnOutput = $namedParameters['return_output'];

        switch ( $operatorName )
        {
            case 'wrap_php_func':
            {
                // Check from ini if we are allowed to call given function.
                $ini = eZINI::instance('wrap_operator.ini');

                $permittedFunctionList = $ini->variable( 'PHPFunctions', 'PermittedFunctionList' );

                if ( $this->Debug == true )
                eZDebug::writeDebug( "wrap_php_func: permittedFunctionList: " . print_r($permittedFunctionList, TRUE) );

                if( !in_array($callbackFunction, $permittedFunctionList) )
                {
                    // Function is not in list of permitted functions, bail out.
                    eZDebug::writeError( "wrap_php_func: function '$callbackFunction' is not in list of permitted functions." );
                    return FALSE;
                }

                // Check if given function is indeed visible and callable for php.
                if( !is_callable($callbackFunction) )
                {
                    // Function is not callable, bail out.
                    eZDebug::writeError( "wrap_php_func: function '$callbackFunction' does not exist or is not callable." );
                    return FALSE;
                }

                // Start capturing the output of called function, to be discarded when the call returns or optionally returned.
                ob_start();

                // Execute the function call.

                if ( $this->Debug == true )
                eZDebug::writeDebug( "wrap_php_func: paramArray:" . print_r($paramArray, true));

                $operatorValue = call_user_func_array($callbackFunction, $paramArray);

                if ( $this->Debug == true )
                eZDebug::writeDebug( "wrap_php_func: function returned value:" . print_r($operatorValue, true));

                // If return_output is set to true, return the captured output from the called function instead of its return value.
                if( $returnOutput )
                {
                if ( $this->Debug == true )
                    eZDebug::writeDebug( "wrap_php_func: returning function output instead of returnvalue, which is '$operatorValue'.");
                    $operatorValue = ob_get_contents();
                }
                ob_end_clean();

                return;

            } break;
            // Same as calling system function, just include the definition file and check for permission in different ini setting.
            case 'wrap_user_func':
            {
                // Check from ini if we are allowed to call given function.
                $ini = eZINI::instance('wrap_operator.ini');

                $permittedFunctionList = $ini->variable( 'UserFunctions', 'PermittedFunctionList' );

                if ( $this->Debug == true )
                eZDebug::writeDebug( "wrap_user_func: permittedFunctionList: " . print_r($permittedFunctionList, TRUE) );

                if( !in_array($callbackFunction, $permittedFunctionList) )
                {
                    // Function is not in list of permitted functions, bail out.
                    eZDebug::writeError( "wrap_user_func: function '$callbackFunction' is not in list of permitted functions." );
                    return FALSE;
                }

                // Function is permitted, lets include the file with it.
                // For easy management user functions are in separate files named by function name.
                include_once('extension/wrap_operator/userfunctions/' . $callbackFunction . '.php');

                // Check if given function is indeed visible and callable for php.
                if( !is_callable($callbackFunction) )
                {
                    // Function is not callable, bail out.
                    eZDebug::writeError( "wrap_user_func: function '$callbackFunction' does not exist or is not callable." );
                    return FALSE;
                }

                // Start capturing the output of called function, to be discarded when the call returns or optionally returned.
                ob_start();

                // Execute the function call.
                if ( $this->Debug == true )
                eZDebug::writeDebug( "wrap_user_func: paramArray:" . print_r($paramArray, true));

                $operatorValue = call_user_func_array($callbackFunction, $paramArray);

                if ( $this->Debug == true )
                eZDebug::writeDebug( "wrap_user_func: function returned value:" . print_r($operatorValue, true));
                // If return_output is set to true, return the captured output from the called function instead of its return value.
                if( $returnOutput )
                {
                if ( $this->Debug == true )
                    eZDebug::writeDebug( "wrap_user_func: returning function output instead of returnvalue, which is '$operatorValue'.");
                    $operatorValue = ob_get_contents();
                }
                ob_end_clean();

                return;

            } break;
        }
    }
}

?>