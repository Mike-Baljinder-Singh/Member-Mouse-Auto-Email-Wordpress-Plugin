<?php/* Handeler to handle the rebilling*/function rebillReminderNotification($orderData, $rebillDate, $daysPriorToRebill=10){	//global $daysPriorToRebill;		$memberId = $orderData["member_id"];	$email = $orderData["email"];	$phone = $orderData["phone"];	$firstName = $orderData["first_name"];	$lastName = $orderData["last_name"];		// access products associated with the order	$products = json_decode(stripslashes($orderData["order_products"]));		foreach($products as $product)	{		$productName = $product->name;		$productRecurringAmount = $product->recurring_amount;	// amount charged every rebill period		$productRebillPeriod = $product->rebill_period;			// integer - complete rebill period is a combination of rebill period		// and frequency i.e. 1 months, 30 days, 2 weeks, etc.		$productRebillFrequency = $product->rebill_frequency;  	// days, weeks, months, years	}		// ===> TODO perform custom action here	$msg = "{$firstName} {$lastName} ({$email}) will be billed ";	$msg .= "{$daysPriorToRebill} days from now on ".date("M j, Y", strtotime($rebillDate))."<br>"; 	//echo $msg;	$product = (array) $products[0];	return array_merge( array(				'memberID'		=>	@$memberID,				'memeberEmail'	=>	@$email,				'memberPhone'	=>	@$phone,				'memberFName'	=>	@$firstName,				'memberLName'	=>	@$lastName,				'memExpiry'		=>	date("M j, Y", strtotime($rebillDate))				), $product );}// ================= END CUSTOMIZATIONS ===============================// ====================================================================function beginmm_process($daysPriorToRebill){	global $wpdb;	$orderItemsTable = MM_TABLE_ORDER_ITEMS;	$ordersTable = MM_TABLE_ORDERS;	$MMremdata=array();	// This SQL retrieves all active subscriptions	$sql = "SELECT id FROM {$orderItemsTable} WHERE item_type=1 AND status =1 AND is_recurring=1;";	$orderItemIds = $wpdb->get_results($sql);	if($orderItemIds)	{		// Iterate over all active subscriptions and check if next rebill date is within		foreach($orderItemIds as $orderItemId)		{			$orderItem = new MM_OrderItem($orderItemId->id);						$nextRebillDate = "";			if($orderItem->isValid())			{					// retrieve ID of payment service associated with subscription				$sql = $wpdb->prepare("SELECT payment_id FROM {$ordersTable} WHERE id = %s LIMIT 1;", $orderItem->getOrderId());				$pymtServiceId = $wpdb->get_var($sql);								if($pymtServiceId !== false)				{					$pymtService = MM_PaymentServiceFactory::getPaymentServiceById($pymtServiceId);										// rebill date is only known for payment services that support card-on-file functionality (see this					// article for a full list: http://support.membermouse.com/knowledgebase/articles/317469-payment-methods-overview)					if($pymtService->supportsFeature(MM_PaymentServiceFeatures::CARD_ON_FILE))					{						$isCardOnFile = true;						$scheduledPaymentEvent = MM_ScheduledPaymentEvent::findNextScheduledEventByOrderItemId($orderItem->getId());						if ($scheduledPaymentEvent->isValid())						{							$nextRebillDate = $scheduledPaymentEvent->getScheduledDate();														// check if next rebill date is X days away where X is defined in $daysPriorToRebill							$priorToRebillDate = date('Y-m-d', strtotime("-{$daysPriorToRebill} days", strtotime($nextRebillDate)));														if($priorToRebillDate == date('Y-m-d'))							{								$orderId = $orderItem->getOrderId();								$memberId = MM_Order::getUserIdByOrderId($orderId);								$orderData = MM_Event::packageOrderData($memberId, $orderId, $orderItem->getId());								$MMremdata[] = rebillReminderNotification($orderData, $nextRebillDate, $daysPriorToRebill);							}						}					}				}			}		}	}	return $MMremdata;}?>