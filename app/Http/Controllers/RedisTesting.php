<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\RedisTestResource;
use Predis\Command\Redis\TYPE;

class RedisTesting extends Controller
{

    public function show(Request $request, int $id): View
    {
        $result = $this->getAllKeys($id);
        $data = $result->resolve($request);
        return view('redis',  $data);
    }

    public function index(Request $request, int $id, string $key): string|null
    {
        $value = Redis::get("$id:$key");
        if (is_null($value)) {
            $this->removeKey($id, $key);
            return json_encode(['error' => 'Key not found']);
        }
        return json_encode(['value' => $value]);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request, int $id, string $key): mixed
    {
        $value = $request->value;
        $timing = $request->get('timing', '3600');
        Log::alert($timing);
        $this->storeKey($id, $key);

        return Redis::set("$id:$key",  $value, 'EX', (int)$timing);
    }

    private function removeKey(int $id, string $key): void
    {
        $keys = $this->getKeys($id);
        if (strpos($keys, $key) !== false) {
            $keys = explode(',', $keys);
            $keys = array_filter($keys, function ($k) use ($key) {
                return $k !== $key;
            });
            Redis::set("$id",  implode(',', $keys));
        }
    }

    private function storeKey(int $id, string $key): void
    {
        $keys = $this->getKeys($id);
        Redis::set("$id",  "$keys,$key");
    }

    private function getKeys(int $id): mixed
    {
        return Redis::get("$id");
    }

    public function getAllKeys(int $id): RedisTestResource
    {
        $result = [];
        $keys = $this->getKeys($id);
        foreach (explode(',', $keys) as $key) {
            $value = Redis::get("$id:$key");
            if (is_null($value)) {
                $this->removeKey($id, $key);
            } else {
                $result[$key] = $value;
            }
        }
        return new RedisTestResource(['id' => $id, 'redis' => $result]);
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
