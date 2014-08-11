<?php

namespace N1c0\OfficialtextBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use N1c0\OfficialtextBundle\Exception\InvalidFormException;
use N1c0\OfficialtextBundle\Form\OfficialtextType;
use N1c0\OfficialtextBundle\Model\OfficialtextInterface;
use N1c0\OfficialtextBundle\Form\AuthorsrcType;
use N1c0\OfficialtextBundle\Model\AuthorsrcInterface;

class AuthorsrcController extends FOSRestController
{
    /**
     * Get single Authorsrc.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Authorsrc for a given id",
     *   output = "N1c0\OfficialtextBundle\Entity\Authorsrc",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the authorsrc or the officialtext is not found"
     *   }
     * )
     *
     *
     * @Annotations\View(templateVar="authorsrc")
     *
     * @param int                   $id                   the officialtext id
     * @param int                   $authorsrcId           the authorsrc id
     *
     * @return array
     *
     * @throws NotFoundHttpException when authorsrc not exist
     */
    public function getAuthorsrcAction($id, $authorsrcId)
    {
        $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
        if (!$officialtext) {
            throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
        }
        
        return $this->getOr404($authorsrcId);
    }

    /**
     * Get the authorsrcs of a officialtext.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing authorsrcs.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many authorsrcs to return.")
     *
     * @Annotations\View(
     *  templateVar="authorsrc"
     * )
     *
     * @param int                   $id           the officialtext id
     *
     * @return array
     */
    public function getAuthorsrcsAction($id)
    {
        $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
        if (!$officialtext) {
            throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
        }

        return $officialtext->getAuthorsrc();
    }

    /**
     * Presents the form to use to create a new authorsrc.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @param int                   $id           the officialtext id
     *
     * @return FormTypeInterface
     */
    public function newAuthorsrcAction($id)
    {
        $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
        if (!$officialtext) {
            throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
        }

        $authorsrc = $this->container->get('n1c0_officialtext.manager.authorsrc')->createAuthorsrc($officialtext);

        $form = $this->container->get('n1c0_officialtext.form_factory.authorsrc')->createForm();
        $form->setData($authorsrc);

        return array(
            'form' => $form, 
            'id' => $id
        );
    }

    /**
     * Edits an authorsrc.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * 
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Authorsrc:editAuthorsrc.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param int     $id                       the officialtext id
     * @param int     $authorsrcId           the authorsrc id
     *
     * @return FormTypeInterface
     */
    public function editAuthorsrcAction($id, $authorsrcId)
    {
        $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
        if (!$officialtext) {
            throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
        }
        $authorsrc = $this->getOr404($authorsrcId);

        $form = $this->container->get('n1c0_officialtext.form_factory.authorsrc')->createForm();
        $form->setData($authorsrc);
    
        return array(
            'form'           => $form,
            'id'             => $id,
            'authorsrcId'    => $authorsrc->getId()
        );
    }


    /**
     * Creates a new Authorsrc for the Officialtext from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new authorsrc for the officialtext from the submitted data.",
     *   input = "N1c0\OfficialtextBundle\Form\AuthorsrcType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Authorsrc:newAuthorsrc.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param string  $id      The id of the officialtext 
     *
     * @return FormTypeInterface|View
     */
    public function postAuthorsrcAction(Request $request, $id)
    {
        try {
            $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
            if (!$officialtext) {
                throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
            }

            $authorsrcManager = $this->container->get('n1c0_officialtext.manager.authorsrc');
            $authorsrc = $authorsrcManager->createAuthorsrc($officialtext);

            $form = $this->container->get('n1c0_officialtext.form_factory.authorsrc')->createForm();
            $form->setData($authorsrc);

            if ('POST' === $request->getMethod()) {
                $form->bind($request);

                if ($form->isValid()) {
                    $authorsrcManager->saveAuthorsrc($authorsrc);
                
                    $routeOptions = array(
                        'id' => $id,
                        'authorsrcId' => $form->getData()->getId(),
                        '_format' => $request->get('_format')
                    );

                    $response['success'] = true;
                    
                    $request = $this->container->get('request');
                    $isAjax = $request->isXmlHttpRequest();

                    if($isAjax == false) { 
                        // Add a method onCreateAuthorsrcSuccess(FormInterface $form)
                        return $this->routeRedirectView('api_1_get_officialtext_authorsrc', $routeOptions, Codes::HTTP_CREATED);
                    }
                } else {
                    $response['success'] = false;
                }
                return new JsonResponse($response);
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing authorsrc from the submitted data or create a new authorsrc at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "N1c0\DemoBundle\Form\AuthorsrcType",
     *   statusCodes = {
     *     201 = "Returned when the Authorsrc is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Authorsrc:editOfficialtextAuthorsrc.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request         the request object
     * @param string  $id              the id of the officialtext 
     * @param int     $authorsrcId      the authorsrc id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when authorsrc not exist
     */
    public function putAuthorsrcAction(Request $request, $id, $authorsrcId)
    {
        try {
            $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
            if (!$officialtext) {
                throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
            }

            $authorsrc = $this->getOr404($authorsrcId);

            $form = $this->container->get('n1c0_officialtext.form_factory.authorsrc')->createForm();
            $form->setData($authorsrc);
            $form->bind($request);

            if ($form->isValid()) {
                $authorsrcManager = $this->container->get('n1c0_officialtext.manager.authorsrc');
                if ($authorsrcManager->saveAuthorsrc($authorsrc) !== false) {
                    $routeOptions = array(
                        'id' => $officialtext->getId(),                  
                        '_format' => $request->get('_format')
                    );

                    return $this->routeRedirectView('api_1_get_officialtext', $routeOptions, Codes::HTTP_OK);
                }
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing authorsrc for a officialtext from the submitted data or create a new authorsrc at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "N1c0\DemoBundle\Form\AuthorsrcType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Authorsrc:editOfficialtextAuthorsrc.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request         the request object
     * @param string  $id              the id of the officialtext 
     * @param int     $authorsrcId      the authorsrc id

     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when authorsrc not exist
     */
    public function patchAuthorsrcAction(Request $request, $id, $authorsrcId)
    {
        try {
            $officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id);
            if (!$officialtext) {
                throw new NotFoundHttpException(sprintf('Officialtext with identifier of "%s" does not exist', $id));
            }

            $authorsrc = $this->getOr404($authorsrcId);

            $form = $this->container->get('n1c0_officialtext.form_factory.authorsrc')->createForm();
            $form->setData($authorsrc);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $authorsrcManager = $this->container->get('n1c0_officialtext.manager.authorsrc');
                if ($authorsrcManager->saveAuthorsrc($authorsrc) !== false) {
                    $routeOptions = array(
                        'id' => $officialtext->getId(),                  
                        '_format' => $request->get('_format')
                    );

                    return $this->routeRedirectView('api_1_get_officialtext', $routeOptions, Codes::HTTP_CREATED);
                }
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }   
    }

    /**
     * Get thread for an authorsrc.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a authorsrc thread",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @Annotations\View(templateVar="thread")
     *
     * @param int     $id               the officialtext id
     * @param int     $authorsrcId       the authorsrc id
     *
     * @return array
     */
    public function getAuthorsrcThreadAction($id, $authorsrcId)
    {
        return $this->container->get('n1c0_officialtext.comment.officialtext_comment.default')->getThread($authorsrcId);
    }

    /**
     * Fetch a Authorsrc or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return AuthorsrcInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($authorsrc = $this->container->get('n1c0_officialtext.manager.authorsrc')->findAuthorsrcById($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $authorsrc;
    }

    /**
     * Get download for the authorsrc.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a download authorsrc",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @Annotations\View(templateVar="authorsrc")
     *
     * @param int     $id                  the officialtext uuid
     * @param int     $authorsrcId      the authorsrc uuid
     *
     * @return array
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function getAuthorsrcDownloadAction($id, $authorsrcId)
    {
        if (!($officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        if (!($authorsrc = $this->container->get('n1c0_officialtext.manager.authorsrc')->findAuthorsrcById($authorsrcId))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }


        $formats = array(
            "native",
            "json",
            "docx",
            "odt",
            "epub",
            "epub3",
            "fb2",
            "html",
            "html5",
            "slidy",
            "dzslides",
            "docbook",
            "opendocument",
            "latex",
            "beamer",
            "context",
            "texinfo",
            "markdown",
            "pdf",
            "plain",
            "rst",
            "mediawiki",
            "textile",
            "rtf",
            "org",
            "asciidoc"
        );

        return array(
            'formats'        => $formats, 
            'id'             => $id,
            'authorsrcId' => $authorsrcId
        );
    }

    /**
     * Convert the authorsrc in pdf format.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Convert the authorsrc",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @param int     $id                  the officialtext uuid
     * @param int     $authorsrcId      the authorsrc uuid
     * @param string  $format              the format to convert officialtext 
     *
     * @return Response
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function getAuthorsrcConvertAction($id, $authorsrcId, $format)
    {
        if (!($officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id))) {
            throw new NotFoundHttpException(sprintf('The officialtext with the id \'%s\' was not found.',$id));
        }

        if (!($authorsrc = $this->container->get('n1c0_officialtext.manager.authorsrc')->findAuthorsrcById($authorsrcId))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        $authorsrcConvert = $this->container->get('n1c0_officialtext.authorsrc.download')->getConvert($authorsrcId, $format);

        $response = new Response();
        $response->setContent($authorsrcConvert);
        $response->headers->set('Content-Type', 'application/force-download');
        switch ($format) {
            case "native":
                $ext = "";
            break;
            case "s5":
                $ext = "html";
            break;
            case "slidy":
                $ext = "html";
            break;
            case "slideous":
                $ext = "html";
            break;
            case "dzslides":
                $ext = "html";
            break;
            case "latex":
                $ext = "tex";
            break;
            case "context":
                $ext = "tex";
            break;
            case "beamer":
                $ext = "pdf";
            break;
            case "rst":
                $ext = "text";
            break;
            case "docbook":
                $ext = "db";
            break;
            case "man":
                $ext = "";
            break;
            case "asciidoc":
                $ext = "txt";
            break;
            case "markdown":
                $ext = "md";
            break;
            case "epub3":
                $ext = "epub";
            break;
            default:
                $ext = $format;       
        }
   
        $response->headers->set('Content-disposition', 'filename='.$authorsrc->getTitle().'.'.$ext);
         
        return $response;
    }

}
