<?php

namespace Users\Form;

use Laminas\Form\Form;

class UsersForm extends Form
{
    /** Constructor. */
    public function __construct()
    {
        parent::__construct('users');

        $this->add([
            'name' => 'usr_users_id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'usr_name',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre'
            ]
        ]);
        $this->add([
            'name' => 'usr_middle_name',
            'type' => 'text',
            'options' => [
                'label' => 'Segundo nombre'
            ]
        ]);
        $this->add([
            'name' => 'usr_email',
            'type' => 'text',
            'options' => [
                'label' => 'Correo electrónico'
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ]
        ]);
    }
}