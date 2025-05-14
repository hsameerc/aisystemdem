<?php

namespace App\Repositories;

interface FineTuneRepositoryInterface
{
    public function httpGetFineTunes($model);
    public function httpCreateFineTune($model, $data);
    public function httpUpdateFineTune($model, $id, $data);
    public function httpDeleteFineTune($id);
}
