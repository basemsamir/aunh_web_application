<?php
namespace App\HL7;
use SoapClient;
use App\HL7\add;
use App\HL7\Edit;
use App\HL7\EditResponse;
use App\HL7\Cancel;
use App\HL7\cancelResponse;
use App\Wsconfig;
/**
 * AUNHHL7ServiceService class
 * 
 *  
 * 
 * @author    {Michael}
 * @copyright {Michael}
 * @package   {Michael}
 */
class AUNHHL7ServiceService extends SoapClient {

    private static $classmap = array(
                                    'add' => 'add',
                                    'msgHeader' => 'msgHeader',
                                    'orcOrderInfo' => 'orcOrderInfo',
                                    'patientInfo' => 'patientInfo',
                                    'procedureInfo' => 'procedureInfo',
                                    'Cancel' => 'Cancel',
                                    'cancelResponse' => 'cancelResponse',
                                    'Edit' => 'Edit',
                                    'EditResponse' => 'EditResponse',
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
   * @param Cancel $parameters
   * @return CancelResponse
   */
  public function cancel(cancel $parameters) {
    return $this->__soapCall('cancel', array($parameters),array(
            'uri' => 'http://AUNHHL7Service/',
            'soapaction' => ''
           ));
  }

  /**
   *  
   *
   * @param addString $parameters
   * @return addStringResponse
   */
  public function addString(addString $parameters) {
    return $this->__soapCall('addString', array($parameters),       array(
            'uri' => 'http://AUNHHL7Service/',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param Edit $parameters
   * @return EditResponse
   */
  public function edit(Edit $parameters) {
    return $this->__soapCall('Edit', array($parameters),       array(
            'uri' => 'http://AUNHHL7Service/',
            'soapaction' => ''
           )
      );
  }

}

?>
