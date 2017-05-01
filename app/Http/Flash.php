<?php

namespace App\Http;

class Flash {


    /**
     * Show the info message
     *
     * @param $message
     * @return mixed
     */
    public function info($message)
    {
        return $this->create($message, 'info');
    }

    /**
     * Master file to create and mix messages.
     *
     * @param        $message
     * @param        $level
     * @param string $key
     * @return mixed
     */
    public function create($message, $level, $key = 'flash_message')
    {
        return session()->flash($key, [
            'message' => $message,
            'level'   => $level,
        ]);

    }

    /**
     * Generate a success message
     *
     * @param $message
     * @return mixed
     */
    public function success($message)
    {
        return $this->create($message, 'success');
    }

    /**
     * Generate an error message
     *
     * @param $message
     * @return mixed
     */
    public function error($message)
    {
        return $this->create($message, 'danger');
    }

    /**
     * Generate an error message
     *
     * @param $message
     * @return mixed
     */
    public function warning($message)
    {
        return $this->create($message, 'warning');
    }

    /**
     * Generate an overlay message, which is set default to success.
     *
     * @param        $message
     * @param string $level
     * @return mixed
     */
    public function overlay($message, $level = 'success')
    {
        return $this->create($message, $level, 'flash_message_overlay');
    }
}