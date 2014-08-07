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

class OfficialtextController extends FOSRestController
{
    /**
     * List all officialtexts.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing officialtexts.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="100", description="How many officialtexts to return.")
     *
     * @Annotations\View(
     *  templateVar="officialtexts"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getOfficialtextsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('n1c0_officialtext.manager.officialtext')->all($limit, $offset);
    }

    /**
     * Get single Officialtext.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Officialtext for a given id",
     *   output = "N1c0\OfficialtextBundle\Entity\Officialtext",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the officialtext is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="officialtext")
     *
     * @param int     $id      the officialtext id
     *
     * @return array
     *
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function getOfficialtextAction($id)
    {
        $officialtext = $this->getOr404($id);

        return $officialtext;
    }

    /**
     * Presents the form to use to create a new officialtext.
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
     * @return FormTypeInterface
     */
    public function newOfficialtextAction()
    {
        return $form = $this->container->get('n1c0_officialtext.form_factory.officialtext')->createForm();
    }

    /**
     * Edits a officialtext.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * 
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Officialtext:editOfficialtext.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param int     $id      the officialtext id
     * @return FormTypeInterface
     */
    public function editOfficialtextAction($id)
    {
        $officialtext = $this->getOr404($id);
        $form = $this->container->get('n1c0_officialtext.form_factory.officialtext')->createForm();
        $form->setData($officialtext);
    
        return array(
            'form' => $form, 
            'id'=>$id
        );
    }

    /**
     * Create a Officialtext from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new officialtext from the submitted data.",
     *   input = "N1c0\OfficialtextBundle\Form\OfficialtextType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Officialtext:newOfficialtext.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postOfficialtextAction(Request $request)
    {
        try {
            $officialtextManager = $this->container->get('n1c0_officialtext.manager.officialtext');
            $officialtext = $officialtextManager->createOfficialtext();

            $form = $this->container->get('n1c0_officialtext.form_factory.officialtext')->createForm();
            $form->setData($officialtext);

            if ('POST' === $request->getMethod()) {
                $form->bind($request);

                if ($form->isValid()) {
                    $officialtextManager->saveOfficialtext($officialtext);
                
                    $routeOptions = array(
                        'id' => $form->getData()->getId(),
                        '_format' => $request->get('_format')
                    );

                    // Add a method onCreateOfficialtextSuccess(FormInterface $form)
                    return $this->routeRedirectView('api_1_get_officialtext', $routeOptions, Codes::HTTP_CREATED);
                }
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        // Add a method onCreateOfficialtextError(FormInterface $form)
        return new Response(sprintf("Error of the officialtext id '%s'.", $form->getData()->getId()), Codes::HTTP_BAD_REQUEST);

    }

    /**
     * Update existing officialtext from the submitted data or create a new officialtext at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Updates a officialtext.",
     *   input = "N1c0\DemoBundle\Form\OfficialtextType",
     *   statusCodes = {
     *     200 = "Returned when the Officialtext is updated",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Officialtext:editOfficialtext.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the officialtext id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function putOfficialtextAction(Request $request, $id)
    {
        try {
            $officialtext = $this->getOr404($id);

            $form = $this->container->get('n1c0_officialtext.form_factory.officialtext')->createForm();
            $form->setData($officialtext);
            $form->bind($request);

            if ($form->isValid()) {
                $officialtextManager = $this->container->get('n1c0_officialtext.manager.officialtext');
                if($officialtextManager->saveOfficialtext($officialtext) !== false) {
                    $routeOptions = array(
                        'id' => $officialtext->getId(),
                        '_format' => $request->get('_format')
                    );

                    return $this->routeRedirectView('api_1_get_officialtext', $routeOptions, Codes::HTTP_OK); // Must return 200 for ajax request
                }
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        // Add a method onCreateOfficialtextError(FormInterface $form)
        return new Response(sprintf("Error of the officialtext id '%s'.", $form->getData()->getId()), Codes::HTTP_BAD_REQUEST);
    }

    /**
     * Update existing officialtext from the submitted data or create a new officialtext at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Updates a officialtext.",
     *   input = "N1c0\DemoBundle\Form\OfficialtextType",
     *   statusCodes = {
     *     200 = "Returned when the Officialtext is updated",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "N1c0OfficialtextBundle:Officialtext:editOfficialtext.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the officialtext id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function patchOfficialtextAction(Request $request, $id)
    {
        try {
            $officialtext = $this->getOr404($id);

            $form = $this->container->get('n1c0_officialtext.form_factory.officialtext')->createForm();
            $form->setData($officialtext);
            $form->bind($request);

            if ($form->isValid()) {
                $officialtextManager = $this->container->get('n1c0_officialtext.manager.officialtext');
                if($officialtextManager->saveOfficialtext($officialtext) !== false) {
                    $routeOptions = array(
                        'id' => $officialtext->getId(),
                        '_format' => $request->get('_format')
                    );

                    return $this->routeRedirectView('api_1_get_officialtext', $routeOptions, Codes::HTTP_OK); // Must return 200 for ajax request
                }
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        // Add a method onCreateOfficialtextError(FormInterface $form)
        return new Response(sprintf("Error of the officialtext id '%s'.", $form->getData()->getId()), Codes::HTTP_BAD_REQUEST);
    }

    /**
     * Get thread for the officialtext.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a comment thread",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @Annotations\View(templateVar="thread")
     *
     * @param int     $id      the officialtext uuid
     *
     * @return array
     */
    public function getOfficialtextThreadAction($id)
    {
        return $this->container->get('n1c0_officialtext.comment.officialtext_comment.default')->getThread($id);
    }

    /**
     * Fetch a Officialtext or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return OfficialtextInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $officialtext;
    }

    /**
     * Get download for the officialtext.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a download officialtext",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @Annotations\View(templateVar="officialtext")
     *
     * @param int     $id      the officialtext uuid
     *
     * @return array
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function getOfficialtextDownloadAction($id)
    {
        if (!($officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id))) {
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
            'formats' => $formats,
            'id' => $id
        );
    }

    /**
     * Convert the officialtext in pdf format.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Convert the officialtext",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @param int     $id      the officialtext uuid
     * @param string  $format  the format to convert officialtext 
     *
     * @return Response
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function getOfficialtextConvertAction($id, $format)
    {
        if (!($officialtext = $this->container->get('n1c0_officialtext.manager.officialtext')->findOfficialtextById($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        $officialtextConvert = $this->container->get('n1c0_officialtext.officialtext.download')->getConvert($id, $format);

        $response = new Response();
        $response->setContent($officialtextConvert);
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
        $response->headers->set('Content-disposition', 'filename='.$officialtext->getTitle().'.'.$ext);
         
        return $response;
    }
    
    /**
     * Get logs of a single Officialtext.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets lofs of a Officialtext for a given id",
     *   output = "Gedmo\Loggable\Entity\LogEntry",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the officialtext is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="officialtext")
     *
     * @param int     $id      the officialtext id
     *
     * @return array
     *
     * @throws NotFoundHttpException when officialtext not exist
     */
    public function logsOfficialtextAction($id)
    {
        $officialtext = $this->getOr404($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $entity = $em->find('Entity\Officialtext', $officialtext->getId());
        $logs = $repo->getLogEntries($entity);
        
        return $logs;
    }
}
