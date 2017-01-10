<?php

namespace OpenstoreSchema\Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SaleOrderRepository extends EntityRepository
{
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
