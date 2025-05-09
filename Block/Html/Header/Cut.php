<?php
/**
 * This source file is subject to the GNU General Public License (GNU version 3)
 * It is available through the world-wide-web at this URL:
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@goivvy.com so we can send you a copy immediately.
 *
 * @component  Goivvyllc_CSS
 * @copyright  Copyright (c) 2025 GOIVVY LLC (https://www.goivvy.com)
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License version 3
 * @author     Goivvy.com <sales@goivvy.com>
 */
declare(strict_types=1);

namespace Goivvyllc\CSS\Block\Html\Header;

use Goivvyllc\CSS\Helper\Data;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\Module\Dir;

class Cut implements ArgumentInterface
{
   private $_helper;
   private $_asset;
   private $_module;
    
   public function __construct(Data $helper
                              ,Repository $asset
                              ,Dir $module){
     $this->_helper = $helper;  
     $this->_asset = $asset;
     $this->_module = $module;
   }
    
    
   public function getCutCSS(string $mode) :string
   {
     try{

       $content = '';
       $filePath = '';
       $cut = false;

       if($this->_helper->isEnabled()){
         if(!$cut && $this->_helper->isOnHomepage() && 
             $this->_helper->isHomepageEnabled() && 
             $this->_helper->getHomepageFile($mode) ) {
              $cut = true;
              $filePath = $this->_helper->getHomepageFile($mode);
         }

         if(!$cut &&  $this->_helper->isOnProduct() && 
             $this->_helper->isProductEnabled() && 
             $this->_helper->getProductFile($mode)) {
               $cut = true;
               $filePath = $this->_helper->getProductFile($mode);
         }

         if(!$cut && $this->_helper->isOnCategory() && 
             $this->_helper->isCategoryEnabled() &&
             $this->_helper->getCategoryFile($mode)) {
                $cut = true;
                $filePath = $this->_helper->getCategoryFile($mode);
         }

         if(!$cut && $this->_helper->isOnCustomUrl() && 
             $this->_helper->isCustomEnabled() &&
             $this->_helper->getCustomFile($mode) ) {
                 $cut = true;
                 $filePath = $this->_helper->getCustomFile($mode);
         }
        
         if($cut && $filePath){
            file_put_contents(BP.'/var/log/cc.log',$this->_module->getDir('Goivvyllc_CSS',Dir::MODULE_VIEW_DIR).'/frontend/web/'.$filePath."\n",(FILE_APPEND | LOCK_EX));
            $content = file_get_contents($this->_module->getDir('Goivvyllc_CSS',Dir::MODULE_VIEW_DIR).'/frontend/web/'.$filePath);
         }
      }
       
     }catch(LocalizedException | NotFoundException $e){
       $content = ''; 
     }       
     
     return $content;
   }
}
