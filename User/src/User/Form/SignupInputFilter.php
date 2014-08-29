<?php

namespace User\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use DoctrineModule\Validator\NoObjectExists;
use Zend\ServiceManager\ServiceManager;

class SignupInputFilter extends InputFilter
{
    public function __construct(ServiceManager $sm)
    {
//        $username = new Input('username');
        $objectManager = $sm->get('Doctrine\ORM\EntityManager');
        $userRepository = $objectManager->getRepository('User\Entity\User');
        $recordExistsOptions = array(
            'object_repository' => $userRepository,
            'fields'            => 'username'
        );
        $recordExistsValidator = new NoObjectExists($recordExistsOptions);
        $recordExistsValidator->setMessage(
            'User with this login already exists',
            NoObjectExists::ERROR_OBJECT_FOUND
        );
//        $username->getValidatorChain()->attach($recordExistsValidator);
//        $this->add($username);

        $this->add(array(
            'name' => 'username',
            'required' => true,
            'validators' => array(
                $recordExistsValidator,
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 100,
                    ),
                )
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),

        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
                array(
                    'name' => 'Db\NoRecordExists',
                    'options' => array(
                        'table' => $objectManager->getClassMetadata('User\Entity\User')->getTableName(),
                        'field' => 'email',
                        'adapter' => $sm->get('Db\Adapter')
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 25,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'repeat-password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 25,
                    ),
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password'
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
    }
}
