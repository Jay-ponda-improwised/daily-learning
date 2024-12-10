<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisTesting extends Controller
{

    public function index(Request $request, int $id, string $key): string
    {
        $value = Redis::get("$id:$key");
        if(is_null($value)){
            return $this->removeKey($id, $key);
        }
        return $value;
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request, int $id, string $key): never
    {
        $value = $request->value;
        $timing = $request->get('timing', '3600');
        $this->storeKey($id, $key);

        return Redis::set("$id:$key",  $value, 'EX', (int)$timing);
    }

    private function removeKey(int $id, string $key): void {
        $keys = $this->getKeys($id);
        if(strpos($keys, $key) !== false){
            $keys = explode(',', $keys);
            $keys = array_filter($keys, function($k) use($key){return $k !== $key;});
            Redis::set("$id",  implode(',', $keys));
        }
    }

    private function storeKey(int $id, string $key): void {
        $keys = $this->getKeys($id);
        Redis::set("$id",  "$keys,$key");
    }

    private function getKeys(int $id): never{

        return Redis::get("$id");
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
