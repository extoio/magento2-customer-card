#Exto CustomerCard
##Overview
![Overview](http://i.imgur.com/Ksjb5fz.gif)

##How to extend by custom data
*Vendor\Module\Model\Card\DataProvider\CustomDataProvider.php*
```php
namespace Vendor\Module\Model\Card\CustomDataProvider;

use Exto\CustomerCard\Model\Card\DataProviderInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Custom data provider.
 */
class CustomDataProvider implements DataProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getData(CustomerInterface $customer)
    {
        return [
            'custom' => [
                'group_id' => $customer->getGroupId()
            ]
        ];
    }
}
```

*adminhtml/di.xml*
```xml
<type name="Exto\CustomerCard\Model\Card\DataProviderInterface">
    <arguments>
        <argument name="providers" xsi:type="array">
            <item name="my-custom-provider" xsi:type="object">Vendor\Module\Model\Card\DataProvider\CustomDataProvider\Proxy</item>
        </argument>
    </arguments>
</type>
```

*view/adminhtml/layout/customer_card.xml*
```xml
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <reference name="customer.card">
            <arguments>
                <argument name="jsLayout" xsi:type="array">
                    <item name="components" xsi:type="array">
                        <item name="customer-card-modal" xsi:type="array">
                            <item name="children" xsi:type="array">
                                <item name="card" xsi:type="array">
                                    <item name="tabs" xsi:type="array">
                                        <item name="10" xsi:type="array">
                                            <item name="code" xsi:type="string">my-custom-tab</item>
                                            <item name="title" translate="true" xsi:type="string">Summary</item>
                                        </item>
                                    </item>
                                    <item name="children" xsi:type="array">
                                        <!-- Cards -->
                                        <item name="my-custom-data" xsi:type="array">
                                            <item name="component" xsi:type="string">Exto_CustomerCard/js/card/data</item>
                                            <item name="template" xsi:type="string">Vendor_Module/card/data/custom</item>
                                            <item name="card" xsi:type="string">customer-card-modal.card</item>
                                            <item name="displayArea" xsi:type="string">my-custom-tab</item>
                                        </item>
                                    </item>
                                </item>
                            </item>
                        </item>
                    </item>
                </argument>
            </arguments>
        </reference>
    </body>
</page>
```

*view/adminhtml/web/template/card/data/custom.html*

```html
<div class="customer-card-modal-item-inner-box">
    <span data-bind="i18n: 'Customer Group Id:'"></span>
    <span data-bind="text: getCardData('data.custom.group_id')"></span>
</div>
```
