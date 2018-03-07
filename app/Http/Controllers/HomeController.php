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
	private $role;
	private $medical_device_category;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		$this->user=User::with('role')->where('id',Auth::id())->first();
		if($this->user){
			$this->role=$this->user->role->name;
			switch ($this->role) {
				case 'Xray':
					$this->medical_device_category=1;
					break;
				case 'Lab':
					$this->medical_device_category=2;
					break;
			}
		}			
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		//dd(Session::get('proc_devices'));
		Session::forget('proc_devices');
		$medical_device_category=$this->medical_device_category;
		$devices= MedicalDevice::whereHas('medical_device_type',function ($query) use ($medical_device_category) {
									$query->where('medical_device_category_id',$medical_device_category);
								})
								->lists('name','id');
		
		$first_device=MedicalDevice::whereHas('medical_device_type',function ($query) use ($medical_device_category) {
										$query->where('medical_device_category_id',$medical_device_category);
									})
									->first();
		$device_procedures= $first_device->procedures()->lists('procedures.name','procedures.id');
		$rs_places=$this->user->reservation_places()->get();
		$rs_places_list=array();
		foreach($rs_places as $rs_place)
			$rs_places_list[$rs_place->id]=$rs_place->name;
		$day_month=$this->day_month_array();
		$departments=Department::lists('name','id');
		$ref_doctors=Doctor::lists('name','id');
		$index_menu_item_active='true';
        return view('home.form.store_reservation',compact('index_menu_item_active','devices','device_procedures','rs_places_list','day_month','departments','ref_doctors'));
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
		//dd($input);
		if(count(Session::get('proc_devices')) == 0)
			return redirect()->back()->withErrors(array('proc_device'=>'لا يوجد فحوصات تمت حجزها'))->withInput();
		DB::beginTransaction();
		try{

			$proc_devices=Session::get('proc_devices');
			$input['sin']=$input['sin']==""?null:$input['sin'];
			if(!isset($input['pid'])){
				$patient= Patient::create($input);
			}
			else{
				$patient=Patient::find($input['pid']);
				$patient->update($input);
			}
			//dd($proc_devices);
			$visit=$patient->visits()->create([
				'entry_id'=>$input['rs_place'],
				'user_id'=>$this->user->id
			]);
			try{
				$this->send_order_item($proc_devices,$visit);
			}
			catch (\Exception $e){
				DB::rollBack();
				return redirect()->back()->withFailureMessage(Lang::get('flash_messages.wsdl_error'));
			}
			Session::forget('proc_devices');
			DB::commit();
			return redirect()->back()->withSuccessMessage(Lang::get('flash_messages.success'));
		}
		catch (\Exception $e){
				DB::rollBack();
				
				return redirect()->back()->withFailureMessage(Lang::get('flash_messages.failed'));
		}
	}

	private function send_order_item($proc_devices,$visit)
	{
		foreach($proc_devices as $row)
		{
			foreach($row as $row1)
			{
				if(!$row1[2][4]){
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
					if($this->medical_device_category == 1)
						$this->sendingData($visit,$m_order_item);
				}
			}
		}
	}
	public function edit($vid)
	{
		Session::forget('proc_devices');
		$visit = Visit::find($vid);
		if(is_null($visit))
			return redirect()->action('HomeController@index');
			//dd($visit->orders);
		if(Carbon::parse($visit->created_at)->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
			$orders= $visit->orders;
		}
		else{
			$orders= $visit->orders()->whereDate('procedure_date','=',Carbon::now()->format('Y-m-d'))->get();
		}
		
		foreach($orders as $order){
			
			$medical_device_procedure_id=$order->medical_device_procedure_id;
			$proc_device=MedicalDeviceProcedure::find($medical_device_procedure_id);
			$proc_device=$proc_device->medical_device_id."_".$proc_device->procedure_id;
			Session::push("proc_devices.$proc_device",$this->_getProcDeviceByID($proc_device,$order->procedure_date,$order->procedure_status,$order->department_id,$order->xray_doctor_id,true));
		}
		//dd(Session::get("proc_devices"));
		$patient= $visit->patient;
		$age=Carbon::parse($patient->birthdate)->diffInYears(Carbon::now());
		$medical_device_category=$this->medical_device_category;
		$devices= MedicalDevice::whereHas('medical_device_type',function ($query) use ($medical_device_category) {
									$query->where('medical_device_category_id',$medical_device_category);
								})
								->lists('name','id');
		
		$first_device=MedicalDevice::whereHas('medical_device_type',function ($query) use ($medical_device_category) {
										$query->where('medical_device_category_id',$medical_device_category);
									})
									->first();
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
			if(count(Session::get('proc_devices')) == 0){
				return redirect()->back()->withErrors(array('proc_device'=>'لا يوجد فحوصات تمت حجزها'))->withInput();
			}
			DB::beginTransaction();
			try{
				$visit=Visit::find($vid);
				$proc_devices=Session::get('proc_devices');
				$input['sin']=$input['sin']==""?null:$input['sin'];
				$patient=Patient::find($visit->patient_id)->update($input);
				$visit->update(array('entry_id'=>$input['rs_place']));
				$orders=$visit->orders;
				// call function for canceling orders //
				//$this->cancel_rad($orders,$visit);
				// call function for sending orders //
				try{
					$this->send_order_item($proc_devices,$visit);
				}
				catch (\Exception $e){
					DB::rollBack();
					return redirect()->back()->withFailureMessage(Lang::get('flash_messages.wsdl_error'));
				}
				Session::forget('proc_devices');
				DB::commit();
				return redirect()->route('ris.home')->withSuccessMessage(Lang::get('flash_messages.success'));
			}
			catch (\Exception $e){
				DB::rollBack();
				return redirect()->back()->withFailureMessage(Lang::get('flash_messages.failed'));
			}
		}
		private function cancel_rad($order,$last_order_status)
		{
			try{
				$visit=$order->visit;
				if($last_order_status == "true"){
					if($visit->orders()->count() == 1)
						$visit->delete();
				}
				$order->delete();
				if($this->medical_device_category == 1)
					$this->sendingData($visit,$order,'cancel');
				return response()->json(['success' => true]);
			}
			catch(\Exception $e){
				DB::rollBack();
				return response()->json(['success' => false]);
			}
		}
		public function show($id)
		{
			Session::forget('proc_devices');
			$patient= Patient::find($id);

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
			$show=true;
			return view('home.form.edit_reservation',compact('show','age','patient','visit','devices','rs_places_list','device_procedures','orders','day_month','departments','ref_doctors'));
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
				$proc_device_arr=explode('_',$proc_device);
				
				if($proc_device != ""){
					$proc_device=Session::pull("proc_devices.$proc_device");
					//dd();
					if(request()->input('vid') && request()->input('existrow') ){
						
						$visit=Visit::find(request()->input('vid'));
						$orders=$visit->orders;
						foreach ($orders as $order) {
							if($order->medical_device_proc->medical_device_id==$proc_device_arr[0]
								&& $order->medical_device_proc->procedure_id==$proc_device_arr[1])
							{
								// call function for canceling orders //
								try{
									return $this->cancel_rad($order,request()->input('last_one'));
								}
								catch(\Exception $e){
									return redirect()->back()->withFailureMessage(Lang::get('flash_messages.wsdl_error'));
								}
								
							}
						}
					}
				}
				
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
								3 =>'visit_date',
								4 =>'last_proc_date',
								5 =>'patient_options',
								6 =>'visit_options',
	                        );

				$totalData = Patient::leftJoin('visits','patients.id','=','visits.patient_id')
									->leftJoin('medical_order_items','medical_order_items.visit_id','=','visits.id')
									->leftJoin('medical_device_procedure','medical_device_procedure.id','=','medical_order_items.medical_device_procedure_id')
									->leftJoin('medical_devices','medical_devices.id','=','medical_device_procedure.medical_device_id')
									->leftJoin('medical_device_types','medical_device_types.id','=','medical_devices.medical_device_type_id')
									->leftJoin('medical_device_categories','medical_device_categories.id','=','medical_device_types.medical_device_category_id')
									->where('medical_device_categories.id',$this->medical_device_category)
									 ->where(function($query){
										$query->whereDate('patients.created_at','=',\Carbon\Carbon::today()->format('Y-m-d'))
											  ->orWhereDate('visits.created_at','=',\Carbon\Carbon::today()->format('Y-m-d'))
											  ->orWhereDate('medical_order_items.procedure_date','=',\Carbon\Carbon::today()->format('Y-m-d'));
									 })
									->groupBy('visits.id')
									->count();

				$totalFiltered = $totalData;

				$limit = $request->input('length');
				$start = $request->input('start');
				$order = $columns[$request->input('order.0.column')];
				$dir = $request->input('order.0.dir');

				if(empty(trim($request->input('search.value'))) || trim($request->input('search.value')) == "N")
				{
					$patient_visits = Patient::leftJoin('visits','patients.id','=','visits.patient_id')
									 ->leftJoin('medical_order_items','medical_order_items.visit_id','=','visits.id')
									 ->leftJoin('medical_device_procedure','medical_device_procedure.id','=','medical_order_items.medical_device_procedure_id')
									 ->leftJoin('medical_devices','medical_devices.id','=','medical_device_procedure.medical_device_id')
									 ->leftJoin('medical_device_types','medical_device_types.id','=','medical_devices.medical_device_type_id')
									 ->leftJoin('medical_device_categories','medical_device_categories.id','=','medical_device_types.medical_device_category_id')
									 ->where('medical_device_categories.id',$this->medical_device_category)
									 ->where(function($query){
										$query->whereDate('patients.created_at','=',\Carbon\Carbon::today()->format('Y-m-d'))
											  ->orWhereDate('visits.created_at','=',\Carbon\Carbon::today()->format('Y-m-d'))
											  ->orWhereDate('medical_order_items.procedure_date','=',\Carbon\Carbon::today()->format('Y-m-d'));
									 })
									 ->offset($start)
									 ->limit($limit)
									 ->orderBy($order)
									 ->select('patients.id','patients.name','sin','visits.created_at','visits.id as vid',
									 DB::raw('(select count(*) from medical_order_items where medical_order_items.visit_id= `visits`.`id`
									 and date(`procedure_date`) >= CURRENT_DATE() ) as procs_count'),
									 DB::raw('(select max(procedure_date) from medical_order_items where medical_order_items.visit_id= `visits`.`id`
									 and date(`procedure_date`) >= CURRENT_DATE() ) as last_proc_date'))
									 ->groupBy('visits.id')
									 ->get();
				}
				else {

					$search = $request->input('search.value');
					if($search[0] == "N" or $search[0] == "n")
						$search=substr($search,1);
					
					$query=
					$patient_visits = Patient::leftJoin(
											DB::raw('( select visits.id as vid,visits.patient_id,
											max(visits.created_at) as created_at,
											count(medical_order_items.id) procs_count ,max(medical_order_items.procedure_date) last_proc_date from visits join medical_order_items on visits.id=medical_order_items.visit_id
											join medical_device_procedure on medical_order_items.medical_device_procedure_id=medical_device_procedure.id
											join medical_devices on medical_device_procedure.medical_device_id=medical_devices.id
											join medical_device_types on medical_devices.medical_device_type_id=medical_device_types.id
											join medical_device_categories on medical_device_types.medical_device_category_id=medical_device_categories.id
											where medical_device_categories.id='.$this->medical_device_category.'
											and DATE(medical_order_items.procedure_date) >= CURDATE()
											group by visits.id
											) t'),'patients.id','=','t.patient_id')
											->where('patients.id','LIKE',"%{$search}%")
											->orWhere('patients.name', 'LIKE',"%{$search}%")						
											->select('patients.id','patients.name','sin','address','t.created_at','vid','procs_count','last_proc_date')
											->offset($start)
											->limit($limit)
											->orderBy($order)
											->get();

					$totalData =  Patient::where('patients.id','LIKE',"%{$search}%")
									 	->orWhere('name', 'LIKE',"%{$search}%")
									 	->count();
					$totalFiltered=$totalData;
				}

				$data = array();
				if(!empty($patient_visits))
				{
					foreach ($patient_visits as $patient_visit)
					{
						$new =  route('ris.show',$patient_visit->id);
						$edit =  route('ris.edit',$patient_visit->vid);

						$nestedData['id'] = "N".$patient_visit->id;
						$nestedData['name'] = $patient_visit->name;
						$nestedData['sin'] = $patient_visit->sin;
						$nestedData['address'] = $patient_visit->address;
						$nestedData['visit_date'] =is_null($patient_visit->created_at)?"":Carbon::parse($patient_visit->created_at)->format('Y-m-d');
						$nestedData['last_proc_date'] =is_null($patient_visit->last_proc_date)?"":Carbon::parse($patient_visit->last_proc_date)->format('Y-m-d');
						
						if(!is_null($patient_visit->vid) 
							&& $patient_visit->procs_count ){
								$nestedData['visit_options'] = "<a href='{$edit}' title='تعديل الحجز'  class='btn btn-info' ><i class='fa fa-edit'></i></a>";
								$nestedData['patient_options']=""; 
							}
							
						else{
							$nestedData['patient_options'] = "<a href='{$new}' title='عمل حجز جديد'  class='btn btn-success'  ><i class='fa fa-plus'></i></a>";
							$nestedData['visit_options']="";	
						}
							
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
		public function searchPatientProc($value='')
		{
			$medical_device_category=$this->medical_device_category;
			$orders=MedicalOrderItem::with('visit','visit.patient','medical_device_proc.device_order_item',
											'medical_device_proc.proc_order_item','department','ref_doctor')
										->whereHas('medical_device_proc.device_order_item.medical_device_type.category',function($query) use($medical_device_category){
											$query->where('id',$medical_device_category);
										})
										->whereDate('medical_order_items.created_at','=',Carbon::now()->format('Y-m-d'))
										->get();
			$devices=MedicalDevice::whereHas('medical_device_proc.device_order_item.medical_device_type.category',function($query) use($medical_device_category){
										$query->where('id',$medical_device_category);
									})
								  ->lists('name','id');
			$patients_proc_menu_item_active='true';
			return view('home.patients_proc_table',compact('orders','devices','patients_proc_menu_item_active'));
		}
		public function postSearchPatientProc()
		{
			$input=request()->all();
			$medical_device_category=$this->medical_device_category;
			$orders=MedicalOrderItem::with('visit','medical_device_proc.proc_order_item','department','ref_doctor')
									->whereHas('medical_device_proc.device_order_item.medical_device_type.category',function($query) use($medical_device_category){
										$query->where('id',$medical_device_category);
									})
									->whereHas('visit.patient',function($query) use($input){
									if($input['pid'] != ""){
										if($input['pid'][0] == "N" || $input['pid'][0] == "n")
											$input['pid']=substr($input['pid'],1);
										$query->where('id',$input['pid']);
									}
									elseif($input['name'] != "")
										$query->where('name','like',"%$input[name]%");

									})
									->whereHas('medical_device_proc.device_order_item',function($query) use($input){
										if(isset($input['devices']) && count($input['devices']) > 0)
										{
											$query->whereIn('id',$input['devices']);
										}
									})
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
									->get();

			$devices= MedicalDevice::lists('name','id');
			$patients_proc_menu_item_active='true';
			return view('home.patients_proc_table',compact('orders','devices','patients_proc_menu_item_active'));
		}
		public function searchPatient($value='')
		{
			$patient_menu_item_active='true';
			return view('home.patients_table',compact('patient_menu_item_active'));
		}
		public function postSearchPatient()
		{
			$input=request()->all();
			$medical_device_category=$this->medical_device_category;
			$patients=Patient::where(function($query) use($input){
									if($input['pid'] != ""){
										if($input['pid'][0] == "N" || $input['pid'][0] == "n")
											$input['pid']=substr($input['pid'],1);
										$query->where('id',$input['pid']);
									}
									elseif($input['name'] != "")
										$query->where('name','like',"%$input[name]%");
									elseif($input['sin'] != "")
										$query->where('sin',$input['sin']);
								})
								->get();
			$patient_menu_item_active='true';
			return view('home.patients_table',compact('patients','patient_menu_item_active'));
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
