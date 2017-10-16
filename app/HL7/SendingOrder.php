<?php namespace App\HL7;

class msgHeader {
  public $SendingApplication; // string
  public $SendingFacility; // string
  public $ReceivingApplication; // string
  public $ReceivingFacility; // string
}

class orcOrderInfo {
  public $StudyID; // string
  public $AccesstionNumber; // string
  public $ReceptionistID; // string
  public $LastNamefamilynameR; // string
  public $FirstNameR; // string
  public $MiddleNameR; // string
  public $DoctorID; // string
  public $LastNamefamilynameDoctor; // string
  public $FirstNameDoctor; // string
  public $MiddleNameDoctor; // string
  public $ModalityType; // string
  public $ModalityName; // string
}

class patientInfo {
  public $PatientID; // string
  public $PatientBirthdate; // dateTime
  public $PatientGender; // string
  public $LastNamefamilyname; // string
  public $FirstName; // string
  public $MiddleName; // string
  public $Address; // string
  public $PhoneNumber; // string
  public $MaritalStatus; // string
  public $Religion; // string
  public $NationalID; // string
  public $Nationality; // string

}

class procedureInfo {
  public $ProcedureID; // string
  public $ProcedureName; // string
  public $ProcedureReason; // string
  public $SceduledDateTime; // dateTime
  public $StudyID; // string
  public $AccesstionNumber; // string
  public $DoctorID; // string
  public $LastNamefamilynameDoctor; // string
  public $FirstNameDoctor; // string
  public $MiddleNameDoctor; // string

}
