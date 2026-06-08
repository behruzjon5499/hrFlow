<?php

namespace common\traits;

trait ApiResponse
{
  public function response($result = null)
  {
    if ($result->hasErrors()) {
      return $this->error($result);
    }

    return $this->success($result);
  }

  public function success($result = 'Успешно')
  {
    return ['result' => $result ?? 'Успешно', 'errors' => null];
  }

  public function error($result = 'Что-то пошло не так')
  {
    return ['result' => null, 'errors' => $result];
  }

  public function notAccess($message = 'У вас нет доступа!', $code = 403)
  {
    return $this->error(['message' => $message], $code);
  }
}
