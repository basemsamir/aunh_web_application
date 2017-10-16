<?php
namespace App\HL7;
use SoapClient;
use App\HL7\add;
use App\HL7\addResponse;
use App\Wsconfig;

class AUNHHL7ServiceService extends SoapClient {

	private static $classmap = array(
                                    'add' => 'add',
                                    'msgHeader' => 'msgHeader',
                                    'orcOrderInfo' => 'orcOrderInfo',
                                    'patientInfo' => 'patientInfo',
                                    'procedureInfo' => 'procedureInfo',
                                    'addString' => 'addString',
                                    'addStringResponse' => 'addStringResponse',
                                   );

	public function __construct($wsdl = "", $options = array()) {
		foreach(self::$classmap as $key => $value) {
		  if(!isset($options['classmap'][$key])) {
			$options['classmap'][$key] = $value;
		  }
		}
		$config=Wsconfig::first();
		$wsdl=$config->url;
		parent::__construct($wsdl, $options);
    }

  /**
   *  
   *
   * @param add $parameters
   * @return addResponse
   */
	public function add(add $parameters) {
		return $this->__soapCall('add', array($parameters),array(
				'uri' => 'http://AUNHHL7Service/',
				'soapaction' => ''
			   )
		  );
	}

  /**
   *  
   *
   * @param addString $parameters
   * @return addStringResponse
   */
	public function addString(addString $parameters) {
		return $this->__soapCall('addString', array($parameters),array(
				'uri' => 'http://AUNHHL7Service/',
				'soapaction' => ''
			   )
		  );
	}

}
?>
