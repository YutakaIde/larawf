<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\StoreText;  // ジョブクラスをuseする

class SampleController extends Controller
{
  public function queues()
  {
    $text = str_random(1000);

    // ジョブをディスパッチする
    $this->dispatch(new StoreText($text));

    return view('sample_queues');
  }
}

