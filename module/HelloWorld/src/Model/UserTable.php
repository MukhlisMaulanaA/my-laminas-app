<?php

namespace HelloWorld\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class UserTable
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

  public function getUser($id)
  {
    $id = (int) $id;
    $rowset = $this->tableGateway->select(['id' => $id]);
    $row = $rowset->current();
    if (!$row) {
      throw new RuntimeException(sprintf(
        'Could not find row with identifier %d',
        $id
      ));
    }

    return $row;
  }

  public function createUser(User $user)
  {
    $data = [
      'name' => $user->name,
      'email' => $user->email,
    ];

    $id = (int) $user->id;

    if ($id === 0) {
      $this->tableGateway->insert($data);
      return;
    }

    if (!$this->getUser($id)) {
      throw new RuntimeException(sprintf(
        'Cannot update user with identifier %d; does not exist',
        $id
      ));
    }

    $this->tableGateway->update($data, ['id' => $id]);
  }

  public function deleteUser($id)
  {
    $this->tableGateway->delete(['id' => (int) $id]);
  }

  public function fetchByUsername($username)
  {
    $rowset = $this->tableGateway->select(['username' => $username]);
    return $rowset->current();

    // if (!$user) {
    //   throw new RuntimeException('User not found');
    // }

    // return $user;
  }

  public function saveUser(User $user)
  {
    $data = $user->getArrayCopy();

    if ($user->id) {
      $this->tableGateway->update($data, ['id' => $user->id]);
    } else {
      $this->tableGateway->insert($data);
    }
  }
}
