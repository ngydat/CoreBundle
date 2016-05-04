<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Controller\API\Admin;

use JMS\DiExtraBundle\Annotation as DI;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use Claroline\CoreBundle\Manager\OauthManager;




/**
 * @NamePrefix("client_")
 */
class ClientController extends FOSRestController {

	 private $oauthManager;

	/**
    * @DI\InjectParams({
    *     "oauthManager" = @DI\Inject("claroline.manager.oauth_manager")
    * })
    */
   public function _construct(OauthManager $oauthManager){
     $this->oauthManager = $oauthManager;
   }


   /**
    * @View()
    */
    public function getIdsecretAction(){
      $arr = $this->oauthManager->findVisibleClients();
      $client = $arr[0];
      $clientId = $client->getConcatRandomId();
      $clientSecret = $client->getSecret();

			 $tab = $client->getAccessTokens(); // all access tokens
			 $isExpired = $tab[count($tab)-1]->hasExpired(); //check if the most recent access token has expired

      $result = array('client_id' => $clientId, 'client_secret' =>$clientSecret, 'hasExpired'=>$isExpired);
      return $result;

    }


}
