<?php namespace Velent\Abstracts;

interface RepositoryInterface
{
    public function all($fields=[]);

    public function getById($id, array $with = []);

    public function delete ($id);
}
