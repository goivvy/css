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

namespace Goivvyllc\CSS\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;

class Data extends AbstractHelper
{
   const IS_ENABLED_PATH = 'goivvycss/general/enable';
   const CUT_HOMEPAGE = 'goivvycss/cut/homepage';
   const CUT_HOMEPAGE_FILE = 'goivvycss/cut/homepage_file';
   const CRITICAL_HOMEPAGE_FILE = 'goivvycss/cut/critical_homepage_file';
   const CUT_CATEGORY = 'goivvycss/cut/category';
   const CUT_CATEGORY_FILE = 'goivvycss/cut/category_file';
   const CRITICAL_CATEGORY_FILE = 'goivvycss/cut/critical_category_file';
   const CUT_PRODUCT = 'goivvycss/cut/product';
   const CUT_PRODUCT_FILE = 'goivvycss/cut/product_file';
   const CRITICAL_PRODUCT_FILE = 'goivvycss/cut/critical_product_file';
   const CUT_CUSTOM = 'goivvycss/cut/custom';
   const CUT_CUSTOM_URL = 'goivvycss/cut/custom_url';
   const CUT_CUSTOM_FILE = 'goivvycss/cut/custom_file';
   const CRITICAL_CUSTOM_FILE = 'goivvycss/cut/critical_custom_file';
    
   private $_scopeConfig;
   private $_storeManager;
   private $_url;
   private $_requestApp;
     
   public function __construct(ScopeConfigInterface $scopeConfig
                             , StoreManagerInterface $storeManager 
                             , UrlInterface $url 
                             , RequestInterface $request)
   {
      $this->_scopeConfig = $scopeConfig;
      $this->_storeManager = $storeManager; 
      $this->_url = $url;
      $this->_requestApp = $request;
   }
    
   private function _getStoreId() :int
   {
      return (int)$this->_storeManager->getStore()->getId(); 
   }
    
   public function isEnabled() :bool
   {  
      return $this->_scopeConfig->getValue(self::IS_ENABLED_PATH
                                        ,  ScopeInterface::SCOPE_STORE
                                        ,  $this->_getStoreId()) ? true : false; 
   }
    
   public function isHomepageEnabled() :bool
   {
       return $this->_scopeConfig->getValue(self::CUT_HOMEPAGE
                                        ,  ScopeInterface::SCOPE_STORE
                                        ,  $this->_getStoreId()) ? true : false; 
   }
    
   public function getHomepageFile(string $mode) :string
   {
       return $this->_scopeConfig->getValue(constant('self::'.strtoupper($mode).'_HOMEPAGE_FILE')
                                         ,  ScopeInterface::SCOPE_STORE
                                         ,  $this->_getStoreId()) ?: '';  
   }

   public function isCategoryEnabled() :bool
   {
       return $this->_scopeConfig->getValue(self::CUT_CATEGORY
                                        ,  ScopeInterface::SCOPE_STORE
                                        ,  $this->_getStoreId()) ? true : false; 
   }
    
   public function getCategoryFile(string $mode) :string
   {
       return $this->_scopeConfig->getValue(constant('self::'.strtoupper($mode).'_CATEGORY_FILE')
                                         ,  ScopeInterface::SCOPE_STORE
                                         ,  $this->_getStoreId()) ?: '';  
   }

   public function isProductEnabled() :bool
   {
       return $this->_scopeConfig->getValue(self::CUT_PRODUCT
                                        ,  ScopeInterface::SCOPE_STORE
                                        ,  $this->_getStoreId()) ? true : false; 
   }
    
   public function getProductFile(string $mode) :string
   {
       return $this->_scopeConfig->getValue(constant('self::'.strtoupper($mode).'_PRODUCT_FILE')
                                         ,  ScopeInterface::SCOPE_STORE
                                         ,  $this->_getStoreId()) ?: '';  
   }

   public function isCustomEnabled() :bool
   {
       return $this->_scopeConfig->getValue(self::CUT_CUSTOM
                                        ,  ScopeInterface::SCOPE_STORE
                                        ,  $this->_getStoreId()) ? true : false; 
   }
    
   public function getCustomFile(string $mode) :string
   {
       return $this->_scopeConfig->getValue(constant('self::'.strtoupper($mode).'_CUSTOM_FILE')
                                         ,  ScopeInterface::SCOPE_STORE
                                         ,  $this->_getStoreId()) ?: '';  
   }

   public function getCustomUrl() :string
   {
       return $this->_scopeConfig->getValue(self::CUT_CUSTOM_URL
                                         ,  ScopeInterface::SCOPE_STORE
                                         ,  $this->_getStoreId()) ?: '';  
   }

   public function isOnCustomUrl() :bool
   {
       return $this->_requestApp->getRequestUri() == $this->getCustomUrl() ? true : false;
   }
    
   public function isOnHomepage() :bool
   {
       return $this->_requestApp->getFullActionName() == 'cms_index_index' ? true : false; 
   }
    
   public function isOnCategory() :bool
   { 
       return $this->_requestApp->getFullActionName() == 'catalog_category_view' ? true : false;
   }
   
   public function isOnProduct() :bool
   {
       return $this->_requestApp->getFullActionName() == 'catalog_product_view' ? true : false; 
   }
    
   public function shouldDisplay() :bool
   {
      $cut = false;
      if($this->isEnabled()){
         if(!$cut && $this->isOnHomepage() && 
             $this->isHomepageEnabled() ) $cut = true;

         if(!$cut &&  $this->isOnProduct() && 
             $this->isProductEnabled() ) $cut = true;

         if(!$cut && $this->isOnCategory() && 
             $this->isCategoryEnabled() ) $cut = true;

         if(!$cut && $this->isOnCustomUrl() && 
             $this->isCustomEnabled() ) $cut = true;
      }
      return $cut;
   }
}
