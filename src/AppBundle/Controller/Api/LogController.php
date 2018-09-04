<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\Feedback;
use AppBundle\Entity\Log;
use AppBundle\Entity\SystemInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{

    /**
     * @Route("/uploadLog", name="api_upload_log")
     * @Method({"POST"})
     */
    public function uploadLog(Request $request)
    {
        $map = json_decode($request->getContent(), true);

        /* foreach ($map as $key => $value) {
            echo "Key: $key; Value: $value\n";
        } */
        /* $repo = $this->getDoctrine()->getRepository('AppBundle:Feedback');
        $repo->addFeedback($map); */

        // print_r($map['logs']);
        /* foreach ($map['logs'] as &$value) {
            echo $value['log'];
        } */

        $fb = new Feedback();
        $fb->setMessage($map['message']);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($fb);
        $em->flush();

        // echo $fb->getId();

        foreach ($map['logs'] as &$value) {
            $log = new Log();
            $log->setLog($value['log']);
            $log->setTimestamp($value['timestamp']);
            $log->setSystemInfoTimestamp($value['systemInfoTimestamp']);
            $log->setFeedbackFk($fb->getId());
            $em->persist($log);
        }

        foreach ($map['systemInfos'] as &$value) {
            $systemInfo = new SystemInfo();
            $systemInfo->setVersionCode($value['versionCode']);
            $systemInfo->setVersionName($value['versionName']);
            $systemInfo->setTimestamp($value['timestamp']);
            $systemInfo->setLocale($value['locale']);
            $systemInfo->setBrand($value['brand']);
            $systemInfo->setModel($value['model']);
            $systemInfo->setOsVersion($value['osVersion']);
            $systemInfo->setUserName($value['userName']);
            $systemInfo->setFeedbackFk($fb->getId());
            $em->persist($systemInfo);
        }
        $em->flush();

        /* return new JsonResponse(
            $serializer->serialize($..., 'json'),
            Response::HTTP_OK,
            [],
            true
        ); */
        return new Response();
    }

}
