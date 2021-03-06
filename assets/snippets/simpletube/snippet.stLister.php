<?php
/**
 * stLister
 * 
 * DocLister wrapper for SimpleTube table
 *
 * @category    snippet
 * @version     0.10
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties 
 * @internal    @modx_category Content
 * @author      Pathologic (m@xim.name)
 */

include_once(MODX_BASE_PATH . 'assets/lib/APIHelpers.class.php');

$prepare = \APIhelpers::getkey($modx->event->params, 'BeforePrepare', '');
$prepare = explode(",", $prepare);
$prepare[] = 'DLstLister::prepare';
$prepare[] = \APIhelpers::getkey($modx->event->params, 'AfterPrepare', '');
$modx->event->params['prepare'] = trim(implode(",", $prepare), ',');

$params = array_merge(array(
    "controller"    =>  "onetable",
    "config"        =>  "stLister:assets/snippets/simpletube/config/"
), $modx->event->params, array(
    'depth' => '0',
    'showParent' => '-1'
));

if(!class_exists("DLstLister", false)){
    class DLstLister{
        public static function prepare(array $data = array(), DocumentParser $modx, $_DL, prepare_DL_Extender $_extDocLister){
            $imageField = $_DL->getCfgDef('imageField');
            $thumbOptions = $_DL->getCfgDef('thumbOptions');
            $thumbSnippet = $_DL->getCfgDef('thumbSnippet');
            if(!empty($thumbOptions) && !empty($thumbSnippet)){
                $data['thumb.'.$imageField] = $modx->runSnippet($thumbSnippet, array(
                    'input' => $data[$imageField],
                    'options' => $thumbOptions
                ));
            }
            return $data;            
        }
    }
}
return $modx->runSnippet('DocLister', $params);
?>