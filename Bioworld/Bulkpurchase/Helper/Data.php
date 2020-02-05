<?php
namespace Bioworld\Bulkpurchase\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
	/**
     * @var \Magento\Framework\App\Http\Context
     */
    private $httpContext;
 
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Http\Context $httpContext
    ) 
    {
        parent::__construct($context);
        $this->httpContext = $httpContext;
    }

    public function getSizeAttributes()
    {
    	$sizes = array(
    				//'XS'	=>	'Extra Small',
    				'S'		=>	'Small',
    				'M'		=>	'Medium',
    				'L'		=>	'Large',
    				'XL'	=>	'Extra Large',
    				'XXL'	=>	'Double Extra Large',
    				'XXXL'	=>	'Triple Extra Large',
    				//'XXXXL'	=>	'Four Extra Large',
    			);
    	
    	return $sizes;
    }

    public function getSizeAttributesArray()
    {
        $sizes = array(
                    array('label'=>'Small'),
                    array('label'=>'Medium'),
                    array('label'=>'Large'),
                    array('label'=>'Extra Large'),
                    array('label'=>'Double Extra Large'),
                    array('label'=>'Triple Extra Large'),
                    //array('label'=>'Four Extra Large'),

                );
        
        return $sizes;
    }

    public function getShortCode($size)
    {
        $sizes_array = $this->getSizeAttributes();

        $result = array_search($size, $sizes_array);

        return $result;
    }

    
}

?>