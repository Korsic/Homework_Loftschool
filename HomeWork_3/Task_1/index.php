<?php
/*
HomeWork: 3
Task: 1
Author: Korsic
 */

/*Написать скрипт, который выведет всю информацию из этого файла в удобно читаемом виде. Результат вашего скрипта будет распечатан и выдан курьеру для доставки.
 */

$xml = simplexml_load_file('data.xml');


echo "Order number: " . $xml[PurchaseOrderNumber] . "<br />";
echo "Order date: " . $xml[OrderDate] . "<br /><br />";

foreach ($xml->Address as $info) {
    echo "Client who: " . $info[Type] . "<br />";
    echo "Name: " . $info->Name . "<br />";
    echo "Address<br />";
    echo "Street: " . $info->Street . "<br />";
    echo "City: " . $info->City . "<br />";
    echo "State: " . $info->State . "<br />";
    echo "Zip: " . $info->Zip . "<br />";
    echo "Country: " . $info->Country . "<br />";
    echo "<br />";
}

echo "Items <br /> <br />";
foreach ($xml->Items->Item as $info) {
    echo "Item ID: " . $info[PartNumber] . "<br />";
    echo "Product name: " . $info->ProductName . "<br />";
    echo "Quantity: " . $info->Quantity . "<br />";
    echo "Price, $: " . $info->USPrice . "<br />";
    echo "Ship date: " . $info->ShipDate . "<br />";
    echo "<br />";

}

