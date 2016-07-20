<?php
$result =  Add2BasketByProductID(
				 6493, // ID товара
				 1, //количество
				 array( 'DELAY'=>'Y' ),	 // список полей с https://dev.1c-bitrix.ru/api_help/sale/classes/csalebasket/csalebasket__add.php
				 array( 
				 		 array(  'NAME' => 'Наличие',
					         	'SORT' => 20,
					         	'CODE' => 'STATUS_AVAIL',
					         	'VALUE' => false
				          	)				         
					  )
					  ); 

?>
