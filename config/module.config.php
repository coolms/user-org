<?php
/**
 * CoolMS2 User Organization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-org for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserOrg;

return [
    'cmspermissions' => [
        'acl' => [
            'guards' => [
                'CmsAcl\Guard\Route' => [
                    ['route' => 'cms-user/org', 'roles' => ['user'], 'assertion' => ['CmsUserOrg\Acl\UserActionAssertion']],
                    ['route' => 'cms-admin/user/org', 'roles' => ['admin']],
                ],
            ],
            'assertion_manager' => [
                'factories' => [
                    'CmsUserOrg\Acl\UserActionAssertion' => 'CmsUserOrg\Factory\Acl\UserActionAssertionFactory',
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'CmsUserOrg\Controller\Admin' => 'CmsUserOrg\Mvc\Controller\AdminController',
            'CmsUserOrg\Controller\User' => 'CmsUserOrg\Mvc\Controller\UserController',
        ],
        'factories' => [
            'CmsUserOrg\Mvc\Controller\UserController' => 'CmsUserOrg\Factory\Controller\UserControllerFactory',
        ],
        'invokables' => [
            'CmsUserOrg\Mvc\Controller\AdminController' => 'CmsUserOrg\Mvc\Controller\AdminController',
        ],
    ],
    'navigation' => [
        'cmsuser' => [
            [
                'label' => 'Add job data',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-user/org',
                'params' => ['action' => 'create'],
                'resource' => 'route/cms-user/org',
                'privilege' => 'create',
                'order' => 750,
                'twbs' => [
                    'icon' => [
                        'type' => 'fa',
                        'content' => 'pencil',
                        'placement' => 'prepend',
                        'tagName' => 'i',
                    ],
                ],
            ],
            [
                'label' => 'Edit job data',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-user/org',
                'params' => ['action' => 'update'],
                'resource' => 'route/cms-user/org',
                'privilege' => 'update',
                'order' => 750,
                'twbs' => [
                    'icon' => [
                        'type' => 'fa',
                        'content' => 'pencil',
                        'placement' => 'prepend',
                        'tagName' => 'i',
                    ],
                ],
            ],
            [
                'order' => 800,
                'uri' => '',
                'class' => 'divider',
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'cms-user' => [
                'child_routes' => [
                    'org' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/org[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z\-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'CmsUserOrg\Controller',
                                'controller' => 'User',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'cms-admin' => [
                'child_routes' => [
                    'user' => [
                        'child_routes' => [
                            'org' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/org[/:controller[/:action[/:id]]]',
                                    'constraints' => [
                                        'controller' => '[a-zA-Z\-]*',
                                        'action' => '[a-zA-Z\-]*',
                                        'id' => '[a-zA-Z0-9\-]*',
                                    ],
                                    'defaults' => [
                                        '__NAMESPACE__' => 'CmsUserOrg\Controller',
                                        'controller' => 'Admin',
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => __NAMESPACE__,
            ],
            [
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            'CmsUserOrgTerminationDate' => 'CmsUserOrg\Factory\Validator\TerminationDateValidatorFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
];
