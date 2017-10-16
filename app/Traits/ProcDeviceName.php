<?php
namespace App\Traits;

use App\Procedure;

trait ProcDeviceName{

	protected function _getProcDeviceByID($proc_dev_string){
		$proc=explode("_",$proc_dev_string);
		$procedure=Procedure::find($proc[1]);
		$medical_device_procedure=$procedure->devices()->where('medical_device_id',$proc[0])->first();
		return array(array($procedure->id,$procedure->name),array($medical_device_procedure->id,$medical_device_procedure->name));
	}
}