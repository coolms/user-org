<?php
/**
 * CoolMS2 User Organization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-org for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserOrg\Mvc\Controller;

use Zend\Http\PhpEnvironment\Response,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\Mvc\Controller\Plugin\FlashMessenger,
    Zend\View\Model\ViewModel,
    CmsUser\Service\UserServiceAwareTrait,
    CmsUser\Service\UserServiceInterface;

class UserController extends AbstractActionController
{
    use UserServiceAwareTrait;

    /**
     * __construct
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->setUserService($userService);
    }

    /**
     * {@inheritDoc}
     */
    public function indexAction()
    {
        if ($this->cmsAuthentication()->getIdentity()->getOrgMetadata()) {
            return $this->redirect()->toRoute(null, ['action' => 'update']);
        }

        return $this->redirect()->toRoute(null, ['action' => 'create']);
    }

    /**
     * Creates user's job info
     *
     * @return ViewModel|Response
     */
    public function createAction()
    {
        $identity = $this->cmsAuthentication()->getIdentity();
        if ($identity->getOrgMetadata()->count()) {
            return $this->redirect()->toRoute(null, ['action' => 'update']);
        }

        $url = $this->url()->fromRoute(null, ['action' => 'create']);
        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $post = $prg;
        } else {
            $post = [];
        }

        $form = $this->getUserService()->getForm();
        $form->setAttribute('action', $url);
        $form->setElementGroup([
            'orgMetadata' => [
                'description',
                'annotation',
                'organization',
                'position',
                'experience',
                'contactMetadata' => [
                    'phones',
                    'emails',
                    'messengers',
                ],
            ],
        ]);
        $form->bind($identity);

        $viewModel = new ViewModel();

        if ($post && $form->setData($post)->isValid()) {
            $identity = $form->getData();
            $this->getUserService()->getMapper()->save($identity);

            $this->flashMessenger()
                ->setNamespace($form->getName() . '-' . FlashMessenger::NAMESPACE_SUCCESS)
                ->addMessage('Data has been successfully saved');

            if ($identity->getOrgMetadata()->count()) {
                $url = $this->url()->fromRoute(null, ['action' => 'update']);
                $form->setAttribute('action', $url);
                $viewModel->setTemplate('cms-user-org/user/update');
            }
        }

        return $viewModel->setVariables(compact('form'));
    }

    /**
     * Updates user's job info
     *
     * @return ViewModel|Response
     */
    public function updateAction()
    {
        $identity = $this->cmsAuthentication()->getIdentity();
        if (!$identity->getOrgMetadata()->count()) {
            return $this->redirect()->toRoute(null, ['action' => 'create']);
        }

        $url = $this->url()->fromRoute(null, ['action' => 'update']);
        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $post = $prg;
        } else {
            $post = [];
        }

        $form = $this->getUserService()->getForm();
        $form->setAttribute('action', $url);
        $form->setElementGroup([
            'orgMetadata' => [
                'description',
                'annotation',
                'organization',
                'position',
                'experience',
                'contactMetadata' => [
                    'phones',
                    'emails',
                    'messengers',
                ],
            ],
        ]);
        $form->bind($identity);

        $viewModel = new ViewModel();

        if ($post && $form->setData($post)->isValid()) {
            $identity = $form->getData();
            $this->getUserService()->getMapper()->save($identity);

            $this->flashMessenger()
                ->setNamespace($form->getName() . '-' . FlashMessenger::NAMESPACE_SUCCESS)
                ->addMessage('Data has been successfully saved');

            if (!$identity->getOrgMetadata()->count()) {
                $url = $this->url()->fromRoute(null, ['action' => 'create']);
                $form->setAttribute('action', $url);
                $viewModel->setTemplate('cms-user-org/user/create');
            }
        }

        return $viewModel->setVariables(compact('form'));
    }
}
