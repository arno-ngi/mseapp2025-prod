<?php
namespace App\Helpers;

class Flash {

    public function create($message, $level, $key = 'flash_message')
    {
        session()->flash($key, [
            'message' => $message,
            'level' => $level
        ]);
    }

    public function info($message)
    {
        return $this->create($message, 'info');
    }

    public function success($message)
    {
        return $this->create($message, 'success');
    }

    public function error($message)
    {
        return $this->create($message, 'danger');
    }
}
