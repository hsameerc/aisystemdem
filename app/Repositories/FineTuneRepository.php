<?php

namespace App\Repositories;

class FineTuneRepository extends BaseApiRepository implements FineTuneRepositoryInterface
{

    public function httpGetFineTunes($model)
    {
        $this->setHeaderToken();
        return $this->get('/api/support/model/' . $model . '/supportdata/');
    }

    public function httpCreateFineTune($model, $data)
    {
        $this->setHeaderToken();
        return $this->post('/api/support/model/' . $model . '/supportdata/', $data);
    }

    public function httpImportFineTune($model, $data)
    {
        $this->setFileHeaderToken();
        return $this->post('/api/support/model/' . $model . '/supportdata/import', $data);
    }

    public function httpUpdateFineTune($model, $id, $data)
    {
        // TODO: Implement httpUpdateFineTune() method.
    }

    public function httpDeleteFineTune($id)
    {
        $this->setHeaderToken();
        return $this->delete('/api/support/model/supportdata/' . $id . '/');
    }
}
