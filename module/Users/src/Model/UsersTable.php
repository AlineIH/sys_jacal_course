<?php

namespace Users\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class UsersTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUsers($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['usr_users_id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Registro no encontrado %d',
                $id
            ));
        }

        return $row;
    }

    public function saveUsers(Users $user)
    {
        $data = [
        'usr_users_id' => $user->usr_users_id,
        'usr_name' => $user->usr_name,
        'usr_middle_name' => $user->usr_middle_name,
        'usr_email' => $user->usr_email,
        'usr_status' => $user->usr_status,
        ];

        $id = (int) $user->usr_users_id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getUsers($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUsers($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}