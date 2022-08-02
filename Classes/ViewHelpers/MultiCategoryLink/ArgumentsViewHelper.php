<?php
declare(strict_types=1);

namespace HeBoTek\suedbahnhotelWebsite\ViewHelpers\MultiCategoryLink;

/**
 * This file is part of the "news" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Viewhelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

use \HeBoTek\suedbahnhotelWebsite\Utility\HebotekUtility;


use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * ViewHelper to get additional params including add/remove categories from list
 *
 * # Example: Basic Example
 * # Description: Render the content of the VH as page title
 * <code>
 *    <f:link.page title="{category.item.title}" pageUid="{settings.listPid}"
 *       additionalParams="{n:multiCategoryLink.arguments(
 *          mode:'add',
 *          item:category.item.uid,
 *          list:overwriteDemand.categories)}">link
 *     </f:link.page>
 * </code>
 * <output>
 *    <title>TYPO3 is awesome</title>
 * </output>
 *
 */
class ArgumentsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     * 
     * Important: Active 'disable override demand' in news filter plugin! Otherwise the filter/viewhelper will not work!
     */
    public function initializeArguments()
    {
        $this->registerArgument('mode', 'string', 'Mode, either "add" or "remove"', true);
        $this->registerArgument('list', 'array', 'overwriteDemand list', false, '');
        $this->registerArgument('item', '\GeorgRinger\News\Domain\Model\Category', 'Category Item', true);
        $this->registerArgument('additionalParams', 'array', 'Additional params', false, []);
        $this->registerArgument('forceCatId', 'any', 'Force Always a Category ID', false, '');
        $this->registerArgument('siblings', 'any', 'Get the Parent Cateogry', false, []);
        parent::initializeArguments();
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )
    {
        if ($arguments['mode'] !== 'add' && $arguments['mode'] !== 'remove') {
            throw new Exception('Mode must be either "add" or "remove', 1522293549);
        }


        $forceId = (int) $arguments['forceCatId'];

        $allArguments = array();

        $forceCategoryId = '';
        if($forceId) {


            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
            $statement = $queryBuilder
                ->select('sys_category.uid')
                ->from('sys_category')
                ->join(
                    'sys_category',
                    'sys_category_record_mm',
                    'sys_category_record_mm',
                    $queryBuilder->expr()->eq('sys_category_record_mm.uid_local', $queryBuilder->quoteIdentifier('sys_category.uid'))
                )
                ->where(
                    $queryBuilder->expr()->eq('sys_category_record_mm.uid_foreign', $forceId)
                )
                ->setMaxResults(1)
                ->execute()
                ->fetchAll();

                if($statement && count($statement) > 0) {
                    $forceCategoryId = $statement[0]['uid'];
                }
        }


        
        $category = $arguments['item'];

        $categoryId = $category->getUid();

        $siblings = $arguments['siblings'];

        $categoryList = '';
        if($arguments['list'] && array_key_exists('categories', $arguments['list'])) {
            $categoryList = $arguments['list']['categories'];
        }
       
        $categoryListArray = [];
        if($categoryList) {
            $categoryListArray = explode(',',$categoryList);
        }

        $monthList = [];
        if($arguments['list'] && array_key_exists('month', $arguments['list'])) {
            $monthList = $arguments['list']['month'];
        }
        
        $yearList = [];
        if($arguments['list'] && array_key_exists('year', $arguments['list'])) {
            $yearList = $arguments['list']['year'];
        }

        if($forceId) {
            $categoryList .= ',' . $forceCategoryId;
        }

        if ($arguments['mode'] === 'add') {
            if (!GeneralUtility::inList($categoryList, $categoryId)) {
                foreach ($siblings as $sibling) {
                    $siblingUid = $sibling['item']->getUid();
                    if(in_array($siblingUid,$categoryListArray)) {
                        $categoryList = HebotekUtility::rmFromList($siblingUid, $categoryList);
                    }
                }

                $categoryList .= ',' . $categoryId;
            }
        } else {
            $categoryList = HebotekUtility::rmFromList($categoryId, $categoryList);
        }

        if($monthList) {
            $allArguments = [
                'tx_news_pi1' => [
                    'overwriteDemand' => [
                        'month' => $monthList,
                        'year' => $yearList
                    ]
                ]
            ];
        }

        if (!empty($categoryList)) {
            $categoryList = trim($categoryList, ',');
            $categoryArray = [
                'tx_news_pi1' => [
                    'overwriteDemand' => [
                        'categories' => $categoryList
                    ]
                ]
            ];
            ArrayUtility::mergeRecursiveWithOverrule($allArguments, $categoryArray);
        }

        return $allArguments;
    }
}