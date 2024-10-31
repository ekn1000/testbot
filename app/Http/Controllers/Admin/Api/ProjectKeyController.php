<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Jobs\recalculateProjectKeysFrequencyOfCheatingJob;
use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\ProjectKey;
use App\Services\massUpdateService;
use App\Services\ReCalculateValuesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProjectKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private ReCalculateValuesService $reCalculateValuesService;
    private massUpdateService $massUpdateService;
    public function __construct(
        ReCalculateValuesService $reCalculateValuesService,
        massUpdateService $massUpdateService
    )
    {
        $this -> reCalculateValuesService = $reCalculateValuesService;
        $this->massUpdateService = $massUpdateService;
    }
    public function index(Request $request)
    {
        $project = Project::findOrFail($request->get('project_id'));
        Gate::authorize('show-project-group', ProjectGroup::find($project->group_id));
        $keys = ProjectKey::where('project_id', $request->get('project_id'))
            ->orderBy('frequency_of_cheating' , 'desc')->get();
        return  $keys;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
            'project_id' => 'required',
        ]);

        $key = ProjectKey::create($request->all());
        $this -> reCalculateValuesService->recalculateProjectValues($key->project_id);
        return $key;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $key = Projectkey::findOrFail($id);
        return $key;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keyword' => 'required',
            'project_id' => 'required',
        ]);

        $key = ProjectKey::findOrFail($id);
        $key->update($request->all());
        $this -> reCalculateValuesService->recalculateProjectValues($key->project_id);
        return $key;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $key = ProjectKey::findOrFail($id);
        $key->delete();
        $this -> reCalculateValuesService->recalculateProjectValues($key->project_id);
        return  $key;
    }

    public function massDestroy(Request $request)
    {
        if ($request->has('selectedItemIds') && count($request->get('selectedItemIds')) > 0) {
            DB::table('project_key_tasks')
                ->whereIn('project_key_id',$request->get('selectedItemIds'))
                ->delete();
           ProjectKey::destroy($request->get('selectedItemIds'));
        } else {
            DB::table('project_key_tasks')
                ->where('project_id', $request->get('project_id'))->delete();
            DB::table('project_keys')
                ->where('project_id', $request->get('project_id'))->delete();
        }
        $this -> reCalculateValuesService->recalculateProjectValues($request->get('project_id'));
        return 'keys deleted successfully';
    }

    public function massCreate(Request $request)
    {
        $request->validate([
            'keywords' => 'required',
            'project_id' => 'required',
        ]);
        $keywordsArr = explode(PHP_EOL, $request->get('keywords'));
        $keyForm = $request->except('keywords');
        $keys = [];
        foreach ($keywordsArr as $keyword) {
            $keyForm['keyword'] = $keyword;
            $key = ProjectKey::create($keyForm);
            $key = $key -> toArray();
            $keys[]=$key;
        }
        $this -> reCalculateValuesService->recalculateProjectValues($request->get('project_id'));
        return $keys;
    }

    public function massEdit(Request $request)
{
        $request->validate([
            'data.targeturl' => 'sometimes|required',
            'data.project_id' => 'required',
            'conditions.targeturl.value' => 'sometimes|required',
            'conditions.keyword.value' => 'sometimes|required',
            'conditions.getparameters.value' => 'sometimes|required',
        ],[
            'conditions.targeturl.value' => 'Заполните условие для targeturl',
            'conditions.keyword.value.required' => 'Заполните условие для ключа',
            'conditions.getparameters.value.required' => 'Заполните условие для параметров',
            'data.targeturl.required' => 'Заполните поле targeturl'
        ]);
     $keys_count = $this->massUpdateService->massUpdate($request->all());
        $project_id = (int) $request->get('data')['project_id'];

     recalculateProjectKeysFrequencyOfCheatingJob::dispatch($project_id, $this -> reCalculateValuesService);
     return $keys_count;
    }

    public function Import(Request $request)
    {
        $request->validate([
            'file'=>'required|file|mimes:txt'
        ],[
            'file.required' => "Выберите файл",
            'file.file' => "Выберите файл",
            'file.mimes' => "Расширение файла должно быть txt",
        ]);

        $importText = file_get_contents($request->file('file'));
        $importArr = explode(PHP_EOL,$importText);
        $resultArr = [];
        $successArr = [];
        $failArr = [];
        $keysArr = [
            'targeturl', 'keyword', 'frequency', 'getparameters'
        ];
        foreach ($importArr as $key => $row) {
            if($row) {
                $rowArr = explode(';', $row);
                $keyData = [];
                $number = $key + 1;
                foreach ($keysArr as $key2 => $item) {
                    isset($rowArr[$key2]) ? $keyData[$item] =  $rowArr[$key2] : $keyData[$item] = '';
                }
                $validator = Validator::make($keyData, [
                    'targeturl' => 'required',
                    'keyword' => 'required|string',
                    'frequency' => 'required|numeric'
                ]);
                if ($validator->fails()) {
                   $failArr[] = 'Строка №'. $number . ' ' . $row;
                } else {
                    $keyData['project_id'] = $request->get('project_id');
                    $keyData['frequency_of_cheating'] = round( $keyData['frequency'] * 0.1 / 30, 4);
                    $key = ProjectKey::create($keyData);
                    $successArr[] = 'Строка №'. $number . ' ' . $row;
                }
            }

        }
        $this -> reCalculateValuesService->recalculateProjectValues($request->get('project_id'));
        return ['successArr' =>  $successArr, 'failArr' => $failArr];
    }
}
