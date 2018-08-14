<?php
 
namespace App\Soap;
use Artisaninweb\SoapWrapper\Service;
use Artisaninweb\SoapWrapper\SoapWrapper;
class UniversityOfPhayao
{
    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;
    /**
     * AuthSoapWrapper constructor.
     */
    public function __construct()
    {
        $context = stream_context_create([
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        $this->soapWrapper = new SoapWrapper();
        $this->soapWrapper->add("AuthenService", function ($service) use ($context) {
            $service
                ->wsdl("https://ws.up.ac.th/mobile/AuthenService.asmx?WSDL")
                ->trace(true)
                ->options(['stream_context' => $context]);
        });
        $this->soapWrapper->add("StaffService", function ($service) use ($context) {
            $service
                ->wsdl("https://ws.up.ac.th/mobile/StaffService.asmx?WSDL")
                ->trace(true)
                ->options(['stream_context' => $context]);
        });
        $this->soapWrapper->add("StudentService", function ($service) use ($context) {
            $service
                ->wsdl("https://ws.up.ac.th/mobile/StudentService.asmx?WSDL")
                ->trace(true)
                ->options(['stream_context' => $context]);
        });
    }
    public function getSoapWrapper()
    {
        return $this->soapWrapper;
    }
    public function getSID($username, $password)
    {
        $authResult = $this->getSoapWrapper()->call("AuthenService.login",
            [
                'Login' => [
                    'username' => base64_encode($username),
                    'password' => base64_encode($password),
                    'ProductName' => 'decaffair_student',
                ]
            ]
        );
        return $authResult->LoginResult;
    }
    public function getLogOff($sid){
        return $this->getSoapWrapper()->call('AuthenService.Logoff', [
            'Logoff ' => [
                'sessionID' => $sid
            ]
        ])->LogoffResult;
    }
    public function getStaffInfo($sid)
    {
        return $this->getSoapWrapper()->call('StaffService.GetStaffInfo', [
            'GetStaffInfo' => [
                'sessionID' => $sid
            ]
        ])->GetStaffInfoResult;
    }
    public function getStudentInfo($sid)
    {
        return $this->getSoapWrapper()->call('StudentService.GetStudentInfo', [
            'GetStudentInfo' => [
                'sessionID' => $sid
            ]
        ])->GetStudentInfoResult;
    }
}