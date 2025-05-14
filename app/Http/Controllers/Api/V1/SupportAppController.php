<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\FineTuneRepository;
use App\Repositories\ModelRepository;
use App\Resources\FineTuneDataResource;
use App\Resources\SupportModelResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupportAppController extends Controller
{
    private ModelRepository $modelRepository;
    private FineTuneRepository $fineTuneRepository;

    public function __construct(ModelRepository $modelRepository, FineTuneRepository $fineTuneRepository)
    {
        $this->modelRepository = $modelRepository;
        $this->fineTuneRepository = $fineTuneRepository;
    }

    public function dashboard()
    {

    }

    public function getModels(Request $request): SupportModelResource
    {
        return new SupportModelResource($this->modelRepository->httpGetModels());
    }

    public function createModel(Request $request): SupportModelResource
    {
        $data = $request->all();
        return new SupportModelResource($this->modelRepository->httpCreateModel($data));
    }

    public function updateModel(Request $request, $id): SupportModelResource
    {
        $data = $request->all();
        return new SupportModelResource($this->modelRepository->httpUpdateModel($id, $data));
    }

    public function deleteModel($id): SupportModelResource
    {
        return new SupportModelResource($this->modelRepository->httpDeleteModel($id));
    }

    public function viewModel($id): SupportModelResource
    {
        return new SupportModelResource($this->modelRepository->httpGetModel($id));
    }

    public function getFineTunes($id): FineTuneDataResource
    {
        return new FineTuneDataResource($this->fineTuneRepository->httpGetFineTunes($id));
    }

    public function createFineTune(Request $request, $model): FineTuneDataResource
    {
        $data = $request->all();
        return new FineTuneDataResource($this->fineTuneRepository->httpCreateFineTune($model, $data));
    }

    public function importFineTune(Request $request, $model): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        if ($request->hasFile('import_data')) {
            $file = $request->file('import_data');
            $destinationPath = 'uploads/tmp';
            $file->move($destinationPath, $file->getClientOriginalName());
            $file_data = json_decode(file_get_contents($destinationPath . '/' . $file->getClientOriginalName()), true);
            $response = [];
            foreach ($file_data as $data) {
                $fineTune = new FineTuneDataResource($this->fineTuneRepository->httpCreateFineTune($model, [
                    'support_model' => $model,
                    'prompt' => $data['prompt'],
                    'completion' => $data['completion'],
                ]));
                $response[] = $fineTune;
            }
            return response([$response], 200);
        }
        return response(["INVALID"], 400);
    }

    public function testModel(Request $request, $model): SupportModelResource
    {
        $request->validate([
            'prompt' => 'required'
        ]);
        new FineTuneDataResource($this->fineTuneRepository->httpCreateFineTune($model, [
            'support_model' => $model,
            'prompt' => "user",
            'completion' =>$request->input('prompt'),
        ]));
        $data = $request->only(['prompt']);
        $modelResult = $this->modelRepository->httpTestModel($model, $data);
        return new SupportModelResource($modelResult);
    }

    public function updateFineTune()
    {

    }

    public function deleteFineTune($id): FineTuneDataResource
    {
        return new FineTuneDataResource($this->fineTuneRepository->httpDeleteFineTune($id));
    }

    public function viewFineTune()
    {

    }

    public function validateModel($id): SupportModelResource
    {
        return new SupportModelResource($this->modelRepository->httpValidateModel($id));
    }

    public function fineTuneModel($id): SupportModelResource
    {
        return new SupportModelResource($this->modelRepository->httpFineTuneModel($id));
    }
}
