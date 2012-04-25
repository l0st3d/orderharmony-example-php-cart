<?php

/**

Copyright (c) 2012 Rivelin Software Limited support@orderharmony.com

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

**/

class OrderHarmonyAPI
{
	/**
	* @var String $strHost The host that you used during your signup with OrderHarmony
	*/
	private $strHost;
	
	/**
	* @var String $strVersion This is the version of the API you are using the default is 1
	*/
	private $strVersion;
	
	/**
	* @var String $strSecret The shared secret key that can be found at $strHost/api 
	*/
	private $strSecret;
	
	/**
	* @var String $strToken The token that can be found at $strHost/api
	*/
	private $strToken;

	/**
	* @var String $strFormat This is the return format from the API call xml, json
	*/
	private $strFormat = 'json';
	
	/**
	* @param String $strHost The host that you used during your signup with OrderHarmony
	* @param String $strSecret The shared secret key that can be found at $strHost/api
	* @param String $strToken The token that can be found at $strHost/api
	* @param String $strVersion This is the version of the API you are using the default is 1
	*/
	public function OrderHarmonyAPI($strHost, $strSecret, $strToken, $strVersion = '1')
	{
		$this->strHost = $strHost;
		$this->strSecret = $strSecret;
		$this->strToken = $strToken;
		$this->strVersion = $strVersion;
	}
	
	/**
	* Set the return format to json
	*/
	public function setFormatJSON()
	{
		$this->strFormat = 'json';
	}
	
	/**
	* This is a call to get all the products listed in your OrderHarmony instance
	* The documentation for this call can be found at /apidoc/[version]/products
	*
	* @return String or Array depending on the format, for xml and json it will be a string and for objects array
	*/
	public function getProducts()
	{
		$strCall = 'products';
		
		return $this->doApiCall($strCall);
	}
	
	/**
	* This method will handle the post back to OrderHarmony and create the order
	*
	* @param Array $strOrderData Contains all the required data to create the order.
	* @return 
	*/
	public function createOrder(Array $arrOrderData)
	{
		$strCall = 'orders';
		$strContent = json_encode($arrOrderData);
		
		$arrParams = array(
			'http' => array(
				'method' => 'POST',
				'header' => "\r\nContent-type: application/x-www-form-urlencoded\r\n",
				'content' => http_build_query(array('order'=> $strContent))
			)
		);
		
		$resContext = stream_context_create($arrParams);
		
		return $this->doApiCall($strCall, false, $resContext);
	}

	/**
	* This is a call to get the product for this id listed in your OrderHarmony instance
	* The documentation for this call can be found at /apidoc/[version]/products/:id
	*
	* @return String or Array depending on the format, for xml and json it will be a string and for objects array
	*/
	public function getProduct($intID)
	{
		$strCall = 'products/'.$intID;
		
		return $this->doApiCall($strCall);
	}

	
	/**
	* This is the main call to the OrderHarmony Instance.
	* 
	* @return String or Array depending on the format, for xml and json it will be a string and for objects array
	*/
	private function doApiCall($strCall, $bolUseIncludePath = false, $resContext = null)
	{
		$strContent = file_get_contents($this->buildApiUrl($strCall), $bolUseIncludePath, $resContext);
		
		return $strContent;
	}
	
	/**
	* This method builds the url tat will be call for doing the Api Call
	*
	* @param String $strCall The specific call that needs to be build for the url
	* @return String Url for the API call
	*/
	private function buildApiUrl($strCall)
	{
		$intTime = time();
		
		$strSignature = sha1('/api/'.$this->strVersion.'/'.$strCall.'?token='.$this->strToken.'&serial='.$intTime.'&secret='.$this->strSecret);
		return 	$this->strHost.'/api/'.$this->strVersion.'/'.$strCall.'?token='.$this->strToken.'&serial='.$intTime.'&signature='.$strSignature.'&format='.$this->strFormat;
	}
}

?>