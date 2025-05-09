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

namespace Goivvyllc\CSS\Plugin;

use Magento\Framework\View\Page\Config;
use Goivvyllc\CSS\Helper\Data;

class PageConfigPlugin
{
    private $_helper;
     
    public function __construct(Data $helper)
    {
      $this->_helper = $helper;  
    }    
    
    public function aroundAddPageAsset(Config $subject
                                     , callable $proceed
                                     , string $file
                                     , array $properties = []
                                     , string|null $name = null) :Config
    {
      $cut = $this->_helper->shouldDisplay();
      if(!$cut || 
         ($cut && strpos($file,'.css') === FALSE)) $proceed($file,$properties,$name);  
      return $subject;
    }
}
