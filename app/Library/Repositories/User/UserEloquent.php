<?php namespace Velent\Repositories\User;

use Velent\Abstracts\EloquentRepository;
use Velent\Models\User;

class UserEloquent extends EloquentRepository implements UserInterface
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function create($data)
    {
        $model = new $this->model;
        return $this->prepareData($model, $data);
    }

    private function prepareData($model, $data)
    {
        if (isset($data['firstName']) && $data['firstName']) {
            $model->first_name = $data['firstName'];
        }

        if (isset($data['lastName']) && $data['lastName']) {
            $model->last_name = $data['lastName'];
        }

        if (isset($data['email']) && $data['email']) {
            $model->email = $data['email'];
        }

        if (isset($data['password']) && $data['password']) {
            $model->password = $data['password'];
        }

        if (isset($data['photo']) && $data['photo']) {
            $model->photo = $data['photo'];
        }

        $model->save();
        return $model;
    }

    public function update($data, $id)
    {
        $model = $this->model->where('id', $id)->first();
        return $this->prepareData($model, $data);
    }

    public function getByParams($params)
    {
        $model = $this->model->getQuery();
        $model->where('is_admin', 0);
        $model->when($params['search'], function ($query) use($params){
            $query->where('first_name', 'LIKE', '%' . $params['search'] . '%');
            $query->orWhere('last_name', 'LIKE', '%' . $params['search'] . '%');
            $query->orWhere('email', 'LIKE', '%' . $params['search'] . '%');
        });

        if (isset($params['sortBy']) && isset($params['orderBy'])){
            $model->orderBy($params['orderBy'], $params['sortBy']);
        }

        if (isset($params['perPage'])){
            return $model->paginate($params['perPage']);
        }

        return $model->get();

    }

}
