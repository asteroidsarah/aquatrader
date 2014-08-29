<?php

	class Cart {

		private $aContents; //an array that holds all the carts products

		public function __construct() {

			$this->aContents = array(); //intialising array

		}

		public function addToCart($iProductID, $iQuantity) {

            if(isset($this->aContents[$iProductID])) {

                $this->aContents[$iProductID] += $iQuantity;

            } else {

                $this->aContents[$iProductID] = $iQuantity;

            }


		}

		public function removeFromCart($iProductID) {
            $this->aContents[$iProductID] -= 1;

            if($this->aContents[$iProductID] <= 0) {

                unset($this->aContents[$iProductID]);

            }

		}


		public function __get($var) {

            switch($var) {
                case 'contents':
                    return $this->aContents;
                    break;
                default:
                    die($var . "does not exist in cart");
            }

		}

		public function __set($var, $value) {

            switch($var) {
                case 'contents':
                    $this->aContents = $value;
                    break;
                default:
                    die($var . "does not exist in cart");
            }

		}


	}

//test

    // $oCart = new Cart();
    // $oCart->addToCart(3,6);

    // $oCart->addToCart(3);
    // $oCart->addToCart(1);
    // $oCart->addToCart(3);
    // $oCart->removeFromCart(3);
    // $oCart->addToCart(3);
    // $oCart->addToCart(3);
    // $oCart->removeFromCart(1);

    // echo "<pre>";
    // print_r($oCart);
    // echo "</pre>";


?>

