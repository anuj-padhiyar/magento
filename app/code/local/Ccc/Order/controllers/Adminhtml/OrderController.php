<?php

class Ccc_Order_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action{
    
    public function indexAction(){
        $this->loadLayout();
        $this->_title($this->__('Sales'))->_title($this->__('Orders'));
        $this->_setActiveMenu('order');
        $this->renderLayout();
    }

    public function showCustomerAction(){
        $this->_title($this->__('Sales'))->_title($this->__('Orders'))->_title($this->__('New Order'));
        $this->loadLayout();
        $this->_setActiveMenu('order');
        $this->renderLayout();
        // echo Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles());
    }

    public function gridAction(){
        $this->loadLayout();
        Mage::register('cart',$this->getCart());
        $this->_setActiveMenu('order');
        $this->renderLayout();
    }

    protected function getCart(){
        $id = $this->getRequest()->getParam('id');
        $cart = Mage::getModel('order/cart');
        if(!$id){
            return $cart;
        }

        $collection = $cart->getCollection()->addFieldToFilter('customer_id',['eq'=>$id]);
        $select = $collection->getSelect();
        $data = $collection->getResource()->getReadConnection()->fetchAll($select);
        if(sizeof($data) == 1){
            $cart = $cart->load($data[0]['cart_id']);
            return $cart;
        }
        
        $customer = Mage::getModel('customer/customer')->load($id);
        $cart->setCustomerName($customer->getFirstname().' '.$customer->getLastname());
        $cart->setCustomerId($id);
        date_default_timezone_set('Asia/Kolkata');
        $cart->setCreatedDate(date('j/m/Y  h:i:s A'));
        $cart->save();
        return $cart;
    }

    protected function getItemIds($cart){
        $ids = [];
        $collection = Mage::getModel('order/cart_item')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$cart->getId()]);
        if($collection->count()){
            foreach($collection->getData() as $key=>$value){
                $ids[$value['item_id']] = $value['product_id'];
            }
        }
        return $ids;
    }
    protected function calculatePrice($price, $quantity){
        return $price * $quantity;
    }
    public function addProductAction(){
        $products = $this->getRequest()->getParam('product');
        $cart = $this->getCart();
        $itemId = $this->getItemIds($cart);
        if($products){
            foreach($products as $key=>$id){
                $product = Mage::getModel('catalog/product')->load($id);

                if(in_array($id,$itemId)){
                    $cartItem = Mage::getModel('order/cart_item')->load(array_search($id,$itemId));
                    $cartItem->quantity++;
                    $price = $this->calculatePrice($cartItem->getBasePrice(),$cartItem->getQuantity());
                    $cartItem->setPrice($price);
                }else{
                    $cartItem = Mage::getModel('order/cart_item');
                    $cartItem->setCartId($cart->getId());
                    $cartItem->setProductId($id);
                    $cartItem->setBasePrice($product->getPrice());
                    $cartItem->setPrice($product->getPrice());
                    date_default_timezone_set('Asia/Kolkata');
                    $cartItem->setCreatedDate(date('j/m/Y  h:i:s A'));
                }
                $cartItem->save();
            }
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product is Added Successfully');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    public function changeQuantityAction(){
        $data = $this->getRequest()->getPost('quantity');
        if($data){
            foreach($data as $itemId=>$quantity){
                $model = Mage::getModel('order/cart_item')->load($itemId);
                if($quantity<=0){
                    $model->delete();
                    continue;
                }
                $model->setQuantity($quantity);
                $price = $this->calculatePrice($model->getBasePrice(), $quantity);
                $model->setPrice($price);
                $model->save();
            }
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product Quantity Updated');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    public function deleteItemAction(){
        $id = $this->getRequest()->getParam('itemId');
        $customerId = $this->getRequest()->getParam('id');
        try{
            $model = Mage::getModel('order/cart_item')->load($id);
            if(!$model){
                throw new Exception("Product Not Found!!");
            }
            $model->delete();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product is Deleted Successfully');
        $this->_redirect('*/adminhtml_order/grid',array('id' => $customerId));
    }

    public function paymantMethodAction(){
        $data = $this->getRequest()->getPost('payment');
        if($data){
            $cart = $this->getCart();
            $cart->setPaymentMethodCode($data);
            $cart->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Paymnet Method Saved');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    public function shippingMethodAction(){
        $data = $this->getRequest()->getPost('shippingMethod');
        $data = explode('_',$data);
        if($data){
            $cart = $this->getCart();
            $cart->setShippingMethodCode($data[0]);
            $cart->setShippingAmount($data[1]);
            $cart->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Shipping Method Saved');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    public function saveCommentAction(){
        $data = $this->getRequest()->getPost('comment');
        if($data){
            $cart = $this->getCart();
            $cart->setComment($data);
            $cart->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Comment is Saveed Successfully');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    public function shippingAddressAction(){
        $cart = $this->getCart();
        $address = $this->getRequest()->getPost('shipping');
        $model = Mage::getModel('order/cart_address');
        $saveToAddress = 0;
        if(array_key_exists('save_to_address',$address)){
            $saveToAddress = 1;
            unset($address['save_to_address']);
        }

        if(array_key_exists('same_as_billing',$address)){
            $billingAddress = $cart->getCartBillingAddress();
            if(!$billingAddress = $cart->getCartBillingAddress()){
                Mage::getSingleton('adminhtml/session')->addError('Please Save Billing Address First');
                $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
                return;
            }
            if($cartAddress = $cart->getCartShippingAddress()){
                $model = $model->load($cartAddress['address_id']);
                $model->setAddress($billingAddress['address']);
                $model->setCity($billingAddress['city']);
                $model->setZipcode($billingAddress['zipcode']);
                $model->setCountry($billingAddress['country']);
                $model->setState($billingAddress['state']);
                $model->setFirstName($billingAddress['first_name']);
                $model->setLastName($billingAddress['last_name']);
            }else{
                $model->setData($billingAddress);
                $model->setAddressType('shipping');
                unset($model['address_id']);
            }
            $model->setSameAsBilling('1');
        }else{
            if($cartAddress = $cart->getCartShippingAddress()){
                $model = $model->load($cartAddress['address_id']);
                $model->addData($address);
            }else{
                $model->addData($address);
                $model->setAddressType('shipping');
                date_default_timezone_set('Asia/Kolkata');
                $model->setCreatedData(date('j/m/Y  h:i:s A'));
                $model->setCartId($cart->getId());
            }
            $model->setSameAsBilling('0');
        }
        $model->save();
    
        if($saveToAddress){
            $customerId = $this->getRequest()->getParam('id');
            $customerShippingAddress = Mage::getModel('customer/customer')->load($customerId)->getDefaultShippingAddress();
            if (!$customerShippingAddress) {
                $customerShippingAddress = Mage::getModel('customer/address');
                $customerShippingAddress->setEntityTypeId($customerShippingAddress->getEntityTypeId());
                $customerShippingAddress->setParentId($customerId); 
                $customerShippingAddress->setCustomerId($customerId);
                $customerShippingAddress->setIsDefaultShipping(1);
            }
            $customerShippingAddress->setFirstname($model->getFirstName());
            $customerShippingAddress->setLastname($model->getLastName());
            $customerShippingAddress->setStreet($model->getAddress());
            $customerShippingAddress->setCity($model->getCity());
            $customerShippingAddress->setRegion($model->getState());
            $customerShippingAddress->setCountryId($model->getCountry());
            $customerShippingAddress->setPostcode($model->getZipcode());
            $customerShippingAddress->save();
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Shipping Address is saved successfully');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    public function billingAddressAction(){
        $cart = $this->getCart();
        $address = $this->getRequest()->getPost('billing');
        $model = Mage::getModel('order/cart_address');
        $saveToAddress = 0;
        if(array_key_exists('save_to_address',$address)){
            $saveToAddress = 1;
            unset($address['save_to_address']);
        }
       

        if($cartAddress = $cart->getCartBillingAddress()){
            $model = $model->load($cartAddress['address_id']);
            $model->addData($address);
        }else{
            $model->addData($address);
            $model->setAddressType('billing');
            date_default_timezone_set('Asia/Kolkata');
            $model->setCreatedData(date('j/m/Y  h:i:s A'));
            $model->setCartId($cart->getId());
        }
        $model->save();

        
        if($saveToAddress){
            $customerId = $this->getRequest()->getParam('id');
            $customerBillingAddress = Mage::getModel('customer/customer')->load($customerId)->getDefaultBillingAddress();
            if (!$customerBillingAddress) {
                $customerBillingAddress = Mage::getModel('customer/address');
                $customerBillingAddress->setEntityTypeId($customerBillingAddress->getEntityTypeId());
                $customerBillingAddress->setParentId($customerId); 
                $customerBillingAddress->setCustomerId($customerId);
                $customerBillingAddress->setIsDefaultBilling(1);
            }
            $customerBillingAddress->setFirstname($model->getFirstName());
            $customerBillingAddress->setLastname($model->getLastName());
            $customerBillingAddress->setStreet($model->getAddress());
            $customerBillingAddress->setCity($model->getCity());
            $customerBillingAddress->setRegion($model->getState());
            $customerBillingAddress->setCountryId($model->getCountry());
            $customerBillingAddress->setPostcode($model->getZipcode());
            $customerBillingAddress->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Billing Address is saved successfully');
        $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
    }

    protected function getCartTotal($items,$shipping){
        $total = 0;
        if($items){
            foreach($items as $key=>$item){
                $total += $this->calculatePrice($item['quantity'],$item['price']);
            }
        }
        $total += $shipping;
        return $total;
    }
    public function placeOrderAction(){
        $cart = $this->getCart();
        $cartItems = $cart->getItems();
        $billingAddress = $cart->getCartBillingAddress();
        $shippingAddress = $cart->getCartShippingAddress();

        if($cartItems->count() <= 0){
            Mage::getSingleton('adminhtml/session')->addError('Please Add At Least One Item');
            $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
            return;
        }
        if(!$billingAddress){
            Mage::getSingleton('adminhtml/session')->addError('Please Fill The Billing Address');
            $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
            return;
        }
        if(!$shippingAddress){
            Mage::getSingleton('adminhtml/session')->addError('Please Fill The Shipping Address');
            $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
            return;
        }

        if(!$cart->getShippingMethodCode()){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Shipping Method');
            $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
            return;
        }
        if(!$cart->getPaymentMethodCode()){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Payment Method');
            $this->_redirect('*/adminhtml_order/grid',array('_current' => true));
            return;
        }

        $total = $this->getCartTotal($cartItems,$cart->getShippingAmount());
        $cart->setTotal($total);
        $cart->save();

        $orderModel = Mage::getModel('order/order');
        $orderModel->setData($cart->getData());
        unset($orderModel['cart_id']);
        date_default_timezone_set('Asia/Kolkata');
        $orderModel->setCreatedDate(date('j/m/Y  h:i:s A'));
        $orderModel->save();


        foreach($cartItems as $key=>$item){
            $orderItemModel = Mage::getModel('order/order_item')
                                ->setData($item->getData());

            unset($orderItemModel['item_id']);
            unset($orderItemModel['cart_id']);
            $orderItemModel->setOrderId($orderModel->getId());
            $orderItemModel->save();
            $item->delete();
            
        }

        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($billingAddress);
        unset($orderAddress['cart_id']);
        unset($orderAddress['address_id']);
        $orderAddress->setOrderId($orderModel->getId());
        $orderAddress->setCreatedDate(date('j/m/Y  h:i:s A'));
        $orderAddress->save();
        Mage::getModel('order/cart_address')->load($billingAddress['address_id'])->delete();


        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($shippingAddress);
        unset($orderAddress['cart_id']);
        unset($orderAddress['address_id']);
        $orderAddress->setOrderId($orderModel->getId());
        $orderAddress->setCreatedDate(date('j/m/Y  h:i:s A'));
        $orderAddress->save();
        $addressModel = Mage::getModel('order/cart_address')->load($shippingAddress['address_id'])->delete();

        $cart->delete();

        Mage::getSingleton('adminhtml/session')->addSuccess("Your Order Is Placed");
        $this->_redirect('*/adminhtml_order/index');
    }
}