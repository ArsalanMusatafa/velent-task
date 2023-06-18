<?php namespace Velent\Repositories\User;

use Velent\Abstracts\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function create($data);

    public function update($data, $id);

    public function getByParams($params);

}
