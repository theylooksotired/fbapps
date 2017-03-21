<?php
class PayPal {

	static public function checkout($options=array()) {
		$item_name = (isset($options['item_name'])) ? $options['item_name'] : Parms::param('titlePage');
		$item_number = (isset($options['item_number'])) ? $options['item_number'] : '1';
		$item_amount = (isset($options['item_amount'])) ? $options['item_amount'] : '1.00';
		$currency_code = (isset($options['currency_code'])) ? $options['currency_code'] : 'USD';
		$cancel_return = (isset($options['cancel_return'])) ? $options['cancel_return'] : url('');
		$return = (isset($options['return'])) ? $options['return'] : url('');
		$image = (isset($options['image'])) ? $options['image'] : 'https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif';
		return '<form action="'.PAYPAL_URL.'" method="post" class="paypalForm">
					
					<input type="hidden" name="business" value="'.PAYPAL_ID.'">
					<input type="hidden" name="cmd" value="_xclick">

					<input type="hidden" name="item_name" value="'.$item_name.'">
					<input type="hidden" name="item_number" value="'.$item_number.'">
					<input type="hidden" name="amount" value="'.$item_amount.'">
					<input type="hidden" name="currency_code" value="'.$currency_code.'">

					<input type="hidden" name="cancel_return" value="'.$cancel_return.'">
					<input type="hidden" name="return" value="'.$return.'">

					<input type="image" name="submit" border="0" src="'.$image.'">

		       	</form>';
	}

}
?>