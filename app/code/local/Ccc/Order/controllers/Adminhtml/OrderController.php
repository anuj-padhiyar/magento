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
        $id = (int)$this->getRequest()->getParam('id');
        if(!$id){
            $id = $this->_getSession()->getData('id');
        }else{
            $this->_getSession()->setData('id',$id);
        }

        $cart = Mage::getModel('order/cart');
        if(!$id){
            return $cart;
        }

        $collection = $cart->getCollection()->addFieldToFilter('customer_id',['eq'=>$id]);
        if(sizeof($collection->getItems()) == 1){
            $cart = $collection->getFirstItem();
            return $cart;
        }
        
        $customer = Mage::getModel('customer/customer')->load($id);
        $cart->setCustomerName($customer->getFirstname().' '.$customer->getLastname());
        $cart->setCustomerId($id);
        $cart->setCreatedDate(date('Y-m-d h:i:s'));
        $cart->save();
        return $cart;
    }

    
    protected function calculatePrice($price, $quantity){
        return $price * $quantity;
    }
    public function addProductAction(){
        $products = $this->getRequest()->getParam('product');
        $cart = $this->getCart();
        $itemIds = $cart->getItemIds();
        if(!$products){
            Mage::getSingleton('adminhtml/session')->addError('No Product is Selected');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        foreach($products as $key=>$id){
            $product = Mage::getModel('catalog/product')->load($id);
            if(in_array($id,$itemIds)){
                $cartItem = Mage::getModel('order/cart_item')->load(array_search($id,$itemIds));
                $cartItem->quantity++;
                $cartItem->setBasePrice($product->getPrice());
                $price = $this->calculatePrice($cartItem->getBasePrice(),$cartItem->getQuantity());
                $cartItem->setPrice($price);
            }else{
                $cartItem = Mage::getModel('order/cart_item');
                $cartItem->setCartId($cart->getId());
                $cartItem->setProductId($id);
                $cartItem->setBasePrice($product->getPrice());
                $cartItem->setPrice($product->getPrice());
                $cartItem->setCreatedDate(date('Y-m-d h:i:s'));
            }
            $cartItem->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product is Added Successfully');
        $this->_redirect('*/adminhtml_order/grid');
    }

    public function changeQuantityAction(){
        $data = $this->getRequest()->getPost('quantity');
        if(!$data){
            Mage::getSingleton('adminhtml/session')->addError('No Item in Cart');
            $this->_redirect('*/*/grid');
            return;
        }
        foreach($data as $itemId=>$quantity){
            $model = Mage::getModel('order/cart_item')->load($itemId);
            if(!is_numeric($quantity) || $quantity<0){
                Mage::getSingleton('adminhtml/session')->addError('Please Enter Valid Number For Quantity!');
                $this->_redirect('*/adminhtml_order/grid');
                return;
            }
            if($quantity==0){
                $model->delete();
                continue;
            }
            $model->setQuantity($quantity);
            $price = $this->calculatePrice($model->getBasePrice(), $quantity);
            $model->setPrice($price);
            $model->save();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product Quantity Updated');
        $this->_redirect('*/adminhtml_order/grid');
    }

    public function deleteItemAction(){
        $id = (int)$this->getRequest()->getParam('itemId');
        try{
            $model = Mage::getModel('order/cart_item')->load($id);
            if(!$model){
                throw new Exception("Product Not Found!!");
            }
            $model->delete();
        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Product is Deleted Successfully');
        $this->_redirect('*/adminhtml_order/grid');
    }

    public function paymantMethodAction(){
        $data = $this->getRequest()->getPost('payment');
        if(!$data){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Payment Method');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        $cart = $this->getCart();
        $cart->setPaymentMethodCode($data);
        $cart->save();
        Mage::getSingleton('adminhtml/session')->addSuccess('Paymnet Method Saved');
        $this->_redirect('*/adminhtml_order/grid');
    }

    public function shippingMethodAction(){
        $data = $this->getRequest()->getPost('shippingMethod');
        if(!$data){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Shipping Method');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        $data = explode('_',$data);
        $cart = $this->getCart();
        $cart->setShippingMethodCode($data[0]);
        $cart->setShippingAmount($data[1]);
        $cart->save();
        Mage::getSingleton('adminhtml/session')->addSuccess('Shipping Method Saved');
        $this->_redirect('*/adminhtml_order/grid');
    }

    public function saveCommentAction(){
        $data = $this->getRequest()->getPost('comment');
        if(!$data){
            Mage::getSingleton('adminhtml/session')->addError('Please Add Comment');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        $cart = $this->getCart();
        $cart->setComment($data);
        $cart->save();
        Mage::getSingleton('adminhtml/session')->addSuccess('Comment is Saveed Successfully');
        $this->_redirect('*/adminhtml_order/grid');
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

        $cartAddress = $cart->getCartShippingAddress();
        if(array_key_exists('same_as_billing',$address)){
            $billingAddress = $cart->getCartBillingAddress();
            if(!$billingAddress->getId()){
                Mage::getSingleton('adminhtml/session')->addError('Please Save Billing Address First');
                $this->_redirect('*/adminhtml_order/grid');
                return;
            }
            if($cartAddress->getId()){
                $model = $model->load($cartAddress->getAddressId());
                $model->setAddress($billingAddress->getAddress());
                $model->setCity($billingAddress->getCity());
                $model->setZipcode($billingAddress->getZipcode());
                $model->setCountry($billingAddress->getCountry());
                $model->setState($billingAddress->getState());
                $model->setFirstName($billingAddress->getFirstName());
                $model->setLastName($billingAddress->getLastName());
            }else{
                $model->setData($billingAddress->getData());
                $model->setAddressType('shipping');
                unset($model['address_id']);
            }
            $model->setSameAsBilling('1');
        }else{
            if($cartAddress->getId()){
                $model = $model->load($cartAddress->getAddressId());
                $model->addData($address);
            }else{
                $model->addData($address);
                $model->setAddressType('shipping');
                $model->setCreatedData(date('Y-m-d h:i:s'));
                $model->setCartId($cart->getId());
            }
            $model->setSameAsBilling('0');
        }
        $model->save();
    
        if($saveToAddress){
            $customerId = $this->getCart()->getCustomerId();
            $customerShippingAddress = $cart->getCustomer()->getCustomerShippingAddress();
            if (!$customerShippingAddress->getId()) {
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
        $this->_redirect('*/adminhtml_order/grid');
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
       
        $cartAddress = $cart->getCartBillingAddress();
        if($cartAddress->getId()){
            $model = $model->load($cartAddress->getAddressId());
            $model->addData($address);
        }else{
            $model->addData($address);
            $model->setAddressType('billing');
            $model->setCreatedData(date('Y-m-d h:i:s'));
            $model->setCartId($cart->getId());
        }
        $model->save();

        
        if($saveToAddress){
            $customerId = $this->getCart()->getCustomerId();
            $customerBillingAddress =$cart->getCustomer()->getCustomerBillingAddress();
            if (!$customerBillingAddress->getId()) {
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
        $this->_redirect('*/adminhtml_order/grid');
    }

    public function placeOrderAction(){
        $cart = $this->getCart();
        $cartItems = $cart->getItems();
        $billingAddress = $cart->getCartBillingAddress();
        $shippingAddress = $cart->getCartShippingAddress();

        if($cartItems->count() <= 0){
            Mage::getSingleton('adminhtml/session')->addError('Please Add At Least One Item');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        if(!$billingAddress->getId()){
            Mage::getSingleton('adminhtml/session')->addError('Please Fill The Billing Address');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        if(!$shippingAddress->getId()){
            Mage::getSingleton('adminhtml/session')->addError('Please Fill The Shipping Address');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }

        if(!$cart->getShippingMethodCode()){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Shipping Method');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }
        if(!$cart->getPaymentMethodCode()){
            Mage::getSingleton('adminhtml/session')->addError('Please Select Payment Method');
            $this->_redirect('*/adminhtml_order/grid');
            return;
        }

        $cart->setTotal($cart->getFinalTotal());
        $cart->save();

        $orderModel = Mage::getModel('order/order');
        $orderModel->setData($cart->getData());
        unset($orderModel['cart_id']);
        $orderModel->setCreatedDate(date('Y-m-d h:i:s'));
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
        $orderAddress->setData($billingAddress->getData());
        unset($orderAddress['cart_id']);
        unset($orderAddress['address_id']);
        $orderAddress->setOrderId($orderModel->getId());
        $orderAddress->setCreatedDate(date('Y-m-d h:i:s'));
        $orderAddress->save();
        Mage::getModel('order/cart_address')->load($billingAddress->getAddressId())->delete();


        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($shippingAddress->getData());
        unset($orderAddress['cart_id']);
        unset($orderAddress['address_id']);
        $orderAddress->setOrderId($orderModel->getId());
        $orderAddress->setCreatedDate(date('Y-m-d h:i:s'));
        $orderAddress->save();
        $addressModel = Mage::getModel('order/cart_address')->load($shippingAddress->getAddressId())->delete();

        $cart->delete();
        Mage::getSingleton('adminhtml/session')->addSuccess("Your Order Is Placed");
        $this->_redirect('*/adminhtml_order/index');
    }
}