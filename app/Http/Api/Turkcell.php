<?php

namespace App\Http\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Turkcell
{
    private $url;
    private $username;
    private $password;
    private $userCode;
    private $accountID;
    private $requestType;
    private $originator;
    public $receivers;
    public $errorCode;

    /**
     * Class construct
     */
    public function __construct()
    {
        $config = config('sms-api.turkcell');

        $this->setUrl($config['url']);
        $this->setUsername($config['username']);
        $this->setPassword($config['password']);
        $this->setUserCode($config['userCode']);
        $this->setAccountID($config['accountID']);
        $this->setOriginator($config['originator']);

    }

    /**
     * get credit amount
     * @return array
     */
    public function getCredit(): array
    {
        $this->setRequestType("getCredit");
        $result = $this->sendRequest();

        return [
            'ErrorCode' => $result->ErrorCode,
            'Amount' => $result->Amount
        ];

    }

    /**
     * get list of originators
     * @return array
     */
    public function getOriginator(): array
    {
        $this->setRequestType("getOriginator");
        $result = $this->sendRequest();

        return [
            'ErrorCode' => $result->ErrorCode,
            'OriginatorList' => $result->OriginatorList
        ];
    }

    /**
     * sends sms message to single or multiple receivers
     * @param string $message
     * @return array
     */
    public function sendSMS(string $message): array
    {

        $this->setRequestType('sendSms');
        $args = "<Originator>$this->originator</Originator>
            <SendDate />
            <ValidityPeriod>60</ValidityPeriod>
            <MessageText>$message</MessageText>
            <IsCheckBlackList>1</IsCheckBlackList>
            <ReceiverList>";

        foreach ($this->getReceivers() as $receiver) {
            $args .= "<Receiver>$receiver</Receiver>";
        }

        $args .= "</ReceiverList>";

        $result = $this->sendRequest($args);

        $this->errorCode = $result->ErrorCode;

        return [
            'ErrorCode' => $result->ErrorCode,
            'PacketId' => $result->PacketId,
        ];
    }

    /**
     * @param string $args
     * @return \SimpleXMLElement|string
     */
    public function sendRequest(string $args = '')
    {
        $request = $this->setEnvelope($this->setRequestBody($args));

        try {
            $client = new Client();
            $options = [
                "body" => $request,
                "headers" => [
                    "Content-Type" => "text/xml",
                    "SoapAction" => "https://webservice.asistiletisim.com.tr/SmsProxy/" . $this->getRequestType(),
                ]
            ];

            $response = $client->request("POST", $this->url . "?WSDL", $options);

            $result = $response->getBody()->getContents();

            return $this->parseXML($result);

        } catch (GuzzleException $e) {
            Log::error('Error Code: ' . $e->getCode() . " Error Message:" . $e->getMessage());
            return "Error (" . $e->getMessage() . ")";
        }

    }

    /**
     * @param $xml
     * @return \SimpleXMLElement
     */
    protected function parseXML($xml): \SimpleXMLElement
    {
        $cleanedXML = str_ireplace(["SOAP_ENV:", "SOAP:"], "", "$xml");
        $xml = simplexml_load_string($cleanedXML);
        return $xml->Body->{$this->getRequestType() . 'Response'}->{$this->getRequestType() . 'Result'};
    }

    /**
     * @param $body
     * @return string
     */
    protected function setEnvelope($body): string
    {
        $envelope = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns=\"https://webservice.asistiletisim.com.tr/SmsProxy\">";
        $envelope .= "<soapenv:Header/>";
        $envelope .= "<soapenv:Body>";
        $envelope .= $body;
        $envelope .= "</soapenv:Body>";
        $envelope .= "</soapenv:Envelope>";
        return $envelope;
    }

    /**
     * @param string $args
     * @return string
     */
    protected function setRequestBody(string $args = ''): string
    {
        $body = "<" . $this->getRequestType() . ">";
        $body .= "<requestXml>";
        $body .= "<![CDATA[";
        $body .= "<" . ucfirst($this->getRequestType()) . ">";
        $body .= "<Username>$this->username</Username>";
        $body .= "<Password>$this->password</Password>";
        $body .= "<UserCode>$this->userCode</UserCode>";
        $body .= "<AccountId>$this->accountID</AccountId>";

        if ($args) {
            $body .= $args;
        }

        $body .= "</" . ucfirst($this->getRequestType()) . ">";
        $body .= "]]>";
        $body .= "</requestXml>";
        $body .= "</" . $this->getRequestType() . ">";
        return $body;
    }

    /**
     * @param string $userCode
     */
    public function setUserCode(string $userCode): void
    {
        $this->userCode = $userCode;
    }

    /**
     * @param string $accountID
     */
    public function setAccountID(string $accountID): void
    {
        $this->accountID = $accountID;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getRequestType(): string
    {
        return $this->requestType;
    }

    /**
     * @param string $requestType
     */
    public function setRequestType(string $requestType): void
    {
        $this->requestType = $requestType;
    }

    /**
     * @param string $originator
     */
    public function setOriginator(string $originator): void
    {
        $this->originator = $originator;
    }

    /**
     * @param array $receivers
     */
    public function setReceivers(array $receivers): void
    {
        $this->receivers = $receivers;
    }

    /**
     * @return array
     */
    public function getReceivers(): array
    {
        return $this->receivers;
    }

    public function getErrorMessage(): ?string
    {
        $message = null;
        switch($this->errorCode) {
            case 0:
                $message = 'Hata Yok';
                break;
            case -1:
                $message = 'Girilen bilgilere sahip bir kullanıcı bulunamadı.';
                break;
            case -2:
                $message = 'Kullanıcı pasif durumda.';
                break;
            case -3:
                $message = 'Kullanıcı bloke durumda.';
                break;
            case -4:
                $message = 'Kullanıcı hesabı bulunamadı.';
                break;
            case -5:
                $message = 'Kullanıcı hesabı pasif durumda.';
                break;
            case -6:
                $message = 'Kayıt bulunamadı.';
                break;
            case -7:
                $message = 'Hatalı xml istek yapısı.';
                break;
            case -8:
                $message = 'Alınan parametrelerden biri veya birkaçı hatalı.';
                break;
            case -9:
                $message = 'Prepaid hesap bulunamadı.';
                break;
            case -10:
                $message = 'Operatör servisinde geçici kesinti.';
                break;
            case -11:
                $message = 'Başlangıç tarihi ve şu anki zaman arasındaki fark 30 dakikadan az.';
                break;
            case -12:
                $message = 'Bitiş tarihi ve şu anki zaman arasındaki fark 30 günden fazla..';
                break;
            case -13:
                $message = 'Geçersiz gönderici bilgisi.';
                break;
            case -14:
                $message = 'Hesaba ait SMS gönderim yetkisi bulunmuyor.';
                break;
            case -15:
                $message = 'Mesaj içeriği boş veya limit oan karakter sayısını aşıyor.';
                break;
            case -16:
                $message = 'Geçersiz alıcı bilgisi.';
                break;
            case -17:
                $message = 'Parametre adetleri ile şablon içerisindeki parametre adedi uyuşmuyor.';
                break;
            case -18:
                $message = 'Gönderim içerisinde birden fazla hata mevcut. MessageId kontrol edilmelidir.';
                break;
            case -19:
                $message = 'Mükerrer gönderim isteği.';
                break;
            case -20:
                $message = 'Bilgilendirme mesajı almak istemiyor.';
                break;
            case -21:
                $message = 'Numara karalistede.';
                break;
            case -22:
                $message = 'Yetkisiz IP Adresi';
                break;
            case -23:
                $message = 'Kullanıcı yetkisi bulunmamaktadır.';
                break;
            case -24:
                $message = 'Belirtilen paket zaten onaylanmıştır.';
                break;
            case -25:
                $message = 'Belirtilen Id için onaylanmamı bir paket bulunamadı.';
                break;
            case -26:
                $message = 'Taahüt süresi zaman aşımına uğradı.';
                break;
            case -27:
                $message = 'Taahüt miktarı aşıldı.';
                break;
            case -28:
                $message = 'Kullanıcı gönderim limiti aşıldı.';
                break;
            case -29:
                $message = 'Başlangıç tarihi bitiş tarihinden büyük olamaz.';
                break;
            case -1000:
                $message = 'Sistem hatası.';
                break;
            default:
                $message = "Bilinmeyen hata.";
                break;
        }
        return $message;
    }
}
