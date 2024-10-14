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
        // Check if any filters were set in the page
        $get = $request->query();
        if (! empty($get)) {
            // grab the relevant database records using the applyFilters method inherited from the Controller.php class
            $models = $this->applyFilters(Task::class)->paginate();

            // load the task list view, passing in the data it needs
            return view('task.index', [
                'models' => $models,
                'links' => $models->links(), // used for pagination if applicable
                'get' => $get, // to prepopulate the filters
                'sort' => isset($get['sort']) && $get['sort'] ? $get['sort'] : '', // apply sorting if applicable
                'sort_icon' => self::sortIcon($get),
            ])->with('i', (request()->input('page', 1) - 1) * $models->perPage());
        }

        // if no filters were set, grab the tasks for the current user, and pass them to the view
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

        // set the user_id to the current user's id
        $model->user_id = Auth::user()->id;
        $model->save();

        // return the user to the list of tasks
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
    public function update(Request $request, Task $task): RedirectResponse
    {
        request()->validate(Task::$rules);

        $task->update($request->all());

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
