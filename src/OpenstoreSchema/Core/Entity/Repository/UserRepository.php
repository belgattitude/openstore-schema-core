<?php

namespace OpenstoreSchema\Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * Get all roles hierachically.
     */
    public function getAllRoles()
    {
        $roles = [];
        $repo = $this->em->getRepository('OpenstoreSchema\Core\Entity\Role');

        foreach ($user->getRoles() as $role) {
            $roles[] = $role->getName();
            // all parents of this role
            foreach ($repo->getPath($role) as $parent) {
                $roles[] = $parent->getName();
            }
        }
        $roles = array_unique($roles);
        var_dump($roles);
        die();
        //var_dump($user->getRoles()[0]->getName());
    }

    /**
     * @param InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFiler = $inputFilter;
    }

    /**
     * @return InputFilterInterface $inputFilter
     */
    public function getInputFilter()
    {
        $md = $this->getClassMetadata();
        var_dump($md);
        die();

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput([
                        'name' => 'reference',
                        'required' => true,
                        'filters' => [
                            ['name' => 'StripTags'],
                            ['name' => 'StringTrim'],
                        ],
                        'validators' => [
                            [
                                'name' => 'StringLength',
                                'options' => [
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 60,
                                ],
                            ],
                        ],
                    ]));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
