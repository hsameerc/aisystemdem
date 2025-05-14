<?php

namespace App\Repositories;

interface ModelRepositoryInterface
{
    public function httpGetModels();
    public function httpCreateModel($data);
    public function httpGetModel($id);
    public function httpUpdateModel($id, $data);
    public function httpDeleteModel($id);
    public function httpValidateModel($id);
    public function httpTestModel($id, $data);
}
