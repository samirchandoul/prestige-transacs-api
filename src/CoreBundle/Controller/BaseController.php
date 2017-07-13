<?php


namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class BaseController
 * @package CoreBundle\Controller
 */
class BaseController extends Controller
{


    /**
     * Get Form Errors
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function getFormErrors($form)
    {
        $errors = array();
        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }
        // Fields
        foreach ($form as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }
        return [
            "_code" => 1,
            "error" => $errors
        ];
    }

    /**
     * @return \Doctrine\ORM\EntityManager|object
     */
    public function em()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \JMS\Serializer\Serializer|object|\Symfony\Component\Serializer\Serializer
     */
    public function serializer()
    {
        return $this->get('serializer');
    }


    /**
     * @param UploadedFile $file
     * @param $tr_uid
     * @return string
     */
    protected function uploadLogo($file, $tr_uid)
    {
        $filePath = null;

        if ($file) {
            $rootDir = $this->get('kernel')->getRootDir();
            $path = "{$rootDir}/../web/{$this->getParameter('logo_config')['pathUpload']}";

            // Delete old Logo
            $fileSystem = new Filesystem();
            $oldImage = glob("{$path}/logo_*");
            foreach ($oldImage as $item) {
                $fileSystem->remove($item);
            }

            $filePath = "{$path}/logo_{$tr_uid}.{$file->getClientOriginalExtension()}";
            $file->move($path, $filePath);
        }
        return $filePath;
    }

    /**
     * @param Request $request
     * @param $tr_uid
     * @return string
     */
    public function getLogo(Request $request, $tr_uid)
    {
        $logoLink = null;
        if (!is_null($tr_uid)) {
            $rootDir = $this->get('kernel')->getRootDir();
            $path = "{$rootDir}/../web/{$this->getParameter('logo_config')['pathUpload']}";

            $image = glob("{$path}/logo_{$tr_uid}.*");

            if (!empty($image)) {
                $nameImg = "logo_{$tr_uid}";
                $extention = explode($nameImg, (string)$image[0]);
                $logoLink = $request->getSchemeAndHttpHost() .
                    $request->getBasePath() .
                    "/{$this->getParameter('logo_config')['pathUpload']}" .
                    "/logo_{$tr_uid}{$extention[1]}";
            }
        }
        return $logoLink;
    }
}