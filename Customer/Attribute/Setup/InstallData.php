<?php


namespace Customer\Attribute\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'dba_any', [
            'type' => 'varchar',
            'label' => 'DBA (If Any)',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 161,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'dba_any')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
        

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'fax', [
            'type' => 'text',
            'label' => 'Fax',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 160,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'fax')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'admin_email', [
            'type' => 'varchar',
            'label' => 'Admin Email',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 163,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'admin_email')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
        

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sales_email', [
            'type' => 'varchar',
            'label' => 'Sales Email',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 164,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'sales_email')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'references_one', [
            'type' => 'varchar',
            'label' => 'References One',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 185,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'references_one')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phone_references_one', [
            'type' => 'varchar',
            'label' => 'Phone References One',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 186,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phone_references_one')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phone_references_two', [
            'type' => 'varchar',
            'label' => 'Phone References Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 190,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phone_references_two')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phone_references_three', [
            'type' => 'varchar',
            'label' => 'Phone References Three',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 194,
            'system' => false,
            'backend' => ''
        ]);
		
		 $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phone_references_three')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'tradefaxone', [
            'type' => 'text',
            'label' => 'Trade Fax One',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 187,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'tradefaxone')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'tradefaxtwo', [
            'type' => 'text',
            'label' => 'Trade Fax Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 191,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'tradefaxtwo')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'tradefaxthree', [
            'type' => 'text',
            'label' => 'Trade Fax Three',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 196,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'tradefaxthree')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();

        
       
			$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phone_email_one', [
            'type' => 'varchar',
            'label' => 'Phone Email One',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 188,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phone_email_one')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phone_email_two', [
            'type' => 'varchar',
            'label' => 'Phone Email Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 192,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phone_email_two')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phone_email_three', [
            'type' => 'varchar',
            'label' => 'Phone Email Three',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 195,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phone_email_three')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'references_two', [
            'type' => 'varchar',
            'label' => 'References Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 189,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'references_two')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'references_three', [
            'type' => 'varchar',
            'label' => 'References Three',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 193,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'references_three')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bank_name', [
            'type' => 'varchar',
            'label' => 'Bank Name',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 197,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'bank_name')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'address', [
            'type' => 'varchar',
            'label' => 'Address',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 198,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'address')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'acct_number', [
            'type' => 'int',
            'label' => 'Acct Number',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 199,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'acct_number')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phoneinfo', [
            'type' => 'int',
            'label' => 'Phone',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 200,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phoneinfo')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
			$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'faxinfo', [
            'type' => 'int',
            'label' => 'Fax _Bank',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 201,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'faxinfo')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		

		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'name_one', [
            'type' => 'varchar',
            'label' => 'Name One',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 173,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'name_one')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'position', [
            'type' => 'varchar',
            'label' => 'Position',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 174,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'position')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'address_ph', [
            'type' => 'varchar',
            'label' => 'Address / PH',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 175,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'address_ph')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'address_ph_two', [
            'type' => 'varchar',
            'label' => 'Address / PH Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 178,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'address_ph_two')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'position_two', [
            'type' => 'varchar',
            'label' => 'Position Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 177,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'position_two')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'name_two', [
            'type' => 'varchar',
            'label' => 'Name Two',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 176,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'name_two')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'credit_card', [
            'type' => 'varchar',
            'label' => 'Credit_Card',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 179,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'credit_card')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'expiry_date', [
            'type' => 'datetime',
            'label' => 'Expiry Date',
            'input' => 'date',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 180,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'expiry_date')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'cardholder', [
            'type' => 'varchar',
            'label' => 'Cardholder',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 181,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'cardholder')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'signature', [
            'type' => 'varchar',
            'label' => 'Signature',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 182,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'signature')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'date', [
            'type' => 'datetime',
            'label' => 'Date',
            'input' => 'date',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 183,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'date')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'datetwo', [
            'type' => 'datetime',
            'label' => 'Datetwo',
            'input' => 'date',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 204,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'datetwo')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'requested_limit', [
            'type' => 'varchar',
            'label' => 'Requested Limit',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 184,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'requested_limit')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'account_card', [
            'type' => 'varchar',
            'label' => 'Mega Account#',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 333,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'account_card')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'account_card1', [
            'type' => 'varchar',
            'label' => 'Cantrex Account#',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 333,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'account_card1')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'in_business', [
            'type' => 'varchar',
            'label' => 'In Business (YRS) ',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 165,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'in_business')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'present_location', [
            'type' => 'varchar',
            'label' => 'At Present Location (YRS) ',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 166,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'present_location')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'length_lease', [
            'type' => 'varchar',
            'label' => 'Length Of Lease (YRS)',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 168,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'length_lease')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'lease_expiry', [
            'type' => 'datetime',
            'label' => 'Lease Expiry',
            'input' => 'date',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 169,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'lease_expiry')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'landlord_name', [
            'type' => 'varchar',
            'label' => 'Landlord Name',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 170,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'landlord_name')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'product_line', [
            'type' => 'varchar',
            'label' => 'Specify Product Line',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 202,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'product_line')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'phonelist', [
            'type' => 'varchar',
            'label' => 'Phone Listing',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 171,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'phonelist')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'print_name', [
            'type' => 'varchar',
            'label' => 'Print Name',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 203,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'print_name')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
				
		$customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'epra', [
            'type' => 'varchar',
            'label' => 'EPRA No.',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 172,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'epra')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(Customer::ENTITY,'corporation_proproetorship',
                [
                    'type' => 'int',
                    'label' => 'Corporation Or Proproetorship',
                    'input' => 'select',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
                    'required' => false,
                    'default' => '0',
                    'sort_order' => 162,
                    'system' => false,
                    'position' => 162,
                    'adminhtml_only' => 1,
                    'option' =>
                        array (
                            'values' =>
                                array (
                                    0 => 'Corporation',
                                    1 => 'Proproetorship',
                                ),
                        ),
                ]
            );
            $myAttribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'corporation_proproetorship');
            // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
            $myAttribute->setData(
                'used_in_forms', ['adminhtml_customer', 'customer_account_create','wholesale_account_create', 'customer_account_edit']);
            $myAttribute->save();

            $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'customer_code_for_erp', [
            'type' => 'varchar',
            'label' => 'Customer Code For ERP',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 173,
            'system' => false,
            'backend' => ''
        ]);

        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'customer_code_for_erp')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
		
		$customerSetup->addAttribute(Customer::ENTITY,'rented_owned',
                [
                    'type' => 'int',
                    'label' => 'Rented Or Owned',
                    'input' => 'select',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
                    'required' => false,
                    'default' => '0',
                    'sort_order' => 167,
                    'system' => false,
                    'position' => 167,
                    'adminhtml_only' => 1,
                    'option' =>
                        array (
                            'values' =>
                                array (
                                    0 => 'Rented',
                                    1 => 'Owned',
                                ),
                        ),
                ]
            );
            $myAttribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'rented_owned');
            // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
            $myAttribute->setData(
                'used_in_forms', ['adminhtml_customer', 'customer_account_create','wholesale_account_create', 'customer_account_edit']);
            $myAttribute->save();

            $customerSetup->addAttribute(Customer::ENTITY,'credit_type',
                [
                    'type' => 'int',
                    'label' => 'Credit Type requested',
                    'input' => 'select',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
                    'required' => false,
                    'default' => '0',
                    'sort_order' => 400,
                    'system' => false,
                    'position' => 400,
                    'adminhtml_only' => 1,
                    'option' =>
                        array (
                            'values' =>
                                array (
                                    0 => 'Credit Card',
                                    1 => 'Open terms',
                                    2 => 'Mega / NBA',
                                    3 => 'Cantrex',
                                ),
                        ),
                ]
            );
            $myAttribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'credit_type');
            // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
            $myAttribute->setData(
                'used_in_forms', ['adminhtml_customer', 'customer_account_create','wholesale_account_create', 'customer_account_edit']);
            $myAttribute->save();   
		
    }
}
