<?php
namespace HeBoTek\suedbahnhotelWebsite\ViewHelpers;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Viewhelper\AbstractConditionViewHelper;

/**
 * ### Condition: String contains substring
 *
 * Condition ViewHelper which renders the `then` child if provided
 * string $haystack contains provided string $needle.
 */
class ContainsViewHelper extends AbstractConditionViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('haystack', 'string', 'haystack', true);
        $this->registerArgument('needle', 'string', 'need', true);
        $this->registerArgument('list', 'boolean', 'list', false);
    }

    /**
     * @param array $arguments
     * @return bool
     */
    protected static function evaluateCondition($arguments = null)
    {
        if(array_key_exists('list', $arguments) && $arguments['list'] == true) {
            $haystack = explode(",",$arguments['haystack']);
            return false !== in_array($arguments['needle'], $haystack);
        } else {
            $pos = strpos($arguments['haystack'], $arguments['needle']);
            if($pos !== false) {  
                return true;
            } else {
                return false;
            } 
        }
          
    }
}
