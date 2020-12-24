<?php


namespace App\Repositories;


use App\Models\Task;
use Exception;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data)
    {
        $task = new Task;
        foreach ($data as $key => $value) {
            $task->{$key} = $value;
        }
        $task->save();
        return $task->id;
    }

    public function update(Task $task, array $data)
    {
        foreach ($data as $key => $value) {
            $task->{$key} = $value;
        }
        $task->save();
        return $task->id;
    }

    public function delete(Task $task)
    {
        $id = $task->id;
        $task->delete();
        return $id;
    }
}
