<?php namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //$this->insertLoginIntoFirebase($this->getUser()->getUsername(), date('Y-m-d H:i:s'));

        return $this->render(':secret:home.html.twig');
    }

    /**
     * @Route("/ecwid_login", name="ecwid_login")
     */
    public function ecwid_login(Request $request){
        $serializer = $this->get('jms_serializer');
        $objUser =  $this->get('security.token_storage')->getToken()->getUser();
        $strFullName = $objUser->getFirstName() . " " . $objUser->getLastName();
        $response["ecwid_sso_profile"] = $this->checkEcwidSignOnSession($objUser->getEmail(), $strFullName);

        return new JsonResponse(
            $serializer->serialize(
                $response,
                'json'
            ),
            Response::HTTP_OK,
            [],
        true
        );
    }

    protected function checkEcwidSignOnSession($strUserEmail, $strFullName){
        $numUserID = $this->checkIfEmailRegisteredInEcwid($strUserEmail, "secret_SPuzPcYRFffBh41AyVJ4Hf1Uv2gy5F5j", '14262098', $strFullName);
        $this->setEcwidSignOnSession($numUserID, $strUserEmail, $strFullName);

        $ecwid_sso_profile = $this->get('session')->get("ecwid_sso_profile");

        return $ecwid_sso_profile;
    }

    protected function setEcwidSignOnSession($numUserID, $strUserEmail, $strFullName){
        $user_data = array(
            'userId' => $numUserID,
            'profile' => array(
                'email' => $strUserEmail,
                'billingPerson' => array(
                    'name' => $strFullName
                )
            )
        );

        $key = "X37DpDfXQFYmvhJHjG74HXPfWBBTTZzM";
        $user_data['appClientId'] = "bmWzQL83eEQBrPkd";

        $user_data_encoded = base64_encode(json_encode($user_data));

        $time = time();
        $hmac = hash_hmac('sha1', "$user_data_encoded $time", $key);

        $sso_profile = "$user_data_encoded $hmac $time";

        $this->get('session')->set("ecwid_sso_profile", $sso_profile);
    }

    protected function checkIfEmailRegisteredInEcwid($strEmail, $strSecret, $numAppID, $strFullName){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://app.ecwid.com/api/v3/" . $numAppID . "/customers?email=" . $strEmail . "&token=" . $strSecret);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $content = trim(curl_exec($ch));
        curl_close($ch);
        $decodedContent = json_decode($content);

        if($decodedContent->total < 1){
            return $this->registerEcwidAccount($strEmail, $strSecret, $numAppID, $strFullName);
        } else {
            return $decodedContent->items[0]->id;
        }
    }

    protected function registerEcwidAccount($strEmail, $strSecret, $numAppID, $strFullName){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.ecwid.com/api/v3/" . $numAppID . "/customers?token=" . $strSecret,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "
                                        {
                                            \"email\": \"" . $strEmail . "\",
                                            \"billingPerson\": {
                                                \"name\": \"" . $strFullName . "\"
                                            }
                                        }",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $decodedResponse = json_decode($response);

            return $decodedResponse->id;
        }
    }

    public function insertLoginIntoFirebase($strUsername, $strDate){
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/../../AppBundle/firebase_service_account.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        $database = $firebase->getDatabase();

        $newLogin = $database
            ->getReference('php_fb_login_details/')
            ->push([
                'username' => $strUsername,
                'timestamp' => $strDate
            ]);
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logout()
    {

    }
}