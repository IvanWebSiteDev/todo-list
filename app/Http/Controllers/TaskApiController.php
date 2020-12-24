<?php

namespace App\Http\Controllers;

use App\Http\Traits\ErorApiResponse;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TaskApiController extends Controller
{
    use ErorApiResponse;

    protected $messages;
    protected $rules;
    /**
     * The task repository instance.
     */
    protected $task;

    /**
     * Create a new controller instance.
     *
     * @param TaskRepositoryInterface $task
     * @return void
     */
    public function __construct(TaskRepositoryInterface $task)
    {
        $this->task = $task;
        $this->messages = [
            'required' => 'The :attribute field is required.',
            'in' => 'The :attribute must be one of the following types: :values',
            'max' => 'The :attribute must be shorter.'
        ];
        $this->rules = [
            'name' => 'present|max:255',
            'status' => 'present|in:0,1',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "links" => [
                "self" => env('APP_URL', 'http://localhost') . "/api/task"
            ],
            'data' => Task::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Task::where('id', $id)->firstOrFail();
            return response()->json($this->okSchema($data->toArray(), 202), 201);
        } catch (Exception $e) {
            return response()->json($this->forbiddenSchema(), 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return response()->json($this->abortSchema($validator->errors()->toArray(), 409), 409);
        }

        try {
            if ($request->name !== null) $data['name'] = $request->name;
            if ($request->status !== null) $data['status'] = $request->status;

            $data['id'] = $this->task->create($data);

            return response()->json($this->okSchema($data, 202), 201);
        } catch (Exception $e) {
            return response()->json($this->forbiddenSchema(), 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return response()->json($this->abortSchema($validator->errors()->toArray(), 409), 409);
        }

        try {
            $task = Task::where('id', $id)->firstOrFail();

            if ($request->name !== null) $data['name'] = $request->name;
            if ($request->status !== null) $data['status'] = $request->status;

            $this->task->update($task, $data);
            $data['id'] = $id;
            return response()->json($this->okSchema($data, 202), 202);
        } catch (Exception $e) {
            return response()->json($this->forbiddenSchema(), 403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Task::destroy($id);
            return response()->json($this->okSchema(['id' => $id], 202), 202);
        } catch (Exception $e) {
            return response()->json($this->forbiddenSchema(), 403);
        }
    }
}
