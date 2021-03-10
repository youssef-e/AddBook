<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Form\FormInterface;


trait ControllerTraits
{
    protected function Json($data, $status = Response::HTTP_OK, $headers = [], $context = []) :JsonResponse
    {
        if ($this->container->has('jms_serializer')) {
            $json = $this->container->get('jms_serializer')->serialize($data, 'json');
            return new JsonResponse($json, $status, $headers, true);
        }

        $this->json($data,$status,$headers,$context);
    }

    protected function Ok($data) : JsonResponse {
        return $this->Json($data,Response::HTTP_OK);
    }

    protected function NotFound() : JsonResponse {
        return $this->Json(["error"=>"entity not found"],Response::HTTP_NOT_FOUND);
    }

    protected function Deleted() : JsonResponse {
        return $this->Json(null,Response::HTTP_NO_CONTENT);
    }

        protected function Created($data) : JsonResponse {
        return $this->Json($data,Response::HTTP_CREATED);
    }

    protected function Error($data) : JsonResponse {
        return $this->Json($data,Response::HTTP_BAD_REQUEST);
    }

    protected function FormError(FormInterface $form) : JsonResponse {
        return $this->Error($this->getErrorsFromForm($form));
    }

    private function getErrorsFromForm(FormInterface $form) : array
    {
        $errors = [];
        
        foreach ($form->getErrors() as $error) 
        {
            $errors[] = $error->getMessage();
        }
        
        foreach ($form->all() as $childForm)
        {
            if (!$childForm instanceof FormInterface) 
            {
                continue;
            }
            $errors[$childForm->getName()] = $this->getErrorsFromForm($childForm);
        }
        return $errors;
    }
}
