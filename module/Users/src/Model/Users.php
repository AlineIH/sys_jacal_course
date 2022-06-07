<?php
namespace Users\Model;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Users implements InputFilterAwareInterface
{
    public $usr_users_id;
    public $usr_name;
    public $usr_middle_name;
    public $usr_email;
    public $usr_status;
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->usr_users_id = !empty($data['usr_users_id']) ? $data['usr_users_id'] : null;
        $this->usr_name = !empty($data['usr_name']) ? $data['usr_name'] : null;
        $this->usr_middle_name = !empty($data['usr_middle_name']) ? $data['usr_middle_name'] : null;
        $this->usr_email = !empty($data['usr_email']) ? $data['usr_email'] : null;
        $this->usr_status = !empty($data['usr_status']) ? $data['usr_status'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \DomainException(sprintf(
            '%s does not allow injection of an alternate input filter', __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'usr_users_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'usr_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 50
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'usr_middle_name',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 50
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'usr_email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 150
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function getArrayCopy(): array
    {
        return [
            'usr_users_id'     => $this->usr_users_id,
            'usr_name' => $this->usr_name,
            'usr_middle_name'  => $this->usr_middle_name,
            'usr_email'  => $this->usr_email,
        ];
    }
}