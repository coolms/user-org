<?php
/**
 * CoolMS2 User Organization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-org for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserOrg\Factory\Validator;

use Zend\Filter\DateSelect as DateSelectFilter,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Validator\Callback,
    Zend\Validator\ValidatorChain;

class TerminationDateValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $validators)
    {
        $validatorChain = new ValidatorChain();

        $validatorChain->attachByName('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'Termination date must be greater'
                    . ' than the date of employment',
            ],
            'callback' => function($value, $context = [])
            {
                if ($value && isset($context['since'])) {
                    $filter = new DateSelectFilter();
                    return (new \DateTime($value)) > new \DateTime($filter->filter($context['since']));
                }

                return true;
            },
        ], true);

        return $validatorChain;
    }
}
