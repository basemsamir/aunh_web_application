<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\MedicalDevice;
use App\MedicalOrderItem;
use App\Procedure;
use App\Patient;
use App\Visit;
use App\User;
use App\Department;
use App\Doctor;
use App\MedicalDeviceProcedure;
use App\Wsconfig;
use App\HL7\msgHeader;
use App\HL7\orcOrderInfo;
use App\HL7\patientInfo;
use App\HL7\procedureInfo;
use App\HL7\AUNHHL7ServiceService;
use App\HL7\add;
use App\HL7\addResponse;
use App\HL7\cancel;
use App\HL7\Edit;
use Auth;
use Carbon\Carbon;
use DB;
use Session;
use Illuminate\Support\Facades\Lang;
use App\Traits\ProcDeviceName;

class HomeController extends Controller
{
		use ProcDeviceName;
		private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
				$this->user=User::find(Auth::id());

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	//dd(Session::get('proc_devices'));
				Session::forget('proc_devices');
				$devices= MedicalDevice::lists('name','id');
				$first_device=MedicalDevice::first();
				$device_procedures= $first_device->procedures()->lists('procedures.name','procedures.id');
				$rs_places=$this->user->reservation_places()->get();
				$rs_places_list=array();
				foreach($rs_places as $rs_place)
					$rs_places_list[$rs_place->id]=$rs_place->name;
				$day_month=$this->day_month_array();
				$departments=Department::lists('name','id');
				$ref_doctors=Doctor::lists('name','id');

        return view('home.form.store_reservation',compact('devices','device_procedures','rs_places_list','day_month','departments','ref_doctors'));
    }
		private function day_month_array()
		{
				$monthes=array();
				$days = array();
				$monthes[""]=0;
				$days[""]=0;
				for($i=1;$i<=11;$i++)
					$monthes[$i]=$i;
				for($i=1;$i<=29;$i++)
					$days[$i]=$i;
				return array($days,$monthes);
		}
		private function getBirthday($day,$month,$year)
		{
				# code...
				$birthdate=strtotime("-".($day==""?0:$day)." day",time());
				$birthdate=strtotime("-".($month==""?0:$month)." month",$birthdate);
				$birthdate=strtotime("-".($year==""?0:$year)." year",$birthdate);
				return date('Y-m-d',$birthdate);
		}
		public function store(ReservationRequest $request){

			$input=$request->all();
			if(count(Session::get('proc_devices')) == 0)
				return redirect()->back()->withErrors(array('proc_device'=>'لا يوجد فحوصات تمت حجزها'))->withInput();
			 DB::beginTransaction();
			 try{

				$proc_devices=Session::get('proc_devices');
				$input['sin']=$input['sin']==""?null:$input['sin'];
				$patient=Patient::create($input);

				//dd($proc_devices);
				$visit=Visit::create([
					'patient_id'=>$patient->id,
					'entry_id'=>$input['rs_place'],
					'user_id'=>$this->user->id
				]);
				$this->send_rad($proc_devices,$visit);
				Session::forget('proc_devices');
				DB::commit();
				return redirect()->back()->withSuccessMessage(Lang::get('flash_messages.success'));
		  }
			catch (\Exception $e){
				 DB::rollBack();
				 return redirect()->back()->withFailureMessage(Lang::get('flash_messages.failed'));
			}
		}

		private function send_rad($proc_devices,$visit)
		{
			foreach($proc_devices as $row)
			{
				foreach($row as $row1)
				{
					$procedure=Procedure::find($row1[0][0]);
					$medical_device_procedure=$procedure->devices()->where('medical_device_id',$row1[1][0])->first();

					$m_order_item=MedicalOrderItem::create([
						'visit_id'=>$visit->id,
						'medical_device_procedure_id'=>$medical_device_procedure->pivot->id,
						'procedure_status'=>$row1[2][1],
						'procedure_date'=>$row1[2][0],
						'department_id'=>$row1[2][2],
						'xray_doctor_id'=>$row1[2][3],
						'user_id'=>$this->user->id
					]);
					$this->sendingData($visit,$m_order_item);

				}
			}
		}
		public function edit($vid)
	  {
			Session::forget('proc_devices');
	    $visit = Visit::find($vid);
			if(Carbon::parse($visit->created_at)->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
				$orders= $visit->orders;
			}
			else{
				$orders= $visit->orders()->whereDate('procedure_date','>',Carbon::now()->format('Y-m-d'))->get();
			}

			foreach($orders as $order){
				$medical_device_procedure_id=$order->medical_device_procedure_id;
				$proc_device=MedicalDeviceProcedure::find($medical_device_procedure_id);
				$proc_device=$proc_device->medical_device_id."_".$proc_device->procedure_id;
				Session::push("proc_devices.$proc_device",$this->_getProcDeviceByID($proc_device,$order->procedure_date,$order->procedure_status,$order->department_id,$order->xray_doctor_id));
			}
			$patient= $visit->patient;
			$age=Carbon::parse($patient->birthdate)->diffInYears(Carbon::now());
			$devices= MedicalDevice::lists('name','id');
			$first_device=MedicalDevice::first();
			$device_procedures= $first_device->procedures()->lists('procedures.name','procedures.id');
			$rs_places=$this->user->reservation_places()->get();
			$rs_places_list=array();
			foreach($rs_places as $rs_place)
				$rs_places_list[$rs_place->id]=$rs_place->name;
			//$medical_proc_devices= $visit->orders;
			$day_month=$this->day_month_array();
			$departments=Department::lists('name','id');
			$ref_doctors=Doctor::lists('name','id');
	    return view('home.form.edit_reservation',compact('age','patient','visit','devices','rs_places_list','device_procedures','orders','day_month','departments','ref_doctors'));
	  }
		public function update(ReservationRequest $request,$vid)
	  {
			$input=$request->all();
			if(count(Session::get('proc_devices')) == 0)
				return redirect()->back()->withErrors(array('proc_device'=>'لا يوجد فحوصات تمت حجزها'));
			DB::beginTransaction();
			try{
				$visit=Visit::find($vid);
				$proc_devices=Session::get('proc_devices');
				$input['sin']=$input['sin']==""?null:$input['sin'];
				$patient=Patient::find($visit->patient_id)->update($input);
				$visit->update(array('entry_id'=>$input['rs_place']));
				$orders=$visit->orders;
				// call function for canceling orders //
				$this->cancel_rad($orders,$visit);
				// call function for sending orders //
				$this->send_rad($proc_devices,$visit);
				Session::forget('proc_devices');
				DB::commit();
				return redirect()->route('ris.home')->withSuccessMessage(Lang::get('flash_messages.success'));
			}
			catch (\Exception $e){
				DB::rollBack();
				return redirect()->back()->withFailureMessage(Lang::get('flash_messages.failed'));
			}
		}
		private function cancel_rad($orders,$visit)
		{
				foreach($orders as $order){
					$m_order_item=MedicalOrderItem::find($order->id);
					$this->sendingData($visit,$m_order_item,'cancel');
					$m_order_item->delete();
				}
		}
		public function ajaxStoreDeviceProc(){
			if(request()->ajax()){
				$proc_device=request()->input('proc_device');
				$proc_date=request()->input('proc_date');
				$proc_status=request()->input('proc_status');
				$proc_dep=request()->input('proc_dep');
				$proc_doc=request()->input('proc_doctor');
				if($proc_device != "" && $proc_date!=""){
					Session::push("proc_devices.$proc_device",$this->_getProcDeviceByID($proc_device,$proc_date,$proc_status,$proc_dep,$proc_doc));
					return response()->json(['success' => 'true']);
				}

			}
			else{
				return abort(404);
			}
		}
		public function ajaxDeleteDeviceProc(){
			if(request()->ajax()){
				$proc_device=request()->input('proc_device');
				if($proc_device != ""){
					Session::pull("proc_devices.$proc_device");
				}
				return response()->json(['success' => 'true']);
			}
			else{
				return abort(404);
			}
		}
		public function ajaxMDeviceProcedures(Request $request){
			if($request->ajax()){
				$device= MedicalDevice::find($request->get('id'));
				$procedures= $device->procedures()->get();
				return response()->json(['success' => 'true','procedures'=>$procedures]);
			}
			else{
				return abort(404);
			}
		}
		public function ajaxGetAllPatientsToday(Request $request){
			if($request->ajax()){
				$columns = array(
	                            0 =>'id',
	                            1 =>'name',
															2 =>'sin',
	                            3 =>'options',
	                        );

				$totalData = Visit::join('patients','patients.id','=','visits.patient_id')->whereDate('visits.created_at','=',date('Y-m-d'))->count();

				$totalFiltered = $totalData;

				$limit = $request->input('length');
				$start = $request->input('start');
				$order = $columns[$request->input('order.0.column')];
				$dir = $request->input('order.0.dir');

				if(empty(trim($request->input('search.value'))))
				{
					$patient_visits = Visit::join('patients','patients.id','=','visits.patient_id')
									 ->offset($start)
									 ->limit($limit)
									 ->orderBy($order,$dir)
									 ->select('patients.id','name','sin','visits.id as vid')
									 ->whereDate('visits.created_at','=',date('Y-m-d'))
									 ->get();
				}
				else {
					$search = $request->input('search.value');

					$patient_visits = Visit::join('patients','patients.id','=','visits.patient_id')
									->where('patients.id','LIKE',"%{$search}%")
									->orWhere('name', 'LIKE',"%{$search}%")
									->offset($start)
									->limit($limit)
									->orderBy($order,$dir)
									->select('patients.id','name','sin','visits.id as vid')

									->get();

					$totalFiltered =  Visit::join('patients','patients.id','=','visits.patient_id')
									 ->where('patients.id','LIKE',"%{$search}%")
									 ->orWhere('name', 'LIKE',"%{$search}%")
									 ->count();
				}

				$data = array();
				if(!empty($patient_visits))
				{
					foreach ($patient_visits as $patient_visit)
					{
						$edit =  route('ris.edit',$patient_visit->vid);

						$nestedData['id'] = "N".$patient_visit->id;
						$nestedData['name'] = $patient_visit->name;
						$nestedData['sin'] = $patient_visit->sin;
						$nestedData['options'] = "<a href='{$edit}' title='تحديد'  class='btn btn-info'  >
												   <i class='fa fa-edit'></i></a>";
						$data[] = $nestedData;

					}
				}

				$json_data = array(
							"draw"            => intval($request->input('draw')),
							"recordsTotal"    => intval($totalData),
							"recordsFiltered" => intval($totalFiltered),
							"data"            => $data
							);

				return response()->json($json_data);
			}
			else{
				return abort(404);
			}
		}
		public function search($value='')
		{
				$orders=MedicalOrderItem::join('visits','visits.id','=','medical_order_items.visit_id')
															->join('patients','patients.id','=','visits.patient_id')
															->join('medical_device_procedure','medical_device_procedure.id','=','medical_order_items.medical_device_procedure_id')
															->join('medical_devices','medical_devices.id','=','medical_device_procedure.medical_device_id')
															->join('procedures','procedures.id','=','medical_device_procedure.procedure_id')
															->select('visits.id as vid','patients.id','patients.name','sin','birthdate','address','procedure_date','procedure_status'
																			,'medical_devices.name as dev_name','procedures.name as proc_name')

								  ->whereDate('medical_order_items.created_at','=',Carbon::now()->format('Y-m-d'))
									->get();

				$devices= MedicalDevice::lists('name','id');
				$patient_active='true';
				return view('home.patients_table',compact('orders','devices','patient_active'));
		}
		public function post_search()
		{
			# code...
			$input=request()->all();
			$id=$input['pid'];
			$orders=MedicalOrderItem::join('visits','visits.id','=','medical_order_items.visit_id')
															->join('patients','patients.id','=','visits.patient_id')
															->join('medical_device_procedure','medical_device_procedure.id','=','medical_order_items.medical_device_procedure_id')
															->join('medical_devices','medical_devices.id','=','medical_device_procedure.medical_device_id')
															->join('procedures','procedures.id','=','medical_device_procedure.procedure_id')
															->where(function($query) use($input){

																		switch ($input['date_selection']) {
																			case 'today':
																				$query->whereDate('medical_order_items.created_at','=',Carbon::now()->format('Y-m-d'));
																				break;
																			case 'yestarday':
																				$query->whereDate('medical_order_items.created_at','=',Carbon::yesterday()->format('Y-m-d'));
																				break;
																			case 'last_week':
																				$query->whereBetween('medical_order_items.created_at',[Carbon::now()->subWeek()->format('Y-m-d'),Carbon::now()->format('Y-m-d')]);
																				break;
																			case 'date_selected':
																				if($input['duration_from']!="" && $input['duration_to'] !="")
																					$query->whereBetween('medical_order_items.created_at',[$input['duration_from'],$input['duration_to']]);
																				break;
																			default:
																				# code...
																				break;
																		}
																})
															->where(function($query) use($input)
															{
																# code...
																	if($input['pid'] != "")
																		$query->where('patients.id',$input['pid']);
																	elseif($input['name'] != "")
																		$query->where('patients.name','like',"%$input[name]%");

																	if(isset($input['devices']) && count($input['devices']) > 0)
																	{
																		$query->whereIn('medical_devices.id',$input['devices']);
																	}
															})
															->select('visits.id as vid','patients.id','patients.name','sin','birthdate','address','procedure_date','procedure_status'
																			,'medical_devices.name as dev_name','procedures.name as proc_name')
															->get();

			$devices= MedicalDevice::lists('name','id');
			$patient_active='true';
			return view('home.patients_table',compact('orders','devices','patient_active'));
		}
		private function sendingData($visit,$medical_order_item,$op='add'){

			$config=Wsconfig::first();
			$msgHeader=new msgHeader();
			$msgHeader->SendingApplication=$config->sending_app;
			$msgHeader->SendingFacility=$config->sending_fac;
			$msgHeader->ReceivingApplication=$config->receiving_app;
			$msgHeader->ReceivingFacility=$config->receiving_fac;

			$patient=Patient::find($visit->patient_id);
			//dd($patient);
			$patientInfo=new patientInfo();
			// AUNH prefix for all patients over all hospitals
			$patientInfo->PatientID="N".$patient->id;
			$patientInfo->PatientBirthdate=$patient->birthdate;
			$patientInfo->PatientGender=$patient->gender;
			$names=explode(" ",$patient->name);
			$patientInfo->LastNamefamilyname=isset($names[2])?$names[2]:"";
			$patientInfo->FirstName=isset($names[0])?$names[0]:"";
			$patientInfo->MiddleName=isset($names[1])?$names[1]:"";
			$patientInfo->Address=$patient->address;
			$patientInfo->PhoneNumber=$patient->phone_num;
			$patientInfo->MaritalStatus="Unknown";
			$patientInfo->Religion="Unknown";
			$patientInfo->NationalID=$patient->sin;
			$patientInfo->Nationality=$patient->nationality;

			$orcOrderInfo=new orcOrderInfo();
			$orcOrderInfo->StudyID=$medical_order_item->id; // string
			$orcOrderInfo->AccesstionNumber= $medical_order_item->id; // string

			$orcOrderInfo->ReceptionistID= $visit->user_id; // string
			$reception_user=User::find($visit->user_id);

			$orcOrderInfo->LastNamefamilynameR= ""; // string
			$orcOrderInfo->FirstNameR= $reception_user->name; // string
			//$orcOrderInfo->MiddleNameR= $names[1]; // string
			//dd($medical_order_item->doctor_id);
			$medicalOrderItem=$medical_order_item;
			//$medical_order_item_object=MedicalOrderItem::find($medicalOrderItem);

			$orcOrderInfo->DoctorID= $medicalOrderItem->user_id; // string

			$doctor_user=User::find($medicalOrderItem->user_id);


			$orcOrderInfo->LastNamefamilynameDoctor= ""; // string
			$orcOrderInfo->FirstNameDoctor= $doctor_user->name; // string
			//$orcOrderInfo->MiddleNameDoctor= $names[1]; // string


			$medical_device_procedure=DB::table('medical_device_procedure')
										->where('id',$medicalOrderItem->medical_device_procedure_id)
										->first();
			//dd($medical_device_procedure);
			$procedure=Procedure::find($medical_device_procedure->procedure_id);
			$device=MedicalDevice::find($medical_device_procedure->medical_device_id);

			$orcOrderInfo->ModalityType= $device->type; // string
			$orcOrderInfo->ModalityName= $device->name; // string

			$procedureInfo=new procedureInfo();
			$procedureInfo->ProcedureID=$procedure->proc_ris_id; // string
			$procedureInfo->ProcedureName=$procedure->name; // string
			$procedureInfo->ProcedureReason=""; // string
			$procedureInfo->SceduledDateTime=$medicalOrderItem->created_at; // string
			$procedureInfo->StudyID=$medicalOrderItem->id; // string
			$procedureInfo->AccesstionNumber=$medicalOrderItem->id;  // string
			$procedureInfo->DoctorID=$medicalOrderItem->user_id; // string
			$procedureInfo->LastNamefamilynameDoctor=""; // string
			$procedureInfo->FirstNameDoctor= $doctor_user->name;  // string
			//$procedureInfo->MiddleNameDoctor=$names[1]; // string

			$client = new AUNHHL7ServiceService();
			switch($op){
				case 'add':
					$input = new add();
					$input->arg0=$msgHeader;
					$input->arg1=$orcOrderInfo;
					$input->arg2=$patientInfo;
					$input->arg3=$procedureInfo;
					$response=$client->add($input);
				break;
				case 'cancel':
					$input = new Cancel();
					$input->arg0=$msgHeader;
					$input->arg1=$orcOrderInfo;
					$input->arg2=$patientInfo;
					$input->arg3=$procedureInfo;
					$response=$client->cancel($input);
				break;
				case 'edit':
					$input = new add();
					$input->arg0=$msgHeader;
					$input->arg1=$orcOrderInfo;
					$input->arg2=$patientInfo;
					$input->arg3=$procedureInfo;
					$response=$client->edit($input);
				break;

			}
			  // var_dump($client->next1($input));

		}
}
