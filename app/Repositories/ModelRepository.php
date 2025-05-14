<?php

namespace App\Repositories;

class ModelRepository extends BaseApiRepository implements ModelRepositoryInterface
{

    public function httpGetModels()
    {
        $this->setHeaderToken();
        return $this->get('/api/support/model/');
    }

    public function httpCreateModel($data)
    {
        $this->setHeaderToken();
        return $this->post('/api/support/model/', $data);
    }

    public function httpGetModel($id)
    {
        $this->setHeaderToken();
        return $this->get('/api/support/model/' . $id . '/');
    }

    public function httpUpdateModel($id, $data)
    {
        $this->setHeaderToken();
        return $this->put('/api/support/model/' . $id . '/', $data);
    }

    public function httpDeleteModel($id)
    {
        $this->setHeaderToken();
        return $this->delete('/api/support/model/' . $id . '/');
    }

    public function httpValidateModel($id)
    {
        $this->setHeaderToken();
        return $this->get('/api/support/model/' . $id . '/validate/');
    }

    public function httpFineTuneModel($id)
    {
        $this->setHeaderToken();
        return $this->get('/api/support/model/' . $id . '/finetune/');
    }

    public function httpTestModel($model, $data)
    {
        $this->setHeaderToken();
        $params = "?". http_build_query($data);
        return $this->get('/api/support/model/' . $model . '/test/'.$params);
    }
}
