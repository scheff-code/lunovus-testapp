<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\TaskUpdateRequest;
use function Symfony\Component\String\s;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $get = $request->query();

        if (! empty($get)) {
            $models = $this->applyFilters(Task::class)->paginate();

            return view('task.index', [
                'models' => $models,
                'links' => $models->links(),
                'get' => $get,
                'sort' => isset($get['sort']) && $get['sort'] ? $get['sort'] : '',
                'sort_icon' => self::sortIcon($get),
            ])->with('i', (request()->input('page', 1) - 1) * $models->perPage());
        }

        $models = Task::all()->where('user_id', Auth::user()->id);

        return view('task.index', [
            'models' => $models,
            'sort' => $this->sort,
            'sort_icon' => $this->sort_icon,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Task();

        return view('task.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskUpdateRequest $request
     * @return RedirectResponse
     */
    public function store(TaskUpdateRequest $request)
    {
        request()->validate(Task::$rules);

        $model = (new Task)->create($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();

        return redirect()->route('tasks')
            ->with('success', 'New task created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $model = (new Task)->find($id);

        return view('task.edit', ['model' => $model]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $model = (new Task)->find($id);

        return view('task.show', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $Task
     * @return RedirectResponse
     */
    public function update(Request $request, Task $Task): RedirectResponse
    {
        request()->validate(Task::$rules);

        $Task->update($request->all());

        return redirect()->route('tasks')
            ->with('success', 'Task updated');
    }

    /**
     * Update the specified resource's status with ajax json data, in storage.
     *
     * @param string $dataObject
     * @return JsonResponse
     */
    public function toggleStatus(int $id): JsonResponse
    {
        $task = Task::find($id);
        $task->status = $task->status == 1 ? 0 : 1;
        $task->save();

        return response()->json([
            'id' => $task->id,
            'status' => $task->status,
            'imgSrc' => Task::toggleSrc($task->status),
            'statusText' => Task::statusText()[$task->status],
        ]);
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy($id): RedirectResponse
    {
        $model = (new Task)->find($id)->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Record deleted');
    }

}
